<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $officer = $_POST["officer"];
    $desc = $_POST["desc"];
    $owner = $_POST["owner"];
    $database->query("INSERT INTO mdt_medreps (report_owner, report_creator, report_desc, report_date)VALUES('".$owner."', '".$officer."', '".$desc."', '".date("m/d/Y")."');");
}
?> 