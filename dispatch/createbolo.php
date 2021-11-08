<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $date = date("i");
    $database->query("INSERT INTO mdt_bolos (bolo_desc, bolo_creator, bolo_createdAt)VALUES('".str_replace("'", '', $desc)."', '".str_replace("'", '', $name)."', '".$date."');");
}
?> 