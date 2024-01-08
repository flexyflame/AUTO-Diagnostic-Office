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
    if (isset($_REQUEST['test_id'])) { 
    	if (($_REQUEST['test_id'] != 0) && ($_REQUEST['test_id'] != "")) {
    		$query_where_temp .= " AND (V.test_id='" . $_REQUEST['test_id'] . "') "; 
    	}
    }

    if (isset($_REQUEST['id_customer'])) { 
    	if ($_REQUEST['id_customer'] != "0") {
    		$query_where_temp .= " AND (V.id_customer='" . $_REQUEST['id_customer'] . "') "; 
    	}
    }

    if (isset($_REQUEST['vehicle'])) { 
    	if ($_REQUEST['vehicle'] != "") {
    		$query_where_temp .= " AND (V.vehicle LIKE '%" . $_REQUEST['vehicle'] . "%') ";
    	} 
    }

    if (isset($_REQUEST['plate'])) { 
    	if ($_REQUEST['plate'] != "") {
    		$query_where_temp .= " AND (V.plate LIKE '%" . $_REQUEST['plate'] . "%') ";
    	} 
    }

    $arr_id_shop_system = array();
	if (!empty($_REQUEST['id_shop_system'])) {
		$arr_id_shop_system = $_REQUEST['id_shop_system'];
	}

	if (!empty($arr_id_shop_system)) {
		$query_where_temp .= " AND (V.id_shop_system IN (". implode(", ", $arr_id_shop_system) .")) "; 
	} // end if isset($arr_id_shop_system);

    if (isset($_REQUEST['status'])) { 
    	if ($_REQUEST['status'] != "-1") {
    		$query_where_temp .= " AND (V.status=" . $_REQUEST['status'] . ") ";  
    	}
    }
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ORDER BY test_id DESC ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM vehicle_tests AS V ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//
    // Prepare Output Query
    $query = "SELECT V.test_id, V.plate, V.vehicle, V.id_customer, V.id_shop_system, S.shop_name, V.date, V.id_users_created_by, V.test_result, V.AxleAmount, V.CubicCapacity, V.ProductionYear, V.FirstUse, V.VehicleIdentificationNumber, V.TotalWeight, V.TotalMeasuredWeight, V.LastInspection, V.ReceiptId, V.TestPurpose, V.Vehicle_Make, V.Vehicle_Class, V.Vehicle_Class_ID, V.Vehicle_Colour, V.Vehicle_Model, V.Vehicle_Purpose, V.status, V.flag_visual_defects, V.flag_brakes, V.flag_extrapolation, V.flag_suspension_side_slip, V.flag_headlight, V.flag_emission, V.flag_alignment, V.flag_vulcanize,
    	C.Company AS customer_company, C.Address AS customer_Address, C.Address_Street_1 AS customer_Address_Street_1, C.Address_Street_2 AS customer_Address_Street_2, 
    	C.Address_City AS customer_Address_City, C.Address_State AS customer_Address_State, C.Address_Zip AS customer_Address_Zip, C.Address_Country AS customer_Address_Country, 
    	C.Phone AS customer_Phone, C.Email AS customer_Email ";

    $query .=  "FROM vehicle_tests AS V ";
    $query .=  "LEFT OUTER JOIN customer AS C ON (V.id_customer = C.id_customer) ";
    $query .=  "LEFT OUTER JOIN shop_systems AS S ON (V.id_shop_system = S.id_shop_system) ";

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

			$http_result_data .= '<vehicle_tests_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<vehicle_tests>' . "\r\n";

					$http_result_data .= '<test_id>' . $obj_arr->test_id . '</test_id>' . "\r\n";
					$http_result_data .= '<plate><![CDATA[' . $obj_arr->plate . ']]></plate>' . "\r\n";
					$http_result_data .= '<vehicle><![CDATA[' . $obj_arr->vehicle . ']]></vehicle>' . "\r\n";
					$http_result_data .= '<id_shop_system><![CDATA[' . $obj_arr->id_shop_system . ']]></id_shop_system>' . "\r\n";
					$http_result_data .= '<shop_name><![CDATA[' . $obj_arr->shop_name . ']]></shop_name>' . "\r\n";
					$http_result_data .= '<date><![CDATA[' . strtotime($obj_arr->date) . ']]></date>' . "\r\n";

					//Customer Details
					$http_result_data .= '<id_customer><![CDATA[' . $obj_arr->id_customer . ']]></id_customer>' . "\r\n";
					$http_result_data .= '<customer_company><![CDATA[' . $obj_arr->customer_company . ']]></customer_company>' . "\r\n";
					$http_result_data .= '<customer_Address><![CDATA[' . $obj_arr->customer_Address . ']]></customer_Address>' . "\r\n";
					$http_result_data .= '<customer_Address_Street_1><![CDATA[' . $obj_arr->customer_Address_Street_1 . ']]></customer_Address_Street_1>' . "\r\n";
					$http_result_data .= '<customer_Address_Street_2><![CDATA[' . $obj_arr->customer_Address_Street_2 . ']]></customer_Address_Street_2>' . "\r\n";
					$http_result_data .= '<customer_Address_City><![CDATA[' . $obj_arr->customer_Address_City . ']]></customer_Address_City>' . "\r\n";

					$http_result_data .= '<customer_Address_State><![CDATA[' . $obj_arr->customer_Address_State . ']]></customer_Address_State>' . "\r\n";
					$http_result_data .= '<customer_Address_Zip><![CDATA[' . $obj_arr->customer_Address_Zip . ']]></customer_Address_Zip>' . "\r\n";
					$http_result_data .= '<customer_Address_Country><![CDATA[' . $obj_arr->customer_Address_Country . ']]></customer_Address_Country>' . "\r\n";
					$http_result_data .= '<customer_Phone><![CDATA[' . $obj_arr->customer_Phone . ']]></customer_Phone>' . "\r\n";
					$http_result_data .= '<customer_Email><![CDATA[' . $obj_arr->customer_Email . ']]></customer_Email>' . "\r\n";

					$http_result_data .= '<id_users_created_by><![CDATA[' . $obj_arr->id_users_created_by . ']]></id_users_created_by>' . "\r\n";
					$http_result_data .= '<test_result><![CDATA[' . $obj_arr->test_result . ']]></test_result>' . "\r\n";
					$http_result_data .= '<AxleAmount><![CDATA[' . $obj_arr->AxleAmount . ']]></AxleAmount>' . "\r\n";
					$http_result_data .= '<CubicCapacity><![CDATA[' . $obj_arr->CubicCapacity . ']]></CubicCapacity>' . "\r\n";
					$http_result_data .= '<ProductionYear><![CDATA[' . $obj_arr->ProductionYear . ']]></ProductionYear>' . "\r\n";
					$http_result_data .= '<FirstUse><![CDATA[' . $obj_arr->FirstUse . ']]></FirstUse>' . "\r\n";
					$http_result_data .= '<VehicleIdentificationNumber><![CDATA[' . $obj_arr->VehicleIdentificationNumber . ']]></VehicleIdentificationNumber>' . "\r\n";
					$http_result_data .= '<TotalWeight><![CDATA[' . $obj_arr->TotalWeight . ']]></TotalWeight>' . "\r\n";
					$http_result_data .= '<TotalMeasuredWeight><![CDATA[' . $obj_arr->TotalMeasuredWeight . ']]></TotalMeasuredWeight>' . "\r\n";
					$http_result_data .= '<LastInspection><![CDATA[' . strtotime($obj_arr->LastInspection) . ']]></LastInspection>' . "\r\n";
					$http_result_data .= '<ReceiptId><![CDATA[' . $obj_arr->ReceiptId . ']]></ReceiptId>' . "\r\n";
					$http_result_data .= '<TestPurpose><![CDATA[' . $obj_arr->TestPurpose . ']]></TestPurpose>' . "\r\n";

					$http_result_data .= '<Vehicle_Make><![CDATA[' . $obj_arr->Vehicle_Make . ']]></Vehicle_Make>' . "\r\n";
					$http_result_data .= '<Vehicle_Class><![CDATA[' . $obj_arr->Vehicle_Class . ']]></Vehicle_Class>' . "\r\n";
					$http_result_data .= '<Vehicle_Class_ID><![CDATA[' . $obj_arr->Vehicle_Class_ID . ']]></Vehicle_Class_ID>' . "\r\n";
					$http_result_data .= '<Vehicle_Colour><![CDATA[' . $obj_arr->Vehicle_Colour . ']]></Vehicle_Colour>' . "\r\n";
					$http_result_data .= '<Vehicle_Model><![CDATA[' . $obj_arr->Vehicle_Model . ']]></Vehicle_Model>' . "\r\n";
					$http_result_data .= '<Vehicle_Purpose><![CDATA[' . $obj_arr->Vehicle_Purpose . ']]></Vehicle_Purpose>' . "\r\n";
					
					$http_result_data .= '<status>' . $obj_arr->status . '</status>' . "\r\n";

					$http_result_data .= '<flag_visual_defects>' . $obj_arr->flag_visual_defects . '</flag_visual_defects>' . "\r\n";
					$http_result_data .= '<flag_brakes>' . $obj_arr->flag_brakes . '</flag_brakes>' . "\r\n";
					$http_result_data .= '<flag_extrapolation>' . $obj_arr->flag_extrapolation . '</flag_extrapolation>' . "\r\n";
					$http_result_data .= '<flag_suspension_side_slip>' . $obj_arr->flag_suspension_side_slip . '</flag_suspension_side_slip>' . "\r\n";
					$http_result_data .= '<flag_headlight>' . $obj_arr->flag_headlight . '</flag_headlight>' . "\r\n";
					$http_result_data .= '<flag_emission>' . $obj_arr->flag_emission . '</flag_emission>' . "\r\n";
					$http_result_data .= '<flag_alignment>' . $obj_arr->flag_alignment . '</flag_alignment>' . "\r\n";
					$http_result_data .= '<flag_vulcanize>' . $obj_arr->flag_vulcanize . '</flag_vulcanize>' . "\r\n";

				$http_result_data .= '</vehicle_tests>' . "\r\n";
			} // end foreach
			$http_result_data .= '</vehicle_tests_list>' . "\r\n";
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