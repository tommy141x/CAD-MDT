<?php
require '../connectdb.php';
$value = $_GET['value'];
$callid = $_GET['callid'];
$database->query("UPDATE mdt_calls SET call_description='".$value."' WHERE id='".$callid."'");
