<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $title = $_POST["title"]; //set PHP variables like this so we can use them anywhere in code below
    $text = $_POST["text"];
    $checked = $_POST["checked"];

    $database->query("INSERT INTO mdt_announcements (title, description, checked)VALUES('".$title."', '".str_replace("'", '', $text)."', '".str_replace("'", '', $checked)."');");
    header("Location: index.php");
    die();
}
?> 