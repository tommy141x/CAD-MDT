<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    require '../connectdb.php';
    $owner = $_POST["warrant_owner"];
    $creator = $_POST["warrant_creator"];
    $desc = $_POST["warrant_desc"];
    $database->query("INSERT INTO mdt_warrants (warrant_owner, warrant_desc, warrant_creator)VALUES('".str_replace("'", '', $owner)."', '".str_replace("'", '', $desc)."', '".$creator."');");
}
?> 