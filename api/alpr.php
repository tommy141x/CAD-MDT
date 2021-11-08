<?php
if (isset($_GET["steam"])) {
    include '../config.php';
    require '../connectdb.php';
	if($extraFeaturesEnabled){
    $steam = $_GET["steam"];
    $plate = $_GET["plate"];
    global $exists;
    $adata = $database->select('mdt_vehicles', [
        'veh_owner_name',
        'veh_flags',
        'veh_color',
        'veh_model'
      ], ['veh_plate[=]'=>$plate]);

    $ajsondata = json_encode($adata);
    $apparray = json_decode($ajsondata, true);
    global $veh;
    if (empty($apparray)) {
        $exists=false;
    } else {
        $exists=true;
        $veh = $apparray[0];
    }
    if ($exists) {
                echo '

{
   "exists": true,
   "owner": "'.$veh["veh_owner_name"].'",
   "flag": "'.$veh["veh_flags"].'",
   "model": "'.$veh["veh_color"].' '.$veh["veh_model"].'"
}

';
            }else{
                echo '

{
   "exists": "false",
   "owner": "ERROR",
   "flag": "ERROR",
   "model": "ERROR"
}

';
			}
}
}
