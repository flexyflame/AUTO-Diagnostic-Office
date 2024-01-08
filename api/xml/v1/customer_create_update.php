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
    $id_customer = 0;
    if (isset($_REQUEST['id_customer'])) { $id_customer = $_REQUEST['id_customer']; }
    $Company = "";
    if (isset($_REQUEST['Company'])) { $Company = $_REQUEST['Company']; }
    $Industry = "";
    if (isset($_REQUEST['Industry'])) { $Industry = $_REQUEST['Industry']; }
    $Address = "";
    if (isset($_REQUEST['Address'])) { $Address = $_REQUEST['Address']; }
    $Address_Street_1 = "";
    if (isset($_REQUEST['Address_Street_1'])) { $Address_Street_1 = $_REQUEST['Address_Street_1']; }
    $Address_Street_2 = "";
    if (isset($_REQUEST['Address_Street_2'])) { $Address_Street_2 = $_REQUEST['Address_Street_2']; }
    $Address_City = "";
    if (isset($_REQUEST['Address_City'])) { $Address_City = $_REQUEST['Address_City']; }
 	 $Address_State = "";
    if (isset($_REQUEST['Address_State'])) { $Address_State = $_REQUEST['Address_State']; }
    $Address_Zip = "";
    if (isset($_REQUEST['Address_Zip'])) { $Address_Zip = $_REQUEST['Address_Zip']; }
    $Address_Country = "";
    if (isset($_REQUEST['Address_Country'])) { $Address_Country = $_REQUEST['Address_Country']; }
    $Phone = "";
    if (isset($_REQUEST['Phone'])) { $Phone = $_REQUEST['Phone']; }
    $Email = "";
    if (isset($_REQUEST['Email'])) { $Email = $_REQUEST['Email']; }
    $Website = "";

    if (isset($_REQUEST['Website'])) { $Website = $_REQUEST['Website']; }
    $Background_Info = "";
    if (isset($_REQUEST['Background_Info'])) { $Background_Info = $_REQUEST['Background_Info']; }
    $Sales_Rep = 0;
    if (isset($_REQUEST['Sales_Rep'])) { $Sales_Rep = $_REQUEST['Sales_Rep']; }
    $Date_of_Initial_Customer = 0;
    if (isset($_REQUEST['Date_of_Initial_Customer'])) { $Date_of_Initial_Customer = $_REQUEST['Date_of_Initial_Customer']; }
    $Contact_person = "";
    if (isset($_REQUEST['Contact_person'])) { $Contact_person = $_REQUEST['Contact_person']; }

    $id_shop_system = 0;
	if (isset($_REQUEST['id_shop_system'])) { $id_shop_system = $_REQUEST['id_shop_system']; }

    $flag_active = "";
    if (isset($_REQUEST['flag_active'])) { $flag_active = $_REQUEST['flag_active']; }

    $action = "update";
    if (isset($_REQUEST['action'])) { $action = $_REQUEST['action']; }
    
    //
    if (($id_customer == 0) || ($id_customer == "")) {
		// Create Shop Systems Query
		$query  = "INSERT INTO customer (";
		$query .= "id_customer, Company, Industry, Address, Address_Street_1, Address_Street_2, Address_City, ";
		$query .= "Address_State, Address_Zip, Address_Country, Phone, Email, Website, Background_Info, "; 
		$query .= "Sales_Rep, Contact_person, id_shop_system, flag_active) "; 

		$query .= "VALUE ('" . $id_customer . "', '" . $Company . "', '" . $Industry . "', '" . $Address . "', '" . $Address_Street_1 . "', ";
		$query .= "'" . $Address_Street_2 . "', '" . $Address_City . "', '" . $Address_State . "', '" . $Address_Zip . "', '" . $Address_Country . "', '" . $Phone . "', '" . $Email . "', ";
		$query .= "'" . $Website . "', '" . $Background_Info . "', '" . $Sales_Rep . "', '" . $Contact_person . "', " . $id_shop_system . ", '" . $flag_active . "');";

		//echo $query;
		//Execute SQL query
		$result = DB_Query($dbconn, $query);
		if ($result != false) {
			$msg = "Record Create successfully";
		} else {
			$msg = "SQL query failed!";
			$id_customer = -1;
		}

		
	} else {

		if ($action == 'update') {
			// Update Customer Query
			$query  = "UPDATE customer SET ";
			$query .= "Company = '" . $Company . "', Industry = '" . $Industry . "', Address = '" . $Address . "', Address_Street_1 = '" . $Address_Street_1 . "', ";
			$query .= "Address_Street_2 = '" . $Address_Street_2 . "', Address_City = '" . $Address_City . "', Address_State = '" . $Address_State . "', Address_Zip = '" . $Address_Zip . "', Address_Country = '" . $Address_Country . "', ";
			$query .= "Phone = '" . $Phone . "', Email = '" . $Email . "', Website = '" . $Website . "', Background_Info = '" . $Background_Info . "', Sales_Rep = '" . $Sales_Rep . "', ";
			$query .= "Contact_person = '" . $Contact_person . "', id_shop_system = " . $id_shop_system . ", flag_active = '" . $flag_active . "' "; 
			$query .= "WHERE  id_customer = " . $id_customer . ";";
			//
			$msg = "Record updated successfully";
		} else if ($action == 'delete') {

			// Delete Customer Query
			$query  = "DELETE from customer ";
			$query .= "WHERE id_customer = " . $id_customer . ";";
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
			$id_customer = -1;
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
			$http_result_data .= '<customer>' . "\r\n";
			$http_result_data .= '	<id_customer>' . $id_customer . '</id_customer>' . "\r\n";
			$http_result_data .= '</customer>' . "\r\n";
		} 
	}

	$http_result_data .= '</ecomcentral_system>' . "\r\n";

	ob_clean();
	echo $http_result_data;

	//DB_FreeResult($result);
	DB_Close($dbconn);

?>