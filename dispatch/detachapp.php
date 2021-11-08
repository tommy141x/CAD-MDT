<?php
require '../connectdb.php';
$database->query("UPDATE mdt_apparatus SET apparatus_call='none' WHERE id='".$_POST["id"]."'");
