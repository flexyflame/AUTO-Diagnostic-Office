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
    $id_users = 0;
    if (isset($_REQUEST['id_users'])) { $id_users = $_REQUEST['id_users']; }
    $Login = "";
    if (isset($_REQUEST['Login'])) { $Login = $_REQUEST['Login']; }
    $Name = "";
    if (isset($_REQUEST['Name'])) { $Name = $_REQUEST['Name']; }
    $FirstName = "";
    if (isset($_REQUEST['FirstName'])) { $FirstName = $_REQUEST['FirstName']; }
    $Email = "";
    if (isset($_REQUEST['Email'])) { $Email = $_REQUEST['Email']; }
    $Password = "";
    if (isset($_REQUEST['Password'])) { $Password = $_REQUEST['Password']; }
    $Supervisor = "";
    if (isset($_REQUEST['Supervisor'])) { $Supervisor = $_REQUEST['Supervisor']; }
 	 $status = "";
    if (isset($_REQUEST['status'])) { $status = $_REQUEST['status']; }

    $action = "update";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
    
    //
    if (($id_users == 0) || ($id_users == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO users (";
		$query .= "id_users, Login, Name, FirstName, Email, Password, Supervisor, status) "; 

		$query .= "VALUE ('" . $id_users . "', '" . $Login . "', '" . $Name . "', '" . $FirstName . "', '" . $Email . "', ";
		$query .= "'" . $Password . "', " . $Supervisor . ", " . $status . ");";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$id_users = -1;
		}

		
	} else {

		if ($action == 'update') {
			// Update Users Query
			$query  = "UPDATE users SET ";
			$query .= "id_users = '" . $id_users . "', Login = '" . $Login . "', Name = '" . $Name . "', FirstName = '" . $FirstName . "', ";
			$query .= "Email = '" . $Email . "', Password = '" . $Password . "', Supervisor = " . $Supervisor . ", status = " . $status . " "; 
			$query .= "WHERE  id_users = " . $id_users . ";";

			//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Users Query
			$query  = "DELETE from users ";
			$query .= "WHERE id_users = " . $id_users . ";";
			//
			$msg = "Record deleted successfully";
		}
		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record updated successfully";
		} else {
			$msg = "SQL query failed!";
			$id_users = -1;
		}
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
			$http_result_data .= '<users>' . "\r\n";
			$http_result_data .= '	<id_users>' . $id_users . '</id_users>' . "\r\n";
			$http_result_data .= '</users>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>