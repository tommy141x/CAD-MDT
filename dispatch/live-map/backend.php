<?php
include '../../config.php';
require '../../connectdb.php';
global $arr;
if ($extraFeaturesEnabled)
{
    $query5 = $database->query("SELECT mdt_data FROM mdt_status WHERE id=1;");
    $result5 = $query5->fetch(PDO::FETCH_ASSOC);
    foreach ($result5 as $key => $value)
    {
        $arr = ($result5[$key]);
    }
    $arr = json_decode($arr, true);

    echo "<script> clearMarkers();";
    if (!empty($arr))
    {
        $data2 = $database->select('mdt_units', ['steam_id', 'unit_callsign', 'unit_name', 'unit_status', 'unit_call', 'unit_type', 'unit_division'], []);
        $jsondata2 = json_encode($data2);
        $arr3 = json_decode($jsondata2, true);

        $data3 = $database->select('mdt_apparatus', ['id', 'apparatus_name', 'apparatus_status', 'apparatus_call'], []);
        $jsondata3 = json_encode($data3);
        $arr4 = json_decode($jsondata3, true);
        foreach ($arr as $steam => $user)
        {
            for ($x = 1;$x <= (count($arr3) + 0);$x++)
            {
                if ($arr3[$x - 1]["steam_id"] == hexdec($steam))
                {
                    $unit = $arr3[$x - 1];
                    if ($unit["unit_type"] == "LEO")
                    {
                        //LEO UNIT
                        $xv = (5.931106891820634e-7 * pow($user['x'], 2)) + (0.018603455004715965 * $user['x']) - 8.85588713987304;
                        $yv = (0.0000012437752427594618 * pow($user['y'], 2)) + (0.014148239855183741 * $user['y']) - 35.854938862614134;
                        if ($unit["unit_call"] != "none")
                        {
                            echo "addMarker(" . $yv . "," . $xv . ", 'static', '" . $unit["unit_callsign"] . " // " . $unit["unit_name"] . "<br><b>" . $unit["unit_status"] . " | ATTACHED TO A CALL', 'blip', false);";
                        }
                        else
                        {
                            echo "addMarker(" . $yv . "," . $xv . ", 'static', '" . $unit["unit_callsign"] . " // " . $unit["unit_name"] . "<br><b>" . $unit["unit_status"] . " | NOT ATTACHED TO ANY CALL', 'blip', false);";
                        }
                    }
                    elseif ($unit["unit_type"] != "DISPATCH")
                    {
                        for ($x = 1;$x <= (count($arr4) + 0);$x++)
                        {
                            if ($arr4[$x - 1]["id"] == $unit["unit_call"])
                            {
                                $app = $arr4[$x - 1];
                                //FIRE OR EMS UNIT
                                $xv = (5.931106891820634e-7 * pow($user['x'], 2)) + (0.018603455004715965 * $user['x']) - 8.85588713987304;
                                $yv = (0.0000012437752427594618 * pow($user['y'], 2)) + (0.014148239855183741 * $user['y']) - 35.854938862614134;
                                if ($app["apparatus_call"] != "none")
                                {
                                    echo "addMarker(" . $yv . "," . $xv . ", 'static', '" . $unit["unit_callsign"] . " // " . $app["apparatus_name"] . "<br><b>" . $app["apparatus_status"] . " | ATTACHED TO A CALL', 'blip_red', false);";
                                }
                                else
                                {
                                    echo "addMarker(" . $yv . "," . $xv . ", 'static', '" . $unit["unit_callsign"] . " // " . $app["apparatus_name"] . "<br><b>" . $app["apparatus_status"] . " | NOT ATTACHED TO ANY CALL', 'blip_red', false);";
                                }
                            }
                        }
                    }
                }
            }
            //echo "<p style='position:absolute; left:0; top:0; color:red;'>X: ".$x." Y:".$y."</p>";
            //echo "<img style='position:absolute; left:".$x."; top:".$y."; max-width:32px;' src='blip.png'/>";
            
        }
    }
    echo "showMarkers(); </script>";
}
?>
