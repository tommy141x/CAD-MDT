<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require 'connectdb.php';
    $call_caller = $_POST["call_caller"]; //set PHP variables like this so we can use them anywhere in code below
    $call_street = $_POST["call_street"];
    $call_postal = $_POST["call_postal"];
    $call_desc = $_POST["call_desc"];
    $char_id = $_POST["steam_id"];
    

    if (strlen($call_caller) > 1) {
        $query = $database->query("SELECT id FROM mdt_calls WHERE call_name = '".$call_caller."'");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (($result == null) or ($result == 0)) {
            $database->query("INSERT INTO mdt_calls (call_id, call_name, call_description, call_location, call_postal, call_type, call_isPriority)VALUES('".$char_id."', '".str_replace("'", '', $call_caller)."', '".str_replace("'", '', $call_desc)."', '".str_replace("'", '', $call_street)."', '".$call_postal."', '911 CALL', '0');");
            header("Location: civilian/index.php?data=callsuccess");
            die();
        } else {
            header("Location: civilian/index.php?data=callfailed");
            die();
        }
    } else {
        header("Location: civilian/index.php?data=vfailed2");
        die();
    }
}
?> 