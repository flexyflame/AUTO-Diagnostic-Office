<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");


// define("WEBHOSTING_BASIC", 1001);
// define("SERVER1_IPV4_ADDR", "85.214.229.37");


class ClassRESTDaten {
//  const constant = 'Konstanter Wert';
//    protected $errors = array();
//    protected $maxLength = 16;
//    protected $allowedSymbols = array('#', '-', '_', '$', '!', '.', ',', '?', '*', '+');
//    public $public = 'Public';
//    protected $protected = 'Protected';
//    private $private = 'Private';
	
	private $ref_SESSION = null; // Pointer to another class

	public $id_user = 0;
	//public $school_code = 0;
	public $ip = '';
   
   /*
	function __construct() {
		// constructor
   	}
	*/
	
	function __construct(&$ref_sess) {
		// constructor
		$this->ref_SESSION = &$ref_sess;
		
		$this->id_user = $_SESSION['id_users']; //$this->ref_SESSION->Session_GetLoginBenutzerID();
		//$this->school_code = $_SESSION['school_code']; //$this->ref_SESSION->Session_GetID_Arbeitsplatz();
		$this->ip = $_SERVER['REMOTE_ADDR'];
   	}


   	function __destruct() {
		// destructor
   	}


    public function setOptions($options) {
/*
        if (isset($options['minSymbols'])) {
            $this->minSymbols = $options['minSymbols'];			
        }
*/
	}
}

?>