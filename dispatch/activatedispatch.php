<?php
require '../connectdb.php';
$database->query("UPDATE mdt_status SET mdt_data='1' WHERE id='2'");
