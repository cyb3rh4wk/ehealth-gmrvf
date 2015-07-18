<!DOCTYPE html>
<?php
	session_start();
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
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
	
	<!-- <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="../../public/css/style.css"> -->
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>About Us - GMRVF</title>
	<style type="text/css">
		table, th, td {
		    border: 1px solid black;
		    border-collapse: collapse;
		}
		th, td {
		    padding: 5px;
		}
	</style>
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
					<li class="active"><a href="./about.php">About Us</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Services<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="./patient.php">New Patient</a></li>
              				<li><a href="./ex-patient.php">Exisiting Patient</a></li>
              				<li><a href="./id.php">Generate ID</a></li>
							<li class="divider"></li>
							<li><a href="./medicine.php">Medicine Data</a></li>
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
			<h3 class="text-danger"><b>Evening Medical Clinics:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-12">
					<p>
						In 2005, when Mobile Medical Unit(MMU) was started by GMRVF for elderly people, people of the age groups used to visit MMU's for availing health services. The treatment cases were around 100-150 per day, so the staff could not manage the crwod and neither were they in a position to ask people other than the elderly people not to come to the MMU's. Because at that time people had just started developing trust towards MMU as well as GMR Varalakshmi Foundation.
					</p>
					<p>
						As a solution for this predicament, GMR Varalakshmi Foundation took the decision to run an Evening Medical Clinic between 5:00 PM to 7:30 PM for providing health services to the people aged below 60.In 2007, Evening Medical CLinics were started in 4 Villages(Airport Colony, Shamshabad, Gollapally, Mamidipally) where people lost their land during acquisition for Rajiv Gandhi International Airport, Hyderabad.Later on special request from Hameedullanagar which had partially lost land to Airport in 2009, The services were extended to this village also.
					</p>
					<p>
						All these villages(except Shamshabad) have no qualified Medical practitioner and there were only RMP's practicing in their village. The nearest PHC is also in Shamshabad which is quite far from other villages.
					</p>
				</div>
			</div>
			<h3 class="text-danger"><b>Objective:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-12">
					1.To provide basic health check-ups, treatment/medicines, counselling free of cost to the general population at their doorstep.
				<br>
					2.To provide referral services
				</div>
			</div>
			<h3 class="text-danger"><b>Clinic timing and Coverage:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-12">
					<p>The doctor and the pharmacist who run the MMU,visit the clinics in the evening and render health services.Evening medical clinics have been running as per the following weekly schedule between 5pm to 7:30 pm at GMRVF's Bhavitha library premises.
					The following table shows schedule of Evening medical clinics:
					</p>
				</div>
			</div>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-8">
					<table style="width:100%; font-size:16px;">
					  <tr>
					    <th>Days</th>
					    <th>Name of the village</th>		 
					  </tr>
					  <tr>
					    <td>Monday</td>
					    <td>Airport colony</td>		 
					  </tr>
					  <tr>
					    <td>Tuesday</td>
					    <td>Shamshabad</td>		  
					  </tr>
					  <tr>
					    <td>Wednesday</td>
					    <td>Mamidipally</td>		
					  </tr>
					   <tr>
					    <td>Thurssday</td>
					    <td>Gollapally</td>		
					  </tr>
					   <tr>
					    <td>Friday</td>
					    <td>Hamedullanagar</td>		
					  </tr>
					</table>
				</div>
			</div>
			<h3 class="text-danger"><b>Coverage:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-8">
					<table style="width:100%">
					  <tr>
					    <th>Year</th>
					    <th>Number of villages covered</th>	
					    <th>Number of beneficiaries</th>	
					    <th>Nmber of referrals</th>
					  </tr>
					  <tr>
					    <td>2007-2008</td>
					    <td>3</td>		
					    <td>7151</td>
						<td>694</td>
					  </tr>
					  <tr>
						<td>2008-2009</td>
					    <td>4</td>		
					    <td>8330</td>
						<td>814</td>
					  </tr>
					  <tr>
					    <td>2009-2010</td>
					    <td>5</td>		
					    <td>8525</td>
						<td>713</td>
					  </tr>
					   <tr>
					   <td>2010-2011</td>
					    <td>5</td>		
					    <td>9727</td>
						<td>804</td>
					  </tr>
					   <tr>
					    <td>2011-2012</td>
					    <td>5</td>		
					    <td>8956</td>
						<td>696</td>		
					  </tr>
					   <td>Grand total</td>
					    <td>5</td>		
					    <td>40,689</td>
						<td>3721</td>		
					  </tr>
					</table>
				</div>
			</div>
			<h3 class="text-danger"><b>Services:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-8">
					<p>
						Free services are being provided in Evening medical clinic to all the age groups except elderly person
						<br></br>
						1.Health check-ups
						<br></br>
						2.Medicines
						<br></br>
						3.counselling and 
						<br></br>
						4.Referral services(Patients are referred to government/private hospitals where they can get quality service)
					</p>
				</div>
			</div>
			<h3 class="text-danger"><b>Suggestions:</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-12">
					<p>
						For any suggestions please <a href="./contact.php">Click Here</a>
					</p>
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
<!-- <script src="../../public/js/jquery.js"></script>
<script src="../../public/js/bootstrap.min.js" type="text/javascript"></script> -->
<script src="./js/jquery.js"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"></script>
<!-- <script src="../../public/js/dropdown.js" type="text/javascript"></script> -->
</body>
</html>
