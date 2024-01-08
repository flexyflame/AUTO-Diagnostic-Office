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
	$dbconn = DB_Connect_Direct();
	$result = false;
	$query  = "";

	//Prepare SQL query parameters
    $producer = 0;
    if (isset($_REQUEST['producer'])) { $producer = $_REQUEST['producer']; }
    $producer_update = "";
    if (isset($_REQUEST['producer_update'])) { $producer_update = $_REQUEST['producer_update']; }

    $action = "";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
    
    //
    if ($action == "create") {
		// Create vehicle_producer Query
		$query  = "INSERT INTO vehicle_producer (";
		$query .= "producer) "; 

		$query .= "VALUE ('" . $producer . "');";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$producer = -1;
		}

		
	} else if ($action == "update") {

		// Update vehicle_producer Query
		$query  = "UPDATE vehicle_producer SET ";
		$query .= "producer = '" . $producer_update . "' "; 
		$query .= "WHERE  producer = '" . $producer . "';";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record updated successfully";
			$producer = $producer_update;
		} else {
			$msg = "SQL query failed!";
			$producer = -1;
		}

	} else if ($action == "delete") {

		// Delete vehicle_producer Query
		$query  = "DELETE from vehicle_producer ";
		$query .= "WHERE producer = '" . $producer . "';";
		//
		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record deleted successfully";
		} else {
			$msg = "SQL query failed!";
			$producer = -1;
		}
	} else {
		$msg = "No Action!";
		$producer = -1;
	}
    
	//Prepare xml hearder
	$t=time();
	if ($api_auth != false) {
		if ($result != false) {
			$http_code = 200;
			$code = 1;
			//$msg = "Record Create successfully";
		} else {
			$http_code = 400;
			$code = 0;
			$msg = "Record could NOT create";
		}
	} else {
		$http_code = 400;
		$code = 1;
		$msg = "Invalid API Access";
	}

	$ip = $SESSION->get_client_ip();
	$http_result_data = '';
	$http_result_data .= '<ecomcentral_system>' . "\r\n";
	$http_result_data .= '<timestamp>' . $t . '</timestamp>' . "\r\n";
	$http_result_data .= '<timestamp_format>' . date("m/d/Y H:i:s",$t) . '</timestamp_format>' . "\r\n";
	$http_result_data .= '<http_code>' . $http_code . '</http_code>' . "\r\n";
	$http_result_data .= '<code>' . $code . '</code>' . "\r\n";
	$http_result_data .= '<msg>' . $msg . '</msg>' . "\r\n";
	$http_result_data .= '<client_ip>' . $ip . '</client_ip>' . "\r\n";

	if ($api_auth != false) {
		if ($result != false) {
			$http_result_data .= '<vehicle_producer>' . "\r\n";
			$http_result_data .= '	<producer><![CDATA[' . $producer . ']]></producer>' . "\r\n";
			$http_result_data .= '</vehicle_producer>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	//ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>