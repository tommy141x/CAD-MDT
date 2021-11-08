<?php
require '../connectdb.php';
$database->query("DELETE FROM mdt_bolos WHERE id='".$_POST["id"]."'");
