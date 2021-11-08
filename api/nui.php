<?php
if (isset($_GET["steam"])) {
    include '../config.php';
    require '../connectdb.php';
	if($extraFeaturesEnabled){
    $steam = $_GET["steam"];
    global $logged;
    $adata = $database->select('mdt_units', [
        'unit_callsign',
        'unit_name',
        'unit_status',
        'unit_call',
        'unit_type'
      ], ['steam_id[=]'=>hexdec($steam)]);

    $ajsondata = json_encode($adata);
    $apparray = json_decode($ajsondata, true);
    global $unit;
    if (empty($apparray)) {
        $logged=false;
    } else {
        $logged=true;
        $unit = $apparray[0];
    }
    if ($logged) {
        if ($unit["unit_type"] == "LEO") {
            if ($unit["unit_call"] == "none") {
                echo '

{
   "callsign": "'.$unit["unit_callsign"].'",
   "unitname": "'.$unit["unit_name"].'",
   "unitstatus": "'.$unit["unit_status"].'",
   "logged": true,
   "attached": false,
   "callid": "",
   "calldetails": "N/A",
   "callpostal": "",
   "calllocation": "N/A",
   "calltype": "",
   "callerid": "Not currently attached to any call."
}

';
            } else {
                $cdata = $database->select('mdt_calls', [
        'id',
        'call_name',
        'call_description',
        'call_location',
        'call_postal',
        'call_type'
      ], ['id[=]'=>$unit["unit_call"]]);

                $cjsondata = json_encode($cdata);
                $callarray = json_decode($cjsondata, true);
                $call = $callarray[0];
                $callnum = $call["id"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
                echo '

{
   "callsign": "'.$unit["unit_callsign"].'",
   "unitname": "'.$unit["unit_name"].'",
   "unitstatus": "'.$unit["unit_status"].'",
   "logged": true,
   "attached": true,
   "callid": "'.$callnum.'",
   "calldetails": "'.$call["call_description"].'",
   "callpostal": "'.$call["call_postal"].'",
   "calllocation": "'.$call["call_location"].'",
   "calltype": "'.$call["call_type"].'",
   "callerid": "'.$call["call_name"].'"
}

';
            }
        } else {
            $apdata = $database->select('mdt_apparatus', [
        'apparatus_name',
        'apparatus_status',
        'apparatus_division',
        'apparatus_call'
      ], ['id[=]'=>$unit["unit_call"]]);
            $apjsondata = json_encode($apdata);
            $appaarray = json_decode($apjsondata, true);
            $apparatus = $appaarray[0];
            if ($apparatus["apparatus_call"] == "none") {
                echo '

{
   "callsign": "'.$unit["unit_callsign"].'",
   "unitname": "'.$apparatus["apparatus_name"].'",
   "unitstatus": "'.$apparatus["apparatus_status"].'",
   "logged": true,
   "attached": false,
   "callid": "",
   "calldetails": "N/A",
   "callpostal": "",
   "calllocation": "N/A",
   "calltype": "",
   "callerid": "Not currently attached to any call."
}

';
            } else {
                $cdata = $database->select('mdt_calls', [
        'id',
        'call_name',
        'call_description',
        'call_location',
        'call_postal',
        'call_type'
      ], ['id[=]'=>$apparatus["apparatus_call"]]);

                $cjsondata = json_encode($cdata);
                $callarray = json_decode($cjsondata, true);
                $call = $callarray[0];
                $callnum = $call["id"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
                echo '

{
   "callsign": "'.$unit["unit_callsign"].'",
   "unitname": "'.$apparatus["apparatus_name"].'",
   "unitstatus": "'.$apparatus["apparatus_status"].'",
   "logged": true,
   "attached": true,
   "callid": "'.$callnum.'",
   "calldetails": "'.$call["call_description"].'",
   "callpostal": "'.$call["call_postal"].'",
   "calllocation": "'.$call["call_location"].'",
   "calltype": "'.$call["call_type"].'",
   "callerid": "'.$call["call_name"].'"
}

';
            }
        }
    } else {
        echo '

{
   "callsign": "000",
   "unitname": "Error",
   "unitstatus": "10-42",
   "logged": false,
   "attached": false,
   "callid": "",
   "calldetails": "N/A",
   "callpostal": "",
   "calllocation": "N/A",
   "calltype": "",
   "callerid": "Not currently attached to any call."
}

';
    }
}else{
        echo '

{
   "callsign": "000",
   "unitname": "Error",
   "unitstatus": "10-42",
   "logged": false,
   "attached": false,
   "callid": "",
   "calldetails": "N/A",
   "callpostal": "",
   "calllocation": "N/A",
   "calltype": "",
   "callerid": "Not currently attached to any call."
}

';

}
}
