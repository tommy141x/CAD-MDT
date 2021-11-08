<?php
require '../connectdb.php';
$database->query("UPDATE mdt_units SET unit_call='none' WHERE steam_id='".$_POST["steamid"]."'");
