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
    $id_shop_system = 0;
    if (isset($_REQUEST['id_shop_system'])) { $id_shop_system = $_REQUEST['id_shop_system']; }
    $shop_name = "";
    if (isset($_REQUEST['shop_name'])) { $shop_name = $_REQUEST['shop_name']; }
    $shop_code = "";
    if (isset($_REQUEST['shop_code'])) { $shop_code = $_REQUEST['shop_code']; }
    $flag_visual_defects = 0;
    if (isset($_REQUEST['flag_visual_defects'])) { $flag_visual_defects = $_REQUEST['flag_visual_defects']; }
    $flag_brakes = 0;
    if (isset($_REQUEST['flag_brakes'])) { $flag_brakes = $_REQUEST['flag_brakes']; }
    $flag_extrapolation = 0;
    if (isset($_REQUEST['flag_extrapolation'])) { $flag_extrapolation = $_REQUEST['flag_extrapolation']; }
    $flag_suspension_side_slip = 0;
    if (isset($_REQUEST['flag_suspension_side_slip'])) { $flag_suspension_side_slip = $_REQUEST['flag_suspension_side_slip']; }
    $flag_headlight = 0;
    if (isset($_REQUEST['flag_headlight'])) { $flag_headlight = $_REQUEST['flag_headlight']; }
    $flag_emission = "";
    if (isset($_REQUEST['flag_emission'])) { $flag_emission = $_REQUEST['flag_emission']; }
    $flag_alignment = 0;
    if (isset($_REQUEST['flag_alignment'])) { $flag_alignment = $_REQUEST['flag_alignment']; }
    $flag_vulcanize = 0;
    if (isset($_REQUEST['flag_vulcanize'])) { $flag_vulcanize = $_REQUEST['flag_vulcanize']; }
    $logo = "";
    if (isset($_REQUEST['logo'])) { $logo = $_REQUEST['logo']; }
    $display_address = "";
    if (isset($_REQUEST['display_address'])) { $display_address = $_REQUEST['display_address']; }
    $display_text = "";
    if (isset($_REQUEST['display_text'])) { $display_text = $_REQUEST['display_text']; }
    $flag_active = 0;
    if (isset($_REQUEST['flag_active'])) { $flag_active = $_REQUEST['flag_active']; }

    $action = "update";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
    //
    if (($id_shop_system == 0) || ($id_shop_system == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO shop_systems(";
		$query .= "shop_name, shop_code, flag_visual_defects, flag_brakes, flag_extrapolation, ";
		$query .= "flag_suspension_side_slip, flag_headlight, flag_emission, flag_alignment, flag_vulcanize, "; 
		$query .= "display_address, display_text, flag_active) "; 

		$query .= "VALUE ('" . $shop_name . "', '" . $shop_code . "', " . $flag_visual_defects . ", ";
		$query .= "" . $flag_brakes . ", " . $flag_extrapolation . ", " . $flag_suspension_side_slip . ", " . $flag_headlight . ", " . $flag_emission . ", " . $flag_alignment . ", ";
		$query .= "" . $flag_vulcanize . ", '" . $display_address . "', '" . $display_text . "', " . $flag_active . ");";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$id_shop_system = -1;
		}
	} else {

		if ($action == 'update') {
			// Update Shop Systems Query
			$query  = "UPDATE shop_systems SET ";
			$query .= "shop_name = '" . $shop_name . "', shop_code = '" . $shop_code . "', ";
			$query .= "flag_visual_defects = " . $flag_visual_defects . ", flag_brakes = " . $flag_brakes . ", flag_extrapolation = " . $flag_extrapolation . ", flag_suspension_side_slip = " . $flag_suspension_side_slip . ", ";
			$query .= "flag_headlight = " . $flag_headlight . ", flag_emission = " . $flag_emission . ", "; 
			$query .= "flag_alignment = " . $flag_alignment . ", flag_vulcanize = " . $flag_vulcanize . ", display_address = '" . $display_address . "', display_text = '" . $display_text . "', flag_active = " . $flag_active . " "; 
			$query .= "WHERE  id_shop_system = " . $id_shop_system . ";";
		//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Customer Query
			$query  = "DELETE from shop_systems ";
			$query .= "WHERE id_shop_system = " . $id_shop_system . ";";
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
			$id_shop_system = -1;
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
			$http_result_data .= '<shop_systems>' . "\r\n";
			$http_result_data .= '	<id_shop_system>' . $id_shop_system . '</id_shop_system>' . "\r\n";
			$http_result_data .= '</shop_systems>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	//ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>