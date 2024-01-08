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
    if (isset($_REQUEST['id'])) { 
    	if (($_REQUEST['id'] != 0) && ($_REQUEST['id'] != "")) {
    		$query_where_temp .= " AND (V.id='" . $_REQUEST['id'] . "') "; 
    	}
    }

    if (isset($_REQUEST['type'])) { 
    	if ($_REQUEST['type'] != 0) {
    		$query_where_temp .= " AND (V.type='" . $_REQUEST['type'] . "') "; 
    	}
    }
    
    //
    $query_where = " WHERE (1=1)" . $query_where_temp . " ORDER BY id_var_mapping DESC ";
    //
    // Prepare Count Query
    $query =  "SELECT * ";
    $query .=  "FROM id_var_mappings AS V ";
    $query .= $query_where;
    $query .= ";";
    //Execute SQL query
	$result_count = DB_Query($dbconn, $query);
	$query_count = DB_NumRows($result_count);
	//

    // Prepare Output Query
    $query = "SELECT V.id_var_mapping, V.type, V.id, V.variable, V.value, V.aktiv, V.ts_angelegt, V.ts_aenderung ";

    $query .=  "FROM id_var_mappings AS V ";

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

			$http_result_data .= '<id_var_mappings_list>' . "\r\n";	
			foreach ($result_array as $obj_arr) {		
				$http_result_data .= '<id_var_mappings>' . "\r\n";

					$http_result_data .= '<id_var_mapping>' . $obj_arr->id_var_mapping . '</id_var_mapping>' . "\r\n";
					$http_result_data .= '<type><![CDATA[' . $obj_arr->type . ']]></type>' . "\r\n";
					$http_result_data .= '<id><![CDATA[' . $obj_arr->id . ']]></id>' . "\r\n";
					$http_result_data .= '<variable><![CDATA[' . $obj_arr->variable . ']]></variable>' . "\r\n";
					$http_result_data .= '<value><![CDATA[' . $obj_arr->value . ']]></value>' . "\r\n";
					$http_result_data .= '<aktiv><![CDATA[' . $obj_arr->aktiv . ']]></aktiv>' . "\r\n";
					$http_result_data .= '<ts_angelegt><![CDATA[' . $obj_arr->ts_angelegt . ']]></ts_angelegt>' . "\r\n";
					$http_result_data .= '<ts_aenderung><![CDATA[' . $obj_arr->ts_aenderung . ']]></ts_aenderung>' . "\r\n";

				$http_result_data .= '</id_var_mappings>' . "\r\n";
			} // end foreach
			$http_result_data .= '</id_var_mappings_list>' . "\r\n";
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