<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('./connect.php');

session_start();
if(!isset($_SESSION['login']) && $_SESSION['login'] == "")  {
  echo '
    <script>
      alert("Please login to continue...");
    </script>
  ';
  header("Location:index.php");
}
$username = $_SESSION['username'];

include('./connect.php');

$medicine_code;
$action;
$med_data;

foreach($_POST as $key => $value)	{
	if($value != '')	{
		// echo "Key: " . $key . " => " . $value . " Type: " . gettype($value);
		// echo "<br />";
		$medicine_code = explode('_', $key)[0];
		$action = explode('_', $key)[1];
		
		$sql_get_med = "SELECT medicine_code, medicine_name, medicine_remain FROM medicine WHERE medicine_code='" . $medicine_code . "';";
		$result = $conn->query($sql_get_med);
		if($result->num_rows > 0)	{
			$med_data = $result->fetch_assoc();
		}
		// Add if additional quantity added
		if($action == 'req')	{
			$newCount = $med_data['medicine_remain'] + $value;
		} else if ($action == 'used') {	// Subtract if qty used
			// If the qty is not reduced to negative qty
			if(($med_data['medicine_remain'] - $value) > 0)
				$newCount = $med_data['medicine_remain'] - $value;
			else
				$newCount = 0;
		}
		// Store to database
		$sql_medicine_update = "UPDATE medicine SET medicine_remain='" . $newCount . "' WHERE medicine_code='" . $medicine_code . "';";
		if ($conn->query($sql_medicine_update) === TRUE) {
		    $mysql_error = 0;
		} else {
		    $mysql_error = 1;
		}
	}
}

?>

<html lang="en">
<head>
  <meta charset="utf-8">

<!--   <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"> -->
<!--   <link rel="stylesheet" type="text/css" href="./css/style.css"> -->
  <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>Medicine - GMRVF</title>
</head>

<body>  
<!-- Fixed Navigation bar with dropdown menu -->

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="row">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- <a href="./index.php" class="navbar-brand">GMR Foundation</a> -->
        <a class="navbar-brand" href="./index.php">
          <img src="../../public/images/logo.png" alt="Logo">
        </a>
        
      </div>
      <div class="navbar-collapse collapse" id="navbar-collapse-main">
        <ul class="nav navbar-nav">
          <li><a href="./index.php">Home</a></li>
          <li><a href="./about.php">About Us</a></li>
          <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./patient.php">Patient Data</a></li>
              <li class="divider"></li>
              <li class="active"><a href="./medicine.php">Medicine Data</a></li>
              <li class="divider"></li>
              <li><a href="#">Analysis</a></li>
            </ul>
          </li>
          <li><a href="./contact.php">Contact</a></li>
          <!-- User Panel Display -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span> 
                <strong><?php echo $username; ?></strong>
                <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <div>
                  <div class="row">                    
                    <div class="col-lg-11">
                        <span style="font-size: 50px;"class="glyphicon glyphicon-user"></span>
                        <a href="./profile.php">
                          <span class="h4 text-primary" ><strong><?php echo $username; ?></strong></span>
                        </a>
                    </div>
                  </div>
                </div>
              </li>
              <li class="divider"></li>
              <li class="btn btn-default btn-block"><center><a href="#">Settings</a></center></li>
              <li class="divider"></li>
              <li>
                <div class="navbar-login">
                  <div class="row">
                    <div class="col-lg-12">
                      <p>
                        <a href="./logout.php" class="btn btn-danger btn-block">Logout</a>
                      </p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
        <form class="form-inline" action="./search.php">
          <div class="nav navbar-nav navbar-right navbar-form">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="button">Search</button>
              </span>
              <input type="text" class="form-control" name="search" placeholder="Search here..."/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</nav>

<!-- Navigation Bar Ends Here -->
<div class="container">
	<?php
		if($mysql_error == 0)	{
	?>
	<div class="panel panel-success" role="panel">
		<div class="panel-heading"><h3>Success!!!</h3></div>
	<?php
		} else if($mysql_error == 1) 	{
	?>
	<div class="panel panel-danger" role="panel">
		<div class="panel-heading"><h3>Failure...:( :(</h3></div>
	<?php
		}
	?>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
				<?php
					if($mysql_error == 0)	{
				?>
					<h4>Inventory has been Updated!!!</h4>
				<?php
					} else {
				?>
					<h4>Problem updaing Inventory :( :(</h4>
				<?php
					}
				?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<h5><a href="./medicine.php">&lt&lt Medicine Inventory</a></h5>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Footer start -->

<div id="footer" style="background-color : #FFFFCC;">
  <div class="container">
    <p class="muted credit">Copyright &copy 2015 <a href="#">cyb3rh4wk</a>.</p>
  </div>
</div>

<!-- End Footer -->
<script src="../../public/js/jquery.js"></script>
<script src="../../public/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/custom.js" type="text/javascript"></script>
<script src="../../public/js/jquery.form.js" type="text/javascript"></script>
<!-- <script src="./js/jquery.js"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"></script>
<script src="./js/jquery.form.js" type="text/javascript"></script>
<script src="./js/custom.js" type="text/javascript"></script> -->
<!-- <script src="../../public/js/dropdown.js" type="text/javascript"></script> -->
</body>
</html>
