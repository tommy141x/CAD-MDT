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
    header("Location: ../login");
    die();
}

global $headerData;
if (isset($_GET["data"])) {
    $headerData = $_GET["data"];
}

$data = $database->select('mdt_departments', [
    'dept_name',
    'dept_abv',
    'dept_logo',
    'dept_type'
], []);

$query = $database->query("SELECT COUNT(*) FROM mdt_departments;");
$result = $query->fetch(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
    $deptNUM = ($result[$key]);
}

$jsondata = json_encode($data);
$arr = json_decode($jsondata, true);

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
            if ($arr[$x-1]["dept_type"] == "CIV") {
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

$query6 = $database->query("SELECT COUNT(*) FROM mdt_citations;");
$result6 = $query6->fetch(PDO::FETCH_ASSOC);

global $tickNUM;
foreach ($result6 as $key => $value) {
    $tickNUM = ($result6[$key]);
}

$cdata = $database->select('mdt_characters', [
    'char_name',
    'char_dob',
    'char_address',
      'char_dl',
      'char_wl'
], ["owner_id[=]" => $steamprofile['steamid']]);

$cjsondata = json_encode($cdata);
$char = json_decode($cjsondata, true);

$ddata = $database->select('mdt_vehicles', [
    'veh_plate',
    'veh_model',
    'veh_color',
    'veh_flags',
    'veh_owner_name'
], ["owner_id[=]" => $steamprofile['steamid']]);

$djsondata = json_encode($ddata);
$veh = json_decode($djsondata, true);

?>

<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title><?php echo $communityName;?> | Civilian Panel</title>
      <!-- plugins:css -->
      <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
      <!-- endinject -->
      <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
      <!-- Plugin css for this page -->
      <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
      <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
      <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
      <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
      <link rel="stylesheet" href="../assets/vendors/select2/select2.min.css">
      <link rel="stylesheet" href="../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
      <!-- End plugin css for this page -->
      <!-- inject:css -->
      <!-- endinject -->
			<!-- Scrollbar -->
			<style>body::-webkit-scrollbar {display: none;}</style>
      <!-- Layout styles -->
      <link rel="stylesheet" href="../assets/css/themes/<?php echo $theme;?>.css">
      <!-- End layout styles -->
   </head>
   <body style="background-color:black;">
      <div class="container-scroller">
      <!-- partial:partials/_horizontal-navbar.html -->
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
         <a href="../settings" class="dropdown-item preview-item">
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
                    <a href='../panel' class='dropdown-item preview-item'>
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
                    <a href='../panel' class='dropdown-item preview-item'>
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
                    <a class="dropdown-item preview-item" href="../login">
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
          <div class="container"  style="max-height: 60px;">
            <ul class="nav page-navigation">
              <li class="nav-item menu-items">
                <a class="nav-link" href="../">
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
                            if (($arr[$x-1]["dept_type"] == "CIV") and ($civNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='../".$arr[$x-1]["dept_abv"]."'>
						<i class='mdi mdi mdi-account-circle menu-icon'></i>
						<span class='menu-title'>".$arr[$x-1]["dept_abv"]."</span>
					  </a>
					</li>
					";
					$civNAV = true;
				} elseif (($arr[$x-1]["dept_type"] == "LEO") and ($leoNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='../leo'>
						<i class='mdi mdi mdi-account-box-multiple menu-icon'></i>
						<span class='menu-title'>LEO</span>
					  </a>
					</li>
					";
					$leoNAV = true;
				} elseif (($arr[$x-1]["dept_type"] == "FIRE") and ($feNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='../fire-ems'>
						<i class='mdi mdi mdi-fire menu-icon'></i>
						<span class='menu-title'>Fire/EMS</span>
					  </a>
					</li>
					";
					$feNAV = true;
				} elseif (($arr[$x-1]["dept_type"] == "DISPATCH") and ($dispatchNAV == false)) {
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
              <h3 class="page-title"> Civilian Dashboard</h3>
			  <?php
              if ($headerData == "created") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-success' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Civilian Created. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "edited") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-success' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Civilian Edited. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "callsuccess") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-success' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> 911 Call Created. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "callfailed") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> You must wait before sending in another call. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "vedited") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-success' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Vehicle Edited. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "vcreated") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-success' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Vehicle Registered. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "failed") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Civilian with that name already exists. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "vfailed") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Vehicle with that plate already exists. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "vfailed2") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> You must create a Civilian first. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "vdeleted") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Vehicle Removed. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
              } elseif ($headerData == "deleted") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> Character Killed. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
					} elseif ($headerData == "cmax") {
                  echo "
					<div class='info-message'>
					<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
                      <i class='mdi mdi-alert-circle'></i> You already have the maximum amount of personas. </div>
					  </div>

					  <script>
			setTimeout(function(){
					var fadeTarget = document.getElementById('info-message');
					  var fadeEffect = setInterval(function () {
				if (!fadeTarget.style.opacity) {
					fadeTarget.style.opacity = 1;
				}
				if (fadeTarget.style.opacity > 0) {
					fadeTarget.style.opacity -= 0.1;
				} else {
					clearInterval(fadeEffect);
				}
			}, 20);
			}, 1500);
			</script>

					  ";
					} elseif ($headerData == "vmax") {
		                  echo "
							<div class='info-message'>
							<style> .info-message{position:absolute; margin:auto; width:30%; top:20%;}</style>
		                    <div id='info-message' class='alert alert-fill-danger' role='alert'>
		                      <i class='mdi mdi-alert-circle'></i> You already have the maximum amount of vehicles. </div>
							  </div>

							  <script>
					setTimeout(function(){
							var fadeTarget = document.getElementById('info-message');
							  var fadeEffect = setInterval(function () {
						if (!fadeTarget.style.opacity) {
							fadeTarget.style.opacity = 1;
						}
						if (fadeTarget.style.opacity > 0) {
							fadeTarget.style.opacity -= 0.1;
						} else {
							clearInterval(fadeEffect);
						}
					}, 20);
					}, 1500);
					</script>

							  ";
		              }?>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Civ Panel</li>
                </ol>
              </nav>
            </div>
            <div class="row">


			<!--MAKE BUTTONS-->
			<div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Currently Logged In:</h4>
                    <button type="button" class="btn btn-primary"><?php echo $steamprofile['personaname']; ?></button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Call the cops!</h4>
                    <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#New911Call'>New 911 Call</button>
                  </div>
                </div>
              </div>
			  <div class='modal fade' id='New911Call' tabindex='-1' role='dialog' aria-labelledby='New911CallLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='New911CallLabel'>Create 911 Call?</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>

						  <form class="forms-sample" method="post" action="../newcall.php">
                      <div class="form-group">
                        <label for="exampleInputUsername1">Caller ID</label>
						<div class="input-group mb-2 mr-sm-2 mb-sm-0">
						<label class='sr-only' for='input5b'>Caller ID</label>
						<select name="call_caller" class="js-example-basic-single" id="input5b" style="width:100%">
						<?php for ($x = 1; $x <= (count($char)); $x++) {
                  echo "
							<label class='sr-only' for='input-owner-name-'".$x."'>Caller ID</label>
							<option id='input-owner-name-".$x."' value='".$char[$x-1]["char_name"]."'>".$char[$x-1]["char_name"]."</option>
							";
              }

                        if (count($char) < 1) {
                            echo"	<label class='sr-only' for='input-owner-name-'".$x."'>Caller ID</label>
							<option id='input-owner-name-".$x."' value=''>Create a civilian first!</option>
					    ";
                        }
                        ?>
                      </select>
						</div>
                      </div>
                      <div class="form-group">
                        <label for="desc">Call Description</label>
                        <input name="call_desc" class="form-control" id="desc" placeholder="Description" required>
                      </div>
                      <div class="form-group">
                        <label for="street">Street Name</label>
                        <input name="call_street" class="form-control" id="street" placeholder="East Joshua Road">
                      </div>
                      <div class="form-group">
                        <label for="postal">Postal #</label>
                        <input name="call_postal" class="form-control" id="postal" placeholder="940">
                      </div>
						<input type='hidden' name='steam_id' value='<?php echo $steamprofile['steamid'];?>'/>
                          </div>
                          <div class='modal-footer'>
                            <button type="submit" class="btn btn-primary mr-2" action="../newcall.php">Submit</button>
                    </form>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h4 class="mb-0"><?php echo $tickNUM ?> Citations</h4>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+<?php echo rand(0, 20);?>%</p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Citations (Global)</h6>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Civ Panel</h4>
					<p class="card-description"> Character Creator </p>
               <form class="form-inline repeater" method="post" action="civcreate.php">
              <label class="sr-only" for="inlineFormInput">Name</label>
              <input name="char_name" minlength="2" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Jane Doe" required>
              <label class="sr-only" for="input1">mm/dd/yy</label>
              <label class="sr-only" for="input2">Address</label>
              <label class="sr-only" for="input3">DR License</label>
              <label class="sr-only" for="input4">DR License</label>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0" style="width:150px;">
                  <div class="input-group-prepend">
                    <span class="input-group-text">DOB</span>
                  </div>
                  <input name="char_dob" minlength="10" type="text" class="form-control" id="input1" placeholder="mm/dd/yy" required>
              </div>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <span class="input-group-text">#</span>
                  </div>
                  <input name="char_address" minlength="3" type="text" class="form-control" id="input2" placeholder="Address" required>
              </div>
             <span class="input-group-text" style="margin-top:2px; background-color:black; color:white; border-width:2px; border-color: black;">DL</span>
			  <div style='margin-top:2px;' class="input-group mb-2 mr-sm-2 mb-sm-0">

                      <select name="char_dl" class="js-example-basic-single" id="input3" style="width:100%">
                        <option value="Valid">Valid</option>
                        <option value="Expired">Expired</option>
                        <option value="Revoked">Revoked</option>
                        <option value="None">None</option>
                      </select>
			</div>
             <span class="input-group-text" style="margin-top:2px; background-color:black; color:white; border-width:2px; border-color: black;">WL</span>
			  <div style='margin-top:2px;'class="input-group mb-2 mr-sm-2 mb-sm-0">
                      <select name="char_wl" class="js-example-basic-single" id="input4" style="width:100%">
                        <option value="None">None</option>
                        <option value="Valid">Valid</option>
                        <option value="Expired">Expired</option>
                        <option value="Revoked">Revoked</option>
                      </select>
			</div>
			<input type='hidden' name='steam_id' value='<?php echo $steamprofile['steamid'];?>'/>
              <button type="submit" class="btn btn-primary" action="civcreate.php">Create</button>
    </form>

					<!-- Dummy Modal Starts -->
                    <div class="accordion accordion-filled" id="accordion-7" role="tablist">
					<?php for ($x = 1; $x <= (count($char)); $x++) {
                            $wdata = $database->select('mdt_warrants', [
                            'warrant_desc',
                            'warrant_creator'
                            ], ['warrant_owner[=]'=>$char[$x-1]["char_name"]]);
                            $wjsondata = json_encode($wdata);
                            $warrantarray = json_decode($wjsondata, true);
                            global $has_warrant;
                            if (count($warrantarray)==0) {
                                $has_warrant=false;
                            } else {
                                $has_warrant=true;
                            }

                            $cdata = $database->select('mdt_citations', [
                'cit_creator',
                'cit_type',
                'cit_details',
                'cit_street',
                'cit_postal',
                'cit_fine',
                'cit_date'
                ], ['cit_owner[=]'=>$char[$x-1]["char_name"]]);

                            $cjsondata = json_encode($cdata);
                            $citationarray = json_decode($cjsondata, true);
                            global $has_citation;
                            if (count($citationarray)==0) {
                                $has_citation=false;
                            } else {
                                $has_citation=true;
                            }

                            $adata = $database->select('mdt_arrests', [
                  'arr_creator',
                  'arr_type',
                  'arr_details',
                  'arr_street',
                  'arr_postal',
                  'arr_date'
                  ], ['arr_owner[=]'=>$char[$x-1]["char_name"]]);

                            $ajsondata = json_encode($adata);
                            $arrestarray = json_decode($ajsondata, true);
                            global $has_arrest;
                            if (count($arrestarray)==0) {
                                $has_arrest=false;
                            } else {
                                $has_arrest=true;
                            }


                            echo "

						<div class='card'>
                        <div class='card-header' role='tab' id='heading-'".$x.">
                          <h5 class='mb-0'>
						  ";
                            if ($has_warrant == true) {
                                echo "
                            <a data-toggle='collapse' href='#collapse-".$x."' aria-expanded='false' aria-controls='collapse-".$x."'> ".$char[$x-1]["char_name"]." - ".$char[$x-1]["char_dob"]." - <code>ACTIVE WARRANT</code></a>";
                            } else {
                                echo "
                            <a data-toggle='collapse' href='#collapse-".$x."' aria-expanded='false' aria-controls='collapse-".$x."'> ".$char[$x-1]["char_name"]." - ".$char[$x-1]["char_dob"]."</a>";
                            }
                            echo"
                          </h5>
                        </div>
                        <div id='collapse-".$x."' class='collapse' role='tabpanel' aria-labelledby='heading-".$x."' data-parent='#accordion-7'>
                          <div class='card-body'>
						  <a style='font-weight:450;'>Address:</a>  ".$char[$x-1]["char_address"]."
						  <br>
						  <a style='font-weight:450;'>Drivers License:</a>  ".$char[$x-1]["char_dl"]."
						  <br>
						  <a style='font-weight:450;'>Weapons License:</a>  ".$char[$x-1]["char_wl"]."
						  ";
                            if ($has_warrant == true) {
                                foreach ($warrantarray as $key => $warrant) {
                                    echo "
								<br>
								<a style='font-weight:440;'>WARRANT:</a> <code>".$warrant["warrant_desc"]."</code>
								";
                                }
                            }
                            echo "
						  <div style='float: right; text-align: right; display: inline-block;'>
							<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#KillChar-".$x."'>Kill Character</button>
						   <button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#viewTickets-".$x."'>Citations / Arrests</button>
						   <button type='button' class='btn btn-info' data-toggle='modal' data-target='#createWarrant-".$x."'>Create Warrant</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#EditChar-".$x."'>Edit</button>
							</div>
						  </div>
                        </div>
                      </div>
                    <div class='modal fade' id='viewTickets-".$x."' tabindex='-1' role='dialog' aria-labelledby='exampleTicketModalLabel-2-".$x."' aria-hidden='true'>
                      <div class='modal-dialog modal-lg' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleTicketModalLabel-2-".$x."'>".$char[$x-1]["char_name"]."'s Tickets</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                          <h3>Citations</h3>
                          <div class='table-responsive w-100'>
                  <table class='table'>
                    <thead>
                      <tr class='bg-dark text-white'>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th class='text-right'>Fine</th>
                        <th class='text-right'>Date</th>
                        <th class='text-right'>Written By</th>
                      </tr>
                    </thead>
                  <tbody>
                  ";
                            if ($has_citation == true) {
                                foreach ($citationarray as $key => $cit) {
                                    $details = strlen($cit["cit_details"]) > 20 ? substr($cit["cit_details"], 0, 20)."..." : $cit["cit_details"];
                                    $street = strlen($cit["cit_street"]) > 17 ? substr($cit["cit_street"], 0, 17)."..." : $cit["cit_street"];
                                    echo "
                      <tr class='text-right'>
                        <td class='text-left'>".$cit["cit_type"]."</td>
                        <td class='text-left'>".$details."</td>
                        <td class='text-left'>".$street.", #".$cit["cit_postal"]."</td>
                        <td>$".$cit["cit_fine"]."</td>
                        <td>".$cit["cit_date"]."</td>
                        <td>".$cit["cit_creator"]."</td>
                  </tr>
                  ";
                                }
                            } else {
                                echo "<p style='color:green;'>NO CITATIONS ON RECORD</p>";
                            }
                            echo "
                    </tbody>
                  </table>
                </div>
                <hr>
                <h3>Arrests</h3>
                <div class='table-responsive w-100'>
                <table class='table'>
                <thead>
                  <tr class='bg-dark text-white'>
                  <th>Reason</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th class='text-right'>   </th>
                  <th class='text-right'>Date</th>
                  <th class='text-right'>Arrested By</th>
                  </tr>
                </thead>
                <tbody>
                ";
                            if ($has_arrest == true) {
                                foreach ($arrestarray as $key => $arr) {
                                    $details = strlen($arr["arr_details"]) > 20 ? substr($arr["arr_details"], 0, 20)."..." : $arr["arr_details"];
                                    $street = strlen($arr["arr_street"]) > 17 ? substr($arr["arr_street"], 0, 17)."..." : $arr["arr_street"];
                                    echo "
                  <tr class='text-right'>
                  <td class='text-left'>".$arr["arr_type"]."</td>
                  <td class='text-left'>".$details."</td>
                  <td class='text-left'>".$street.", #".$arr["arr_postal"]."</td>
                  <td>   </td>
                  <td>".$arr["arr_date"]."</td>
                  <td>".$arr["arr_creator"]."</td>
                  </tr>
                  ";
                                }
                            } else {
                                echo "<p style='color:green;'>NO ARRESTS ON RECORD</p>";
                            }
                            echo "
                </tbody>
                </table>
                </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='modal fade' id='EditChar-".$x."' tabindex='-1' role='dialog' aria-labelledby='exampleETicketModalLabel-2-".$x."' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleATicketModalLabel-2-".$x."'>".$char[$x-1]["char_name"]." - ".$char[$x-1]["char_dob"]."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Edit Character</p>
               <form class='form-inline repeater' method='post' action='civedit.php'>
              <label class='sr-only' for='inputm2-".$x."'>Address</label>
              <label class='sr-only' for='inputm3-".$x."'>DR License</label>
              <label class='sr-only' for='inputm4-".$x."'>DR License</label>
              <span class='input-group-text' style='margin-top:0px; background-color:black; color:white; height:34px; border-width:1px; border-color:rgb(20,20,20);'>DL</span>
							<div class='input-group mb-2 mr-sm-2 mb-sm-0'>

                      <select name='char_dl' class='js-example-basic-single' id='inputm3-".$x."' style='width:100%'>
					  ";
                            if ($char[$x-1]["char_dl"] == "Valid") {
                                echo "
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='Revoked'>Revoked</option>
                        <option value='None'>None</option>
						  ";
                            } elseif ($char[$x-1]["char_dl"] == "Expired") {
                                echo "
                        <option value='Expired'>Expired</option>
						  <option value='Valid'>Valid</option>
                        <option value='Revoked'>Revoked</option>
                        <option value='None'>None</option>
						  ";
                            } elseif ($char[$x-1]["char_dl"] == "Revoked") {
                                echo "
                        <option value='Revoked'>Revoked</option>
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='None'>None</option>
						  ";
                            } else {
                                echo "
                        <option value='None'>None</option>
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='Revoked'>Revoked</option>
						  ";
                            }
                            echo "
                      </select>
			</div>
      <span class='input-group-text' style='margin-top:0px; background-color:black; color:white; height:34px; border-width:1px; border-color:rgb(20,20,20);'>WL</span>
			  <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                      <select name='char_wl' class='js-example-basic-single' id='inputm4-".$x."' style='width:100%'>
                        ";
                            if ($char[$x-1]["char_wl"] == "Valid") {
                                echo "
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='Revoked'>Revoked</option>
                        <option value='None'>None</option>
						  ";
                            } elseif ($char[$x-1]["char_wl"] == "Expired") {
                                echo "
                        <option value='Expired'>Expired</option>
						  <option value='Valid'>Valid</option>
                        <option value='Revoked'>Revoked</option>
                        <option value='None'>None</option>
						  ";
                            } elseif ($char[$x-1]["char_wl"] == "Revoked") {
                                echo "
                        <option value='Revoked'>Revoked</option>
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='None'>None</option>
						  ";
                            } else {
                                echo "
                        <option value='None'>None</option>
						  <option value='Valid'>Valid</option>
                        <option value='Expired'>Expired</option>
                        <option value='Revoked'>Revoked</option>
						  ";
                            }
                            echo "
                      </select>
						</div>
						<input style='margin-top:10px; width:300px;' name='char_address' minlength='3' type='text' class='form-control' id='inputm2-".$x."' placeholder='".$char[$x-1]["char_address"]."'/>
						<input type='hidden' name='steam_id' value='".$steamprofile['steamid']."'/>
						<input type='hidden' name='char_name' value='".$char[$x-1]["char_name"]."'/>
                        </div>
                          <div class='modal-footer'>
                            <button type=' submit'action='civedit.php' class='btn btn-primary'>Submit</button>
						</form>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                          </div>
                        </div>
                      </div>
                    </div>

					<div class='modal fade' id='createWarrant-".$x."' tabindex='-1' role='dialog' aria-labelledby='ModalLabel".$x."' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='ModalLabel".$x."'>CREATE WARRANT</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
						  <form id='createWarrant-Form".$x."' method='post'>
                  <div class='modal-body'>
							      <div class='input-group'>
								        <div class='input-group-prepend'>
								          <span class='input-group-text'>WARRANT</span>
								        </div>
								      <input type='text' id='warrant_desc".$x."' name='warrant_desc".$x."' class='form-control' placeholder='Warrant Description' required>
								      <input type='hidden' name='warrant_owner".$x."' id='warrant_owner".$x."' value='".$char[$x-1]["char_name"]."'>
							      </div>
							    <input type='hidden' name='bolo_name".$x."' id='bolo_name".$x."' value='DISPATCH'>
                  </div>
                  <div class='modal-footer'>
                    <a onclick='javascript:createCivWarrant(".$x.")'><button id='createCivWarrant".$x."' type='submit' class='btn btn-danger'>Create</button></a>
						  </form>
                            <button type='button' id='closeWarrantModal".$x."' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class='modal fade' id='KillChar-".$x."' tabindex='-1' role='dialog' aria-labelledby='exampleATicketModalLabel-2-".$x."' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleATicketModalLabel-2-".$x."'>KILL ".strtoupper($char[$x-1]["char_name"])."?</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Are you sure you want to kill ".$char[$x-1]["char_name"]."?</p>
                          </div>
                          <div class='modal-footer'>
                            <a href='civdelete.php?owner_id=".$steamprofile['steamid']."&char_name=".$char[$x-1]["char_name"]."' method='post' class='btn btn-danger'>KILL</a>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>


						";
                        }
                        ?>
                  </div>
                </div>
              </div>
            </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Vehicle Panel</h4>
					<p class="card-description"> Register Your Vehicle </p>
               <form class="form-inline repeater" method="post" action="vehcreate.php">
              <label class="sr-only" for="inlineFormInput">PLATE</label>
              <label class="sr-only" for="input1b">Make & Model</label>
              <label class="sr-only" for="input2b">Color</label>
              <label class="sr-only" for="input4b">FLAGS</label>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <span class="input-group-text">📋</span>
                  </div>
		              <input style="width:95px;" name="veh_plate" minlength="2" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="PLATE" required>
              </div>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <span class="input-group-text">🚗</span>
                  </div>
                  <input name="veh_model" type="text" class="form-control" id="input1b" placeholder="Make & Model" required>
              </div>
              <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <span class="input-group-text">#</span>
                  </div>
                  <input name="veh_color" style="width:145px;" type="text" class="form-control" id="input2b" placeholder="Color" required>
              </div>
			  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                      <select name="veh_flags" class="js-example-basic-single" id="input4b" style="width:100%">
                        <option value="Valid Registration">Valid Registration</option>
                        <option value="Expired Registration">Expired Registration</option>
                        <option value="STOLEN">STOLEN</option>
                      </select>
			</div>
			  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                      <select name="veh_owner_name" class="js-example-basic-single" id="input3b" style="width:100%">
						<?php for ($x = 1; $x <= (count($char)); $x++) {
                            $out = strlen($char[$x-1]["char_name"]) > 17 ? substr($char[$x-1]["char_name"], 0, 17)."..." : $char[$x-1]["char_name"];
                            echo "
							<label class='sr-only' for='input-owner-'".$x."'>Owner</label>
							<option value='".$char[$x-1]["char_name"]."'>".$out."</option>
							";
                        }

                        if (count($char) < 1) {
                            echo"	<label class='sr-only' for='input-owner-'".$x."'>Owner</label>
							<option value=''>N/A</option>
					    ";
                        }
                        ?>
                      </select>
			</div>
			<input type='hidden' name='steam_id' value='<?php echo $steamprofile['steamid'];?>'/>
              <button type="submit" class="btn btn-primary" action="vehcreate.php">Register</button>
    </form>

					<!-- Dummy Modal Starts -->
                    <div class="accordion accordion-filled" id="accordion-6" role="tablist">
					<?php for ($x = 1; $x <= (count($veh)); $x++) {
                            echo "

						<div class='card'>
                        <div class='card-header' role='tab' id='heading-".$x."-V'>
                          <h5 class='mb-0'>
                            <a data-toggle='collapse' href='#collapse-".$x."-V' aria-expanded='false' aria-controls='collapse-".$x."-V'> ".$veh[$x-1]["veh_model"]." - ".$veh[$x-1]["veh_plate"]."</a>
                          </h5>
                        </div>
                        <div id='collapse-".$x."-V' class='collapse' role='tabpanel' aria-labelledby='heading-".$x."-V' data-parent='#accordion-6'>
                          <div class='card-body'>
						  <a style='font-weight:450;'>Registered Owner:</a>  ".$veh[$x-1]["veh_owner_name"]."
						  <br>
						  <a style='font-weight:450;'>Plate:</a>  ".$veh[$x-1]["veh_plate"]."
						  <br>
						  <a style='font-weight:450;'>Model:</a>  ".$veh[$x-1]["veh_model"]."
						  <br>
						  <a style='font-weight:450;'>Color:</a>  ".$veh[$x-1]["veh_color"]."
						  <br>
						  <a style='font-weight:450;'>Flags:</a>  ".$veh[$x-1]["veh_flags"]."
						  <div style='float: right; text-align: right; display: inline-block;'>
							<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#DelVeh-".$x."-V'>Delete</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#EditVeh-".$x."-V'>Edit</button>
							</div>
						  </div>
                        </div>
                      </div>
                    <div class='modal fade' id='EditVeh-".$x."-V' tabindex='-1' role='dialog' aria-labelledby='exampleETicketModalLaVbel-2-".$x."-V' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleATicketModalLabel-2-".$x."-V'>".$veh[$x-1]["veh_owner_name"]." - ".$veh[$x-1]["veh_owner_name"]."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Edit Vehicle</p>
               <form class='form-inline repeater' method='post' action='vehedit.php'>
              <label class='sr-only' for='inputm2-".$x."-V'>Address</label>
              <label class='sr-only' for='inputm3-".$x."-V'>DR License</label>
              <label class='sr-only' for='inputm4-".$x."-V'>DR License</label>
							<div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                      <select name='veh_flags' class='js-example-basic-single' id='inputm3-".$x."-V' style='width:100%'>
					  ";
                            if ($veh[$x-1]["veh_flags"] == "Valid Registration") {
                                echo "
						  <option value='Valid Registration'>Valid Registration</option>
                        <option value='Expired Registration'>Expired Registration</option>
                        <option value='STOLEN'>STOLEN</option>
						  ";
                            } elseif ($veh[$x-1]["veh_flags"] == "Expired Registration") {
                                echo "
                        <option value='Expired Registration'>Expired Registration</option>
						  <option value='Valid Registration'>Valid Registration</option>
                        <option value='STOLEN'>STOLEN</option>
						  ";
                            } else {
                                echo "
                        <option value='STOLEN'>STOLEN</option>
						  <option value='Valid Registration'>Valid Registration</option>
                        <option value='Expired Registration'>Expired Registration</option>
						  ";
                            }
                            echo "
                      </select>
			</div>
			<input name='veh_color' minlength='3' type='text' class='form-control' id='inputm2-".$x."-V' placeholder='".$veh[$x-1]["veh_color"]."'>
			<input type='hidden' name='steam_id' value='".$steamprofile['steamid']."'/>
			<input type='hidden' name='veh_plate' value='".$veh[$x-1]["veh_plate"]."'/>
                          </div>
                          <div class='modal-footer'>
                            <button type=' submit'action='veh_edit.php' class='btn btn-primary'>Submit</button>
			</form>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='modal fade' id='DelVeh-".$x."-V' tabindex='-1' role='dialog' aria-labelledby='exampleATicketModalLabel-2-".$x."-V' aria-hidden='true'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleATicketModalLabel-2-".$x."-V'>DELETE ".strtoupper($veh[$x-1]["veh_model"]." - ".$veh[$x-1]["veh_plate"])."?</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Are you sure you want to remove this vehicle?</p>
                          </div>
                          <div class='modal-footer'>
                            <a href='vehdelete.php?owner_id=".$steamprofile['steamid']."&veh_plate=".$veh[$x-1]["veh_plate"]."' method='post' class='btn btn-danger'>DELETE</a>
                            <button type='button' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>


						";
                        }
                        ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer container">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://vertexmods.com" target="_blank">Vertex Modifications</a>. All rights reserved.</span>
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
	</script>

    <!-- plugins:js -->


    <!-- PRELOADER -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script>
    	$(window).load(function() {
    		// Animate loader off screen
    		$(".se-pre-bg").fadeOut("slow");;
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

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/select2/select2.min.js"></script>
    <script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../assets/vendors/jquery-validation/jquery.validate.min.js"></script>
    <script src="../assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="createCivWarrant.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->

    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/file-upload.js"></script>
    <script src="../assets/js/typeahead.js"></script>
    <script src="../assets/js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
