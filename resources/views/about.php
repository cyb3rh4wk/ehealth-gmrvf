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
	<title>About Us - GMRVF</title>
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
					<li class="active"><a href="./about.php">About Us</a></li>
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
					<li><a href="./contact.php">Contact</a></li>
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
    <div class="panel-heading"><h3>About Us</h3></div>
    <div class="panel-body">
      <h3 class="text-danger"><b>Objective:</b></h3>
      <div class="row" style="font-size:16px;">
      	<div class="col-lg-12">
      		To work towards better health and more healthy lifestyles in the communities where we work.
      	</div>
      </div>
      <h3 class="text-danger"><b>Health:</b></h3>
      <div class="row" style="font-size:16px;">
      	<div class="col-lg-8">
      		GMRVF, in collaboration with HelpAge India, is running 3 Mobile Medical Units dedicated to taking healthcare to the doorsteps of the elderly. The units provide free medical checks and medicines to those over 60 years of age. These medical units cover over 90 villages visiting each of them every week. Over 4500 elderly people benefit from this initiative. 
      		<br /><br />
			The Foundation also runs ambulances in remote areas. For people in these areas it is very difficult to reach health centers and hospitals quickly. Each of these ambulances attends to about 30-40 emergency cases every month, and has saved many a life. 
			<br /><br />
			General and specific medical camps are conducted in all the Foundation’s work areas. GMRVF stresses on school health check-ups and health education in schools and communities. 
			<br /><br />
			The Foundation also runs regular clinics for identified communities which do not have qualified doctors. At Lambagarh, in Uttarakhand, it runs a weekly clinic. In the remote villages of Hyderabad where trained and qualified doctors are not available GMRVF runs weekly clinics. The Foundation runs both Allopathic and Ayurvedic clinics in Mangalore. 
			<br /><br />
			The Foundation has also initiated Health awareness on AIDS and other deadly diseases for the communities it works with. 
      	</div>
      </div>
      <h3 class="text-danger"><b>Hygiene And Sanitation:</b></h3>
      <div class="row" style="font-size:16px;">
      	<div class="col-lg-8">
			The Foundation has built and is maintaining 8 public toilets in villages and slums. These clean and hygienic toilets are made available to families of the communities for a nominal fee of Rs. 10 per family per month. These toilets have improved the sanitary condition in the areas and are of great help especially to the women of these communities. 
			<br /><br />
			In a Public-Private Partnership with the Municipal Corporation of Hyderabad, the Foundation is building and operating ‘Pay and Use’ toilets in the city. These facilities, in the short time that they have been in operation, have won recognition for setting new standards in the maintenance of public conveniences. Thorough research and professional design inputs have gone into the making of these toilets. Regular monitoring and inspections help in maintaining high hygiene and health standards. 
			<br /><br />
			In some areas like Vemagiri, Foundation supported the communities in the construction of Individual Sanitary Lavatories by leveraging the support from Government. Over 200 families benefited from this initiative and open defecation in these villages has reduced to a great extent. 
			<br /><br />
			The Foundation also imparts education on sanitation and personal hygiene to the communities.
      	</div>
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
