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
</style>
<div class='se-pre-bg'></div>
";
// PRELOADER
include '../config.php';
require 'steamauth/steamauth.php';
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $communityName;?> | Login</title>
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
    <link rel="stylesheet" href="../assets/css/themes/default.css">
    <!-- End layout styles -->
  </head>
  <body style="background-color:grey;">
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
          <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
              <div class="auth-form-transparent text-left p-3">
								<?php
								if(isset($_GET["data"])) {
								if($_GET["data"] == "maxusers"){
								echo '
									<h4>Welcome back!</h4>
									<h6 class="font-weight-light">Happy to see you again!</h6>
									<form class="pt-3">
										<div class="my-2 d-flex justify-content-between align-items-center">
										<a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" disabled>MAX USERS REACHED</a>
										</div>
									</form>
								';
								}else{
								echo '
									<h4>Welcome back!</h4>
									<h6 class="font-weight-light">Happy to see you again!</h6>
									<form class="pt-3">
										<div class="my-2 d-flex justify-content-between align-items-center">
										<a href="?login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN WITH STEAM</a>
										</div>
									</form>
								';
								}
								}else{
								echo '
									<h4>Welcome back!</h4>
									<h6 class="font-weight-light">Happy to see you again!</h6>
									<form class="pt-3">
										<div class="my-2 d-flex justify-content-between align-items-center">
										<a href="?login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN WITH STEAM</a>
										</div>
									</form>
								';
								}
								 ?>
              </div>
            </div>
            <div class="col-lg-6 login-half-bg d-flex flex-row">
              <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2020 All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
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

    <script src="../../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../../assets/js/off-canvas.js"></script>
    <script src="../../../assets/js/hoverable-collapse.js"></script>
    <script src="../../../assets/js/misc.js"></script>
    <script src="../../../assets/js/settings.js"></script>
    <script src="../../../assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
