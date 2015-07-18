<?php

//Connect to database
//Database credentials
$db_server = "127.12.229.2";
$db_dbname = "ehealth";
$db_uname = "admin";
$db_password = "saikrishna";

// Connect to database
$conn = new mysqli($db_server, $db_uname, $db_password, $db_dbname);
if($conn->connect_error)	{
	die("Connection Failed: " . $conn->connect_error);
}

$mysql_error = 1;

?>