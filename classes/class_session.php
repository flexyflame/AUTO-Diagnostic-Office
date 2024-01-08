<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);


require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/mysql_data.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/class_benutzer.php");


class ClassSession {

	private $GLOBAL_SESSION_ID = "";
	private $GLOBAL_ID_USERS = 0;
	private $GLOBAL_LOGIN = "";
	private $GLOBAL_USERNAME = "";
	PUBLIC $GLOBAL_LOGIN_ACCESS = FALSE;
	PUBLIC $GLOBAL_SCHOOL_ACCESS = FALSE;

	PUBLIC $GLOBAL_ARRAY_SHOP_SYSTEMS = array();
	
	private	$dbconn_intern;

	function __construct() {
		// constructor
		// parent::__construct(); ClassBenutzer Constructor aufrufen
		$this->dbconn_intern = DB_Connect_Direct();
   	}

   	public function get_client_ip() {
	    $ipaddress = '';
	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	public function Auth() {
		$api_user = "ad_0000101";
  		$api_key = "DB007SS012021DKBCCTVDQZYGH1JHN8"; //"AA55MK192020IDKCJAHDQZYMAK1JFH9";

		// collect value of input field
		if (isset($_REQUEST['api_user'])) {
			if (isset($_REQUEST['api_key'])) {
				if ($_REQUEST['api_user'] == $api_user && $_REQUEST['api_key'] == $api_key) {
				    return TRUE;
				}
			}	
		}

		return FALSE;
	}

	//Get page
	public function Generate_Link($page = NULL, $args = NULL) {
		
		$g_ValidContentFiles = array(		
       array("name" => "index",
       	"path" => "/",
        "file" => "/index.php",
        "login_needed" => true),
       
       array("name" => "about",
       	"path" => "/",
        "file" => "/about.php",
        "login_needed" => true),

       array("name" => "features",
       	"path" => "/",
        "file" => "/features.php",
        "login_needed" => true),

       array("name" => "dashboard",
       	"path" => "/",
        "file" => "/dashboard.php",
        "login_needed" => true),

       array("name" => "users_overview",
       	"path" => "/administration/",
        "file" => "/users_overview.php",
        "login_needed" => true),

       array("name" => "test_shops_overview",
       	"path" => "/administration/",
        "file" => "/test_shops_overview.php",
        "login_needed" => true),

       array("name" => "customer_overview",
       	"path" => "/administration/",
        "file" => "/customer_overview.php",
        "login_needed" => true),

       array("name" => "shopify_overview",
       	"path" => "/api/api_shopify/",
        "file" => "/shopify_overview.php",
        "login_needed" => true),

       array("name" => "vehicle_class_overview",
       	"path" => "/administration/",
        "file" => "/vehicle_class_overview.php",
        "login_needed" => true),

       array("name" => "vehicle_producer_overview",
       	"path" => "/administration/",
        "file" => "/vehicle_producer_overview.php",
        "login_needed" => true),

       array("name" => "limits_overview",
       	"path" => "/administration/",
        "file" => "/limits_overview.php",
        "login_needed" => true),

       array("name" => "vehicle_tests_overview",
       	"path" => "/file/",
        "file" => "/vehicle_tests_overview.php",
        "login_needed" => true),

   		);

		// check if page is valid
		$z_Path = "/";

		if ($page == NULL) {
			$page = "index"; 	

		} else {
			$login_needed = true;
			$content_file_found = false;
			foreach ($g_ValidContentFiles as $key => $daten) {	
				if ($page == $daten['name']) {

					$z_Path = $daten['path'];
					$page_php_ext = ($_SERVER['DOCUMENT_ROOT'] . $z_Path . $page . ".php");

					//echo $page_php_ext;

					if (file_exists($page_php_ext )) {
						$content_file_found = true;
						$login_needed = $daten['login_needed'];				
					} else {
						$content_file_found = false;
					} // end if (file_exists($page_php_ext));
				} // end if ($page == $daten['name']);
			} // end foreach



			if ($content_file_found == false) { // no valid page found: display defaults to "index_main"
		        $page = "content_404";
		        $page_php_ext = "/includes/content_404.php";
			} else { // valid page found
			
				// allright, don't change variables
				$page;
				$page_php_ext;

			} // end if

		}
	
		// prepare args (without & or ? on beginning)
		if ($args != NULL) {
			if ( (substr($args, 0, 1) == '&') || (substr($args, 0, 1) == '?') ) {
				$args = substr($args, 1, (strlen($args) - 1));
			} // end if
		} // end if ($args != NULL);

		// rawurlencode parameters
		$get_parameters_string = "";
		$args = str_replace("+", "%2B", $args);
		parse_str($args, $arr_get_parameters);
		foreach ($arr_get_parameters AS $key => $value) {
			$get_parameters_string .= "&" . $key . "=" . rawurlencode($value);
		} // end foreach	

		$retval = "";
		if ($page === "#") {
			$retval = "#";
		} else {
			$retval = $z_Path . rawurlencode($page) . ".php?" . $get_parameters_string;	
		}
		return $retval;
	}

	public function Session_Login($user, $pass) {
		//
		// Login USER
		$_SESSION['admin'] = FALSE;
		//
		$query_users = "SELECT * FROM users AS U WHERE U.Login='$user' AND U.Password='$pass';";
							
		$result_users = DB_Query($this->dbconn_intern, $query_users);
		if ($result_users != false) {
			if (DB_NumRows($result_users) > 0) {		
				$obj_users = DB_FetchObject($result_users);

				$_SESSION['id_users'] = $obj_users->id_users;
				$_SESSION['fullname'] = $obj_users->FirstName . " " . $obj_users->Name;
				$_SESSION['login_access'] = TRUE;
				$_SESSION['school_access'] = TRUE;
				$_SESSION['supervisor'] = $obj_users->Supervisor;

				if ($obj_users->Supervisor == 1) {
					//echo $obj_users->Name . ": ";
					$_SESSION['admin'] = TRUE;				
				} // end if

				$this->Session_Check($_SESSION['id_users'], $_SESSION['supervisor']);

				DB_FreeResult($result_users);

				return TRUE;

			} // end if
		
		} // end if ($result != false);
	}

	public function Session_Check($id_users, $is_supervisor = 0) {
		//
		$this->GLOBAL_ARRAY_SHOP_SYSTEMS = array();
		$id_shop_system_list = '';
		//
		if ($is_supervisor == 0) {

			$query = "SELECT id_shop_system FROM users_shop_systems_mapping AS USSM WHERE USSM.id_users='$id_users';";
			$result = DB_Query($this->dbconn_intern, $query);
			while ($obj = DB_FetchObject($result)) {
				$id_shop_system_list .= $obj->id_shop_system . ',';
			} // end while ($obj = DB_FetchObject($result));
			DB_FreeResult($result);

			$query_users_shop_systems = "SELECT S.id_shop_system, S.shop_name, " . $id_users . " AS id_users FROM shop_systems AS S WHERE S.id_shop_system IN ('$id_shop_system_list');";
		} else {
			$query_users_shop_systems = "SELECT S.id_shop_system, S.shop_name, " . $id_users . " AS id_users FROM shop_systems AS S;";
		} 

		$result_users_shop_systems_mapping = DB_Query($this->dbconn_intern, $query_users_shop_systems);
		if ($result_users_shop_systems_mapping != false) {
			while ($obj_users_shop_systems_mapping = DB_FetchObject($result_users_shop_systems_mapping)) {
				$this->GLOBAL_ARRAY_SHOP_SYSTEMS[] = $obj_users_shop_systems_mapping;
			} // end while ($obj_users_shop_systems_mapping = DB_FetchObject($result_users_shop_systems_mapping));
			DB_FreeResult($result_users_shop_systems_mapping);
		} // end if ($result_users_shop_systems_mapping != false);
	}

	public function Session_GetArrayShopSystems() {
		return $this->GLOBAL_ARRAY_SHOP_SYSTEMS;
	}


} //end class ClassSession

?>