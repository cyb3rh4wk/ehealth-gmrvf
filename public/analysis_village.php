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

$month = isset($_POST['month']) ? $_POST['month'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';

$error_no_data = 1;
GLOBAL $result;
if(isset($month) && isset($year) && $month != '' && $year != '') {

  $sql_count = 'SELECT p.p_address_street,(SELECT COUNT(p_sex) FROM patient WHERE p_sex=1 AND p_address_street=p.p_address_street AND MONTH(created)=' . $month . ' AND YEAR(created)=' . $year . ') as p_males,(SELECT COUNT(p_sex) FROM patient WHERE p_sex=2 AND p_address_street=p.p_address_street AND MONTH(created)=' . $month .  ' AND YEAR(created)=' . $year . ') as p_females,(SELECT COUNT(p_sex) FROM patient WHERE p_sex=3 AND p_address_street=p.p_address_street AND MONTH(created)=' . $month .  ' AND YEAR(created)=' . $year . ') as p_others FROM patient p GROUP by p.p_address_street';

  $result = $conn->query($sql_count);
  $error_no_data = 0;
} else {
  $error_no_data = 1;
}

function toMonthString($monthNum)  {
  switch ($monthNum) {
    case '01':
      echo 'January';
      break;
    case '02':
      echo 'February';
      break;
    case '03':
      echo 'March';
      break;
    case '04':
      echo 'April';
      break;
    case '05':
      echo 'May';
      break;
    case '06':
      echo 'June';
      break;
    case '07':
      echo 'July';
      break;
    case '08':
      echo 'August';
      break;
    case '09':
      echo 'September';
      break;
    case '10':
      echo 'October';
      break;
    case '11':
      echo 'November';
      break;
    case '12':
      echo 'December';
      break;
    
    default:
      echo 'Invalid month';
      break;
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
  <title>Analysis - GMRVF</title>
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Services<b class="caret"></b></a>

            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li><a href="./patient.php">New Patient</a></li>
              <li><a href="./ex-patient.php">Exisiting Patient</a></li>
              <li><a href="./id.php">Generate ID</a></li>
              <li class="divider"></li>
              <li><a href="./medicine.php">Medicine Data</a></li>
              <li class="divider"></li>
              <li class="dropdown-submenu active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Analysis</a>
                <ul class="dropdown-menu">
                  <li class="active"><a href="./analysis_village.php">Village vs Gender</a></li>
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
	<div class="panel panel-danger" role="panel">
    <div class="panel-body">
    <?php
      if(isset($month) && isset($year) && $month != '' && $year != '') {
    ?>
        <div class="text-success"><h4>Month: <?php echo toMonthString($month); ?>, Year: <?php echo $year; ?></h4></div>
        <table class="table">
          <thead>
            <tr>
              <th>Village Name</th>
              <th>Males</th>
              <th>Females</th>
              <th>Others</th>
            </tr>
          </thead>
          <tbody>
      <?php
        if($result->num_rows > 0)  {
          //output data of each row
          
          while($row = $result->fetch_assoc())  {
            echo "<tr>" .
                    "<td>" . $row['p_address_street'] . "</td>" .
                    "<td>" . $row['p_males'] . "</td>" .
                    "<td>" . $row['p_females'] . "</td>" .
                    "<td>" . $row['p_others'] . "</td>" .
                 "</tr>";
      ?>
          
      <?php
          }
        }
      ?>
          </tbody>
        </table>
      <?php
      } else {
      ?>
      <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="row">
          <div class="col-lg-2">
            <select class="form-control" name="month" id="month">
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
            <!-- <input type="text" class="form-control" name="age" placeholder="Age" /> -->
          </div>
          <div class="col-lg-2">
            <select class="form-control" name="year" id="year">
              <option value="2014">2014</option>
              <?php
                $stop = false;
                $start = 2014;
                $temp = $start;
                $current_year = date('Y', time());
                while($stop != true)  {
                  $temp += 1;
                  if($temp > $current_year)  {
                    $stop = true;
                  } else {
                    echo '<option value="' . $temp . '">' . $temp . '</option>';
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="form-group">
            <div class="col-lg-2">
              <input type="submit" class="btn btn-primary" style="width:100px" value="Get Analysis" />
            </div>
          </div>
        </div>
      </form>
      <?php
      }
      ?>
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
