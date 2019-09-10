<?php

// Database Credentials:
$dbhostname = "localhost";
//$dbusername = "appscan1";
$dbusername = "root";
// $dbpassword = "appscan1";
$dbpassword = "";
$dbname = "appscan1";

// Conect to MySQL server:
$dbhandle = new mysqli($dbhostname, $dbusername, $dbpassword, $dbname); // or die("FATAL ERROR: Unable to connect to MySQL / MariaDB Server or AppScan Issue Database");

$db = $dbhandle ; // Just in case I forget the variable later in this code.

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

// Connect to AppScan Issue database:
// $dbselected = mysql_select_db("appscan1",$dbhandle) or die("FATAL ERROR: Unable to connect to AppScan Issue Database.");


// Close connection - maybe later
// mysql_close($dbhandle);


?>