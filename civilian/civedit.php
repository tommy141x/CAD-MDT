<?php
require '../connectdb.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") { //Check it is coming from a form
    require_once __DIR__ . '/../Medoo.php';
    $char_name = $_POST["char_name"]; //set PHP variables like this so we can use them anywhere in code below
    $char_address = $_POST["char_address"];
    $char_dl = $_POST["char_dl"];
    $char_wl = $_POST["char_wl"];
    $char_id = $_POST["steam_id"];

    if (strlen($char_address) > 2) {
        $database->query("UPDATE mdt_characters SET char_dl='" . $char_dl . "', char_wl='" . $char_wl . "', char_address='" . $char_address . "' WHERE owner_id='" . $char_id . "' AND char_name='" . $char_name . "'");
    } else {
        $database->query("UPDATE mdt_characters SET char_dl='" . $char_dl . "', char_wl='" . $char_wl . "' WHERE owner_id='" . $char_id . "' AND char_name='" . $char_name . "'");
    }
    header("Location: index.php?data=edited");
    die();
}
