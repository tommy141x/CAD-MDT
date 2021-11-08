<?php
require '../connectdb.php';
$status = $_GET["status"];
$id = $_GET["unit"];
$type = $_GET["type"];
if($type == 0){
$database->query("UPDATE mdt_units SET unit_status='".$status."' WHERE steam_id='".$id."'");
}else{
$database->query("UPDATE mdt_apparatus SET apparatus_status='".$status."' WHERE id='".$id."'");
}
