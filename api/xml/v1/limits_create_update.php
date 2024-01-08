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
    $limits_id = 0;
    if (isset($_REQUEST['limits_id'])) { $limits_id = $_REQUEST['limits_id']; }
    $name = "";
    if (isset($_REQUEST['name'])) { $name = $_REQUEST['name']; }
    $id_shop_system = 0;
    if (isset($_REQUEST['id_shop_system'])) { $id_shop_system = $_REQUEST['id_shop_system']; }
    $vehicle_class_id = 0;
    if (isset($_REQUEST['vehicle_class_id'])) { $vehicle_class_id = $_REQUEST['vehicle_class_id']; }
    $AxleAmount = 0;
    if (isset($_REQUEST['AxleAmount'])) { $AxleAmount = $_REQUEST['AxleAmount']; }

    $SideSlipValueMax = "";
    if (isset($_REQUEST['SideSlipValueMax'])) { $SideSlipValueMax = $_REQUEST['SideSlipValueMax']; }
    $WheelDampingLeftMin = "";
    if (isset($_REQUEST['WheelDampingLeftMin'])) { $WheelDampingLeftMin = $_REQUEST['WheelDampingLeftMin']; }
    $WheelDampingRightMin = "";
    if (isset($_REQUEST['WheelDampingRightMin'])) { $WheelDampingRightMin = $_REQUEST['WheelDampingRightMin']; }
 	 $WheelDampingDifferenceMax = "";
    if (isset($_REQUEST['WheelDampingDifferenceMax'])) { $WheelDampingDifferenceMax = $_REQUEST['WheelDampingDifferenceMax']; }
    $BrakeForceDiffServiceBrakeMax = "";
    if (isset($_REQUEST['BrakeForceDiffServiceBrakeMax'])) { $BrakeForceDiffServiceBrakeMax = $_REQUEST['BrakeForceDiffServiceBrakeMax']; }
    $BrakeForceDiffParkingBrakeMax = "";
    if (isset($_REQUEST['BrakeForceDiffParkingBrakeMax'])) { $BrakeForceDiffParkingBrakeMax = $_REQUEST['BrakeForceDiffParkingBrakeMax']; }
    $GasRPMMin = "";
    if (isset($_REQUEST['GasRPMMin'])) { $GasRPMMin = $_REQUEST['GasRPMMin']; }
    $GasRPMMax = "";
    if (isset($_REQUEST['GasRPMMax'])) { $GasRPMMax = $_REQUEST['GasRPMMax']; }
    $GasCO = "";
    if (isset($_REQUEST['GasCO'])) { $GasCO = $_REQUEST['GasCO']; }
    $GasHC = "";
    if (isset($_REQUEST['GasHC'])) { $GasHC = $_REQUEST['GasHC']; }
    $DieselOpacityAvg = "";
    if (isset($_REQUEST['DieselOpacityAvg'])) { $DieselOpacityAvg = $_REQUEST['DieselOpacityAvg']; }
    $ApplyBrakeEvaluation = "";
    if (isset($_REQUEST['ApplyBrakeEvaluation'])) { $ApplyBrakeEvaluation = $_REQUEST['ApplyBrakeEvaluation']; }
    $ApplySuspensionEvaluation = "";
    if (isset($_REQUEST['ApplySuspensionEvaluation'])) { $ApplySuspensionEvaluation = $_REQUEST['ApplySuspensionEvaluation']; }
    $ApplySideSlipEvaluation = "";
    if (isset($_REQUEST['ApplySideSlipEvaluation'])) { $ApplySideSlipEvaluation = $_REQUEST['ApplySideSlipEvaluation']; }
    $ApplyEmissionEvaluation = "ApplyEmissionEvaluation";
    if (isset($_REQUEST['ApplyEmissionEvaluation'])) { $ApplyEmissionEvaluation = $_REQUEST['ApplyEmissionEvaluation']; }
    $ApplyHeadlightEvaluation = "ApplyHeadlightEvaluation";
    if (isset($_REQUEST['ApplyHeadlightEvaluation'])) { $ApplyHeadlightEvaluation = $_REQUEST['ApplyHeadlightEvaluation']; }
    
   	$action = "update";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }

    //
    if (($limits_id == 0) || ($limits_id == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO limits (";
		$query .= "name, id_shop_system, vehicle_class_id, AxleAmount, SideSlipValueMax, WheelDampingLeftMin, WheelDampingRightMin, WheelDampingDifferenceMax, ";
		$query .= "BrakeForceDiffServiceBrakeMax, BrakeForceDiffParkingBrakeMax, GasRPMMin, GasRPMMax, GasCO, GasHC, DieselOpacityAvg, "; 
		$query .= "ApplyBrakeEvaluation, ApplySuspensionEvaluation, ApplySideSlipEvaluation, ApplyEmissionEvaluation, ApplyHeadlightEvaluation) "; 

		$query .= "VALUE ('" . $name . "', " . $id_shop_system . ", " . $vehicle_class_id . ", " . $AxleAmount . ", '" . $SideSlipValueMax . "', '" . $WheelDampingLeftMin . "', ";
		$query .= "'" . $WheelDampingRightMin . "', '" . $WheelDampingDifferenceMax . "', '" . $BrakeForceDiffServiceBrakeMax . "', '" . $BrakeForceDiffParkingBrakeMax . "', '" . $GasRPMMin . "', '" . $GasRPMMax . "', '" . $GasCO . "', ";
		$query .= "'" . $GasHC . "', '" . $DieselOpacityAvg . "', '" . $ApplyBrakeEvaluation . "', '" . $ApplySuspensionEvaluation . "', '" . $ApplySideSlipEvaluation . "', '" . $ApplyEmissionEvaluation . "', '" . $ApplyHeadlightEvaluation . "');";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$limits_id = -1;
		}

		
	} else {

		 //limits_id, name, limit_values, id_shop_system, vehicle_class_id, AxleAmount, SideSlipValueMax, WheelDampingLeftMin, WheelDampingRightMin, WheelDampingDifferenceMax, BrakeForceDiffServiceBrakeMax, BrakeForceDiffParkingBrakeMax, GasRPMMin, GasRPMMax, GasCO, GasHC, DieselOpacityAvg, ApplyBrakeEvaluation, ApplySuspensionEvaluation, ApplySideSlipEvaluation, ApplyEmissionEvaluation, ApplyHeadlightEvaluation

		if ($action == 'update') {
			// Update Limits Query
			$query  = "UPDATE limits SET ";
			$query .= "name = '" . $name . "', id_shop_system = " . $id_shop_system . ", vehicle_class_id = " . $vehicle_class_id . ", AxleAmount = " . $AxleAmount . ", SideSlipValueMax = '" . $SideSlipValueMax . "', ";
			$query .= "SideSlipValueMax = '" . $SideSlipValueMax . "', WheelDampingLeftMin = '" . $WheelDampingLeftMin . "', WheelDampingRightMin = '" . $WheelDampingRightMin . "', WheelDampingDifferenceMax = '" . $WheelDampingDifferenceMax . "', BrakeForceDiffServiceBrakeMax = '" . $BrakeForceDiffServiceBrakeMax . "', ";
			$query .= "BrakeForceDiffParkingBrakeMax = '" . $BrakeForceDiffParkingBrakeMax . "', GasRPMMin = '" . $GasRPMMin . "', GasRPMMax = '" . $GasRPMMax . "', GasCO = '" . $GasCO . "', GasHC = '" . $GasHC . "', ";
			$query .= "DieselOpacityAvg = '" . $DieselOpacityAvg . "', ApplyBrakeEvaluation = '" . $ApplyBrakeEvaluation . "', ApplySuspensionEvaluation = '" . $ApplySuspensionEvaluation . "', ApplySideSlipEvaluation = '" . $ApplySideSlipEvaluation . "', ApplyEmissionEvaluation = '" . $ApplyEmissionEvaluation . "', ";
			$query .= "ApplyHeadlightEvaluation = '" . $ApplyHeadlightEvaluation . "' "; 
			$query .= "WHERE  limits_id = " . $limits_id . ";";
			//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Limits Query
			$query  = "DELETE from limits ";
			$query .= "WHERE limits_id = " . $limits_id . ";";
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
			$limits_id = -1;
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
			$http_result_data .= '<limits>' . "\r\n";
			$http_result_data .= '	<limits_id>' . $limits_id . '</limits_id>' . "\r\n";
			$http_result_data .= '</limits>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>