<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $veh_plate = $_POST["veh_plate"];
    $veh_flags = $_POST["veh_flags"];
    $veh_color = $_POST["veh_color"];
    $char_id = $_POST["steam_id"];

    if (strlen($veh_color) > 0) {
        $database->query("UPDATE mdt_vehicles SET veh_flags='".$veh_flags."', veh_color='".$veh_color."' WHERE owner_id='".$char_id."' AND veh_plate='".$veh_plate."'");
    } else {
        $database->query("UPDATE mdt_vehicles SET veh_flags='".$veh_flags."' WHERE owner_id='".$char_id."' AND veh_plate='".$veh_plate."'");
    }
    header("Location: index.php?data=vedited");
    die();
}
?> 