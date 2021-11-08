<?php
require '../connectdb.php';
$database->query("UPDATE mdt_apparatus SET apparatus_status='".$_POST['apparatus_status']."' WHERE id='".$_POST['apparatus_id']."'");
