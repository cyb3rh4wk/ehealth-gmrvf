<!DOCTYPE html>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('./connect.php');

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Form data to variable declarations

// Personal Data
$pid = isset($_POST["pid"]) ? $_POST["pid"] : null;
	if(empty($pid) || length($pid) > 12)	{
		$pid_error = 1;
	} else 	{
		$pid_error = 0;
	}
$first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : null;
$last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : null;
$father_name = isset($_POST["father_name"]) ? $_POST["father_name"] : null;
$mother_name = isset($_POST["mother_name"]) ? $_POST["mother_name"] : null;
$dob = isset($_POST["dob"]) ? $_POST["dob"] : null;
	if(validateDOB($dob))	{
		$dob_error = 0;
	} else 	{
		$dob_error = 1;
	}
$sex = isset($_POST["sex"]) ? $_POST["sex"] : 3;
$address_street = isset($_POST["address_street"]) ? $_POST["address_street"] : null;
$address_pincode = isset($_POST["address_pincode"]) ? $_POST["address_pincode"] : null;
$address_state = isset($_POST["address_state"]) ? $_POST["address_state"] : null;
$address_country = isset($_POST["address_country"]) ? $_POST["address_country"] : null;
$countryPrefix = isset($_POST["countryPrefix"]) ? $_POST["countryPrefix"] : null;
$contact_mobile = isset($_POST["contact_mobile"]) ? $_POST["contact_mobile"] : null;
$contact = $contact_mobile;

// History
$genetic_problem = isset($_POST['genetic_problem']) ? $_POST['genetic_problem'] : null;
$smoke = isset($_POST['smoke']) ? $_POST['smoke'] : null;
$alcohol = isset($_POST['alcohol']) ? $_POST['alcohol'] : null;
$betel = isset($_POST['betel']) ? $_POST['betel'] : null;
$spicy = isset($_POST['spicy']) ? $_POST['spicy'] : null;
$junk = isset($_POST['junk']) ? $_POST['junk'] : null;
$less_sleep = isset($_POST['less_sleep']) ? $_POST['less_sleep'] : null;

// Investigation(True/False)
$cue = isset($_POST["cue"]) ? $_POST["cue"] : null;
$rbs = isset($_POST["rbs"]) ? $_POST["rbs"] : null;
$cbp = isset($_POST["cbp"]) ? $_POST["cbp"] : null;
$fbs = isset($_POST["fbs"]) ? $_POST["fbs"] : null;
$plbs = isset($_POST["plbs"]) ? $_POST["plbs"] : null;
$ecg = isset($_POST["ecg"]) ? $_POST["ecg"] : null;
$xray = isset($_POST["xray"]) ? $_POST["xray"] : null;
$esr = isset($_POST["esr"]) ? $_POST["esr"] : null;

// Vitals
$bp_systole = '';
$bp_diastole = '';
$bp = isset($_POST["bp"]) ? $_POST["bp"] : null;
	if($bp != null)	{
		$bp = explode('/', $bp);
		$bp_systole = $bp[0];
		$bp_diastole = $bp[1];
	}
$pulse = isset($_POST["pulse"]) ? $_POST["pulse"] : null;
$temperature = isset($_POST["temperature"]) ? $_POST["temperature"] : null;
$respSys = isset($_POST["respSystem"]) ? $_POST["respSystem"] : null;

// Symptoms
$sym = isset($_POST["sym"]) ? $_POST["sym"] : null;
$symptoms;
$i = 0;
$sym_actual_count = 0;
if($sym)	{
	foreach ($sym as $symptom) {
		# code...
		$symptoms[$i++] = $symptom;
		$sym_actual_count++;
	}
}

// Diagnosis
$current_diagnosis = isset($_POST["current_diagnosis"]) ? $_POST["current_diagnosis"] : null;
	// Retrieve present current diagnosis and store it in $previous diagnosis
$medicine_code = isset($_POST["medicine_code"]) ? $_POST["medicine_code"] : null;
$medicine_name = isset($_POST["medicine_name"]) ? $_POST["medicine_name"] : null;
$medicine_given = isset($_POST["medicine_given"]) ? $_POST["medicine_given"] : null;

$medicine_codes;
$i = 0;
$med_code_count = 0;
if($medicine_code)	{
	foreach ($medicine_code as $x) {
		# code...
		$medicine_codes[$i++] = $x;
		$med_code_count++;
	}
}

$medicine_given_all;
$i = 0;
$med_given_count = 0;
if($medicine_code)	{
	foreach ($medicine_given as $x) {
		# code...
		$medicine_given_all[$i++] = $x;
		$med_given_count++;
	}
}
$previous_diagnosis = "";

// START STORING FORM DATA INTO DATABASE
if($pid != '' && $pid != null)	{
	// Store Personal Details
	$created = date('Y-m-d', time());
	$sql_personal = "INSERT INTO patient(p_pid,p_first_name,p_last_name,p_father_name,p_mother_name,p_dob,p_sex,p_address_street,p_address_pincode,p_address_state,p_address_country,p_contact,created)
			VALUES('" . $pid . "','" .
					$first_name . "','" .
					$last_name . "','" .
					$father_name . "','" .
					$mother_name . "','" .
					$dob . "','" .
					$sex . "','" .
					$address_street . "','" .
					$address_pincode . "','" .
					$address_state . "','" .
					$address_country . "','" .
					$contact . "','" .
					$created . "'" .
			");";

	if($conn->query($sql_personal) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_personal . "<br />" . $conn->error;
	}

	// Store History
	$sql_history = "INSERT INTO history(p_pid,p_genetic_problem,p_smoke,p_alcohol,p_betel,p_spicy,p_junk,p_less_sleep)
			VALUES('" . $pid . "','" .
					$genetic_problem . "','" .
					$smoke . "','" .
					$alcohol . "','" .
					$betel . "','" .
					$spicy . "','" .
					$junk . "','" .
					$less_sleep . "'" .
			");";

	if($conn->query($sql_history) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_history . "<br />" . $conn->error;
	}

	// Store Vitals
	$created = date('Y-m-d', time());
	$sql_vitals = "INSERT INTO vitals(p_pid,p_bp_systole,p_bp_diastole,p_temperature,p_pulse,p_respSys,created)
			VALUES('" . $pid . "','" .
					$bp_systole . "','" .
					$bp_diastole . "','" .
					$temperature . "','" .
					$pulse . "','" .
					$respSys . "','" .
					$created . "'" .
			");";

	if($conn->query($sql_vitals) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_vitals . "<br />" . $conn->error;
	}

	// Store Investigation
	$created = date('Y-m-d', time());
	$sql_inv = "INSERT INTO investigation(p_pid,created,p_rbs,p_cbp,p_fbs,p_plbs,p_ecg,p_xray,p_esr,p_cue)
			VALUES('" . $pid . "','" .
					$created . "','" .
					$rbs . "','" .
					$cbp . "','" .
					$fbs . "','" .
					$plbs . "','" .
					$ecg . "','" .
					$xray . "','" .
					$esr . "','" .
					$cue . "'" .
			");";

	if($conn->query($sql_inv) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_inv . "<br />" . $conn->error;
	}

	// Store Symptoms

	$result = $conn->query("SELECT * FROM symptoms");
	$sym_col_count = $result->field_count - 3;	// Number of symptoms currently present

	if($sym_actual_count > $sym_col_count)	{	// Adding additional number of symptoms columns
		$sql_sym_alter = "ALTER TABLE symptoms ADD COLUMN(";
		for ($j = $sym_col_count + 1; $j <= $sym_actual_count; $j++)	{
			$sql_sym_alter = $sql_sym_alter . "p_sym" . $j . " varchar(255)";
			if($j < $sym_actual_count)	{
				$sql_sym_alter = $sql_sym_alter . ",";
			}
		}
		$sql_sym_alter = $sql_sym_alter . ")";
		if($conn->query($sql_sym_alter) === TRUE)	{
			$mysql_error = 0;
		} else {
			$mysql_error = 1;
			echo "Error " . $sql_sym_alter . "<br />" . $conn->error;
		}
	}

	$sql_sym_1 = "INSERT INTO symptoms(p_pid,created";
	$sql_sym_2 = "VALUES('" . $pid . "','" . $created . "'";

	// foreach($symptoms as $k => $v)	{
	for($i = 0; $i < $sym_actual_count; $i++) {
		$prefix = $i + 1;
		$sql_sym_1 = $sql_sym_1 . ",p_sym" . $prefix;
		$sql_sym_2 = $sql_sym_2 . ",'" . $symptoms[$i] . "'";
		// echo $i . ":" . $symptoms[$i] . "<br />";
	}
	$sql_sym_1 = $sql_sym_1 . ") ";
	$sql_sym_2 = $sql_sym_2 . ");";
	$sql_sym = $sql_sym_1 . $sql_sym_2;

	if($conn->query($sql_sym) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_sym . "<br />" . $conn->error;
	}


	// Store Diagnosis
	$created = date('Y-m-d', time());
	$sql_diag = "INSERT INTO diagnosis(p_pid,created,p_prediag,p_curr_diag)
			VALUES('" . $pid . "','" .
					$created . "','" .
					$previous_diagnosis . "','" .
					$current_diagnosis . "'" .
			");";

	if($conn->query($sql_diag) === TRUE)	{
		$mysql_error = 0;
	} else {
		$mysql_error = 1;
		echo "Error " . $sql_diag . "<br />" . $conn->error;
	}

	// Updating the medicine Inventory
	$new_medicine_qty;
	for ($i=0; $i < $med_code_count; $i++) {
		$med_data = 0;
		$sql_get_med = "SELECT medicine_remain FROM medicine WHERE medicine_code='" . $medicine_codes[$i] . "';";
		$result = $conn->query($sql_get_med);

		if($result->num_rows > 0)	{
			$med_data = $result->fetch_assoc();
		}
		if(($med_data['medicine_remain'] - $medicine_given_all[$i]) > 0)	{
			$new_medicine_qty = $med_data['medicine_remain'] - $medicine_given_all[$i];
			$sql_medicine_give = "UPDATE medicine SET medicine_remain='" . $new_medicine_qty . "' WHERE medicine_code='" . $medicine_codes[$i] . "';";
			if($conn->query($sql_medicine_give) === TRUE)	{
				$mysql_error = 0;
			} else	{
				$mysql_error = 1;
				echo "Error: " . $sql_medicine_give . "<br />" . $conn->error;
			}
		} else {
			$mysql_error = 1;
		}
	}
}
// END STORING FORM DATA INTO DATABASE
function validateDOB($dob)	{
	if(ereg('^[0-9]{4}-[0-9]{2}-[0-9]{2}$', $dob))	{
		return true;
	} else 	{
		return false;
	}
}

$conn->close();
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
					<h4>Patient data has been added</h4>
				<?php
					} else {
				?>
					<h4>Problem adding Patient data :( :(</h4>
				<?php
					}
				?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<h5><a href="./patient.php">&lt&lt Patient Data</a></h5>
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
