<!DOCTYPE html>
<?php
	session_start();
	$username = $_SESSION['username'];
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include('./connect.php');
	
	if(isset($_POST['username']) && isset($_POST['password']))	{
		// Login credentials
		$user = isset($_POST['username']) ? $_POST['username'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;

		//Check the uname and password with the ones in database
		// $pass_crypt = md5($password);

		$sql = "SELECT U.username,U.password FROM users U WHERE U.username=? AND U.password=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $user, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0)	{
			session_start();
			$_SESSION['login'] = 1;
			$_SESSION['username'] = $user;
			header("Location:patient.php");
		}
		else {
			session_start();
			$_SESSION['login'] = '';
			echo '
			<script>
				alert("Invalid Credentials, Please try again..");
			</script>
			';
		}

		$stmt = null;
		$conn = null;
	}
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	
	<link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
	<!-- <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css"> -->
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Contact Us - GMRVF</title>
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Services<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="./patient.php">Patient Data</a></li>
							<li class="divider"></li>
							<li><a href="./medicine.php">Medicine Data</a></li>
							<li class="divider"></li>
							<li><a href="#">Analysis</a></li>
						</ul>
					</li>
					<li class="active"><a href="./contact.php">Contact</a></li>
					<?php
						if(isset($_SESSION['login']) && $_SESSION['login'] == 1)	{
							echo 
								'<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span class="glyphicon glyphicon-user"></span> 
										<strong>' . $username . '</strong>
										<span class="glyphicon glyphicon-chevron-down"></span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<div>
												<div class="row">                    
													<div class="col-lg-11">
														<span style="font-size: 50px;"class="glyphicon glyphicon-user"></span>
														<a href="./profile.php">
															<span class="h4 text-primary" ><strong>' . $username . '</strong></span>
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
								</li>';
						}
					?>
					
				</ul>
				<form class="form-inline" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
					<div class="navbar-right navbar-form"> 
						<input type="text" class="form-control" name="username" placeholder="Username"/>
						<input type="password" class="form-control" name="password" placeholder="Password"/>
						<input type="submit" class="btn btn-primary" value="Login"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</nav>

<!-- Content Start -->

<div class="container" >
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading"><h3>Contact</h3></div>
    <div class="panel-body">
      <div class="table">
      	<tr>
      		<td>
		      	<address>
		      		<h4><strong>Venkata Narayana Dakkina</strong></h4>
					<strong>GMR Varalakshmi Centre for Empowerment and Livelihoods</strong><br>
					Shamshabad-Mammidipally Road, RGIA Campus, Shamshabad, RR Distt<br>
					Telangana, India 501218<br>
					<abbr title="Phone">P:</abbr> +91-77 02 004025<br>
					<b>E-Mail</b>: VenkataNarayana.Dakkina@gmrgroup.in
				</address>
			</td>
			<hr>
			<td>
		      	<address>
		      		<h4><strong>Dr.Avanish Kumar</strong></h4>
					<strong>GMR Varalakshmi Centre for Empowerment and Livelihoods</strong><br>
					Shamshabad-Mammidipally Road, RGIA Campus, Shamshabad, RR Distt<br>
					Telangana, India 501218<br>
					<abbr title="Phone">P:</abbr> +91-92 47 087620
					<abbr title="Mobile">M:</abbr> +91 99 89 143338<br>
					<b>E-Mail</b>: Avanish.Kumar@gmrgroup.in
				</address>
			</td>
		</tr>
      </div>
    </div>
  </div>
</div>

<!-- Content End -->

<!-- Footer start -->

<div id="footer" style="background-color : #FFFFCC;">
	<div class="container">
		<p class="muted credit">Copyright &copy 2015 <a href="#">cyb3rh4wk</a>.</p>
	</div>
</div>

<!-- End Footer -->
<script src="../../public/js/jquery.js"></script>
<script src="../../public/js/bootstrap.min.js" type="text/javascript"></script>
<!-- <script src="./js/jquery.js"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"></script> -->
<!-- <script src="../../public/js/dropdown.js" type="text/javascript"></script> -->
</body>
</html>