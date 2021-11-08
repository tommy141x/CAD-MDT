<?php
require '../login/steamauth/steamauth.php';
include('../login/steamauth/userInfo.php');
require '../connectdb.php';
$steam_id = $steamprofile['steamid'];
$database->query("DELETE FROM mdt_units WHERE steam_id='".$steam_id."'");
header("Location: ../index.php");
die();
?> 