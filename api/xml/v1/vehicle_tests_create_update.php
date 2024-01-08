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
	$test_id = 0;
	if (isset($_REQUEST['test_id'])) { $test_id = $_REQUEST['test_id']; }
	$plate = "";
	if (isset($_REQUEST['plate'])) { $plate = $_REQUEST['plate']; }
	$vehicle = 0;
	if (isset($_REQUEST['vehicle'])) { $vehicle = $_REQUEST['vehicle']; }
	$id_customer = 0;
	if (isset($_REQUEST['id_customer'])) { $id_customer = $_REQUEST['id_customer']; }
	$id_shop_system = 0;
	if (isset($_REQUEST['id_shop_system'])) { $id_shop_system = $_REQUEST['id_shop_system']; }
	$date = date('Y-m-d');
	//if (isset($_REQUEST['date'])) { $date = $_REQUEST['date']; }
	$id_users_created_by = 0;
	if (isset($_REQUEST['id_users_created_by'])) { $id_users_created_by = $_REQUEST['id_users_created_by']; }
	$test_result = "";
	if (isset($_REQUEST['test_result'])) { $test_result = $_REQUEST['test_result']; }
	$AxleAmount = 0;
	if (isset($_REQUEST['AxleAmount'])) { $AxleAmount = $_REQUEST['AxleAmount']; }
	$CubicCapacity = "";
	if (isset($_REQUEST['CubicCapacity'])) { $CubicCapacity = $_REQUEST['CubicCapacity']; }
	$ProductionYear = "";
	if (isset($_REQUEST['ProductionYear'])) { $ProductionYear = $_REQUEST['ProductionYear']; }
	$FirstUse = "";
	if (isset($_REQUEST['FirstUse'])) { $FirstUse = $_REQUEST['FirstUse']; }
	$VehicleIdentificationNumber = "";
	if (isset($_REQUEST['VehicleIdentificationNumber'])) { $VehicleIdentificationNumber = $_REQUEST['VehicleIdentificationNumber']; }
	$TotalWeight = 0;
	if (isset($_REQUEST['TotalWeight'])) { $TotalWeight = $_REQUEST['TotalWeight']; }
	$TotalMeasuredWeight = 0;
	if (isset($_REQUEST['TotalMeasuredWeight'])) { $TotalMeasuredWeight = $_REQUEST['TotalMeasuredWeight']; }

	$LastInspection = 0;
	if ((isset($_REQUEST['LastInspection']) && ($_REQUEST['LastInspection'] > 0))) { 
		$LastInspection = date('Y-m-d', $_REQUEST['LastInspection']); 
	} else {
		$LastInspection = $date;
	}

	$ReceiptId = "";
	if (isset($_REQUEST['ReceiptId'])) { $ReceiptId = $_REQUEST['ReceiptId']; }
	$TestPurpose = "";
	if (isset($_REQUEST['TestPurpose'])) { $TestPurpose = $_REQUEST['TestPurpose']; }
	$Vehicle_Make = "";
	if (isset($_REQUEST['Vehicle_Make'])) { $Vehicle_Make = $_REQUEST['Vehicle_Make']; }
	$Vehicle_Class = "";
	if (isset($_REQUEST['Vehicle_Class'])) { $Vehicle_Class = $_REQUEST['Vehicle_Class']; }
	$Vehicle_Class_ID = 0;
	if (isset($_REQUEST['Vehicle_Class_ID'])) { $Vehicle_Class_ID = $_REQUEST['Vehicle_Class_ID']; }
	$Vehicle_Colour = 0;
	if (isset($_REQUEST['Vehicle_Colour'])) { $Vehicle_Colour = $_REQUEST['Vehicle_Colour']; }
	$Vehicle_Model = 0;
	if (isset($_REQUEST['Vehicle_Model'])) { $Vehicle_Model = $_REQUEST['Vehicle_Model']; }
	$Vehicle_Purpose = 0;
	if (isset($_REQUEST['Vehicle_Purpose'])) { $Vehicle_Purpose = $_REQUEST['Vehicle_Purpose']; }
	$status = 0;
	if (isset($_REQUEST['status'])) { $status = $_REQUEST['status']; }

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
	$flag_emission = 0;
	if (isset($_REQUEST['flag_emission'])) { $flag_emission = $_REQUEST['flag_emission']; }
	$flag_alignment = 0;
	if (isset($_REQUEST['flag_alignment'])) { $flag_alignment = $_REQUEST['flag_alignment']; }
	$flag_vulcanize = 0;
	if (isset($_REQUEST['flag_vulcanize'])) { $flag_vulcanize = $_REQUEST['flag_vulcanize']; }

	$action = "update";
	if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
	//

	//check if customer exists
	$id_customer = $UTIL->DB_Check_Customer ($id_customer);

	if (($test_id == 0) || ($test_id == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO vehicle_tests(";
		$query .= "plate, vehicle, id_customer, id_shop_system, date, id_users_created_by, test_result, ";
		$query .= "AxleAmount, CubicCapacity, ProductionYear, FirstUse, VehicleIdentificationNumber, TotalWeight, "; 
		$query .= "TotalMeasuredWeight, LastInspection, ReceiptId, TestPurpose, Vehicle_Make, Vehicle_Class, Vehicle_Class_ID, "; 
		$query .= "Vehicle_Colour, Vehicle_Model, Vehicle_Purpose, status, "; 
		$query .= "flag_visual_defects, flag_brakes, flag_extrapolation, flag_suspension_side_slip, flag_headlight, flag_emission, flag_alignment, flag_vulcanize) "; 

		$query .= "VALUE ('" . $plate . "', '" . $vehicle . "', " . $id_customer . ", " . $id_shop_system . ", '" . $date . "', " . $id_users_created_by . ", '" . $test_result . "', ";
		$query .= "" . $AxleAmount . ", '" . $CubicCapacity . "', '" . $ProductionYear . "', '" . $FirstUse . "', '" . $VehicleIdentificationNumber . "', '" . $TotalWeight . "', '";
		$query .= "" . $TotalMeasuredWeight . "', '" . $LastInspection . "', '" . $ReceiptId . "', '" . $TestPurpose . "', '" . $Vehicle_Make . "', '" . $Vehicle_Class . "', " . $Vehicle_Class_ID . ", '";
		$query .= "" . $Vehicle_Colour . "', '" . $Vehicle_Model . "', '" . $Vehicle_Purpose . "', " . $status . ", "; 
		$query .= "" . $flag_visual_defects . ", " . $flag_brakes . ", " . $flag_extrapolation . ", " . $flag_suspension_side_slip . ", " . $flag_headlight . ", " . $flag_emission . ", " . $flag_alignment . ", " . $flag_vulcanize . ");"; 

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);

		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$test_id = -1;
		}
	} else {

		if ($action == 'update') {
			// Update Shop Systems Query
			$query  = "UPDATE vehicle_tests SET ";
			$query .= "test_id = " . $test_id  . ", plate = '" . $plate . "', vehicle = '" . $vehicle . "', id_customer = " . $id_customer . ", id_shop_system = " . $id_shop_system . ", id_users_created_by = " . $id_users_created_by . ", test_result = '" . $test_result . "', ";
			$query .= "AxleAmount = " . $AxleAmount . ", CubicCapacity = '" . $CubicCapacity . "', ProductionYear = '" . $ProductionYear . "', FirstUse = '" . $FirstUse . "', VehicleIdentificationNumber = '" . $VehicleIdentificationNumber . "', TotalWeight = '" . $TotalWeight . "', ";
			$query .= "TotalMeasuredWeight = '" . $TotalMeasuredWeight . "', LastInspection = '" . $LastInspection . "', ReceiptId = '" . $ReceiptId . "', TestPurpose = '" . $TestPurpose . "', Vehicle_Make = '" . $Vehicle_Make . "', Vehicle_Class = '" . $Vehicle_Class . "', Vehicle_Class_ID = " . $Vehicle_Class_ID . ", ";
			$query .= "Vehicle_Colour = '" . $Vehicle_Colour . "', Vehicle_Model = '" . $Vehicle_Model . "', Vehicle_Purpose = '" . $Vehicle_Purpose . "', status = " . $status . ", "; 
			$query .= "flag_visual_defects = " . $flag_visual_defects . ", flag_brakes = " . $flag_brakes . ", flag_extrapolation = " . $flag_extrapolation . ", flag_suspension_side_slip = " . $flag_suspension_side_slip . ", "; 
			$query .= "flag_headlight = " . $flag_headlight . ", flag_emission = " . $flag_emission . ", flag_alignment = " . $flag_alignment . ", flag_vulcanize = " . $flag_vulcanize . " "; 

			$query .= "WHERE  test_id = " . $test_id . ";";
			//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Customer Query
			$query  = "DELETE from vehicle_tests ";
			$query .= "WHERE test_id = " . $test_id . ";";
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
			$test_id = -1;
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
			$http_result_data .= '<vehicle_tests>' . "\r\n";
			$http_result_data .= '	<test_id>' . $test_id . '</test_id>' . "\r\n";
			$http_result_data .= '</vehicle_tests>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	//ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>