<?php
require '../connectdb.php';
$database->query("UPDATE mdt_units SET unit_call='".$_POST['unit_call']."' WHERE steam_id='".$_POST['steam_id']."'");
