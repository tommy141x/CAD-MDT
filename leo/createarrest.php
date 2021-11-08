<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $arr_owner = $_POST["arr_owner"];
    $arr_creator = $_POST["arr_creator"];
    $arr_type = $_POST["arr_type"];
    $arr_details = $_POST["arr_details"];
    $arr_street = $_POST["arr_street"];
    $arr_postal = $_POST["arr_postal"];
    if (($arr_street == "") or ($arr_postal == "")) {
    } else {
        $database->query("INSERT INTO mdt_arrests (arr_owner, arr_creator, arr_type, arr_details, arr_street, arr_postal, arr_date)VALUES('".str_replace("'", '', $arr_owner)."', '".str_replace("'", '', $arr_creator)."', '".$arr_type."', '".str_replace("'", '', $arr_details)."', '".str_replace("'", '', $arr_street)."', '".str_replace("'", '', $arr_postal)."', '".date("m/d/Y")."');");
    }
}
?> 