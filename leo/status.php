<?php
require '../connectdb.php';
$database->query("UPDATE mdt_units SET unit_status='".$_POST['unit_status']."' WHERE steam_id='".$_POST['steam_id']."'");
