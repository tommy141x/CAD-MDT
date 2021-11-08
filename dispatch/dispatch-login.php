<?php
require '../connectdb.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    $callsign = $_POST["callsign"]; //set PHP variables like this so we can use them anywhere in code below
    $name = $_POST["name"];
    $steam_id = $_POST["steam_id"];



    $queryquery = $database->query("SELECT unit_name FROM mdt_units WHERE steam_id='".$steam_id."'");
    $queryresult = $queryquery->fetch(PDO::FETCH_ASSOC);
    if ($queryresult == null) {
        $database->query("INSERT INTO mdt_units (steam_id, unit_callsign, unit_name, unit_status, unit_call, unit_division, unit_type, unit_panic)VALUES('".$steam_id."', '".str_replace("'", '', $callsign)."', '".str_replace("'", '', $name)."', '10-42', 'none', 'DISPATCH', 'DISPATCH', '0');");
        header("Location: index.php?callsign=".$callsign."&name=".$name);
        die();
    } else {
        foreach ($queryresult as $key => $value) {
            $finalres = ($queryresult[$key]);
        }

        $query2query = $database->query("SELECT unit_callsign FROM mdt_units WHERE steam_id='".$steam_id."'");
        $query2result = $query2query->fetch(PDO::FETCH_ASSOC);
        foreach ($query2result as $key => $value) {
            $final2res = ($query2result[$key]);
        }
        header("Location: index.php?callsign=".$final2res."&name=".$finalres);
        die();
    }
}
?> 