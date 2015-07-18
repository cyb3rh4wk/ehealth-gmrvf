<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('./connect.php');
$success_password = -1;
$success_email = -1;

session_start();
if(!isset($_SESSION['login']) && $_SESSION['login'] == "")  {
  header("Location:index.php");
}
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : null ;
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null ;
$repeat_new_password = isset($_POST['repeat_new_password']) ? $_POST['repeat_new_password'] : null ;
$new_email = isset($_POST['new_email']) ? $_POST['new_email'] : null ;
$username = $_SESSION['username'];

$get_data;
$sql_password_get = "SELECT password, email FROM users WHERE username='" . $username . "';";
$result = $conn->query($sql_password_get);
$get_data = $result->fetch_assoc();

if(($current_password && $new_password && $repeat_new_password) != '')  {
  if($current_password === $get_data['password']) {
    $sql_password = "UPDATE users SET password='" . $new_password . "' WHERE username='" . $username . "';";
    if($conn->query($sql_password) === TRUE) {
      $mysql_error = 0;
      $success_password = 1;
    } else {
      $mysql_error = 1;
      $success_password = 0;
      echo "Error " . $sql_password . "<br />" . $conn->error;
    }
  } else  {
      $success_password = 0;
  }
}

// Validate E-Mail here using Regular Expressions

if($new_email != '')  {
  $sql_email = "UPDATE users SET email='" . $new_email . "' WHERE username='" . $username . "';";
  if($conn->query($sql_email) === TRUE) {
    $mysql_error = 0;
    $success_email = 1;
  } else {
    $mysql_error = 1;
    $success_email = 0;
    echo "Error " . $sql_email . "<br />" . $conn->error;
  }
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
  <title>Account</title>
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
          <!-- User Panel Display -->
          <li class="dropdown active">
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
    <div class="panel-heading"><h4>Account Details</h4></div>
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-6">
          <form name="account_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Current Password" />
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New Password" />
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="password" id="repeat_new_password" class="form-control" name="repeat_new_password" placeholder="Repeat New Password" />
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="submit" id="submit_settings" class="form-control btn btn-danger" value="Change Password" />
                </div>
              </div>
            </div>
          </form>
          <br>
          <?php
            if($success_password == 1) {
          ?>
          <div class="alert alert-success">
            <strong>Success!!!</strong>Your password has been changed.
          </div>
          <?php
            } else if($success_password == 0)  {
          ?>
          <div class="alert alert-warning">
            <strong>Failure!!!</strong>Sorry, I am unable to change your Password.
          </div>
          <?php
            }
          ?>
        </div>
        <div class="col-lg-6">
          <form name="account_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <strong>Current E-Mail:</strong>
                  <br>
                  <?php
                    echo $get_data['email'];
                  ?>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="text" id="new_email" class="form-control" name="new_email" placeholder="New E-Mail" />
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="form-group">
                <div class="col-lg-6">
                  <input type="submit" id="submit_settings" class="form-control btn btn-danger" name="current_password" value="Change E-Mail" />
                </div>
              </div>
            </div>
          </form>
          <br>
          <?php
            if($success_email == 1) {
          ?>
          <div class="alert alert-success">
            <strong>Success!!!</strong>Your E-Mail has been changed.
          </div>
          <?php
            } else if($success_email == 0)  {
          ?>
          <div class="alert alert-warning">
            <strong>Failure!!!</strong>Sorry, I am unable to change your E-Mail.
          </div>
          <?php
            }
          ?>
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
