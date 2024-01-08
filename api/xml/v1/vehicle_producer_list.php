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
    // if (isset($_REQUEST['producer'])) { 
    // 	if (($_REQUEST['producer'] != 0) && ($_REQUEST['producer'] != "")) {
    // 		$query_where_temp .= " AND (U.producer='" . $_REQUEST['producer'] . "') "; 
    // 	}
    // }

    
    if (isset($_REQUEST['producer'])) { 
		if (($_REQUEST['producer'] != '0') && ($_REQUEST['producer'] != "")) {
			$query_where_temp .= " AND (U.producer='" . $_REQUEST['producer'] . "') "; 
		}
    }

    if (isset($_REQUEST['producer_filter'])) { 
    	if ($_REQUEST['producer_filter'] != "") {
    		$query_where_temp .= " AND (U.producer LIKE '%" . $_REQUEST['producer_filter'] . "%') ";
    	} 
    }
   
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ";
    //
    // Prepare Count Query
    $query =  "SELECT U.producer ";
    $query .=  "FROM vehicle_producer AS U ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//
	

    // Prepare Output Query
    $query =  "SELECT U.producer ";
    $query .=  "FROM vehicle_producer AS U ";
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
	$vehicle_class_result_array = array();
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
			  $vehicle_class_result_array[] = $obj;
			} // end while ($obj = DB_FetchObject($result));

			$http_result_data .= '<vehicle_producer_list>' . "\r\n";	
			foreach ($vehicle_class_result_array as $obj_arr) {		
				$http_result_data .= '<vehicle_producer>' . "\r\n";

					$http_result_data .= '<producer><![CDATA[' . $obj_arr->producer . ']]></producer>' . "\r\n";

				$http_result_data .= '</vehicle_producer>' . "\r\n";
			} // end foreach
			$http_result_data .= '</vehicle_producer_list>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	DB_FreeResult($result);
	DB_Close($dbconn);
	//
    ob_clean();
    $http_result_data=preg_replace('/&(?![#]?[a-z0-9]+;)/i', "&amp;$1", $http_result_data);
    echo $http_result_data;
    return;

?>