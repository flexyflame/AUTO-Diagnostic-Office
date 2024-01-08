<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);



class ClassREST {	
	const REQUEST_METHOD_DELETE = 0;
	const REQUEST_METHOD_GET = 1;
	const REQUEST_METHOD_POST = 2;
	const REQUEST_METHOD_PUT = 3;
		
	private $m_iTestVariable = self::REQUEST_METHOD_DELETE;
	
   
	function __construct() {
		// constructor
   	} // end __construct();


   	function __destruct() {
		// destructor
   	} // end __destruct();
	
	
	public function curl_delete_request($url, $data, $array_optional_headers = NULL, $die_on_error = true) {
		// Funktionswrapper für "curl_request" als DELETE-Methode
		return self::curl_request('DELETE', $url, $data, $array_optional_headers, $die_on_error);
	} // end curl_delete_request();
	
	
	public function curl_get_request($url, $data, $array_optional_headers = NULL, $die_on_error = true) {
		// Funktionswrapper für "curl_request" als GET-Methode
		return self::curl_request('GET', $url, $data, $array_optional_headers, $die_on_error);
	} // end curl_get_request();
	
	
	public function curl_post_request($url, $data, $array_optional_headers = NULL, $die_on_error = true) {
		// Funktionswrapper für "curl_request" als POST-Methode
		return self::curl_request('POST', $url, $data, $array_optional_headers, $die_on_error);
	} // end curl_post_request();
	
	
	public function curl_put_request($url, $data, $array_optional_headers = NULL, $die_on_error = true) {
		// Funktionswrapper für "curl_request" als PUT-Methode
		return self::curl_request('PUT', $url, $data, $array_optional_headers, $die_on_error);
	} // end curl_put_request();
	
	
	public function curl_request($method, $url, $data, $array_optional_headers = NULL, $die_on_error = true) {
		set_time_limit(3600); // Achtung Timeouts in mod_fcgid beachten!!!
		
		// Depending on the API, here json
		$array_headers = array(
			'User-Agent: Derrick Basoah REST Client V1.0',
		    'Accept: application/xml',
		    'Content-Type: application/xml'
		);
		
		if ($array_optional_headers !== NULL) {
 			array_merge($array_headers, $array_optional_headers);
		} // end if (array_optional_headers !== NULL);

		$curl = curl_init();
		 
		switch ($method) {
		    case 'GET':
		        $url .= '?' . $data;
		      break;
		
		    case 'POST':
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;

			case 'PUT':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;

			case 'DELETE':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				$url .= '?' . $data;
			break;
		} // end switch ($method);

// curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_ENCODING, '');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $array_headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,0);
		curl_setopt($curl, CURLOPT_TCP_NODELAY, false);		
		curl_setopt($curl, CURLOPT_TCP_KEEPALIVE, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 300); // timeout in seconds
		
		$response = curl_exec($curl);
		// $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		// $info = curl_getinfo($curl);
		// return $info['connect_time'] . " - " . $info['pretransfer_time'] . " - " . $info['total_time'] . " - " . $info['namelookup_time'] . " - " . $info['pretransfer_time'] . " - " . $info['starttransfer_time'] . " - " . $info['redirect_time'];

		curl_close($curl);

		return $response;		 

		if ($code == 200) {
			die($response);
			return $response;
		} else {
			return '';
		}
	} // end curl_request();
	
	
	public function http_post_request($url, $data, $optional_headers = NULL, $die_on_error = true) {
		set_time_limit(900); // Note the timeouts in mod_fcgid !!!
		$params = array('http' => array('content' => $data, 'method' => 'POST', 'protocol_version' => 1.1, 'timeout' => 890, 'user-agent' => 'Derrick Basoah REST Client V1.0'));
		
		$params['http']['header'] = "Content-Length: " . strlen($data) . "\r\n";
		$params['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\n";
		
		if ($optional_headers !== NULL) {
			$params['http']['header'] .= $optional_headers;
  		}
		
// print_r($params['http']);
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			if ($die_on_error == true) {
				// throw new Exception("Problem with $url, $php_errormsg");
				die("Problem with $url, $php_errormsg");
			} // end if ($die_on_error == true);
		} else {
			$response = @stream_get_contents($fp);
			if ($response === false) {
				if ($die_on_error == true) {
					// throw new Exception("Problem reading data from $url, $php_errormsg");
					fclose($fp);
					die("Problem reading data from $url, $php_errormsg");
				} // end if ($die_on_error == true);
			}
			fclose($fp);
			return $response;
		} // end if ($fp);
		return "";
	} // end http_post_request();
	
	
	public function https_post_request($url, $data, $optional_headers = NULL, $die_on_error = true) {
		set_time_limit(900); // Note the timeouts in mod_fcgid !!!
		$params = array('http' => array('content' => $data, 'method' => 'POST', 'protocol_version' => 1.1, 'timeout' => 890, 'user-agent' => 'MichSoft REST Client V1'));
		
		$params['http']['header'] = "Content-Length: " . strlen($data) . "\r\n";
		$params['http']['header'] .= "Content-Type: application/x-www-form-urlencoded\r\n";
		
		if ($optional_headers !== NULL) {
			$params['http']['header'] .= $optional_headers;
  		}
			
		$params['ssl']['verify_peer'] = false;
		$params['ssl']['verify_peer_name'] = false;
		$params['ssl']['allow_self_signed'] = true;
		
// print_r($params['http']);
		
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			if ($die_on_error == true) {
				// throw new Exception("Problem with $url, $php_errormsg");
				die("Problem with $url, $php_errormsg");
			} // end if ($die_on_error == true);
		} else {
			$response = @stream_get_contents($fp);
			if ($response === false) {
				if ($die_on_error == true) {
					// throw new Exception("Problem reading data from $url, $php_errormsg");
					fclose($fp);
					die("Problem reading data from $url, $php_errormsg");
				} // end if ($die_on_error == true);
			}
			fclose($fp);
			return $response;
		} // end if ($fp);
		return "";
	} // end https_post_request();
		
} // end ClassREST

?>