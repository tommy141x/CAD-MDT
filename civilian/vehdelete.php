<?php
require '../login/steamauth/steamauth.php';
include('../login/steamauth/userInfo.php');
if (!isset($_SESSION['steamid'])) {
    header("Location: /../login");
    die();
}
if (!($steamprofile['steamid'] == $_GET["owner_id"])) {
    header("Location: index.php");
    die();
}
require '../connectdb.php';
    $char_id = $_GET["owner_id"];
    $veh_plate = $_GET["veh_plate"]; //set PHP variables like this so we can use them anywhere in code below
    

$database->query("DELETE FROM mdt_vehicles WHERE owner_id='".$char_id."' AND veh_plate='".$veh_plate."'");
header("Location: index.php?data=vdeleted");
die();
?> 