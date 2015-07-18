<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
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
  <title>New Patient - GMRVF</title>
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
              <li class="active"><a href="./patient.php">New Patient</a></li>
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

<div class="container" >
  <div class="panel panel-primary" role="panel">
    <div class="panel-heading">PATIENT DETAILS</div>
    <div class="panel-body">
      <div class="table">
        <div class="col-lg-4">
        <!-- Switchable tabs start -->
        <div class="tabpanel">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#take_picture" data-toggle="tab" aria-controls="take_picture">Take Picture</a></li>
            <li role="presentation"><a href="#from_file" data-toggle="tab" aria-controls="from_file">From File</a></li>
          </ul>

          <!-- Switchable tabs content -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="take_picture">
              <div class="row">
                <video class="img-rounded" id="video" width="360" height="180" autoplay></video>
              </div>
              <div class="row">
                <center><button class="btn btn-default" id="snap">Take a Photo</button></center>
              </div>
              <div class="row">
        				<center>
        					<canvas class="img-rounded" id="captured" width="280" height="160"></canvas>
        				</center>
              </div>
              <div class="row">
                <center><button class="btn btn-default" id="new">Take Another???</button></center>
              </div>
              <script>
                // Put event listeners into place
                window.addEventListener("DOMContentLoaded", function() {
                  // Grab elements, create settings, etc.
                  var canvas = document.getElementById("captured"),
                  context = canvas.getContext("2d"),
                  video = document.getElementById("video"),
                  videoObj = { "video": true },
                  errBack = function(error) {
                  console.log("Video capture error: ", error.code); 
                };

                // Put video listeners into place
                if(navigator.getUserMedia) { // Standard
                navigator.getUserMedia(videoObj, function(stream) {
                  video.src = stream;
                  video.play();
                  }, errBack);
                } 
                else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
                  navigator.webkitGetUserMedia(videoObj, function(stream){
                  video.src = window.URL.createObjectURL(stream);
                  video.play();
                  }, errBack);
                }
                else if(navigator.mozGetUserMedia) { // Firefox-prefixed
                  navigator.mozGetUserMedia(videoObj, function(stream){
                  video.src = window.URL.createObjectURL(stream);
                  video.play();
                  }, errBack);
                // Trigger photo take
                document.getElementById("snap").addEventListener("click", function() {
                 context.drawImage(video, 0, 0, 240, 160);
                 // Little effects
                  $('#video').fadeOut('slow');
                  $('#captured').fadeIn('slow');
                  $('#snap').hide();
                  $('#new').show();
                  // Allso show upload button
                  //$('#upload').show();
                });
                // Capture New Photo
                document.getElementById("new").addEventListener("click", function() {
                  $('#video').fadeIn('slow');
                  $('#canvas').fadeOut('slow');
                  $('#snap').show();
                  $('#new').hide();
                });
                document.getElementById("snap").addEventListener("click", function(){
                  var dataUrl = canvas.toDataURL();
                  var pid = document.getElementById("pid").value;
                  $.ajax({
                    type: "POST",
                    url: "captureSave.php",
                    data: { 
                      imgBase64 : dataUrl,
                      pid : pid
                    }
                    }).done(function(msg) {
                      console.log('saved');
                  });
                });
                  }
                }, false);

              </script>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="from_file">
              <div class="row">
                <div class="col-lg-12">
                  <h5>Upload a photo from a file...</h5><br />
                </div>
              </div>
              <div class="row col-lg-12">
        				<div id="imgContainer">
        					<form enctype="multipart/form-data" action="image_upload_submit.php" method="post" name="image_upload_form" id="image_upload_form">
        						<div id="imgArea"><img src="./images/default.png">
        							<div class="progressBar">
        								<div class="bar"></div>
        								<div class="percent">0%</div>
        							</div>
        							<div id="imgChange"><span>Upload Photo</span>
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
          <form class="form-horizontal" role="form" method="post" action="submit_details.php">
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
                        <input type="text" id="pid" class="form-control" name="pid" placeholder="Public ID" required/>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" />
                      </div>
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="father_name" placeholder="Father Name" />
                      </div>
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="mother_name" placeholder="Mother Name" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <input type="text" class="form-control" name="dob" placeholder="D.O.B [ YYYY-MM-DD ]" />
                        <!-- <input type="date" class="form-control" name="dob"/> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <select class="form-control" name="sex" id="sex">
                          <option value="1">Male</option>
                          <option value="2">Female</option>
                          <option value="3">Other</option>
                        </select>
                        <!-- <input type="text" class="form-control" name="age" placeholder="Age" /> -->
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-12">
                        <textarea class="form-control" name="address_street" placeholder="Street Address" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <input type="text" class="form-control" name="address_pincode" placeholder="Pincode" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="address_state" placeholder="State" />
                      </div>
                      <div class="col-lg-6">
                        <input type="text" class="form-control" name="address_country" placeholder="Country" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-4">
                        <div class="input-group">
                        <div class="input-group-addon">
                          <span>+91</span>
                          <input type="hidden" name="countryPrefix" value="+91" />
                        </div>
                        <input type="text" class="form-control" name="contact_mobile" placeholder="Mobile" />
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Submit Final Form -->
                  <div class="row">
                    <div class="form-group">
                      <div class="col-lg-offset-5 col-lg-2">
                        <input type="submit" class="btn btn-primary" style="width:100px" value="Submit" />
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
                        <textarea class="form-control" name="current_diagnosis" placeholder="Current Diagnosis" rows="3" required></textarea>
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
