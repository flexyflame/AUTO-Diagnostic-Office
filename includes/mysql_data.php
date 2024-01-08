<?php

# postgres database access
$SQL_DB_HOST		= "127.0.0.1";
$SQL_DB_PORT		= "3306";
$SQL_DB_USER		= "u826373320_auto";
$SQL_DB_PASS		= "Derrick@10";

# databases
$SQL_DB_NAME		= "u826373320_auto";


function DB_AffectedRows($result) {
// function to get number of affected rows (e.a. for DELETE, INSERT or UPDATE query)
	$affected_rows = mysqli_affected_rows($result);
	return $affected_rows;
}


function DB_Close($dbconn) {
// function to close a connection to a SQL database
	mysqli_close($dbconn);
}


function DB_Connect($host, $port, $user, $pass, $dbname) {
// function to connect to a SQL database (returns a database connection handle to further use)
	//$conn_string = "host=" . $host . " port=" . $port . " dbname=" . $dbname . " user=" . $user . " password=" . $pass;
	//$dbconn = mysqli_connect($conn_string) or print("Connection establishment failed: " . error_get_last());

	$dbconn = mysqli_connect($host, $user, $pass, $dbname, $port);
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}

	return $dbconn;
}

function DB_Connect_Direct() {
// function to connect to whcontrol DB
	$dbconn = DB_Connect($GLOBALS['SQL_DB_HOST'], $GLOBALS['SQL_DB_PORT'], $GLOBALS['SQL_DB_USER'], $GLOBALS['SQL_DB_PASS'], $GLOBALS['SQL_DB_NAME']);
	return $dbconn;
}


function DB_FetchObject($result) {
// function to fetch an object from a result set (returns a result object)
	$obj = mysqli_fetch_object($result);
	return $obj;
}


function DB_FetchRow($result) {
// function to fetch a row from a result set (returns a result row)
	$row = mysqli_fetch_row($result);
	return $row;
}


function DB_FreeResult($result) {
// function to free a database result
	if ($result != false) mysqli_free_result($result);
}


function DB_Msg_ResultFalse() {
// DB message function
	return "- The database returns a Result == FALSE.";
}


function DB_NumColumns($result) {
	$num_columns = mysqli_num_fields($result);
	return $num_columns;
}


function DB_NumRows($result) {
// function to get the number of rows from a result (returns number of rows in a result set)
	$num_rows = mysqli_num_rows($result);
	return $num_rows;
}


function DB_Query($dbconn, $query) {
// function to do a database query (returns the result of a SQL query)
	$result = mysqli_query($dbconn, $query);
	if ($result == false) print("Query failed: " . error_get_last() . " " . $query);
	return $result;
}

?>