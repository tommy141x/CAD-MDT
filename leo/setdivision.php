<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $type = $_POST["type"];
    $steamid = $_POST["steam_id"];
    if (!($type == "CANCEL")) {
        $database->query("UPDATE mdt_units SET unit_division='".$type."' WHERE steam_id='".$steamid."'");
    }
}
?> 