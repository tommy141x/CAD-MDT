<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $cit_owner = $_POST["cit_owner"];
    $cit_creator = $_POST["cit_creator"];
    $cit_type = $_POST["cit_type"];
    $cit_details = $_POST["cit_details"];
    $cit_street = $_POST["cit_street"];
    $cit_postal = $_POST["cit_postal"];
    $cit_fine = $_POST["cit_fine"];
    if (($cit_street == "") or ($cit_fine == "")) {
    } else {
        $database->query("INSERT INTO mdt_citations (cit_owner, cit_creator, cit_type, cit_details, cit_street, cit_postal, cit_fine, cit_date)VALUES('".str_replace("'", '', $cit_owner)."', '".str_replace("'", '', $cit_creator)."', '".$cit_type."', '".str_replace("'", '', $cit_details)."', '".str_replace("'", '', $cit_street)."', '".str_replace("'", '', $cit_postal)."', '".str_replace("'", '', $cit_fine)."', '".date("m/d/Y")."');");
    }
}
?> 