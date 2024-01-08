<?php
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");

    //Create Session
	$SESSION = new ClassSession();
	$UTIL = new ClassUtil($SESSION);

	if (!isset($_SESSION)) { 
	//Start Session
	  session_start();
	}

	$_SESSION['error_type'] = '';

	header('Content-type: text/xml; charset=UTF-8');
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Expires: " . date("D, d M Y 12:00:00 GMT", time() - 86400));
	header("Pragma: no-cache"); // HTTP/1.0
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    $api_auth = $SESSION->Auth();
	$query_result_array = array();    
	$dbconn = DB_Connect_Direct();


	//Prepare SQL query parameters
    $query_limit = 100;
    $query_offset = 0;
    $query_count = 0;
    $query_where_temp = "";
    //

    if (isset($_REQUEST['query_limit'])) { $query_limit = $_REQUEST['query_limit']; }
    if (isset($_REQUEST['query_offset'])) { $query_offset = $_REQUEST['query_offset']; }
    //

    if (isset($_REQUEST['limits_id'])) { 
    	if (($_REQUEST['limits_id'] != 0) && ($_REQUEST['limits_id'] != "")) {
    		$query_where_temp .= " AND (L.limits_id=" . $_REQUEST['limits_id'] . ") "; 
    	}
    }

    if (isset($_REQUEST['id_shop_system'])) { 
    	if (($_REQUEST['id_shop_system'] != 0) && ($_REQUEST['id_shop_system'] != "")) {
    		$query_where_temp .= " AND (L.id_shop_system=" . $_REQUEST['id_shop_system'] . ") "; 
    	}
    }

    if (isset($_REQUEST['vehicle_class_id'])) { 
    	if ($_REQUEST['vehicle_class_id'] != 0) {
    		$query_where_temp .= " AND (L.vehicle_class_id=" . $_REQUEST['vehicle_class_id'] . ") "; 
    	}
    }

    if (isset($_REQUEST['name'])) { 
    	if ($_REQUEST['name'] != "") {
    		$query_where_temp .= " AND (L.name LIKE '%" . $_REQUEST['name'] . "%') ";
    	} 
    }
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ORDER BY limits_id ASC ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM limits AS L ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//

    // Prepare Output Query
    $query =  "SELECT L.limits_id, L.name, L.limit_values, L.id_shop_system, S.shop_name, L.vehicle_class_id, L.AxleAmount, V.name AS vehicle_class_name, L.SideSlipValueMax, L.WheelDampingLeftMin, L.WheelDampingRightMin, L.WheelDampingDifferenceMax, L.BrakeForceDiffServiceBrakeMax, L.BrakeForceDiffParkingBrakeMax, L.GasRPMMin, L.GasRPMMax, L.GasCO, L.GasHC, L.DieselOpacityAvg, L.ApplyBrakeEvaluation, L.ApplySuspensionEvaluation, L.ApplySideSlipEvaluation, L.ApplyEmissionEvaluation, L.ApplyHeadlightEvaluation ";

    $query .=  "FROM limits AS L ";
    $query .=  "LEFT OUTER JOIN shop_systems AS S ON (L.id_shop_system = S.id_shop_system) ";
    $query .=  "LEFT OUTER JOIN vehicle_class AS V ON (L.vehicle_class_id = V.vehicle_class_id) ";

    $query .= $query_where;
    if ($query_limit != 0) {
        $query .= " LIMIT " . $query_limit . " OFFSET " . $query_offset;
    } // end if ($query_limit != 0);
    $query .= ";";
   
	//echo $query;
   	//Execute SQL query
	$result = DB_Query($dbconn, $query);

	//Prepare xml hearder
	$t=time();
	if ($api_auth != false) {
		if ($result != false) {
			$http_code = 200;
			$code = 1;
			$msg = "Data available";
		} else {
			$http_code = 400;
			$code = 0;
			$msg = "NO Data available";
		}
	} else {
		$http_code = 400;
		$code = 1;
		$msg = "Invalid API Access";
	}

	$ip = $SESSION->get_client_ip();
	$result_array = array();
	//echo $query;
	$http_result_data = '';
	$http_result_data .= '<ecomcentral_system>' . "\r\n";
	$http_result_data .= '	<timestamp>' . $t . '</timestamp>' . "\r\n";
	$http_result_data .= '	<timestamp_format>' . date("m/d/Y H:i:s",$t) . '</timestamp_format>' . "\r\n";
	$http_result_data .= '	<http_code>' . $http_code . '</http_code>' . "\r\n";
	$http_result_data .= '	<code>' . $code . '</code>' . "\r\n";
	$http_result_data .= '	<msg>' . $msg . '</msg>' . "\r\n";
	$http_result_data .= '	<client_ip>' . $ip . '</client_ip>' . "\r\n";

	$http_result_data .= '	<query_count>' . $query_count . '</query_count>' . "\r\n";
	$http_result_data .= '	<query_offset>' . $query_offset . '</query_offset>' . "\r\n";
	$http_result_data .= '	<query_limit>' . $query_limit . '</query_limit>' . "\r\n";

	if ($api_auth != false) {
		if ($result != false) {
			while ($obj = DB_FetchObject($result)) { //Build Array from result
			  $result_array[] = $obj;
			} // end while ($obj = DB_FetchObject($result));

			$http_result_data .= '<limits_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<limits>' . "\r\n";

					$http_result_data .= '<limits_id>' . $obj_arr->limits_id . '</limits_id>' . "\r\n";
					$http_result_data .= '<name>' . $obj_arr->name . '</name>' . "\r\n";
					$http_result_data .= '<limit_values><![CDATA[' . $obj_arr->limit_values . ']]></limit_values>' . "\r\n";
					$http_result_data .= '<id_shop_system>' . $obj_arr->id_shop_system . '</id_shop_system>' . "\r\n";
					$http_result_data .= '<shop_name><![CDATA[' . $obj_arr->shop_name . ']]></shop_name>' . "\r\n";
					$http_result_data .= '<vehicle_class_id>' . $obj_arr->vehicle_class_id . '</vehicle_class_id>' . "\r\n";
					$http_result_data .= '<vehicle_class_name><![CDATA[' . $obj_arr->vehicle_class_name . ']]></vehicle_class_name>' . "\r\n";
					$http_result_data .= '<AxleAmount><![CDATA[' . $obj_arr->AxleAmount . ']]></AxleAmount>' . "\r\n";

					$http_result_data .= '<SideSlipValueMax><![CDATA[' . $obj_arr->SideSlipValueMax . ']]></SideSlipValueMax>' . "\r\n";
					$http_result_data .= '<WheelDampingLeftMin><![CDATA[' . $obj_arr->WheelDampingLeftMin . ']]></WheelDampingLeftMin>' . "\r\n";
					$http_result_data .= '<WheelDampingRightMin><![CDATA[' . $obj_arr->WheelDampingRightMin . ']]></WheelDampingRightMin>' . "\r\n";
					$http_result_data .= '<WheelDampingDifferenceMax><![CDATA[' . $obj_arr->WheelDampingDifferenceMax . ']]></WheelDampingDifferenceMax>' . "\r\n";
					$http_result_data .= '<BrakeForceDiffServiceBrakeMax><![CDATA[' . $obj_arr->BrakeForceDiffServiceBrakeMax . ']]></BrakeForceDiffServiceBrakeMax>' . "\r\n";
					$http_result_data .= '<BrakeForceDiffParkingBrakeMax><![CDATA[' . $obj_arr->BrakeForceDiffParkingBrakeMax . ']]></BrakeForceDiffParkingBrakeMax>' . "\r\n";
					$http_result_data .= '<GasRPMMin><![CDATA[' . $obj_arr->GasRPMMin . ']]></GasRPMMin>' . "\r\n";
					$http_result_data .= '<GasRPMMax><![CDATA[' . $obj_arr->GasRPMMax . ']]></GasRPMMax>' . "\r\n";
					$http_result_data .= '<GasCO><![CDATA[' . $obj_arr->GasCO . ']]></GasCO>' . "\r\n";
					$http_result_data .= '<GasHC><![CDATA[' . $obj_arr->GasHC . ']]></GasHC>' . "\r\n";
					$http_result_data .= '<DieselOpacityAvg><![CDATA[' . $obj_arr->DieselOpacityAvg . ']]></DieselOpacityAvg>' . "\r\n";
					$http_result_data .= '<ApplyBrakeEvaluation><![CDATA[' . $obj_arr->ApplyBrakeEvaluation . ']]></ApplyBrakeEvaluation>' . "\r\n";
					$http_result_data .= '<ApplySuspensionEvaluation><![CDATA[' . $obj_arr->ApplySuspensionEvaluation . ']]></ApplySuspensionEvaluation>' . "\r\n";
					$http_result_data .= '<ApplySideSlipEvaluation><![CDATA[' . $obj_arr->ApplySideSlipEvaluation . ']]></ApplySideSlipEvaluation>' . "\r\n";
					$http_result_data .= '<ApplyEmissionEvaluation><![CDATA[' . $obj_arr->ApplyEmissionEvaluation . ']]></ApplyEmissionEvaluation>' . "\r\n";
					$http_result_data .= '<ApplyHeadlightEvaluation><![CDATA[' . $obj_arr->ApplyHeadlightEvaluation . ']]></ApplyHeadlightEvaluation>' . "\r\n";

				$http_result_data .= '</limits>' . "\r\n";
			} // end foreach
			$http_result_data .= '</limits_list>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	DB_FreeResult($result);
	DB_Close($dbconn);
	//
    //ob_clean();
    $http_result_data=preg_replace('/&(?![#]?[a-z0-9]+;)/i', "&amp;$1", $http_result_data);
    echo $http_result_data;
    return;

?>