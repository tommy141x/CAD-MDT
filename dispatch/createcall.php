<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $type = $_POST["type"];
    $desc = $_POST["desc"];
    $loc = $_POST["loc"];
    $postal = $_POST["postal"];
    $database->query("INSERT INTO mdt_calls (call_name, call_description, call_location, call_postal, call_type, call_isPriority)VALUES('DISPATCH', '".$desc."', '".$loc."', '".$postal."', '".$type."', '0');");
}
?> 