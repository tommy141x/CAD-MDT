<?php
// Include Config & Connect to Database
include '../config.php';
require '../connectdb.php';
require '../login/steamauth/steamauth.php';
include('../login/steamauth/userInfo.php');

//Make sure the rank of the person is high enough to delete someone from the CAD/MDT.
$rankquery = $database->query("SELECT perm_id FROM mdt_users WHERE steam_id = '".$steamprofile['steamid']."'");
$rankresult = $rankquery->fetch(PDO::FETCH_ASSOC);
global $rank;

//Fetch the Rank from the Query
if (($rankresult == null) or ($rankresult == 0)) {
    $rank = 0;
} else {
    foreach ($rankresult as $key => $value) {
        $rank = ($rankresult[$key]);
    }
}

//If the Rank is high enough delete the account and head back.
if ($rank == 3) {
    $steamquery = $database->query("DELETE FROM mdt_users WHERE steam_id='".$_GET["id"]."'");
}
header("Location: ../panel");
die();
