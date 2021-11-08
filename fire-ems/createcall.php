<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $type = $_POST["type"];
    $desc = $_POST["desc"];
    $loc = $_POST["loc"];
    $postal = $_POST["postal"];
    $attach = $_POST["attach"];
    $database->query("INSERT INTO mdt_calls (call_name, call_description, call_location, call_postal, call_type, call_isPriority)VALUES('DISPATCH', '".$desc."', '".$loc."', '".$postal."', '".$type."', '0');");
    if ($attach == 'attach') {
        $callquery = $database->query("SELECT id FROM mdt_calls WHERE call_description='".$desc."' AND call_type='".$type."' AND call_location='".$loc."' AND call_postal='".$postal."'");
        $callresult = $callquery->fetch(PDO::FETCH_ASSOC);
        global $callid;
        foreach ($callresult as $key => $value) {
            $callid = ($callresult[$key]);
        }
        $aidquery = $database->query("SELECT unit_call FROM mdt_units WHERE steam_id='".$_POST['steam_id']."'");
        $aidresult = $aidquery->fetch(PDO::FETCH_ASSOC);
        global $aid;
        foreach ($aidresult as $key => $value) {
            $aid = ($aidresult[$key]);
        }
        $database->query("UPDATE mdt_apparatus SET apparatus_call='".$callid."' WHERE id='".$aid."'");
    }
}
?> 