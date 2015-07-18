<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('./connect.php');

session_start();
if(!isset($_SESSION['login']) && $_SESSION['login'] == "")  {
  header("Location:index.php");
}
$username = $_SESSION['username'];
$_SESSION['search_pid'] = isset($_GET['search_pid']) ? $_GET['search_pid'] : '';

// get personal data;

GLOBAL $personal;
GLOBAL $history;
GLOBAL $diagnosis;
GLOBAL $pid;
GLOBAL $first_name;
GLOBAL $last_name;
GLOBAL $father_name;
GLOBAL $mother_name;
GLOBAL $dob;
GLOBAL $sex;
GLOBAL $address_street;
GLOBAL $address_pincode;
GLOBAL $address_state;
GLOBAL $address_country;
GLOBAL $contact_mobile;
GLOBAL $genetic_problem;
GLOBAL $smoke;
GLOBAL $alcohol;
GLOBAL $betel;
GLOBAL $spicy;
GLOBAL $junk;
GLOBAL $less_sleep;
GLOBAL $previous_diagnosis;
$search_pid = isset($_GET['search_pid']) ? $_GET['search_pid'] : null;
if( $search_pid != null)  {
  $sql_personal = "SELECT p_pid,p_first_name,p_last_name,p_father_name,p_mother_name,p_dob,p_sex,p_address_street,p_address_pincode,p_address_state,p_address_country,p_contact,created FROM patient WHERE p_pid='" . $search_pid . "';";
  $result = $conn->query($sql_personal);
  if($result->num_rows > 0) {
    $personal = $result->fetch_assoc();  
  }
  $pid = isset($personal['p_pid']) ? $personal['p_pid'] : '';
  $first_name = isset($personal['p_first_name']) ? $personal['p_first_name'] : '';
  $last_name = isset($personal['p_last_name']) ? $personal['p_last_name'] : '';
  $father_name = isset($personal['p_father_name']) ? $personal['p_father_name'] : '';
  $mother_name = isset($personal['p_mother_name']) ? $personal['p_mother_name'] : '';
  $dob = isset($personal['p_dob']) ? $personal['p_dob'] : '';
  $sex = isset($personal['p_sex']) ? $personal['p_sex'] : '';
    if($sex == 1) {
      $sex = 'Male';
    } else if($sex == 2)  {
      $sex = 'Female';
    } else {
      $sex = 'Other';
    }
  $address_street = isset($personal['p_address_street']) ? $personal['p_address_street'] : '';
  $address_pincode = isset($personal['p_address_pincode']) ? $personal['p_address_pincode'] : '';
  $address_state = isset($personal['p_address_state']) ? $personal['p_address_state'] : '';
  $address_country = isset($personal['p_address_country']) ? $personal['p_address_country'] : '';
  $contact_mobile = '+91-' . isset($personal['p_contact']) ? $personal['p_contact'] : '';

  $sql_history = "SELECT p_genetic_problem,p_smoke,p_alcohol,p_betel,p_spicy,p_junk,p_less_sleep FROM history WHERE p_pid='" . $search_pid . "';";
  $result = $conn->query($sql_history);
  if($result->num_rows > 0) {
    $history = $result->fetch_assoc();  
  }

  // History
  $genetic_problem = isset($history['p_genetic_problem']) ? $history['p_genetic_problem'] : '';
  $smoke = isset($history['p_smoke']) ? $history['p_smoke'] : '';
  $alcohol = isset($history['p_alcohol']) ? $history['p_alcohol'] : '';
  $betel = isset($history['p_betel']) ? $history['p_betel'] : '';
  $spicy = isset($history['p_spicy']) ? $history['p_spicy'] : '';
  $junk = isset($history['p_junk']) ? $history['p_junk'] : '';
  $less_sleep = isset($history['p_less_sleep']) ? $history['p_less_sleep'] : '';

  $sql_diagnosis = "SELECT p_prediag FROM diagnosis WHERE p_pid='" . $search_pid . "' GROUP BY p_pid;";
  $result = $conn->query($sql_diagnosis);
  if($result->num_rows > 0) {
    $diagnosis = $result->fetch_assoc();  
  }

  // Diagnosis
  // Retrieve present current diagnosis and store it in $previous diagnosis
  $previous_diagnosis = isset($diagnosis['p_prediag']) ? $diagnosis['p_prediag'] : '';
}

// If update button is pressed

if(isset($_POST['submit_button']) && $pid != null)  {
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
    $bp = isset($_POST["bp"]) ? $_POST["bp"] : '';
    if($bp != '') {
      $bp = explode('/', $bp);
      $bp_systole = $bp[0];
      $bp_diastole = $bp[1];
    }else 	{
    	$bp_systole = '';
    	$bp_diastole = '';
    }
    $pulse = isset($_POST["pulse"]) ? $_POST["pulse"] : null;
    $temperature = isset($_POST["temperature"]) ? $_POST["temperature"] : null;
    $respSys = isset($_POST["respSystem"]) ? $_POST["respSystem"] : null;

    // Symptoms
    $sym = isset($_POST["sym"]) ? $_POST["sym"] : null;
    $symptoms;
    $i = 0;
    $sym_actual_count = 0;
    if($sym)  {
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
    if($medicine_code)  {
    foreach ($medicine_code as $x) {
      # code...
      $medicine_codes[$i++] = $x;
      $med_code_count++;
    }
    }

    $medicine_given_all;
    $i = 0;
    $med_given_count = 0;
    if($medicine_code)  {
    foreach ($medicine_given as $x) {
      # code...
      $medicine_given_all[$i++] = $x;
      $med_given_count++;
    }
    }
    // $previous_diagnosis = "";

    // START STORING FORM DATA INTO DATABASE

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

    if($conn->query($sql_vitals) === TRUE)  {
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

    if($conn->query($sql_inv) === TRUE) {
    $mysql_error = 0;
    } else {
    $mysql_error = 1;
    echo "Error " . $sql_inv . "<br />" . $conn->error;
    }

    // Store Symptoms

    $result = $conn->query("SELECT * FROM symptoms");
    $sym_col_count = $result->field_count - 3;  // Number of symptoms currently present

    if($sym_actual_count > $sym_col_count)  { // Adding additional number of symptoms columns
    $sql_sym_alter = "ALTER TABLE symptoms ADD COLUMN(";
    for ($j = $sym_col_count + 1; $j <= $sym_actual_count; $j++)  {
      $sql_sym_alter = $sql_sym_alter . "p_sym" . $j . " varchar(255)";
      if($j < $sym_actual_count)  {
        $sql_sym_alter = $sql_sym_alter . ",";
      }
    }
    $sql_sym_alter = $sql_sym_alter . ")";
    if($conn->query($sql_sym_alter) === TRUE) {
      $mysql_error = 0;
    } else {
      $mysql_error = 1;
      echo "Error " . $sql_sym_alter . "<br />" . $conn->error;
    }
    }

    $sql_sym_1 = "INSERT INTO symptoms(p_pid,created";
    $sql_sym_2 = "VALUES('" . $pid . "','" . $created . "'";

    for($i = 0; $i < $sym_actual_count; $i++) {
        $prefix = $i + 1;
        $sql_sym_1 = $sql_sym_1 . ",p_sym" . $prefix;
        $sql_sym_2 = $sql_sym_2 . ",'" . $symptoms[$i] . "'";
    }
    $sql_sym_1 = $sql_sym_1 . ") ";
    $sql_sym_2 = $sql_sym_2 . ");";
    $sql_sym = $sql_sym_1 . $sql_sym_2;

    if($conn->query($sql_sym) === TRUE) {
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

    if($conn->query($sql_diag) === TRUE)  {
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

    if($result->num_rows > 0) {
      $med_data = $result->fetch_assoc();
    }
    if(($med_data['medicine_remain'] - $medicine_given_all[$i]) > 0)  {
      $new_medicine_qty = $med_data['medicine_remain'] - $medicine_given_all[$i];
      $sql_medicine_give = "UPDATE medicine SET medicine_remain='" . $new_medicine_qty . "' WHERE medicine_code='" . $medicine_codes[$i] . "';";
      if($conn->query($sql_medicine_give) === TRUE) {
        $mysql_error = 0;
      } else  {
        $mysql_error = 1;
        echo "Error: " . $sql_medicine_give . "<br />" . $conn->error;
      }
    } else {
      $mysql_error = 1;
    }
    }
    // END STORING FORM DATA INTO DATABASE
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
  <title>Existing Patient - GMRVF</title>
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
              <li class="active"><a href="./ex-patient.php">Exisiting Patient</a></li>
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
        <form class="form-inline"  method="get" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
          <div class="nav navbar-nav navbar-right navbar-form">
            <div class="input-group">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Search">Search</button>
              </span>
              <input type="text" class="form-control" name="search_pid" placeholder="Enter Public ID"/>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</nav>

<div class="container" >
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading">PATIENT DETAILS</div>
    <div class="panel-body">
      <div class="table">
        <div class="col-lg-4">
        <!-- Switchable tabs start -->
        <div class="tabpanel">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#from_file" class="active" data-toggle="tab" aria-controls="from_file">Photo</a></li>
          </ul>

          <!-- Switchable tabs content -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="from_file">
              <br />
              <div class="row col-lg-12">
        				<div id="imgContainer">
        					<form enctype="multipart/form-data" action="image_upload_submit.php" method="post" name="image_upload_form" id="image_upload_form">
        						<div id="imgArea"><img src=<?php echo '"./uploads/' . $search_pid . '.jpg"';?>>
        							<div class="progressBar">
        								<div class="bar"></div>
        								<div class="percent">0%</div>
        							</div>
        							<div id="imgChange"><span>Change Photo</span>
        								<input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
        							</div>
        						</div>
        						<br /><br />
        						<div class="row">
        							<div class="form-group">
        								<div class="col-lg-12">
        									<input type="text" class="form-control" id="image_pid" name="image_pid" placeholder="Public ID" />
        								</div>
        							</div>
        						</div>
        					</form>
        				</div>
              </div>
            </div>
          </div>
          <!-- Switchable tabs content ends -->
        </div>
        <!-- Switchable tabs end -->
        </div>
        <div class="col-lg-8">
        
        <!-- Details Form -->
          <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="tabpanel" role="tablist">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#personal" data-toggle="tab" aria-controls="personal">Personal Details</a></li>
                <li role="presentation"><a href="#history" data-toggle="tab" aria-controls="history">History</a></li>
                <li role="presentation"><a href="#vital" data-toggle="tab" aria-controls="vital">Vitals</a></li>
                <li role="presentation"><a href="#investigation" data-toggle="tab" aria-controls="investigation">Investigation</a></li>
                <li role="presentation"><a href="#symptoms" data-toggle="tab" aria-controls="symptoms">Symptoms</a></li>
                <li role="presentation"><a href="#diagnosis" data-toggle="tab" aria-controls="diagnosis">Diagnosis</a></li>
              </ul>

              <div class="tab-content">

                <!-- Switchable Personal Content -->

                <div role="tabpanel" class="tab-pane active" id="personal">
                <br />
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <label for="pid">Public Id:</label>
                        <div name="pid">
                          <?php echo $pid ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <label for="first_name">First Name:</label>
                        <div name="first_name">
                          <?php echo $first_name ; ?>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <label for="last_name">Last Name:</label>
                        <div name="last_name">
                          <?php echo $last_name ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <label for="father_name">Father Name:</label>
                        <div name="father_name">
                          <?php echo $father_name ; ?>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <label for="mother_name">Mother Name</label>
                        <div name="mother_name">
                          <?php echo $mother_name ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <!-- <input type="date" class="form-control" name="dob" placeholder="D.O.B [DD-MM-YYYY]" /> -->
                        <label for="dob">D.O.B.:</label>
                        <div name="dob">
                          <?php echo $dob ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <label for="sex">Sex:</label>
                        <div name="sex">
                          <?php echo $sex ; ?>
                        </div>
                        <!-- <input type="text" class="form-control" name="age" placeholder="Age" /> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <label for="address_street">Street:</label>
                        <div name="address_street">
                          <?php echo $address_street ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <label for="address_pincode">Pincode:</label>
                        <div name="address_pincode">
                          <?php echo $address_pincode ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <label for="address_state">State:</label>
                        <div name="address_state">
                          <?php echo $address_state ; ?>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <label for="address_country">Country:</label>
                        <div name="address_country">
                          <?php echo $address_country ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <label for="contact_mobile">Mobile:</label>
                        <div name="contact_mobile">
                          <?php echo $contact_mobile ; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Submit Final Form -->
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-offset-5 col-lg-2">
                        <input type="submit" name="submit_button" class="btn btn-primary" style="width:100px" value="Update" />
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Personal Content Ends -->

                <!-- Switchable History Content -->

                <div role="tabpanel" class="tab-pane fade" id="history">
                <br />
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <textarea class="form-control" name="genetic_problem" placeholder="Genetic Problems" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                        <span style="font-size:16px; text-align:left;"><b>Addictions:</b></span>
                      </div>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="smoke" value="1" />Smoking</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="alcohol" value="1" />Alcohol Consumption</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="betel" value="1" />Betel Nut</label>
                  </div>
                  <br />
                  <div class="row">
                      <div class="col-lg-6">
                        <span style="font-size:16px; text-align:left;"><b>Lifestyle:</b></span>
                      </div>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="spicy" value="1" />Spicy Food</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="junk" value="1" />Junk Food</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="less_sleep" value="1" />Less Sleep</label>
                  </div>
                  
                </div>

                <!-- History Content ends -->

                <!-- Switchable Vital Content -->

                <div role="tabpanel" class="tab-pane fade" id="vital">
                <br />
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>Patient Vitals:</b>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="bp" placeholder="Blood Pressure" />
                      </div>
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="pulse" placeholder="Pulse Rate" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="temperature" placeholder="Temperature" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <textarea class="form-control" name="respSystem" placeholder="Respiratory System" rows="3"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Vital Content Ends -->

                <!-- Investigation Content Starts -->

                <div role="tabpanel" class="tab-pane fade" id="investigation">
                <br />
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <span style="font-size:16px;"><b>Investigation:</b></span>
                      </div>
                    </div>
                  </div>

                  <!-- CBP -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="cue" value="1" />CBP(Blood Test)</label>
                  </div>
                  <!-- CUE -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="rbs" value="1" />CUE(Urine Test)</label>
                  </div>
                  <!-- RBS -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="cbp" value="1" />RBS(Blood Sugar)</label>
                  </div>
                  <!-- FBS -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="fbs" value="1" />FBS(Fasting Blood Sugar)</label>
                  </div>
                  <!-- PLBS -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="plbs" value="1" />PLBS(Post Lunch Blood Sugar)</label>
                  </div>
                  <!-- ECG -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="ecg" value="1" />ECG(Cardiogram)</label>
                  </div>
                  <!-- X-Ray -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="xray" value="1" />X-Ray</label>
                  </div>
                  <!-- ESR -->
                  <div class="checkbox">
                    <label><input type="checkbox" name="esr" value="1" />ESR</label>
                  </div>
                </div>

                <!-- Investigation Content Ends -->

                <!-- Symptoms Content Starts -->

                <div role="tabpanel" class="tab-pane fade" id="symptoms">
                <br />
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>Symptoms:</b>
                      </div>
                    </div>
                  </div>
                  <div id="sym_dynamic">
                    <div class="row" id="sym1">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 1" />
                      </div>
                    </div>
                    <div class="row" id="sym2">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 2" />
                      </div>
                    </div>
                    <div class="row" id="sym3">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 3" />
                      </div>
                    </div>
                    <div class="row" id="sym4">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 4" />
                      </div>
                    </div>
                    <div class="row" id="sym5">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 5" />
                      </div>
                    </div>
                    <div class="row" id="sym6">
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control" name="sym[]" placeholder="Symptom 6" />
                      </div>
                    </div>
                  </div>

                  <!-- New Symptom is added here -->
                  <!-- <div id="newSym"></div> -->

                  <!-- Add a new Symptom -->
                  <div class="row">
                    <div class="btn btn-default">
                      <span class="glyphicon glyphicon-plus"></span>
                      <a href="#" id="addSym"><b>Add Symptom</b></a>
                    </div>
                    <div class="btn btn-default">
                      <span class="glyphicon glyphicon-minus"></span>
                      <a href="#" id="removeSym"><b>Remove Symptom</b></a>
                    </div>
                  </div>
                </div>

                <!-- Symptoms Content Ends -->

                <!-- Diagnosis Content Starts -->

                <div role="tabpanel" class="tab-pane fade" id="diagnosis">
                  <br />
                  <div class="row">
                    <b>Previous Diagnosis:</b><br />
                    Display latest diagnosis for that particular patient.
                  </div>
                  <br />
                  <div class="row">
                    <b>Current Diagnosis:</b>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <textarea class="form-control" name="current_diagnosis" placeholder="Current Diagnosis" rows="3"></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- Start of Medicine -->
                  <div class="form-group">
                    <b>Medicines:</b>
                  </div>
                  <div id="med_dynamic">
                    <!-- Medicine Row Starts -->
                    <div class="row" id="med1">
                      <div class="col-lg-2">
                        <div class="form-group">
                          <input type="text" id="medicine_code1" class="form-control" name="medicine_code[]" placeholder="Code" />
                        </div>
                      </div>
                      <div class="col-lg-1">
                        <span></span>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <input type="text" id="medicine_name1" class="form-control" name="medicine_name[]" placeholder="Name" />
                        </div>
                      </div>
                      <div class="col-lg-1">
                        <span></span>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <input type="text" id="medicine_given1" class="form-control" name="medicine_given[]" placeholder="###" />
                        </div>
                      </div>
                    </div> 
                    <!-- Medicine Row Ends -->
                    <!-- End of Medicine -->
                  </div>
                  <div class="row">
                      <div class="btn btn-default">
                        <span class="glyphicon glyphicon-plus"></span>
                        <a href="#" id="addMed"><b>Add Medicine</b></a>
                      </div>
                      <div class="btn btn-default">
                        <span class="glyphicon glyphicon-minus"></span>
                        <a href="#" id="removeMed"><b>Remove Medicine</b></a>
                      </div>
                    </div>

                </div>

                <!-- Diagnosis Content Ends -->

              </div>

              <!-- Switchable Form Ends -->
            </div>

            <!-- <div class="row">
              <div class="form-group">
                <div class="col-lg-offset-5 col-lg-2">
                  <button class="btn btn-primary" style="width:100px">Submit</button>
                </div>
              </div>
            </div> -->
          </form><!-- Form ends -->
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