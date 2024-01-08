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

	$query = "SELECT id_var_mapping, type, id, variable, value, aktiv, ts_angelegt, ts_aenderung ";

	//Prepare SQL query parameters
    $id_var_mapping = 0;
    if (isset($_REQUEST['id_var_mapping'])) { $id_var_mapping = $_REQUEST['id_var_mapping']; }
    $type = 0;
    if (isset($_REQUEST['type'])) { $type = $_REQUEST['type']; }
    $id = 0;
    if (isset($_REQUEST['id'])) { $id = $_REQUEST['id']; }
    $variable = "";
    if (isset($_REQUEST['variable'])) { $variable = $_REQUEST['variable']; }
    $value = "";
    if (isset($_REQUEST['value'])) { $value = $_REQUEST['value']; }
    $aktiv = 0;
    if (isset($_REQUEST['aktiv'])) { $aktiv = $_REQUEST['aktiv']; }


    $action = "update";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
    
    //
    if (($id_var_mapping == 0) || ($id_var_mapping == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO id_var_mappings (";
		$query .= "type, id, variable, value, aktiv ) "; 

		$query .= "VALUE (" . $type . ", " . $id . ", '" . $variable . "', '" . $value . "', " . $aktiv . ");";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";

			$return_qry = "SELECT id_var_mapping FROM id_var_mappings ORDER BY id_var_mapping DESC LIMIT 1";
			$result_return_qry = DB_Query($dbconn, $return_qry);
			if ($result_return_qry != false) {
				while ($obj_return_qry = DB_FetchObject($result_return_qry)) {
					$id_var_mapping = $obj_return_qry->id_var_mapping;
				}
				DB_FreeResult($obj_return_qry);
			} // end if ($result_return_qry != false);

		} else {
			$msg = "SQL query failed!";
			$id_var_mapping = -1;
		}

	} else {

		if ($action == 'update') {
			// Update Customer Query
			$query  = "UPDATE id_var_mappings SET ";
			$query .= "id_var_mapping = " . $id_var_mapping . ", type = " . $type . ", id = " . $id . ", variable = '" . $variable . "', ";
			$query .= "value = '" . $value . "', aktiv = " . $aktiv . " "; 

			$query .= "WHERE  id_var_mapping = " . $id_var_mapping . ";";
			//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Customer Query
			$query  = "DELETE from id_var_mappings ";
			$query .= "WHERE id_var_mapping = " . $id_var_mapping . ";";
			//
			$msg = "Record deleted successfully";
		}
			
		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			//$msg = "Record updated successfully";
		} else {
			$msg = "SQL query failed!";
			$id_var_mapping = -1;
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
			$http_result_data .= '<id_var_mappings>' . "\r\n";
			$http_result_data .= '	<id_var_mapping>' . $id_var_mapping . '</id_var_mapping>' . "\r\n";
			$http_result_data .= '</id_var_mappings>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>