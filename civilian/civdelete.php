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
$char_name = $_GET["char_name"]; //set PHP variables like this so we can use them anywhere in code below
$database->query("DELETE FROM mdt_characters WHERE owner_id='" . $char_id . "' AND char_name='" . $char_name . "'");
$database->query("DELETE FROM mdt_citations WHERE cit_owner='" . $char_name . "'");
$database->query("DELETE FROM mdt_warrants WHERE warrant_owner='" . $char_name . "'");
$database->query("DELETE FROM mdt_medreps WHERE report_owner='" . $char_name . "'");
$database->query("DELETE FROM mdt_arrests WHERE arr_owner='" . $char_name . "'");
header("Location: index.php?data=deleted");
die();
