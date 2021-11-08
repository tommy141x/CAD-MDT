<?php
require '../connectdb.php';
$database->query("UPDATE mdt_units SET unit_call='none' WHERE unit_call='".$_POST["id"]."'");
$database->query("UPDATE mdt_apparatus SET apparatus_call='none' WHERE apparatus_call='".$_POST["id"]."'");
$database->query("DELETE FROM mdt_calls WHERE id='".$_POST["id"]."'");
