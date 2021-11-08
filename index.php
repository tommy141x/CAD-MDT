<!DOCTYPE html>
<?php
// PRELOADER
echo "
<link rel='shortcut icon' type='image/ico' href='assets/images/favicon.ico'>
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
	background-image: url('assets/images/blackout.png');
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
include 'config.php';
require 'login/steamauth/steamauth.php';
require 'connectdb.php';
include('login/steamauth/userInfo.php');

if (!isset($_SESSION['steamid'])) {
    header("Location: login");
    die();
}

$cdata = $database->select('mdt_citations', [
  'cit_creator',
  'cit_type',
  'cit_details',
  'cit_street',
  'cit_postal',
  'cit_fine',
  'cit_date'
], ['cit_date[=]'=>date("m/d/Y")]);

  $cjsondata = json_encode($cdata);
  $citationarray = json_decode($cjsondata, true);

  $adata = $database->select('mdt_announcements', [
    'title',
    'description',
    'checked'
  ], []);

  $ajsondata = json_encode($adata);
  $annarray = json_decode($ajsondata, true);

$data2 = $database->select('mdt_departments', [
    'dept_name',
    'dept_abv',
    'dept_logo',
    'dept_type'
], []);

$query2 = $database->query("SELECT COUNT(*) FROM mdt_departments;");
$result2 = $query2->fetch(PDO::FETCH_ASSOC);

foreach ($result2 as $key => $value) {
    $deptNUM = ($result2[$key]);
}

$query5 = $database->query("SELECT COUNT(*) FROM mdt_characters;");
$result5 = $query5->fetch(PDO::FETCH_ASSOC);

global $civNUM;
foreach ($result5 as $key => $value) {
    $civNUM = ($result5[$key]);
}

$query6 = $database->query("SELECT COUNT(*) FROM mdt_citations;");
$result6 = $query6->fetch(PDO::FETCH_ASSOC);

global $tickNUM;
foreach ($result6 as $key => $value) {
    $tickNUM = ($result6[$key]);
}

$data4 = $database->select('mdt_users', [
    'approved_dept',
], []);

$jsondata4 = json_encode($data4);
$leoARR = json_decode($jsondata4, true);
global $leoNUM;
$leoNUM=0;
for ($x = 1; $x <= count($leoARR); $x++) {
    $str = $leoARR[$x-1]["approved_dept"];
    if ((strpos($str, '2')) or (strpos($str, '3')) or (strpos($str, '4'))) {
        $leoNUM++;
    }
}

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
$fileList = glob('assets/css/themes/*.css');
$themeCheck = false;
	foreach($fileList as $filename){
	//Use the is_file function to make sure that it is not a directory.
		if(is_file($filename)){
			$name = str_replace(".css", "", str_replace("assets/css/themes/", "", $filename));
			if($name == $theme){
				$themeCheck = true;
			}
		}
	}
if($themeCheck == false){
	$theme = "default";
}


function getPercentageChange($oldNumber, $newNumber)
{
    $decreaseValue = $oldNumber - $newNumber;
    $one_decimal_place = number_format(-(($decreaseValue / $oldNumber) * 100), 1);
    return $one_decimal_place;
}

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $communityName;?> | Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
		<link rel='stylesheet' href='assets/css/themes/<?php echo $theme;?>.css'>
		<!-- Scrollbar -->
		<style>body::-webkit-scrollbar {display: none;}</style>
    <!-- End layout styles -->
  </head>
  <body style="background-color:black;">
    <div class="container-scroller">
      <!-- partial:partials/_horizontal-navbar.html -->
      <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
          <div class="container">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

              <img class="navbar-brand brand-logo" style="margin-left:7px; max-height:45px;" src="assets/images/logo.png"/>
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
                    <a href="settings" class="dropdown-item preview-item">
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
                    <a href='panel' class='dropdown-item preview-item'>
                      <div class='preview-thumbnail'>
                        <div class='preview-icon bg-dark rounded-circle'>
                          <i class='mdi mdi-settings text-danger'></i>
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
                    <a href='panel' class='dropdown-item preview-item'>
                      <div class='preview-thumbnail'>
                        <div class='preview-icon bg-dark rounded-circle'>
                          <i class='mdi mdi-settings text-danger'></i>
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
                          <i class="mdi mdi-logout text-secondary"></i>
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
                <a class="nav-link" href="#">
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
					  <a class='nav-link' href='".$arr2[$x-1]["dept_abv"]."'>
						<i class='mdi mdi mdi-account-circle menu-icon'></i>
						<span class='menu-title'>".$arr2[$x-1]["dept_abv"]."</span>
					  </a>
					</li>
					";
					$civNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "LEO") and ($leoNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='leo'>
						<i class='mdi mdi mdi-account-box-multiple menu-icon'></i>
						<span class='menu-title'>LEO</span>
					  </a>
					</li>
					";
					$leoNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "FIRE") and ($feNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='fire-ems'>
						<i class='mdi mdi mdi-fire menu-icon'></i>
						<span class='menu-title'>Fire/EMS</span>
					  </a>
					</li>
					";
					$feNAV = true;
				} elseif (($arr2[$x-1]["dept_type"] == "DISPATCH") and ($dispatchNAV == false)) {
                                echo "
					<li class='nav-item menu-items'>
					  <a class='nav-link' href='dispatch'>
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
            <div class="row">

							<div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">New Tactile Look</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">Welcome to our new CAD/MDT System! Try it out, if you have any questions feel free to ask.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Civilians</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?php echo $civNUM; ?></h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+<?php echo(rand(1, 4)); ?>.<?php echo(rand(1, 4)); ?>%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo(rand(5, 7)); ?>.<?php echo(rand(10, 90)); ?>% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-account-circle text-secondary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Law Enforcement Officers</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?php echo $leoNUM; ?></h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+<?php echo(rand(1, 4)); ?>.<?php echo(rand(1, 5)); ?>%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo(rand(10, 12)); ?>.<?php echo(rand(10, 50)); ?>% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-account-box-multiple text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Total Citations</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?php echo $tickNUM; ?></h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+<?php echo(rand(1, 4)); ?>.<?php echo(rand(8, 20)); ?>%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo(rand(15, 40)); ?>.<?php echo(rand(10, 90)); ?>% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-file-document-edit-outline text-danger ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Today's Citations</h4>
                    <?php
                    $countC = 0;
                    foreach ($citationarray as $key => $cit) {
                        if ($countC < 4) {
                            echo"
                      <div class='bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3'>
                      <div class='text-md-center text-xl-left'>
                        <h6 class='mb-1'>".$cit["cit_type"]."</h6>
                        <p class='text-muted mb-0'>Written by ".$cit["cit_creator"]."</p>
                      </div>
                      <div class='align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0'>
                        <h6 class='font-weight-bold mb-0'>$".$cit["cit_fine"]."</h6>
                      </div>
                    </div>
                      ";
                            $countC++;
                        }
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">Announcements</h4>
                      <p class="text-muted mb-1">❤️ Have a wonderful day!</p>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <br>
                        <?php
                        $countA = 0;
                        foreach (array_reverse($annarray) as $key => $ann) {
                            if ($countA < 4) {
                                if ($ann["checked"] == '1') {
                                    echo "
                          <div class='card rounded border mb-2'>
                            <div class='card-body p-3'>
                              <div class='media'>
                                <i class='mdi mdi-check-all icon-sm text-success align-self-center mr-3'></i>
                                <div class='media-body'>
                                  <h6 class='mb-1'>".$ann['title']."</h6>
                                  <p class='mb-0 text-muted'> ".$ann['description']." </p>
                                </div>
                              </div>
                            </div>
                          </div>
                          ";
                                } else {
                                    echo "
                          <div class='card rounded border mb-2'>
                            <div class='card-body p-3'>
                              <div class='media'>
                                <i class='mdi mdi-check icon-sm text-primary align-self-center mr-3'></i>
                                <div class='media-body'>
                                  <h6 class='mb-1'>".$ann['title']."</h6>
                                  <p class='mb-0 text-muted'> ".$ann['description']." </p>
                                </div>
                              </div>
                            </div>
                          </div>
                          ";
                                }
                                $countA++;
                            }
                        }
                        ?>
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
    <!-- plugins:js -->
	<script src="https://cqjrs35st1pb.statuspage.io/embed/script.js"></script>
    <!-- PRELOADER -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script>
    	$(window).load(function() {
    		// Animate loader off screen
    		$(".se-pre-bg").fadeOut("slow");
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

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
