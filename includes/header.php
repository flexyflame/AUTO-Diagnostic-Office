<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/functions.php");


  //Create Session
  $SESSION = new ClassSession();
  $UTIL = new ClassUtil($SESSION);

  if (!isset($_SESSION)) { 
    //Start Session
      session_start();
  }

  $_SESSION['error_type'] = '';

  //Login 
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
      //TODO:
  }

  //Check session
  if (isset($_SESSION['id_users'])) {
    $SESSION->Session_Check($_SESSION['id_users'], $_SESSION['supervisor']);
  }

  // collect value of input field
  if (isset($_REQUEST['aktion']) && $_REQUEST['aktion'] == "login") {
      $username = "";
      if (isset($_REQUEST['text_username'])) {
          $username = $_REQUEST['text_username'];
      }

      $password = "";
      if (isset($_REQUEST['text_password'])) {
          $password = $_REQUEST['text_password'];
      }

      if ($SESSION->Session_Login($username, $password) == TRUE) { 
        //print("You were successfully logged in.");
        $_SESSION['error_type'] = 'login_success';
        $_SESSION['login_access'] = TRUE;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        //header("Location: dashboard.php"); 

      } else {
        //print("The login failed.");
        $_SESSION['error_type'] = 'login_error';
        $_SESSION['login_access'] = FALSE;
      } // end if
  }  else if (isset($_REQUEST['aktion']) && $_REQUEST['aktion'] == "logout") {
      // remove all session variables
      session_unset();
      // destroy the session
      session_destroy();
      //print("You were successfully logged out.");
      $_SESSION['error_type'] = 'logout_success';
      $_SESSION['school_access'] = FALSE;
      $_SESSION['login_access'] = FALSE;
  }

  if (isset($_SESSION['login_access'])) {
    $SESSION->GLOBAL_LOGIN_ACCESS = $_SESSION['login_access'];
  } 

  if (isset($_SESSION['school_access'])) {
    $SESSION->GLOBAL_SCHOOL_ACCESS = $_SESSION['school_access'];
  } else {
    $_SESSION['school_access'] = FALSE;
  } 
  

?> 

<!DOCTYPE html>

<!--Openning of html, head and body tags--> 
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="generator" content="Site Designer 4.0.3206">

    <title>AUTO Diagnostic Office</title>
   <!--  -->

    <!--Integrate DataTables-->
    <!-- <link rel="stylesheet" type="text/css" href="/plug-ins/DataTables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/plug-ins/DataTables/DataTables-1.10.22/css/dataTables.foundation.min.css"/> -->

    <!--Integrate DataTables Buttons-->
    <!-- <link rel="stylesheet" type="text/css" href="/plug-ins/DataTables/Buttons-1.6.5/css/buttons.foundation.min.css"/> -->

    <!--Integrate SearchBuilder-->
    <!-- <link rel="stylesheet" type="text/css" href="/plug-ins/DataTables/SearchBuilder-1.0.0/css/searchBuilder.foundation.min.css"/> -->

     <!--Integrate foundation
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">-->
    <link rel="stylesheet" href="/foundation-6.6.3/css/foundation.min.css">
    
    <link rel="shortcut icon" type="/image/png" href="/images/favicon.ico"/>
    <link rel="stylesheet" href="/css/foundation-datepicker.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/select2.min.css">

    <!--Integrate fontawesome-->
    <link rel="stylesheet" href="/fonts/fontawesome-free-5.14.0-web/css/all.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    END Integrate fontawesome-->

  </head>

  <body>
    <div><input name="session_hidden" type="hidden" id="session_hidden" user_fullname="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>"  value="<?php echo isset($_SESSION['login_access']) ? $_SESSION['login_access'] : ''; ?>" /></div>

 