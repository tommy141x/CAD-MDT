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

//Include Config & Session Info & Connect to Database
include '../config.php';
require '../login/steamauth/steamauth.php';
require '../connectdb.php';
include('../login/steamauth/userInfo.php');

//Make sure they are logged in
if (!isset($_SESSION['steamid'])) {
    header("Location: login");
    die();
}
if (!isset($_GET["steam_id"])) {
    header("Location: ../panel");
    die();
}
use Medoo\Medoo;

//This is optional to allow or not allow someone to edit themself.
//if ($steamprofile['steamid'] == $_GET["steam_id"]){
//	header("Location: ../index.php");
//	die();
//}

//Grab the list of departments.
$data = $database->select('mdt_departments', [
    'dept_name',
    'dept_abv',
    'dept_logo',
    'dept_type'
], []);

//Grab the number of departments
$query = $database->query("SELECT COUNT(*) FROM mdt_departments;");
$result = $query->fetch(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
    $deptNUM = ($result[$key]);
}


$jsondata = json_encode($data);
$arr = json_decode($jsondata, true);

//Grab the departments the user is approved for.
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

//Grab the departments the user being viewed is approved for.
$steamquery2 = $database->query("SELECT approved_dept FROM mdt_users WHERE steam_id = '".$_GET["steam_id"]."'");
$steamresult2 = $steamquery2->fetch(PDO::FETCH_ASSOC);
global $arrapproved;

if (($steamresult2 == null) or ($steamresult2 == 0)) {
    $arrapproved = 0;
} else {
    foreach ($steamresult as $key => $value) {
        $arrapproved = ($steamresult2[$key]);
    }
}

//Grab this user's rank.
$rankquery = $database->query("SELECT perm_id FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$rankresult = $rankquery->fetch(PDO::FETCH_ASSOC);
global $rank;

//Grab the user being viewed's rank.
$rank3query = $database->query("SELECT perm_id FROM mdt_users WHERE steam_id = '".$_GET["steam_id"]."'");
$rank3result = $rank3query->fetch(PDO::FETCH_ASSOC);
global $rank3;

if (($rankresult == null) or ($rankresult == 0)) {
    $rank = 0;
} else {
    foreach ($rankresult as $key => $value) {
        $rank = ($rankresult[$key]);
    }
}

if (($rank3result == null) or ($rank3result == 0)) {
    $rank3 = 0;
} else {
    foreach ($rank3result as $key => $value) {
        $rank3 = ($rank3result[$key]);
    }
}

//Boot them if this user is too low rank to see this page.
if ($rank == 0) {
    header("Location: ../index.php");
    die();
}

function permCheck($num)
{
    if ($num == 0) {
        $rank2 = "User";
    } elseif ($num == 1) {
        $rank2 = "Supervisor";
    } elseif ($num == 2) {
        $rank2 = "Dept Director";
    } elseif ($num == 3) {
        $rank2 = "Admin";
    } else {
        $rank2 = "User";
    }
    return $rank2;
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

//Get the user's steam info
$usteam = $_GET["steam_id"];
$steamarray = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$SteamWebAPIKey."&steamids=".$usteam);
$steaminfo = json_decode($steamarray, true);

$user = $database->select('mdt_users', [
    'time_registered',
    'username',
    'perm_id',
    'approved_dept'
], [
"steam_id[=]" => $usteam
]);
if ($rank > 0) {
    $funk = isset($_GET['action']) ? $_GET['action'] : '';
    if (strpos($funk, 'add') !== false) {
        $code = str_replace('add', '', $funk);
        $database->query("UPDATE mdt_users SET approved_dept='".$arrapproved.$code.",' WHERE steam_id='".$usteam."'");
        header("Refresh:0; url=index.php?steam_id=".$usteam);
        die();
    }

    if (strpos($funk, 'remove') !== false) {
        $code = str_replace('remove', '', $funk);
        $database->query("UPDATE mdt_users SET approved_dept='".str_replace($code.',', '', $arrapproved)."' WHERE steam_id='".$usteam."'");
        header("Refresh:0; url=index.php?steam_id=".$usteam);
        die();
    }
}
if ($rank == 3) {
    if (strpos($funk, 'rank') !== false) {
        $code = str_replace('rank', '', $funk);
        if ($code == '0') {
            $database->query("UPDATE mdt_users SET perm_id=0 WHERE steam_id='".$usteam."'");
        } elseif ($code == '1') {
            $database->query("UPDATE mdt_users SET perm_id=1 WHERE steam_id='".$usteam."'");
        } elseif ($code == '2') {
            $database->query("UPDATE mdt_users SET perm_id=2 WHERE steam_id='".$usteam."'");
        } elseif ($code == '3') {
            $database->query("UPDATE mdt_users SET perm_id=3 WHERE steam_id='".$usteam."'");
        }
        header("Refresh:0; url=index.php?steam_id=".$usteam);
        die();
    }
} elseif ($rank == 2) {
    if (strpos($funk, 'rank') !== false) {
        if ($rank3 < 2) {
            $code = str_replace('rank', '', $funk);
            if ($code == '0') {
                $database->query("UPDATE mdt_users SET perm_id=0 WHERE steam_id='".$usteam."'");
            } elseif ($code == '1') {
                $database->query("UPDATE mdt_users SET perm_id=1 WHERE steam_id='".$usteam."'");
            }
            header("Refresh:0; url=index.php?steam_id=".$usteam);
            die();
        }
    }
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User - <?php echo($steaminfo["response"]["players"][0]["personaname"]); ?></title>
	<!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
		<!-- Scrollbar -->
		<style>body::-webkit-scrollbar {display: none;}</style>
    <!-- endinject -->
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
                    <a class="dropdown-item preview-item" href="login">
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
              <h3 class="page-title"><?php echo($steaminfo["response"]["players"][0]["personaname"]); ?>'s Profile </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../panel">Admin Panel</a></li>
                  <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="border-bottom text-center pb-4">
                          <a href=<?php echo($steaminfo["response"]["players"][0]["profileurl"]); ?> target="_blank"><img src=<?php echo($steaminfo["response"]["players"][0]["avatarfull"]); ?> alt="profile" class="img-lg rounded-circle mb-3" /></a>
                        </div>
                        <div class="border-bottom py-4">
                          <div class="d-flex mb-3">
                            <div class="progress progress-md flex-grow">
                              <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="55" style="width: 55%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                          <div class="d-flex">
                            <div class="progress progress-md flex-grow">
                              <div class="progress-bar bg-success" role="progressbar" aria-valuenow="75" style="width: 75%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                        <div class="py-4">
                          <p class="clearfix">
                            <span class="float-left"> <?php echo $user[0]["username"]; ?> </span>
                            <span class="float-right text-muted"> <?php echo permCheck($user[0]["perm_id"]) ?></span>
                          </p>
                          <p class="clearfix">
                            <span class="float-left"> Steam URL </span>
                            <a href=<?php echo($steaminfo["response"]["players"][0]["profileurl"]); ?> target="_blank"><span class="float-right text-muted"> <?php echo substr($steaminfo["response"]["players"][0]["profileurl"], 0, 25)."..."; ?> </span></a>
                          </p>
                        </div>
					<?php
                    if ($rank == 3) {
                        echo "
                        <button class='btn btn-primary btn-block' data-toggle='modal' data-target='#exampleModal-2'>REMOVE FROM CAD</button>
						";
                    } ?>
						<!-- Modal starts -->
                    <div class="modal fade" id="exampleModal-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel-2">REMOVE USER?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you want to remove <?php echo $user[0]["username"]; ?>?</p>
                          </div>
                          <div class="modal-footer">
                            <a href="delacc.php?id=<?php echo $usteam; ?>"><button type="button" class="btn btn-light" >Delete User</button></a>
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                   </div>
                    <!-- Modal Ends -->
                      <div class="col-lg-8">
                        <div class="d-flex justify-content-between">
                          <div>
                            <h3><?php echo($steaminfo["response"]["players"][0]["personaname"]); ?></h3>
                            <div class="d-flex align-items-center">
                              <h5 class="mb-0 mr-2 text-muted"><?php echo $communityName; ?></h5>
                            </div>
                          </div>
                        </div>
                        <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <p class="card-description">User Settings</p>
                    <!-- Dummy Modal Starts -->
                    <div class="modal demo-modal">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Approved Departments</h5>
                          </div>
                          <div class="modal-body">
						  <?php

                    for ($x = 1; $x <= ($deptNUM + 0); $x++) {
                        if (strpos($arrapproved, strval($x)) !== false) {
                            echo "<img src='".$arr[$x-1]["dept_logo"]."' height=auto width=15px>   ".$arr[$x-1]["dept_name"];
                            echo "<br>";
                        }
                    }
                          ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#deptmodal">Edit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Dummy Modal Ends -->
                    <!-- Modal starts -->
                    <div class="modal fade" id="deptmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModal-Label" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal-Label"><?php echo $user[0]["username"]; ?>'s Settings</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
						  <?php

                    for ($x = 1; $x <= ($deptNUM + 0); $x++) {
                        if (strpos($arrapproved, strval($x)) !== false) {
                            echo "<a href='index.php?steam_id=".$_GET["steam_id"]."&action=remove".strval($x)."'><button type='button' class='btn btn-warning btn-sm'>Remove</button></a> <img src='".$arr[$x-1]["dept_logo"]."' height=auto width=15px>   ".$arr[$x-1]["dept_name"];
                            echo "<br>";
                            echo "<br>";
                        } else {
                            echo "<a href='index.php?steam_id=".$_GET["steam_id"]."&action=add".strval($x)."'><button type='button' class='btn btn-success btn-sm'>   Add   </button></a> <img src='".$arr[$x-1]["dept_logo"]."' height=auto width=15px>   ".$arr[$x-1]["dept_name"];
                            echo "<br>";
                            echo "<br>";
                        }
                    }
                          if ($rank == 3) {
                              echo "<div class='btn-group'>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      ".permCheck($user[0]['perm_id'])." - Admin Level
      </button>
      <div class='dropdown-menu'>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank0'>User</a>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank1'>Supervisor</a>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank2'>Dept Director</a>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank3'>Admin</a>
      </div>
    </div> ";
                          }

                          if ($rank == 2) {
                              echo "<div class='btn-group'>
      <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      ".permCheck($user[0]['perm_id'])." - Admin Level
      </button>
      <div class='dropdown-menu'>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank0'>User</a>
        <a class='dropdown-item' href='index.php?steam_id=".$_GET['steam_id']."&action=rank1'>Supervisor</a>
      </div>
    </div> ";
                          }
                    ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal Ends -->
                  </div>
                </div>
              </div>
					  </div>
					  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
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
    <script src="../assets/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/profile-demo.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
