<?php

//Connect to database
//Database credentials
$db_server = "localhost";
$db_dbname = "health";
$db_uname = "root";
$db_password = "krishna";

// Connect to database
$conn = new mysqli($db_server, $db_uname, $db_password, $db_dbname);
if($conn->connect_error)	{
	die("Connection Failed: " . $conn->connect_error);
}

$mysql_error = 0;

?>