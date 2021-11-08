<?php
    global $priostatus;
    $priostatus = "HOLD";
    require '../connectdb.php';
    $prioquery = $database->query("SELECT mdt_data FROM mdt_status WHERE id='1'");
    $prioresult = $prioquery->fetch(PDO::FETCH_ASSOC);
    foreach ($prioresult as $key => $value) {
        $priostatus = ($prioresult[$key]);
    }
    echo $priostatus;
