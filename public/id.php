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
  <title>
    <?php
    if(isset($search_pid) && $search_pid != '') {
    ?>
    Patient - 
    <?php
    echo $search_pid;
    } else {
    ?>
    Patient ID Card - GMRVF
    <?php
    }
    ?>
  </title>
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
              <li class="active"><a href="./id.php">Generate ID</a></li>
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

<div class="container">
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading">PATIENT DETAILS</div>
    <div class="panel-body" id="printArea">
      <div class="table">
        <div class="col-lg-4">
        <!-- Switchable tabs start -->
        <div class="tabpanel">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#from_file" aria-controls="from_file">Photo</a></li>
          </ul>

          <!-- Switchable tabs content -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="from_file">
              <br />
              <div class="row col-lg-12">
        				<div id="imgContainer">
        					<form enctype="multipart/form-data" action="image_upload_submit.php" method="post" name="image_upload_form" id="image_upload_form">
        						<div id="imgArea"><img src=<?php echo '"./uploads/' . $search_pid . '.jpg"';?>>
        						</div>
        						<br /><br />
        						<div class="row" style="font-size : 16px;">
                      <div class="form-group">
                        <div class="col-lg-12">
                          <label for="pid">Public Id:</label>
                          <div name="pid">
                            <?php echo $pid ; ?>
                          </div>
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
            <div class="tabpanel" role="tablist">
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#personal" data-toggle="tab" aria-controls="personal">Personal Info</a></li>
              </ul>

              <div class="tab-content">

                <!-- Switchable Personal Content -->

                <div role="tabpanel" class="tab-pane active" id="personal">
                <br />
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>Public Id:</b>
                          <?php echo $pid ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>First Name:</b>
                          <?php echo $first_name ; ?>
                      </div>
                      <div class="col-lg-6">
                        <b>Last Name:</b>
                          <?php echo $last_name ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>Father Name:</b>
                          <?php echo $father_name ; ?>
                      </div>
                      <div class="col-lg-6">
                        <b>Mother Name</b>
                          <?php echo $mother_name ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <!-- <input type="date" class="form-control" name="dob" placeholder="D.O.B [DD-MM-YYYY]" /> -->
                        <b>D.O.B.:</b>
                          <?php echo $dob ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <b>Sex:</b>
                          <?php echo $sex ; ?>
                        <!-- <input type="text" class="form-control" name="age" placeholder="Age" /> -->
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <b>Street:</b>
                          <?php echo $address_street ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <b>Pincode:</b>
                          <?php echo $address_pincode ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <b>State:</b>
                          <?php echo $address_state ; ?>
                      </div>
                      <div class="col-lg-6">
                        <b>Country:</b>
                          <?php echo $address_country ; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="font-size : 14px;">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <b>Mobile:</b>
                          <?php echo $contact_mobile ; ?>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Personal Content Ends -->

              </div>

              <!-- Switchable Form Ends -->
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group">
      <div class="col-lg-offset-5 col-lg-2">
        <input type="submit" id="printButton" class="btn btn-primary" style="width:100px" value="Print" onclick="printPage()" />
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