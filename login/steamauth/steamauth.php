<?php
ob_start();
session_start();
include __DIR__ . '/../../config.php';

use Medoo\Medoo;
function insertSteamDB() {
require_once __DIR__ . '/../../Medoo.php';
include ('userInfo.php');
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $databaseName,
    'server' => $dbHOST,
    'username' => $dbUSER,
    'password' => $dbPASS
]);

$query = $database->query("SELECT id FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$result = $query->fetch(PDO::FETCH_ASSOC);
$query2 = $database->query("SELECT COUNT(*) FROM mdt_users;");
$result2 = $query2->fetch(PDO::FETCH_ASSOC);
foreach($result2 as $key => $value) {
   $accNUM = ($result2[$key]);
}
if (($result == null) or ($result == 0)) {

  if(($accNUM > $maxUsers) && ($maxUsers > 0)){
  //run code
  header('Location: index.php?data=maxusers');
  session_destroy();
  die();
}else{
if($autoApproveCiv){
$database->query("INSERT IGNORE INTO mdt_users (steam_id, time_registered, username, perm_id, approved_dept, user_theme)VALUES('".$steamprofile['steamid']."', '".date("m/d/Y")."', '".str_replace("'", '', $steamprofile['personaname'])."', 0, '1,', 'default');");
}else{
$database->query("INSERT IGNORE INTO mdt_users (steam_id, time_registered, username, perm_id, approved_dept, user_theme)VALUES('".$steamprofile['steamid']."', '".date("m/d/Y")."', '".str_replace("'", '', $steamprofile['personaname'])."', 0, '', 'default');");
}
}
}
}

function logoutbutton() {
	//echo "<form action='' method='get'><button name='logout' type='submit'>Logout</button></form>"; //logout button
	//echo "<form action='' method='get'><button name='logout' type='submit'>Logout</button></form>"
	echo "
	<form action='' method='get'>
	<button name='logout' type='submit' style='font-size: 13px; color:white; border:0px solid black; background-color: transparent;' class='preview-item-content'>
    Logout
    </button>
	</form>
	"; //logout button
}

function loginbutton($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	$button = "<a href='?login' class='btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn'>LOGIN WITH STEAM</a>";
	echo $button;
}

if (isset($_GET['login'])){
	require 'openid.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);

		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'User has canceled authentication!';
		} else {
			if($openid->validate()) {
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);

				$_SESSION['steamid'] = $matches[1];
				insertSteamDB();
				if (!headers_sent()) {
					header('Location: '.$steamauth['loginpage']);
					exit;
				} else {
					?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
					<?php
					exit;
				}
			} else {
				echo "User is not logged in.\n";
			}
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}

if (isset($_GET['logout'])){
	require 'SteamConfig.php';
	session_unset();
	session_destroy();
	header('Location: '.$steamauth['logoutpage']);
	exit;
}

if (isset($_GET['update'])){
	unset($_SESSION['steam_uptodate']);
	require 'userInfo.php';
	header('Location: '.$_SERVER['PHP_SELF']);
	exit;
}

// Version 3.2

?>
