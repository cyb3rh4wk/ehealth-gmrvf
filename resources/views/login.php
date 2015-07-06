<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Login credentials
$user = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

//Database credentials
$db_server = "localhost";
$db_dbname = "health";
$db_uname = "root";
$db_password = "krishna";

// Connect to database
try {
	$conn = new PDO("mysql:host=$db_server;dbname=$db_dbname", $db_uname, $db_password);
	// set PDO error to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Connected Successfully!!!";
} catch (PDOException $e) {
	echo "Connection Failed: " . $e->getMessage();
}

//Check the uname and password with the ones in database
// $pass_crypt = md5($password);
try {
	$sql = "SELECT U.username,U.password FROM users U WHERE U.username=:user AND U.password=:password";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':password', $password);
	$stmt->execute();
	// $result = $stmt->fetchAll();

	if($stmt->rowCount() > 0)	{
		session_start();
		$_SESSION['login'] = 1;
		$_SESSION['username'] = $user;
		header("Location:patient.php");
	}
	else {
		session_start();
		$_SESSION['login'] = '';
		header("Location:fail.php");
	}
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage;
}

$stmt = null;
$conn = null;
?>