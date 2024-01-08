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
    if (isset($_REQUEST['id_users'])) { 
    	if (($_REQUEST['id_users'] != 0) && ($_REQUEST['id_users'] != "")) {
    		$query_where_temp .= " AND (U.id_users='" . $_REQUEST['id_users'] . "') "; 
    	}
    }
    if (isset($_REQUEST['login'])) { 
    	if ($_REQUEST['login'] != "") {
    		$query_where_temp .= " AND (U.Login='" . $_REQUEST['login'] . "') "; 
    	}
    }

    if (isset($_REQUEST['name'])) { 
    	if ($_REQUEST['name'] != "") {
    		$query_where_temp .= " AND (U.Name LIKE '%" . $_REQUEST['name'] . "%') ";
    	} 
    }
    if (isset($_REQUEST['firstname'])) { 
    	if ($_REQUEST['firstname'] != "") {
    		$query_where_temp .= " AND (U.FirstName LIKE '%" . $_REQUEST['firstname'] . "%') "; 
    	}
    }
    if (isset($_REQUEST['email'])) { 
    	if ($_REQUEST['email'] != "") {
    		$query_where_temp .= " AND (U.Email LIKE '%" . $_REQUEST['email'] . "%') "; 
    	} 
    }

    if (isset($_REQUEST['supervisor'])) { 
    	if ($_REQUEST['supervisor'] != "-1") {
    		$query_where_temp .= " AND (U.Supervisor=" . $_REQUEST['supervisor'] . ") "; 
    	} 
    }
    if (isset($_REQUEST['status'])) { 
    	if ($_REQUEST['status'] != "-1") {
    		$query_where_temp .= " AND (U.status=" . $_REQUEST['status'] . ") ";  
    	}
    }
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ";
    //
    // Prepare Count Query
    $query =  "SELECT U.id_users, U.Login, U.Name, U.FirstName, U.Email, U.Password, U.Supervisor, U.status ";
    $query .=  "FROM users AS U ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//
	

    // Prepare Output Query
    $query =  "SELECT U.id_users, U.Login, U.Name, U.FirstName, U.Email, U.Password, U.Supervisor, U.status, U.photo ";
    $query .=  "FROM users AS U ";
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
	$users_result_array = array();
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
			  $users_result_array[] = $obj;
			} // end while ($obj = DB_FetchObject($result));

			$http_result_data .= '<users_list>' . "\r\n";	
			foreach ($users_result_array as $obj_arr) {		
				$http_result_data .= '<users>' . "\r\n";

					$http_result_data .= '<id_users>' . $obj_arr->id_users . '</id_users>' . "\r\n";
					$http_result_data .= '<login><![CDATA[' . $obj_arr->Login . ']]></login>' . "\r\n";
					$http_result_data .= '<name><![CDATA[' . $obj_arr->Name . ']]></name>' . "\r\n";
					$http_result_data .= '<firstname><![CDATA[' . $obj_arr->FirstName . ']]></firstname>' . "\r\n";
					$http_result_data .= '<email><![CDATA[' . $obj_arr->Email . ']]></email>' . "\r\n";
					$http_result_data .= '<password><![CDATA[' . $obj_arr->Password . ']]></password>' . "\r\n";
					$http_result_data .= '<supervisor>' . $obj_arr->Supervisor . '</supervisor>' . "\r\n";
					$http_result_data .= '<status>' . $obj_arr->status . '</status>' . "\r\n";
					$http_result_data .= '<photo><![CDATA[***]]></photo>' . "\r\n";
					//$http_result_data .= '<photo><![CDATA[' . base64_encode($obj_arr->photo) . ']]></photo>' . "\r\n";

				$http_result_data .= '</users>' . "\r\n";
			} // end foreach
			$http_result_data .= '</users_list>' . "\r\n";
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