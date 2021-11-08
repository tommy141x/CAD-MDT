<?php
require '../connectdb.php';
$database->query("UPDATE mdt_apparatus SET apparatus_call='".$_POST['apparatus_call']."' WHERE id='".$_POST['apparatus_id']."'");
