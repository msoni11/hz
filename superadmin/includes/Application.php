<?php
################################################## 
# Start the session                              # 
################################################## 

//ini_set("session.gc_maxlifetime", 14440);
ini_set('session.cookie_lifetime', 0); 
ini_set('session.cache_expire', 0); 
date_default_timezone_set('Asia/Calcutta');
session_start();   

error_reporting(0);
//error_reporting(E_ALL ^ E_NOTICE);


// Set Database Parameters
$appDBHost					= 'localhost';
$appDBUser					= 'root';
$appDBPassword				= '';
$appDBDatabase				= 'inventory1';

require '_incClass_mySQL.php';
require '_incGlobalFunctions.php';
?>