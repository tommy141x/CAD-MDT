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
</style>
<div class='se-pre-bg'></div>
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

//$deptNUM = print_r($result);


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
if ($rank == 0) {
    header("Location: ../");
    die();
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

$userdata = $database->select('mdt_users', [
    'time_registered',
    'username',
    'perm_id',
    'approved_dept'
], []);

$jsonuserdata = json_encode($userdata);
$user = json_decode($jsonuserdata, true);

$userquery = $database->query("SELECT COUNT(*) FROM mdt_users;");
$userresult = $userquery->fetch(PDO::FETCH_ASSOC);

foreach ($userresult as $key => $value) {
    $userNUM = ($userresult[$key]);
}


function searchForUser($input)
{
    $result = array_search($input, array_column($user, 'username'));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $communityName;?> | Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
		<!-- Scrollbar -->
		<style>body::-webkit-scrollbar {display: none;}</style>
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/themes/<?php echo $theme;?>.css">
    <!-- End layout styles -->
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jsgrid/jsgrid.min.css">
    <link rel="stylesheet" href="../assets/vendors/jsgrid/jsgrid-theme.min.css">
  </head>
  <body style="background-color:black;">
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
                    <a href='../admin' class='dropdown-item preview-item'>
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
                    <a href='../admin' class='dropdown-item preview-item'>
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
          <div class="container">
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
      <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
			<?php
            if ($rank == 3) {
                echo "<h3 class='page-title'> Admin Panel </h3>";
            } else {
                echo "<h3 class='page-title'> Supervisor Panel </h3>";
            }
            ?>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../">Dashboard</a></li>
			<?php
            if ($rank == 3) {
                echo "<li class='breadcrumb-item active' aria-current='page'>Admin Panel</li>";
            } else {
                echo "<li class='breadcrumb-item active' aria-current='page'>Supervisor Panel</li>";
            }
            ?>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div id="table" class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User List</h4>
                    <p class="card-description"> Number of Users: <code><?php echo $userNUM;?></code></p>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <tbody>
						<div class="container">
			<div class="form-group">
				<div class="input-group">
					<input type="text" name="search_text" id="search_text" placeholder="Search by User Details" class="form-control" />
				</div>
			</div>
			<br />
			<div id="result"></div>
		</div>
		<div style="clear:both"></div>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
			<?php
            if ($rank == 3) {
                echo "<div class='col-lg-6 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Admin Settings</h4>
                    <p class='card-description'> Your Rank: <code>Admin</code></p>
                    <code>Announcement Creator</code>
                    <br>
                    <form method='post' action='newann.php'>
                    <input type='text' class='form-control' id='title' name='title' placeholder='Title' aria-label='Title' aria-describedby='basic-addon' required>
                    <br>
                      <input type='text' class='form-control' id='text' name='text' placeholder='Announcement' aria-label='Announcement' aria-describedby='basic-addon2' required>
                      <br>
                    <div class='input-group'>
                    <select class='form-control' id='checked' name='checked'>
                    <option value='1'>Ticked</option>
                    <option value='0'>Not Ticked</option>
                    </select>
                    <div class='input-group-append'>
                      <button class='btn btn-sm btn-primary' type='submit'>Create</button>
                    </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
			  ";
            } else {
                echo "
							<script>
							document.getElementById('table').classList.remove('col-lg-6');
							document.getElementById('table').classList.add('col-lg-12');
							</script>
			  ";
            }
            ?>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
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
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->

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
	<script>
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"../fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}

	$('#search_text').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();
		}
	});
});
</script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>
