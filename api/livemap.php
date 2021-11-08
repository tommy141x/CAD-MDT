<?php
if (isset($_GET["arr"])) {
    include '../config.php';
    require '../connectdb.php';
	if($extraFeaturesEnabled){
	$arr = json_decode($_GET["arr"], true);
	$database->query("UPDATE mdt_status SET mdt_data='".$_GET["arr"]."' WHERE id=1");
	}
}
?>