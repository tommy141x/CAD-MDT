<!DOCTYPE html>
<?php
// PRELOADER
echo "
<link rel='shortcut icon' type='image/ico' href='../assets/images/favicon.ico'>
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-bg {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
  background-color: rgba(0, 0, 0, 1.0);
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.blackout {
	display: none;
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background-image: url('../assets/images/blackout.png');
	background-position: center;
  background-color: rgba(0, 0, 0, 0.75);
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
<div class='se-pre-bg'></div>
<div class='blackout'></div>
";
// PRELOADER
include '../config.php';
require '../login/steamauth/steamauth.php';
require '../connectdb.php';
include('../login/steamauth/userInfo.php');

if (!isset($_SESSION['steamid'])) {
    header("Location: login");
    die();
}

$query2 = $database->query("SELECT COUNT(*) FROM mdt_departments;");
$result2 = $query2->fetch(PDO::FETCH_ASSOC);

foreach ($result2 as $key => $value) {
    $deptNUM = ($result2[$key]);
}

$data2 = $database->select('mdt_departments', [
    'dept_name',
    'dept_abv',
    'dept_logo',
    'dept_type'
], []);

$jsondata2 = json_encode($data2);
$arr2 = json_decode($jsondata2, true);

$steamquery = $database->query("SELECT approved_dept FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$steamresult = $steamquery->fetch(PDO::FETCH_ASSOC);
global $approved;

if (($steamresult == null) or ($steamresult == 0)) {
    $approved = 0;
} else {
    foreach ($steamresult as $key => $value) {
        $approved = ($steamresult[$key]);
    }
}
$allowed = false;
for ($x = 1; $x <= ($deptNUM + 0); $x++) {
    if (strpos($approved, strval($x)) !== false) {
        if ($arr2[$x-1]["dept_type"] == "FIRE") {
            $allowed = true;
        }
        if ($arr2[$x-1]["dept_type"] == "EMS") {
            $allowed = true;
        }
    }
}
if ($allowed == false) {
    header("Location: /../index.php");
    die();
}

$rankquery = $database->query("SELECT perm_id FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$rankresult = $rankquery->fetch(PDO::FETCH_ASSOC);
global $rank;

if (($rankresult == null) or ($rankresult == 0)) {
    $rank = 0;
} else {
    foreach ($rankresult as $key => $value) {
        $rank = ($rankresult[$key]);
    }
}

//THEMES
$themequery = $database->query("SELECT user_theme FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$themeresult = $themequery->fetch(PDO::FETCH_ASSOC);
global $theme;

if (($themeresult == null) or ($themeresult == 0)) {
    $theme = "default";
} else {
    foreach ($themeresult as $key => $value) {
        $theme = ($themeresult[$key]);
    }
}
$fileList = glob('../assets/css/themes/*.css');
$themeCheck = false;
	foreach($fileList as $filename){
	//Use the is_file function to make sure that it is not a directory.
		if(is_file($filename)){
			$name = str_replace(".css", "", str_replace("../assets/css/themes/", "", $filename));
			if($name == $theme){
				$themeCheck = true;
			}
		}
	}
if($themeCheck == false){
	$theme = "default";
}

global $unit_callsign;
global $unit_name;
$unit_callsign = "";
$unit_name = "";
$queryquery = $database->query("SELECT unit_name FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."' AND (unit_type='FIRE' OR unit_type='EMS')");
$queryresult = $queryquery->fetch(PDO::FETCH_ASSOC);
if (isset($_GET["callsign"])) {
    $unit_callsign = $_GET["callsign"];
    $unit_name = $_GET["name"];
    if ($queryresult == null) {
        header("Location: index.php");
        die();
    }
} else {
    $final4res = 'FIRE/EMS';
    $query4query = $database->query("SELECT unit_type FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
    $query4result = $query4query->fetch(PDO::FETCH_ASSOC);
    if (!($query4result == null)) {
        foreach ($query4result as $key => $value) {
            $final4res = ($query4result[$key]);
        }
    }

    if ($queryresult == null) {
        echo "

<button id='myLogin' type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#login' data-keyboard='false' data-backdrop='static' style='display: none;'></button>

<div class='modal fade' id='login' tabindex='-1' role='dialog' aria-labelledby='New911CallLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='New911CallLabel'>LOGIN</h5>
                          </div>
                          <div class='modal-body'>
                    <form class='form-inline' method='post' action='fire-ems-login.php'>
                      <div class='input-group mb-1 mr-sm-1'>
                      <label class='sr-only' for='inlineFormInputGroupUsername2'>Callsign</label>
                        <div class='input-group-prepend'>
                          <div class='input-group-text'>#</div>
                        </div>

                        <input name='callsign' type='text' class='form-control' id='inlineFormInputGroupUsername2' placeholder='Callsign' size='8' required>

                      </div>
                      <label class='sr-only' for='inlineFormInputName2'>Name</label>

                      <input name='name' type='text' class='form-control mb-1 mr-sm-2' id='inlineFormInputName2' placeholder='Name' size='18' required>

            <input type='hidden' name='steam_id' value=".$steamprofile['steamid'].">
            <div class='form-group'>
								<select class='js-example-basic-single' style='margin-bottom:5px; width:100%' id='unit_type' name='unit_type'>
									<option value='FIRE'>FIRE</option>
									<option value='EMS'>EMS</option>
								</select>
							</div>
								<select class='form-control' style='width:93%; hiehgt:85%;' id='apparatus_type' name='apparatus_type'>
									<option value='1'>ENGINE 01</option>
									<option value='2'>ENGINE 02</option>
									<option value='3'>LADDER 01</option>
									<option value='4'>LADDER 02</option>
									<option value='5'>AMBULANCE 01</option>
									<option value='6'>AMBULANCE 02</option>
									<option value='7'>AIR SUPPORT 01</option>
									<option value='8'>AIR SUPPORT 02</option>
								</select>
                          </div>
                          <div class='modal-footer'>
                          ";
        if (!($final4res == "FIRE/EMS")) {
            echo "<code>You are currently logged into another panel.</code><button type='submit' class='btn btn-primary mr-2' action='fire-ems-login.php' disabled>Login</button>";
        } else {
            echo "<button type='submit' class='btn btn-primary mr-2' action='fire-ems-login.php'>Login</button>";
        }
        echo "
                            <a href='../index.php'><button type='button' class='btn btn-light'>Back</button></a>
                          </div>
						</form>
                        </div>
                      </div>
                </div>
              </div>
";
    } else {
        foreach ($queryresult as $key => $value) {
            $finalres = ($queryresult[$key]);
        }

        $query2query = $database->query("SELECT unit_callsign FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
        $query2result = $query2query->fetch(PDO::FETCH_ASSOC);
        foreach ($query2result as $key => $value) {
            $final2res = ($query2result[$key]);
        }
        header("Location: index.php?callsign=".$final2res."&name=".$finalres);
        die();
    }
}

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $communityName;?> | FIRE/EMS Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
	<script src="status.js"></script>
    <!-- endinject -->
		<!-- Scrollbar -->
		<style>body::-webkit-scrollbar {display: none;}</style>
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/themes/<?php echo $theme;?>.css">
    <!-- End layout styles -->
  </head>
  <body style="background-color:black;">
  <audio id="attach" hidden src="sounds/attach.wav" type="audio/wav"></audio>
  <!--<audio id="on-duty" hidden src="sounds/soft_notification.wav" type="audio/wav"></audio>-->
  <audio id="detach" hidden src="sounds/detach.wav" type="audio/wav"></audio>
	<audio autoplay='true' style='display:none;' src='sounds/notification.wav' type='audio/wav'></audio>
    <div class="container-scroller">
      <!-- partial:../../partials/_horizontal-navbar.html -->
      <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
          <div class="container">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

              <img class="navbar-brand brand-logo" style="margin-left:7px; max-height:45px;" src="../assets/images/logo.png"/>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
              <ul class="navbar-nav">
              </ul>
              <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown d-none d-xl-block">
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                    <h6 class="p-3 mb-0"></h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                      <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                          <i class="mdi mdi-file-outline text-primary"></i>
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-divider"></div>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link mr-0" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                      <img class="img-xs rounded-circle" src='<?=$steamprofile['avatar']?>' alt="">
                      <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $steamprofile['personaname']; ?></p>
                      <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">Profile</h6>
                    <div class="dropdown-divider"></div>
                    <a href="/settings" class="dropdown-item preview-item">
                      <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                          <i class="mdi mdi-settings text-success"></i>
                        </div>
                      </div>
                      <div class="preview-item-content">
                        <p class="preview-subject mb-1">Settings</p>
                      </div>
                    </a>
					<?php
                    if ($rank == 3) {
                        echo "
					<div class='dropdown-divider'></div>
                    <a href='/panel' class='dropdown-item preview-item'>
                      <div class='preview-thumbnail'>
                        <div class='preview-icon bg-dark rounded-circle'>
                          <i class='mdi mdi-settings text-success'></i>
                        </div>
                      </div>
                      <div class='preview-item-content'>
                        <p class='preview-subject mb-1'>Admin Panel</p>
                      </div>
                    </a>
					";
                    } elseif ($rank > 0) {
                        echo "
					<div class='dropdown-divider'></div>
                    <a href='/panel' class='dropdown-item preview-item'>
                      <div class='preview-thumbnail'>
                        <div class='preview-icon bg-dark rounded-circle'>
                          <i class='mdi mdi-settings text-success'></i>
                        </div>
                      </div>
                      <div class='preview-item-content'>
                        <p class='preview-subject mb-1'>Supervisor Panel</p>
                      </div>
                    </a>
					";
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="/login">
                      <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                          <i class="mdi mdi-logout text-danger"></i>
                        </div>
                      </div>
                      <div class="preview-item-content">
                        <!--<p class="preview-subject mb-1" action='' method='get'>Log out</p>-->
						<?php logoutbutton(); ?>
                      </div>
                    </a>
                  </div>
                </li>
              </ul>
              <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                <span class="mdi mdi-menu"></span>
              </button>
            </div>
          </div>
        </nav>
        <nav class="bottom-navbar">
          <div class="container">
            <ul class="nav page-navigation">
              <li class="nav-item menu-items">
                <a class="nav-link" href="../index.php">
                  <i class="mdi mdi-menu menu-icon"></i>
                  <span class="menu-title">Dashboard</span>
                </a>
              </li>
					<?php
									$leoNAV = false;
									$feNAV = false;
									$dispatchNAV = false;
									$civNAV = false;
										for ($x = 1; $x <= ($deptNUM + 0); $x++) {
												if (strpos($approved, strval($x)) !== false) {
														if (($arr2[$x-1]["dept_type"] == "CIV") and ($civNAV == false)) {
																echo "
					<li class='nav-item menu-items'>
						<a class='nav-link' href='../".$arr2[$x-1]["dept_abv"]."'>
						<i class='mdi mdi mdi-account-circle menu-icon'></i>
						<span class='menu-title'>".$arr2[$x-1]["dept_abv"]."</span>
						</a>
					</li>
					";
					$civNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "LEO") and ($leoNAV == false)) {
																echo "
					<li class='nav-item menu-items'>
						<a class='nav-link' href='../leo'>
						<i class='mdi mdi mdi-account-box-multiple menu-icon'></i>
						<span class='menu-title'>LEO</span>
						</a>
					</li>
					";
					$leoNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "FIRE") and ($feNAV == false)) {
																echo "
					<li class='nav-item menu-items'>
						<a class='nav-link' href='../fire-ems'>
						<i class='mdi mdi mdi-fire menu-icon'></i>
						<span class='menu-title'>Fire/EMS</span>
						</a>
					</li>
					";
					$feNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "DISPATCH") and ($dispatchNAV == false)) {
																echo "
					<li class='nav-item menu-items'>
						<a class='nav-link' href='../dispatch'>
						<i class='mdi mdi mdi-tablet-cellphone menu-icon'></i>
						<span class='menu-title'>Dispatch</span>
						</a>
					</li>
					";
					$dispatchNAV = true;
														}
												}
										}
										?>
              <li class="nav-item menu-items">
                <a class="nav-link">
                  <i class=""></i>
                  <span class="menu-title">     </span>
                </a>
              </li>
              <li class="nav-item menu-items">
                <a class="nav-link">
                  <i class=""></i>
                  <span class="menu-title">     </span>
                </a>
              </li>
              <li class="nav-item menu-items">
                <a class="nav-link">
                  <i class=""></i>
                  <span class="menu-title">     </span>
                </a>
              </li>
              <li class="nav-item menu-items">
                <a class="nav-link">
                  <i class=""></i>
                  <span class="menu-title">     </span>
                </a>
              </li>
              <li class="nav-item menu-items">
                <a class="nav-link">
                  <i class=""></i>
                  <span class="menu-title">     </span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
			        <div id="hTitle"></div>
			<div>
			<div style="display: inline-block; margin-right: 10px;">
			<button type='button' style='margin-right:"50px"' class='btn btn-inverse-primary btn-fw' data-toggle="modal" data-target="#notepad">Notepad</button>
			</div>
			<div style="display: inline-block; margin-right: 10px;">
			<button type='button' style='margin-right:"50px"' class='btn btn-inverse-secondary btn-fw' data-toggle="modal" data-target="#apparatus">Apparatus</button>
			</div>
			<?php
            if (isset($_GET["callsign"])) {
                echo "
                <a href='fire-ems-logout.php'><button type='button' class='btn btn-inverse-danger btn-fw'>Logout</button></a>
			";
            }
            ?>
                    <div class="modal fade" id="notepad" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Notepad - <?php echo $_GET["callsign"]." // ".$_GET["name"];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form>
								<textarea class="form-control" id="notepadarea" rows="8"></textarea>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade" id="apparatus" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Apparatus - <?php echo $_GET["callsign"]." // ".$_GET["name"];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id='setApparatus-Form' method='post'>
							              <input type='hidden' name='steam_id' id='steam_id' value=<?php echo "'".$steamprofile["steamid"]."'";?>>
						  <div class="form-group">
								<select class="js-example-basic-single" style="width:100%" id="apparatus_type" name="apparatus_type">
									<option value="CANCEL">SELECT APPARATUS</option>
									<option value="1">ENGINE 01</option>
									<option value="2">ENGINE 02</option>
									<option value="3">LADDER 01</option>
									<option value="4">LADDER 02</option>
									<option value="5">AMBULANCE 01</option>
									<option value="6">AMBULANCE 02</option>
									<option value="7">AIR SUPPORT 01</option>
									<option value="8">AIR SUPPORT 02</option>
								</select>
							</div>
                          </div>
                          <div class="modal-footer">
                            <a onclick='javascript:setApparatus()'><button id='setApparatus' type="button" class="btn btn-primary">Attach to Apparatus</button></a>
                            </form>
                            <button id="closeAApparatusmodal" type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
			</div>
            </div>
			<div id="statusBar"></div>
			<br>
			<div id="dispatchCheck"></div>
                    <!-- Modal starts -->
                    <div class="modal fade" id="call-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                            <div class="fetched-data"></div>
                      </div>
                    </div>
					<div class="modal fade" id="createCall" role="dialog" aria-labelledby="createCall-label" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="createCall-label">Generate Call</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
						  <form id='createCall-Form' method='post'>
                          <div class="modal-body">
						  <div class="form-group">
								<select class="js-example-basic-single" style="width:100%" id="call_type" name="call_type">
									<option value="MVA">MVA</option>
									<option value="SEVERE MVA">SEVERE MVA</option>
									<option value="SEARCH AND RESCUE">SEARCH AND RESCUE</option>
									<option value="DISTRESS CALL">DISTRESS CALL</option>
									<option value="SHOTS FIRED">SHOTS FIRED</option>
									<option value="MISSING PERSONS">MISSING PERSONS</option>
									<option value="STRUCTURE FIRE">STRUCTURE FIRE</option>
									<option value="WILD FIRE">WILD FIRE</option>
									<option value="FIRE ALARM">FIRE ALARM</option>
									<option value="OTHER">OTHER</option>
								</select>
							</div>
							<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
								<span class="input-group-text">DETAILS</span>
								</div>
								<input type="text" id="call_desc" name="call_desc" class="form-control" placeholder="Call Details" required>
							</div>
							</div>
							<input type='hidden' name='steam_id' id='steam_id' value=<?php echo "'".$steamprofile["steamid"]."'";?>>
							<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
								<span class="input-group-text">LOC</span>
								</div>
								<input type="text" id="call_loc" name="call_loc" class="form-control" placeholder="Street Name" required>
							</div>
							</div>
							<div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
								<span class="input-group-text">POSTAL</span>
								</div>
								<input type="text" id="call_postal" name="call_postal" class="form-control" placeholder="Postal #" required>
							</div>
							</div>
                            <div>
								<select class="form-control" id="call_attach" name="call_attach">
								<option value="attach">ATTACH ME TO THIS CALL</option>
								<option value="noattach">DON'T ATTACH ME</option>
								</select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <a onclick='javascript:createCall()'><button id='createCall' type="button" class="btn btn-primary">Create</button></a>
						  </form>
                            <button type="button" id="closeCCallmodal" class="btn btn-light" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal Ends -->
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">SAMR Database</h4>
                    <p class="card-description">San Andreas Medical Records <code>(SAMR)</code></p>
						  <form class="form-inline" id='medQUERY-Form' method='post'>
						  <div class="form-group">
							<div class="input-group">
								<div class="input-group-prepend">
								<span class="input-group-text">MEDICAL QUERY</span>
								</div>
								<input type="text" id="query_name" name="query_name" class="form-control" placeholder="Person Name" required>
							</div>
							<a onclick='javascript:medQUERY()'><button id='medQUERY-Submit' type="button" style='margin-left:5px; height:33px;' class="btn btn-primary">Search</button></a>
							</div>
							</form>
						<div id="medQUERY-results"></div>
				  </div>
				</div>
			  </div>
			</div>
                    </div>

          </div>
      <!-- partial:partials/_footer.html -->
      <footer class="footer container">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://vertexroleplay.com" target="_blank">Vertex Roleplay</a>. All rights reserved.</span>
              <span class="text-muted float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- Plugin js for this page -->

    <!-- PRELOADER -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script>
    	$(window).load(function() {
    		// Animate loader off screen
    		$(".se-pre-bg").fadeOut("slow");;
				document.getElementById('myLogin').click();
    	});
    </script>
    <!-- PRELOADER -->

		<!-- WINDOW SIZE -->
		<script>
		function showModal() {
			//run code
			$(".blackout").fadeIn("slow");
		}

		function hideModal() {
			//run code
			$(".blackout").fadeOut("slow");
		}

		setInterval(sizeCheck, 1000);
		var trig = false;

		function sizeCheck() {
			if (($(window).width() < 1200) && (trig == false)) {
				//Window is too small, size the page down.
				//zoom_page(-10, $(this))
				showModal();
				trig = true;
			} else {
				if (($(window).width() > 1200) && (trig == true)) {
					//Window is big enough so size it back up.
					//zoom_page(10, $(this))
					hideModal();
					trig = false;
				}
			}
		}
		</script>
		<!-- WINDOW SIZE -->

		<script>
		$(':input:not(textarea)').keypress(function(event) {
    return event.keyCode != 13;
		});
		</script>

	<script>
	$(document).ready(function(){
    $('#call-view').on('show.bs.modal', function (e) {
        var callid = $(e.relatedTarget).data('callid');
        var appid = $(e.relatedTarget).data('appid');
        $.ajax({
            type : 'post',
            url : 'fetchcall.php', //Here you will fetch records
            data :  { callid: callid, appid: appid},
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
  </script>

    <script language="javascript" type="text/javascript">
		$('#hTitle').load('backend.php?value=title');
		$('#statusBar').load('backend.php?value=statusbar');
		$('#dispatchCheck').load('backend.php?value=dispatchcheck');
		//$('#personSAMR').load('backend.php?value=medQUERY');
	var timeout = setInterval(reloadChat, 5000);
		function reloadChat () {
		$('#hTitle').load('backend.php?value=title');
		$('#statusBar').load('backend.php?value=statusbar');
		$('#dispatchCheck').load('backend.php?value=dispatchcheck');
		//$('#personSAMR').load('backend.php?value=medQUERY');
		}
	</script>
    <script src="../assets/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="../assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/select2/select2.min.js"></script>
    <script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/typeahead.js"></script>
    <script src="../assets/js/select2.js"></script>
    <script src="../assets/js/modal-demo.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
