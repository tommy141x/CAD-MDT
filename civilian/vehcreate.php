<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    include('../config.php');
    require '../connectdb.php';
    $veh_plate = $_POST["veh_plate"]; //set PHP variables like this so we can use them anywhere in code below
    $veh_model = $_POST["veh_model"];
    $veh_color = $_POST["veh_color"];
    $veh_flags = $_POST["veh_flags"];
    $veh_owner_name = $_POST["veh_owner_name"];
    $char_id = $_POST["steam_id"];

    if($maxVehicles != 0){
    $vquery = $database->query("SELECT COUNT(*) FROM mdt_vehicles WHERE owner_id='".$char_id."';");
    $vresult = $vquery->fetch(PDO::FETCH_ASSOC);

    foreach ($vresult as $key => $value) {
        $vehNUM = ($vresult[$key]);
    }
    if($vehNUM >= $maxVehicles){
        header("Location: index.php?data=vmax");
        die();
    }else{
      if (strlen($veh_owner_name) > 1) {
          $query = $database->query("SELECT id FROM mdt_vehicles WHERE veh_plate = '".$veh_plate."'");
          $result = $query->fetch(PDO::FETCH_ASSOC);

          if (($result == null) or ($result == 0)) {
              $database->query("INSERT INTO mdt_vehicles (owner_id, veh_plate, veh_model, veh_color, veh_flags, veh_owner_name)VALUES('".$char_id."', '".str_replace("'", '', $veh_plate)."', '".str_replace("'", '', $veh_model)."', '".str_replace("'", '', $veh_color)."', '".$veh_flags."', '".$veh_owner_name."');");
              header("Location: index.php?data=vcreated");
              die();
          } else {
              header("Location: index.php?data=vfailed");
              die();
          }
      } else {
          header("Location: index.php?data=vfailed2");
          die();
      }
    }
  }else{
    if (strlen($veh_owner_name) > 1) {
        $query = $database->query("SELECT id FROM mdt_vehicles WHERE veh_plate = '".$veh_plate."'");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (($result == null) or ($result == 0)) {
            $database->query("INSERT INTO mdt_vehicles (owner_id, veh_plate, veh_model, veh_color, veh_flags, veh_owner_name)VALUES('".$char_id."', '".str_replace("'", '', $veh_plate)."', '".str_replace("'", '', $veh_model)."', '".str_replace("'", '', $veh_color)."', '".$veh_flags."', '".$veh_owner_name."');");
            header("Location: index.php?data=vcreated");
            die();
        } else {
            header("Location: index.php?data=vfailed");
            die();
        }
    } else {
        header("Location: index.php?data=vfailed2");
        die();
    }
}
}
?>
