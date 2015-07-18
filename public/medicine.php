<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('./connect.php');

session_start();
if(!isset($_SESSION['login']) && $_SESSION['login'] == "")  {
  header("Location:index.php");
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <!-- <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="../../public/css/style.css"> -->
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
          <img src="./images/logo.png" alt="Logo">
        </a>
        
      </div>
      <div class="navbar-collapse collapse" id="navbar-collapse-main">
        <ul class="nav navbar-nav">
          <li><a href="./index.php">Home</a></li>
          <li><a href="./about.php">About Us</a></li>
          <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./patient.php">New Patient</a></li>
              <li><a href="./ex-patient.php">Exisiting Patient</a></li>
              <li><a href="./id.php">Generate ID</a></li>
              <li class="divider"></li>
              <li class="active"><a href="./medicine.php">Medicine Data</a></li>
              <li class="divider"></li>
              <li class="dropdown-submenu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Analysis</a>
                <ul class="dropdown-menu">
                  <li><a href="./analysis_village.php">Village vs Gender</a></li>
                  <li><a href="./analysis_disease.php">Disease vs Gender</a></li>
                </ul>
              </li>
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
              <li class="btn btn-default btn-block"><center><a href="./settings.php">Settings</a></center></li>
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

<div class="container" >
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading">MEDICINE INVENTORY</div>
    <div class="panel-body">
<!-- 		Medicines from Database -->
<!-- 		Retrieve data from database -->
		<form name="medicine_form" method="post" action="medicine_update.php">
		<?php
			$sql_medicine = "SELECT medicine_code, medicine_name, medicine_remain FROM medicine;";
			$result = $conn->query($sql_medicine);
			
			if($result->num_rows > 0)	{
		?>
			<table class="table">
				<thead>
					<tr>
						<th>Medicine Code</th>
						<th>Medicine Name</th>
						<th>Remaining</th>
						<th>Add Qty</th>
						<th>Used</th>
					</tr>
				</thead>
				<tbody>
		<?php
				//output data of each row
				while($row = $result->fetch_assoc())	{
					echo "<tr>
							<td>" . $row['medicine_code'] . "</td>" .
							"<td>" . $row['medicine_name'] . "</td>" .
							"<td>" . $row['medicine_remain'] . "</td>" .
							"<td>" . 
							'<div class="row">
								<div class="form-group">
								<div class="col-lg-3">
									<input type="text" id="' . $row['medicine_code'] . '_req" class="form-control" name="' . $row['medicine_code'] . '_req" placeholder="###" />
								</div>
								</div>
							</div>'
							. "</td>" .
							"<td>" . 
							'<div class="row">
								<div class="form-group">
								<div class="col-lg-3">
									<input type="text" id="' . $row['medicine_code'] . '_used" class="form-control" name="' . $row['medicine_code'] . '_used" placeholder="###" />
								</div>
								</div>
							</div>'
							. "</td>" .
						"</tr>";
		?>
				
		<?php
				}
		?>
				</tbody>
			</table>
		<?php
			}
		?>
		<center>
			<div class="row">
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-2">
						<input type="submit" class="btn btn-primary" style="width:100px" value="Update" />
					</div>
				</div>
			</div>
		</center>
		</form>
    </div>
  </div>
  
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading">ADD NEW MEDICINE</div>
    <div class="panel-body">
<!-- 		Medicines from Database -->
<!-- 		Retrieve data from database -->
		<form name="medicine_form" method="POST" action="medicine_new.php">
			<table class="table">
				<thead>
					<tr>
						<th>Medicine Code</th>
						<th>Medicine Name</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="row">
							<div class="col-lg-5">
							<div class="form-group">
								<input type="text" id="medicine_code" class="form-control" name="medicine_code" placeholder="Medicine Code" />
							</div>
							</div>
							</div>
						</td>
						<td> 
							<div class="form-group">
								<input type="text" id="medicine_name" class="form-control" name="medicine_name" placeholder="Medicine Name" />
							</div>
						</td>
						<td>
							<div class="row">
							<div class="col-lg-3">
							<div class="form-group">
								<input type="text" id="medicine_remain" class="form-control" name="medicine_qty" placeholder="###" />
							</div>
							</div>
							</div>
						</td>
<!--						<td>
							<div class="form-group">
								<input type="text" id="medicine_req" class="form-control" name="medicine_req" placeholder="###" />
							</div>
						</td>
						<td>
							<div class="form-group">
								<input type="text" id="medicine_used" class="form-control" name="medicine_used" placeholder="###" />
							</div>
						</td>-->
					</tr>
				</tbody>
			</table>
			<center>
				<div class="row">
					<div class="form-group">
						<div class="col-lg-offset-5 col-lg-2">
							<input type="submit" class="btn btn-primary" style="width:100px" value="Add" />
						</div>
					</div>
				</div>
			</center>
		</form>
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
<!-- <script src="../../public/js/jquery.js"></script>
<script src="../../public/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../public/js/custom.js" type="text/javascript"></script>
<script src="../../public/js/jquery.form.js" type="text/javascript"></script> -->
<script src="./js/jquery.js"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"></script>
<script src="./js/jquery.form.js" type="text/javascript"></script>
<script src="./js/custom.js" type="text/javascript"></script>
<!-- <script src="./js/dropdown.js" type="text/javascript"></script> -->
</body>
</html>
