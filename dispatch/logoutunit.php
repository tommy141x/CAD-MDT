<?php
require '../connectdb.php';
$database->query("DELETE FROM mdt_units WHERE steam_id='".$_POST["steamid"]."'");
