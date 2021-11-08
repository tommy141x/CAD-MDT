<?php
require '../connectdb.php';
$value = $_GET['unit'];
$callid = $_GET['cid'];
$type = $_GET['type'];
if($type == 0){
  $database->query("UPDATE mdt_units SET unit_call='".$callid."' WHERE steam_id='".$value."'");
}else{
  $database->query("UPDATE mdt_apparatus SET apparatus_call='".$callid."' WHERE id='".$value."'");
}
