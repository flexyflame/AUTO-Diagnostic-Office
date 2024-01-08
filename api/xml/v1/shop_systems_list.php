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
    if (isset($_REQUEST['id_shop_system'])) { 
    	if (($_REQUEST['id_shop_system'] != 0) && ($_REQUEST['id_shop_system'] != "")) {
    		$query_where_temp .= " AND (S.id_shop_system='" . $_REQUEST['id_shop_system'] . "') "; 
    	}
    }

    if (isset($_REQUEST['shop_name'])) { 
    	if ($_REQUEST['shop_name'] != "") {
    		$query_where_temp .= " AND (S.shop_name LIKE '%" . $_REQUEST['shop_name'] . "%') ";
    	} 
    }

    if (isset($_REQUEST['flag_active'])) { 
    	if ($_REQUEST['flag_active'] != "-1") {
    		$query_where_temp .= " AND (S.flag_active=" . $_REQUEST['flag_active'] . ") ";  
    	}
    }
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ORDER BY id_shop_system DESC ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM shop_systems AS S ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//

    // Prepare Output Query
    $query =  "SELECT S.id_shop_system, S.shop_name, S.shop_code, S.flag_visual_defects, S.flag_brakes, S.flag_extrapolation, S.flag_suspension_side_slip, S.flag_headlight, S.flag_emission, S.flag_alignment, S.flag_vulcanize, S.logo, S.display_address, S.display_text, S.flag_active ";

    $query .=  "FROM shop_systems AS S ";

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

			$http_result_data .= '<shop_systems_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<shop_systems>' . "\r\n";

					$http_result_data .= '<id_shop_system>' . $obj_arr->id_shop_system . '</id_shop_system>' . "\r\n";
					$http_result_data .= '<shop_name><![CDATA[' . $obj_arr->shop_name . ']]></shop_name>' . "\r\n";
					$http_result_data .= '<shop_code><![CDATA[' . $obj_arr->shop_code . ']]></shop_code>' . "\r\n";

					$http_result_data .= '<flag_visual_defects>' . $obj_arr->flag_visual_defects . '</flag_visual_defects>' . "\r\n";
					$http_result_data .= '<flag_brakes>' . $obj_arr->flag_brakes . '</flag_brakes>' . "\r\n";
					$http_result_data .= '<flag_extrapolation>' . $obj_arr->flag_extrapolation . '</flag_extrapolation>' . "\r\n";
					$http_result_data .= '<flag_suspension_side_slip>' . $obj_arr->flag_suspension_side_slip . '</flag_suspension_side_slip>' . "\r\n";
					$http_result_data .= '<flag_headlight>' . $obj_arr->flag_headlight . '</flag_headlight>' . "\r\n";
					$http_result_data .= '<flag_emission>' . $obj_arr->flag_emission . '</flag_emission>' . "\r\n";
					$http_result_data .= '<flag_alignment>' . $obj_arr->flag_alignment . '</flag_alignment>' . "\r\n";
					$http_result_data .= '<flag_vulcanize>' . $obj_arr->flag_vulcanize . '</flag_vulcanize>' . "\r\n";
					$http_result_data .= '<logo><![CDATA[' . $obj_arr->logo . ']]></logo>' . "\r\n";
					$http_result_data .= '<display_address><![CDATA[' . $obj_arr->display_address . ']]></display_address>' . "\r\n";
					$http_result_data .= '<display_text>' . $obj_arr->display_text . '</display_text>' . "\r\n";

					$http_result_data .= '<flag_active>' . $obj_arr->flag_active . '</flag_active>' . "\r\n";

				$http_result_data .= '</shop_systems>' . "\r\n";
			} // end foreach
			$http_result_data .= '</shop_systems_list>' . "\r\n";
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