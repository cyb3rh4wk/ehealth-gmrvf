<!DOCTYPE html>
<?php

	session_start();
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
	error_reporting(E_ALL);

	include('./connect.php');
	
	ini_set('display_errors', 1);
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
	
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<!-- <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="../../public/css/style.css"> -->
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<title>Home - GMRVF</title>
</head>
<style>
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
  width: 60%;
  margin: auto;
}
</style>

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
				<a class="navbar-brand" href="./index.php">
					<img src="./images/logo.png" alt="Logo">
				</a>
			</div>
			<div class="navbar-collapse collapse" id="navbar-collapse-main">
				<ul class="nav navbar-nav">
					<li class="active"><a href="./index.php">Home</a></li>
					<li><a href="./about.php">About Us</a></li>
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

<!-- Body Starts Here -->

<!-- Carousel Starts Here -->

<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="./images/pic-1.jpg" alt="PIC-1" width="720" height="500">
      </div>

      <div class="item">
        <img src="./images/pic-2.jpg" alt="PIC-2" width="720" height="500">
      </div>
    
      <div class="item">
        <img src="./images/pic-3.jpg" alt="PIC-3" width="720" height="500">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<!-- Carousel Ends Here -->

<br />
<div class="container">
	<div class="panel panel-primary" role="panel">
		<div class="panel-heading"><h3>Home</h3></div>
		<div class="panel-body">
			<h3 class="text-danger"><b>GMR Varalakshmi Fundation</b></h3>
			<div class="row" style="font-size:16px;">
				<div class="col-lg-12">
					<p>
						GMR Varalakshmi Foundation (GMRVF), is the Corporate Social Responsibility arm of the GMR Group. It’s objectives are to develop social infrastructure and enhance the quality of life of communities around the locations that has the Group’s presence. This non-profit (Section 25) company has its own professional staff selected from top academic and social work institutions, and is Governed by Group Chairman, GMR Group.
					</p>
					<p>
						<ul>
							<li>Education</li>
							<li>Health, Hygiene & Sanitation</li>
							<li>Empowerment & Livelihoods</li>
							<li>Community Development</li>
						</ul>
					</p>
					<br />
					<h4 class="text-success"><b>GMRVF Vision</b></h4>
					<p>
						To make sustainable impact on the human development of under-served communities through initiatives in education, health and livelihoods.
					</p>
					<br />
					<h4 class="text-success"><b>Education</b></h4>
					<p>
						The Foundation aims to make quality primary, secondary and tertiary education accessible to all. Towards this, GMRVF focuses on 
						<br />
						<br />
						<span class="text-primary">Educational Institutions:</span>
						<ul>
							<li>GMR Institute of Technology</li>
							<li>Sri GCSR Degree College</li>
							<li>GMR Varalakshmi DAV Public School</li>
							<li>Seethamahalakshmi DAV Public School</li>
						</ul>
						<span class="text-primary">Strengthening Education In Communities:</span><br />
						The Foundation undertakes various educational initiatives in the communities it works with. It also collaborates with the Government in promoting its endeavors to strengthen and improve quality of pre-school and school education...
						<br />
					</p>
					<br />
					<h4 class="text-success"><b>Health, Hygiene and Sanitation:</b></h4>
					<p>
						<span class="text-primary">Health Care Institutions:</span>
						<br />
						The GMR Varalakshmi Foundation started a a 135 bed, Multi-Speciality Hospital at Rajam, Srikakulam Dist, Andhra Pradesh in collaboration with the CARE Hospitals.<br />
						<span class="text-primary">Strengthening Health Care In Communities:</span>
						<br />
						To work towards better health and more healthy lifestyles in the communities where we work.
					</p>
					<br />
					<h4 class="text-success"><b>Empowerment & Livelihoods:</b></h4>
					<p>
						To empower unemployed youth through skill training and entrepreneurship development programmes.
					</p>
					<br />
					<h4 class="text-success"><b>Community Development:</b></h4>
					<p>
						To improve lives & livelihood through participatory programmes.
					</p>
					<br />
					<h4 class="text-success"><b>CORPORATE SOCIAL RESPONSIBILITY:</b></h4>
					<p>
						GMR Group believes Corporates have a special and continuing responsibility towards the society. The grim reality in India is that millions of people still do not have access to basic amenities and live in abject poverty - a situation that cannot be redressed by the Government alone. The business sector needs to understand its corporate-social responsibility and work towards making a difference to society.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Body Ends Here -->

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
<!-- <script src="./js/dropdown.js" type="text/javascript"></script> -->
</body>
</html>
