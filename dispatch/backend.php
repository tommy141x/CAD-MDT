<?php
    require '../connectdb.php';
	include('../config.php');
    require '../login/steamauth/steamauth.php';
    include('../login/steamauth/userInfo.php');
    $action = $_GET["value"];

    if ($action == "acButton") {
        $query7 = $database->query("SELECT mdt_data FROM mdt_status WHERE id=2;");
        $result7 = $query7->fetch(PDO::FETCH_ASSOC);

        global $dispatchActivator;
        foreach ($result7 as $key => $value) {
            $dispatchActivator = ($result7[$key]);
        }
        if ($dispatchActivator == "0") {
            echo"


			<div style='display: inline-block;'>
			<button id='activateButton' onclick='javascript:activateDispatch()' type='button' class='btn btn-inverse-success btn-fw'>Activate Dispatch</button>
			</div>
			<div style='display: inline-block;'>
			<button id='deactivateButton' onclick='javascript:deactivateDispatch()' type='button' style='margin-right:10px; display:none;' class='btn btn-inverse-danger btn-fw'>De-activate Dispatch</button>
			</div>

				";
        } else {
            echo"


			<div style='display: inline-block;'>
			<button id='activateButton' onclick='javascript:activateDispatch()' type='button' style='margin-right:10px; display:none;' class='btn btn-inverse-success btn-fw'>Activate Dispatch</button>
			</div>
			<div style='display: inline-block;'>
			<button id='deactivateButton' onclick='javascript:deactivateDispatch()' type='button' class='btn btn-inverse-danger btn-fw'>De-activate Dispatch</button>
			</div>

				";
        }
    }

    if ($action == "calls") {
        $data2 = $database->select('mdt_calls', [
    'id',
    'call_name',
    'call_description',
    'call_location',
    'call_postal',
    'call_type',
    'call_isPriority'
    ], []);
        $jsondata2 = json_encode($data2);
        $arr2 = json_decode($jsondata2, true);
        echo "
     <div class='row'>
	 <div class='col-lg-12 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
					<div class='form-inline'>
                    <h4 class='card-title'>Current Calls</h4>
					<button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#createCall' style='margin-left:auto;'>Register Call</button>
					</div>
                    <p class='card-description'><code>Dispatch Panel</code>
					</p>
                    <div class='table-responsive'>
                      <table class='table'>
                        <thead>
                          <tr>
                            <th>Caller ID</th>
                            <th>Call #</th>
                            <th>Call Location</th>
                            <th>Call Type</th>
                            <th>Call Details</th>
                          </tr>
                        </thead>
                        <tbody>
						";
        for ($x = 1; $x <= (count($arr2) + 0); $x++) {
            $callid = $arr2[$x-1]["id"].substr($arr2[$x-1]["call_postal"], 0, 1).substr($arr2[$x-1]["call_postal"], -1);
            $location = strlen($arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"]) > 38 ? substr($arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"], 0, 38)."..." : $arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"];
            echo "
                          <tr>
                            <td>".$arr2[$x-1]["call_name"]."</td>
                            <td>".$callid."</td>
                            <td>".$location."</td>
                            <td>".$arr2[$x-1]["call_type"]."</td>
							<td><label type='button' id='".$callid."' class='badge badge-danger' data-toggle='modal' data-target='#call-view' data-callid='".$arr2[$x-1]["id"]."' data-steamid='".$steamprofile['steamid']."'>View Call</label></td>
						  </tr>
						  ";
            if (isset($_COOKIE['callnum'])) {
                if ($_COOKIE['callnum'] < count($arr2)) {
                    echo "
						  <audio autoplay='true' style='display:none;'>
         					<source src='sounds/new-call.wav' type='audio/wav'>
							  </audio>
						  ";
                }
            }
        }
        setcookie('callnum', count($arr2), time()+3600, '/');
        echo "</tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
";
    }

    if ($action == "bolo") {
        $data = $database->select('mdt_bolos', [
    'id',
    'bolo_creator',
    'bolo_desc',
    'bolo_createdAt'
    ], []);
        $jsondata = json_encode($data);
        $arr = json_decode($jsondata, true);
        $date = date("i");
        foreach ($arr as $key => $item) {
            if (((int)$date) == ((int)$item["bolo_createdAt"])+30) {
                $database->query("DELETE FROM mdt_bolos WHERE id='".$item["id"]."';");
            } elseif (((int)$date) == ((int)$item["bolo_createdAt"])-30) {
                $database->query("DELETE FROM mdt_bolos WHERE id='".$item["id"]."';");
            }
            echo "
             <div id='bolo_".$item["id"]."' class='alert alert-danger' role='alert'>
			 <form class='form-inline' id='clearBolo-Form' method='post'>
			 BOLO: ".strtoupper($item["bolo_desc"])." - CREATED BY ".strtoupper($item["bolo_creator"])."
						<input type='hidden' name='bolo_id".$key."' id='bolo_id".$key."' value='".$item["id"]."'>
						<div style='margin-left:auto'>
                        <a onclick='clearBolo(".$key.")'><button type='button' id='clearBolo' onclick='clearBolo();' class='btn btn-danger btn-sm'>Clear Bolo</button></a>
						</div>
					</form>
			 </div>
			 ";

            if (isset($_COOKIE['bolonum'])) {
                if ($_COOKIE['bolonum'] < count($arr)) {
                    echo "
				<audio autoplay='true' style='display:none;'>
				   <source src='sounds/new-bolo.wav' type='audio/wav'>
					</audio>
				";
                }
            }
        }
        setcookie('bolonum', count($arr), time()+3600, '/');
        if (count($arr) == 1) {
            echo "
			 <div id='no_bolo_".$item["id"]."' class='alert alert-primary' role='alert' hidden> There are currently no BOLO's.</div>
			";
        }
        if (count($arr) == 0) {
            echo "
             <div class='alert alert-primary' role='alert'> There are currently no BOLO's.</div>
			 ";
        }
    }

    if ($action == "units") {
        $data2 = $database->select('mdt_units', [
    'steam_id',
    'unit_callsign',
    'unit_name',
    'unit_status',
    'unit_call',
    'unit_type',
    'unit_division'
    ], []);
        $jsondata2 = json_encode($data2);
        $arr3 = json_decode($jsondata2, true);

            $data3 = $database->select('mdt_apparatus', [
        'id',
        'apparatus_name',
        'apparatus_status',
        'apparatus_call'
        ], []);
            $jsondata3 = json_encode($data3);
            $arr4 = json_decode($jsondata3, true);
        echo "
     <div class='row'>
	 <div class='col-lg-12 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
					<div class='form-inline'>
                    <h4 class='card-title'>Active Units</h4>
					";
					if($extraFeaturesEnabled){
					echo "<button id='livemapbutton' onclick='showLiveMap();' type='button' class='btn btn-danger' style='margin-left:auto;'>Live Map</button>";
					}
					echo "
					</div>
                    <p class='card-description'><code>Currently Logged-In Units</code>
					</p>
                    <div class='table-responsive'>
                      <table class='table'>
                        <thead>
                          <tr>
                            <th>Unit</th>
                            <th>Unit Type</th>
                            <th>Unit Status</th>
                            <th>Details</th>
                          </tr>
                        </thead>
                        <tbody>
					";
          $appArray = array();
        for ($x = 1; $x <= (count($arr3) + 0); $x++) {
            if ($arr3[$x-1]["unit_type"] == "LEO") {
                echo "
                          <tr>
                            <td>".$arr3[$x-1]["unit_callsign"]." // ".$arr3[$x-1]["unit_name"]."</td>
                            <td>".$arr3[$x-1]["unit_type"]."</td>
                            <td>".$arr3[$x-1]["unit_status"]."</td>
							<td><label type='button' id='".$arr3[$x-1]["steam_id"]."' class='badge badge-danger' data-toggle='modal' data-target='#unit-view' data-unitid='".$arr3[$x-1]["steam_id"]."'>View Unit</label></td>
						  </tr>
						  ";
            }elseif($arr3[$x-1]["unit_type"] != "DISPATCH"){
              if(!in_array($arr3[$x-1]["unit_call"], $appArray)){
                array_push($appArray, $arr3[$x-1]["unit_call"]);
              }
            }
        }
      for ($x = 1; $x <= (count($arr4) + 0); $x++) {
              if(in_array($arr4[$x-1]["id"], $appArray)){
              echo "
                        <tr>
                          <td>".$arr4[$x-1]["apparatus_name"]."</td>
                          <td>FIRE/EMS</td>
                          <td>".$arr4[$x-1]["apparatus_status"]."</td>
            <td><label type='button' id='".$arr4[$x-1]["id"]."' class='badge badge-danger' data-toggle='modal' data-target='#app-view' data-appid='".$arr4[$x-1]["id"]."'>View Unit</label></td>
            </tr>
            ";
          }elseif($arr4[$x-1]["apparatus_status"] != "10-42"){
            //Set the apparatus status to 10-42 since no one is on that apparatus.
              $database->query("UPDATE mdt_apparatus SET apparatus_status='10-42' WHERE id='".$arr4[$x-1]["id"]."'");
              $database->query("UPDATE mdt_apparatus SET apparatus_call='none' WHERE id='".$arr4[$x-1]["id"]."'");
          }
      }
        echo "
                  </div>
                </div>
              </div>
			  ";
    }
