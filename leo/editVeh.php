<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $veh_plate = $_POST["veh_plate"];
    $veh_flags = $_POST["veh_flags"];
    $database->query("UPDATE mdt_vehicles SET veh_flags='".$veh_flags."' WHERE veh_plate='".$veh_plate."'");
}
