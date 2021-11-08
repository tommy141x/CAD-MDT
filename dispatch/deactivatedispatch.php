<?php
require '../connectdb.php';
$database->query("UPDATE mdt_status SET mdt_data='0' WHERE id='2'");
