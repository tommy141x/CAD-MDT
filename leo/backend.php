<?php
    require '../connectdb.php';
    require '../login/steamauth/steamauth.php';
    include('../login/steamauth/userInfo.php');
    $action = $_GET["value"];
    $statusquery = $database->query("SELECT unit_status FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
    $statusresult = $statusquery->fetch(PDO::FETCH_ASSOC);
    foreach ($statusresult as $key => $value) {
        $status = ($statusresult[$key]);
    }
    if ($action == "title") {
        if($status == null){
          echo "<script>
          setTimeout(function() {
          window.location.replace('../');
        }, 15000);
          </script>";
        }
        $divquery = $database->query("SELECT unit_division FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
        $divresult = $divquery->fetch(PDO::FETCH_ASSOC);
        foreach ($divresult as $key => $value) {
            $div = ($divresult[$key]);
        }
        if ($div == "LEO") {
            echo "
			<h3 class='page-title'> LEO Panel </h3>
			";
        } else {
            echo "
			<h3 class='page-title'> LEO Panel // ".$div."</h3>
			";
        }
    }
    if ($action == "statusbar") {
        $statusARR = array("10-42", "10-41", "10-8", "10-7", "10-6", "10-23", "10-97");
        echo "<div style='margin-left:35px;' class='form-inline'>";
        foreach ($statusARR as $key => $item) {
            if ($status == "10-42") {
                if ($item == "10-41") {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='steam_id".$key."' id='steam_id".$key."' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_status".$key."' id='unit_status".$key."' value='10-8'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-outline-danger btn-lg'/></a>
					</form>
					";
                } elseif ($item == $status) {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='steam_id".$key."' id='steam_id".$key."' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_status".$key."' id='unit_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-danger btn-lg' disabled/></a>
					</form>
					";
                } else {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='steam_id".$key."' id='steam_id".$key."' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_status".$key."' id='unit_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-outline-danger btn-lg' disabled/></a>
					</form>
					";
                }
            } else {
                if (($item == $status) or ($item == "10-41")) {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='steam_id".$key."' id='steam_id".$key."' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_status".$key."' id='unit_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-danger btn-lg' disabled/></a>
					</form>
				";
                } else {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='steam_id".$key."' id='steam_id".$key."' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_status".$key."' id='unit_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-outline-danger btn-lg'/></a>
					</form>
						";
                }
            }
        }
        echo "</div>";
    }
    if ($action == "dispatchcheck") {
        $dispatchquery = $database->query("SELECT mdt_data FROM mdt_status WHERE id='2'");
        $dispatchresult = $dispatchquery->fetch(PDO::FETCH_ASSOC);
        foreach ($dispatchresult as $key => $value) {
            $activedispatch = ($dispatchresult[$key]);
        }
        if ($activedispatch == "1") {
            echo "<div class='alert alert-primary' role='alert'> There is currently Active Dispatch.</div>

	<div class='row'>
              <div class='col-7 grid-margin'>
                <div class='card'>
                  <div class='card-body'>
				  ";
            $call2query = $database->query("SELECT unit_call FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
            $call2result = $call2query->fetch(PDO::FETCH_ASSOC);
            foreach ($call2result as $key => $value) {
                $CallID = ($call2result[$key]);
            }
            if ($CallID == "none") {
                echo "
                    <h4 class='card-title'>Not Currently Attached</h4>
                    <p class='card-description'><code>You are currently not attached to any call.</code>
                    </p>
                    <div class='card card-inverse-secondary mb-5'>
                      <div class='card-body'>
                        <p class='mb-4'> 911 Call - N/A </p>
                        <p class='mb-4'> Call Description: N/A </p>
                        <p class='mb-4'> Call Location: N/A </p>
                      </div>
                    </div>
					";
            } else {
                $data6 = $database->select('mdt_calls', [
    'call_name',
    'call_description',
    'call_location',
    'call_postal',
    'call_type',
    'call_isPriority'
    ], ['id[=]'=>$CallID]);

                $jsondata6 = json_encode($data6);
                $arr6 = json_decode($jsondata6, true);
                $call = $arr6[0];
                $call_id = $CallID.substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);

                echo "
                    <h4 class='card-title'>Your Call</h4>
                    <p class='card-description'><code>You are currently attached to call #".$call_id."</code>
                    </p>
                    <div class='card card-inverse-secondary mb-5'>
                      <div class='card-body'>
                        <p class='mb-4'> ".$call["call_type"]." - ".$call["call_name"]." </p>
                        <p class='mb-4'> Call Description: ".$call["call_description"]." </p>
                        <p class='mb-4'> Call Location: ".$call["call_location"]." #".$call["call_postal"]." </p>
                      </div>
                    </div>
					";
            }

            echo "
              </div>
			 </div>
			</div>
	";
            if ($CallID == 'none') {
                echo"
			  <div class='col-md-5 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Units Attached</h4>
                    <p class='card-description'>There are currently 0 units attached to this call.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			 </div>
	";
            } else {
                $udata = $database->select('mdt_units', [
    'steam_id',
    'unit_callsign',
    'unit_name',
    'unit_status',
    'unit_call',
    'unit_division',
    'unit_panic',
    'unit_status'
    ], []);

                $jsonudata = json_encode($udata);
                $auu = json_decode($jsonudata, true);
                $unitsattached = 0;
                foreach ($auu as $key => $item) {
                    if ($item["unit_call"] == $CallID) {
                        $unitsattached++;
                    }
                }
                echo"

	<div class='col-md-5 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Units Attached</h4>
                    <p class='card-description'>There are currently ".$unitsattached." units attached to this call.</p>
					<div class='card card-inverse-light'>
						<div class='card-body'>
						";

                //UNITS ATTACHED to $CallID
                foreach ($auu as $key => $item) {
                    if ($item["unit_call"] == $CallID) {
                        if ($item["unit_division"] == "LEO") {
                            $div = "";
                        } else {
                            $div = " [".$item["unit_division"]."]";
                        }
                        echo "
							<p id='togglex' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"].$div." [".$item["unit_status"]."]</p>
							";
                    }
                }


                echo"
						</div>
					</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
			 </div>

	";
            }
        } else {
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
	 <div class='col-lg-7 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
					<div class='form-inline'>
                    <h4 class='card-title'>Current Calls</h4>
					<button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#createCall' style='margin-left:auto;'>Register Call</button>
					</div>
                    <p class='card-description'><code>Self Dispatch - ".$status."</code>
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
                $location = strlen($arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"]) > 14 ? substr($arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"], 0, 14)."..." : $arr2[$x-1]["call_location"]." #".$arr2[$x-1]["call_postal"];
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
			  <div class='col-lg-5 grid-margin stretch-card'>
                <div class='card'>
                  <div class='card-body'>
			  ";



            $call2query = $database->query("SELECT unit_call FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
            $call2result = $call2query->fetch(PDO::FETCH_ASSOC);
            foreach ($call2result as $key => $value) {
                $CallID = ($call2result[$key]);
            }
            if ($CallID == "none") {
                echo "
                    <h4 class='card-title'>Not Currently Attached</h4>
                    <p class='card-description'><code>You are currently not attached to any call.</code>
                    </p>
                    <div class='card card-inverse-secondary mb-5'>
                      <div class='card-body'>
                        <p class='mb-4'> 911 Call - N/A </p>
                        <p class='mb-4'> Call Description: N/A </p>
                        <p class='mb-4'> Call Location: N/A </p>
                        <button class='btn btn-light' disabled>View Call</button>
                        <button class='btn btn-secondary' disabled>Detach</button>
                        <button class='btn btn-secondary' disabled>Clear Call</button>
                      </div>
                    </div>
					";
            } else {
                $data6 = $database->select('mdt_calls', [
    'call_name',
    'call_description',
    'call_location',
    'call_postal',
    'call_type',
    'call_isPriority'
    ], ['id[=]'=>$CallID]);

                $jsondata6 = json_encode($data6);
                $arr6 = json_decode($jsondata6, true);
                $call = $arr6[0];
                $call_id = $CallID.substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
                echo "
                    <h4 class='card-title'>Your Call</h4>
                    <p class='card-description'><code>You are currently attached to call #".$call_id."</code>
                    </p>
                    <div class='card card-inverse-secondary mb-5'>
                      <div class='card-body'>
                        <p class='mb-4'> ".$call["call_type"]." - ".$call["call_name"]." </p>
                        <p class='mb-4'> Call Description: ".$call["call_description"]." </p>
                        <p class='mb-4'> Call Location: ".$call["call_location"]." #".$call["call_postal"]." </p>
						<div class='form-inline'>
						<div style='margin-right:5px;'>
						<form class='form-inline'>
						<label type='button' id='viewing' class='btn btn-light' data-toggle='modal' data-target='#call-view' data-callid='".$CallID."' data-steamid='".$steamprofile['steamid']."'>View Call</label>
						</div>
						</form>
						";

                $datae = $database->select('mdt_units', [
    'steam_id',
    'unit_callsign',
    'unit_name',
    'unit_status',
    'unit_call',
    'unit_panic',
    'unit_status'
    ], []);
                $jsondatae = json_encode($datae);
                $arre = json_decode($jsondatae, true);
                $onlyUnitAttached = false;
                $x=0;
                foreach ($arre as $key => $item) {
                    if ($item["unit_call"] == $CallID) {
                        $x++;
                    }
                }
                if ($x==1) {
                    $onlyUnitAttached = true;
                }
                if ($onlyUnitAttached == true) {
                    //You are the ONLY Unit Attached to THIS CALL.
                    echo"
					<form class='form-inline' method='post'>
					<input type='hidden' name='steam_id1' id='steam_id1' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call1' id='unit_call1' value='none'>
					<a onclick='detachFromONLY()'><input type='button' id='detachFromONLY' onclick='detachFromONLY();' value='Detach' class='btn btn-secondary'/></a>
					</form>
							";
                } else {
                    echo"
					<form class='form-inline' method='post'>
					<input type='hidden' name='steam_id1' id='steam_id1' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call1' id='unit_call1' value='none'>
					<a onclick='detachFromONLY()'><input type='button' id='detachFromONLY' onclick='detachFromONLY();' value='Detach' class='btn btn-secondary'/></a>
					</form>
						<script>
						document.getElementById('detachFromONLY-Form').hidden = true;
						</script>
							";
                }
                echo "
						<form class='form-inline' id='clearCall-Form' method='post'>
						<input type='hidden' name='fcall_id' id='fcall_id' value='".$CallID."'>
						<div style='margin-left:5px;'>
                        <a onclick='clearCall()'><button type='button' id='clearCall' onclick='clearCall();' class='btn btn-secondary'>Clear Call</button></a>
						</div>
						</form>
						</form>
						</div>
                      </div>
                    </div>
					";
            }
            echo "
                  </div>
                </div>
              </div>
	 </div>
	 </div>
";
        }
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
    if ($action == "personNCIC") {
    }
    if ($action == "vehicleNCIC") {
    }
    if ($action == "officername") {
        $datar = $database->select('mdt_units', [
    'unit_callsign',
    'unit_name',
    ], ["steam_id[=]"=>$steamprofile['steamid']]);
        $jsondatar = json_encode($datar);
        $aee = json_decode($jsondatar, true);
        echo "<input type='hidden' name='bolo_name' id='bolo_name' value='".$aee[0]["unit_callsign"]." // ".$aee[0]["unit_name"]."'>";
    }
