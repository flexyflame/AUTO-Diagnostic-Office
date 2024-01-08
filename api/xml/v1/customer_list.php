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
    if (isset($_REQUEST['id_customer'])) { 
    	if (($_REQUEST['id_customer'] != 0) && ($_REQUEST['id_customer'] != "")) {
    		$query_where_temp .= " AND (C.id_customer=" . $_REQUEST['id_customer'] . ") "; 
    	}
    }

    if (isset($_REQUEST['Company'])) { 
    	if ($_REQUEST['Company'] != "") {
    		$query_where_temp .= " AND (C.Company LIKE '%" . $_REQUEST['Company'] . "%') ";
    	} 
    }

    if (isset($_REQUEST['Industry'])) { 
    	if (($_REQUEST['Industry'] != "") && ($_REQUEST['Industry'] != 0)) {
    		$query_where_temp .= " AND (C.Industry='" . $_REQUEST['Industry'] . "') "; 
    	}
    }

    if (isset($_REQUEST['flag_active'])) { 
    	if ($_REQUEST['flag_active'] != "-1") {
    		$query_where_temp .= " AND (C.flag_active=" . $_REQUEST['flag_active'] . ") ";  
    	}
    }

    $arr_id_shop_system = array();
	if (!empty($_REQUEST['id_shop_system'])) {
		$arr_id_shop_system = $_REQUEST['id_shop_system'];
	}

	if (!empty($arr_id_shop_system)) {
		$query_where_temp .= " AND (C.id_shop_system IN (". implode(", ", $arr_id_shop_system) .")) "; 
	} // end if isset($arr_id_shop_system);
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ORDER BY id_customer DESC ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM customer AS C ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//

    // Prepare customer Output Query
    $query =  "SELECT C.id_customer, C.Company, C.Industry, C.Address, C.Address_Street_1, C.Address_Street_2, C.Address_City, C.Address_State, C.Address_Zip, C.Address_Country, C.Phone, C.Email, C.Website, C.Background_Info, C.Sales_Rep, C.Date_of_Initial_Customer, C.Contact_person, C.id_shop_system, S.shop_name, C.flag_active ";
    $query .=  "FROM customer AS C ";
    $query .=  "LEFT OUTER JOIN shop_systems AS S ON (C.id_shop_system = S.id_shop_system) ";

    $query .= $query_where;
    if ($query_limit != 0) {
        $query .= " LIMIT " . $query_limit . " OFFSET " . $query_offset;
        $query .= "  ";
        
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

			$http_result_data .= '<customer_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<customer>' . "\r\n";

					$http_result_data .= '<id_customer>' . $obj_arr->id_customer . '</id_customer>' . "\r\n";
					$http_result_data .= '<Company><![CDATA[' . $obj_arr->Company . ']]></Company>' . "\r\n";
					$http_result_data .= '<Industry><![CDATA[' . $obj_arr->Industry . ']]></Industry>' . "\r\n";
					$http_result_data .= '<Address><![CDATA[' . $obj_arr->Address . ']]></Address>' . "\r\n";
					$http_result_data .= '<Address_Street_1><![CDATA[' . $obj_arr->Address_Street_1 . ']]></Address_Street_1>' . "\r\n";
					$http_result_data .= '<Address_Street_2><![CDATA[' . $obj_arr->Address_Street_2 . ']]></Address_Street_2>' . "\r\n";
					$http_result_data .= '<Address_City><![CDATA[' . $obj_arr->Address_City . ']]></Address_City>' . "\r\n";

					$http_result_data .= '<Address_State><![CDATA[' . $obj_arr->Address_State . ']]></Address_State>' . "\r\n";
					$http_result_data .= '<Address_Zip><![CDATA[' . $obj_arr->Address_Zip . ']]></Address_Zip>' . "\r\n";
					$http_result_data .= '<Address_Country><![CDATA[' . $obj_arr->Address_Country . ']]></Address_Country>' . "\r\n";
					$http_result_data .= '<Phone><![CDATA[' . $obj_arr->Phone . ']]></Phone>' . "\r\n";

					$http_result_data .= '<Email><![CDATA[' . $obj_arr->Email . ']]></Email>' . "\r\n";
					$http_result_data .= '<Website><![CDATA[' . $obj_arr->Website . ']]></Website>' . "\r\n";
					$http_result_data .= '<Background_Info><![CDATA[' . $obj_arr->Background_Info . ']]></Background_Info>' . "\r\n";

					$http_result_data .= '<Sales_Rep>' . $obj_arr->Sales_Rep . '</Sales_Rep>' . "\r\n";
					$http_result_data .= '<Date_of_Initial_Customer>' . $obj_arr->Date_of_Initial_Customer . '</Date_of_Initial_Customer>' . "\r\n";
					$http_result_data .= '<Contact_person>' . $obj_arr->Contact_person . '</Contact_person>' . "\r\n";

					$http_result_data .= '<id_shop_system><![CDATA[' . $obj_arr->id_shop_system . ']]></id_shop_system>' . "\r\n";
					$http_result_data .= '<shop_name><![CDATA[' . $obj_arr->shop_name . ']]></shop_name>' . "\r\n";

					$http_result_data .= '<flag_active>' . $obj_arr->flag_active . '</flag_active>' . "\r\n";

				$http_result_data .= '</customer>' . "\r\n";
			} // end foreach
			$http_result_data .= '</customer_list>' . "\r\n";
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