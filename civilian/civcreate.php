<?php
require '../connectdb.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Check it is coming from a form
    include('../config.php');
    $char_name = $_POST["char_name"]; //set PHP variables like this so we can use them anywhere in code below
    $char_dob = $_POST["char_dob"];
    $char_address = $_POST["char_address"];
    $char_dl = $_POST["char_dl"];
    $char_wl = $_POST["char_wl"];
    $char_id = $_POST["steam_id"];

    if($maxPersonas != 0){
    $cquery = $database->query("SELECT COUNT(*) FROM mdt_characters WHERE owner_id='".$char_id."';");
    $cresult = $cquery->fetch(PDO::FETCH_ASSOC);

    foreach ($cresult as $key => $value) {
        $civNUM = ($cresult[$key]);
    }
    if($civNUM >= $maxPersonas){
        header("Location: index.php?data=cmax");
        die();
    }else{
    $query = $database->query("SELECT id FROM mdt_characters WHERE char_name = '" . $char_name . "'");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (($result == null) or ($result == 0)) {
        $database->query("INSERT INTO mdt_characters (owner_id, char_name, char_dob, char_address, char_dl, char_wl)VALUES('" . $char_id . "', '" . str_replace("'", '', $char_name) . "', '" . str_replace("'", '', $char_dob) . "', '" . str_replace("'", '', $char_address) . "', '" . $char_dl . "', '" . $char_wl . "');");
        header("Location: index.php?data=created");
        die();
    } else {
        header("Location: index.php?data=failed");
        die();
    }
    }
    }else{
    $query = $database->query("SELECT id FROM mdt_characters WHERE char_name = '" . $char_name . "'");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (($result == null) or ($result == 0)) {
        $database->query("INSERT INTO mdt_characters (owner_id, char_name, char_dob, char_address, char_dl, char_wl)VALUES('" . $char_id . "', '" . str_replace("'", '', $char_name) . "', '" . str_replace("'", '', $char_dob) . "', '" . str_replace("'", '', $char_address) . "', '" . $char_dl . "', '" . $char_wl . "');");
        header("Location: index.php?data=created");
        die();
    } else {
        header("Location: index.php?data=failed");
        die();
    }
  }
}
