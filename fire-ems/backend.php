<?php
    require '../connectdb.php';
    require '../login/steamauth/steamauth.php';
    include('../login/steamauth/userInfo.php');
    $action = $_GET["value"];
    $apparatusquery = $database->query("SELECT unit_call FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
    $apparatusresult = $apparatusquery->fetch(PDO::FETCH_ASSOC);
    foreach ($apparatusresult as $key => $value) {
        $apparatus = ($apparatusresult[$key]);
    }
    $attachedA = false;
    $adata = $database->select('mdt_apparatus', [
        'apparatus_name',
        'apparatus_status',
        'apparatus_division',
        'apparatus_call'
      ], ['id[=]'=>$apparatus]);

        $ajsondata = json_encode($adata);
        $apparray = json_decode($ajsondata, true);
        if (empty($apparray)) {
            $app = "NOT ATTACHED";
            $attachedA = false;
        } else {
            $app = $apparray[0];
            $attachedA = true;
        }
    if ($action == "title") {
          if($apparatus == null){
            echo "<script>
            setTimeout(function() {
            window.location.replace('../');
          }, 15000);
            </script>";
          }
        if ($attachedA == false) {
            echo "
			<h3 class='page-title'> FIRE/EMS Panel </h3>
			";
        } else {
            echo "
			<h3 class='page-title'> FIRE/EMS Panel // ".$app["apparatus_name"]."</h3>
			";
        }
    }
    if ($action == "statusbar") {
        $statusARR = array("10-42", "10-41", "10-8", "10-7", "10-6", "10-23", "10-97");
        echo "<div style='margin-left:40px;' class='form-inline'>";
        foreach ($statusARR as $key => $item) {
            if ($app["apparatus_status"] == "10-42") {
                if ($item == "10-41") {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='apparatus_id".$key."' id='apparatus_id".$key."' value=".$apparatus.">
					<input type='hidden' name='apparatus_status".$key."' id='apparatus_status".$key."' value='10-8'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-outline-danger btn-lg'/></a>
					</form>
					";
                } elseif ($item == $app["apparatus_status"]) {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='apparatus_id".$key."' id='apparatus_id".$key."' value=".$apparatus.">
					<input type='hidden' name='apparatus_status".$key."' id='apparatus_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-danger btn-lg' disabled/></a>
					</form>
					";
                } else {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='apparatus_id".$key."' id='apparatus_id".$key."' value=".$apparatus.">
					<input type='hidden' name='apparatus_status".$key."' id='apparatus_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-outline-danger btn-lg' disabled/></a>
					</form>
					";
                }
            } else {
                if (($item == $app["apparatus_status"]) or ($item == "10-41")) {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='apparatus_id".$key."' id='apparatus_id".$key."' value=".$apparatus.">
					<input type='hidden' name='apparatus_status".$key."' id='apparatus_status".$key."' value='".$item."'>
					<a onclick='javascript:SubmitFormData".$key."()'><input type='button' id='SubmitFormData".$key."' onclick='SubmitFormData".$key."();' value='".$item."' class='btn btn-danger btn-lg' disabled/></a>
					</form>
				";
                } else {
                    echo " 
					<form id='status-form-".$key."' method='post'>
					<input type='hidden' name='apparatus_id".$key."' id='apparatus_id".$key."' value=".$apparatus.">
					<input type='hidden' name='apparatus_status".$key."' id='apparatus_status".$key."' value='".$item."'>
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
            if ($app["apparatus_call"] == "none") {
                echo "
                    <h4 class='card-title'>Not Currently Attached</h4>
                    <p class='card-description'><code>".$app["apparatus_name"]." is currently not attached to any call.</code>
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
    ], ['id[=]'=>$app["apparatus_call"]]);

                $jsondata6 = json_encode($data6);
                $arr6 = json_decode($jsondata6, true);
                $call = $arr6[0];
                $call_id = $app["apparatus_call"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);

                echo "
                    <h4 class='card-title'>".$app["apparatus_name"]."'s Call</h4>
                    <p class='card-description'><code>".$app["apparatus_name"]." is currently attached to call #".$call_id."</code>
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
            if ($app["apparatus_call"] == 'none') {
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
                $udata2 = $database->select('mdt_units', [
        'steam_id',
        'unit_callsign',
        'unit_name',
        'unit_status',
        'unit_call',
        'unit_division',
        'unit_panic',
        'unit_status'
        ], []);

                $jsonudata2 = json_encode($udata2);
                $auu2 = json_decode($jsonudata2, true);
                $unitsattached = 0;
                foreach ($auu2 as $key => $item2) {
                    if ($item2["unit_call"] == $app["apparatus_call"]) {
                        $unitsattached++;
                    }
                }
                $udata = $database->select('mdt_apparatus', [
    'apparatus_name',
    'apparatus_status',
    'apparatus_call',
    ], []);

                $jsonudata = json_encode($udata);
                $auu = json_decode($jsonudata, true);
                foreach ($auu as $key => $item) {
                    if ($item["apparatus_call"] == $app["apparatus_call"]) {
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
                    if ($item["apparatus_call"] == $app["apparatus_call"]) {
                        echo "
							<p id='togglex' class='mb-4'> ".$item["apparatus_name"]." [".$item["apparatus_status"]."]</p>
							";
                    }
                }
                foreach ($auu2 as $key => $item2) {
                    if ($item2["unit_call"] == $app["apparatus_call"]) {
                        if ($item2["unit_division"] == "LEO") {
                            $div = "";
                        } else {
                            $div = " [".$item2["unit_division"]."]";
                        }
                        echo "
							<p id='togglex' class='mb-4'> ".$item2["unit_callsign"]." // ".$item2["unit_name"].$div." [".$item2["unit_status"]."]</p>
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
                    <p class='card-description'><code>Self Dispatch - ".$app["apparatus_status"]."</code>
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
							<td><label type='button' id='".$callid."' class='badge badge-danger' data-toggle='modal' data-target='#call-view' data-callid='".$arr2[$x-1]["id"]."' data-appid='".$apparatus."'>View Call</label></td>
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

            if ($app["apparatus_call"] == "none") {
                echo "
                    <h4 class='card-title'>Not Currently Attached</h4>
                    <p class='card-description'><code>".$app["apparatus_name"]." is currently not attached to any call.</code>
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
    ], ['id[=]'=>$app["apparatus_call"]]);

                $jsondata6 = json_encode($data6);
                $arr6 = json_decode($jsondata6, true);
                $call = $arr6[0];
                $call_id = $app["apparatus_call"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
                echo "
                    <h4 class='card-title'>".$app["apparatus_name"]."'s Call</h4>
                    <p class='card-description'><code>".$app["apparatus_name"]." is currently attached to call #".$call_id."</code>
                    </p>
                    <div class='card card-inverse-secondary mb-5'>
                      <div class='card-body'>
                        <p class='mb-4'> ".$call["call_type"]." - ".$call["call_name"]." </p>
                        <p class='mb-4'> Call Description: ".$call["call_description"]." </p>
                        <p class='mb-4'> Call Location: ".$call["call_location"]." #".$call["call_postal"]." </p>
						<div class='form-inline'>
						<div style='margin-right:5px;'>
						<form class='form-inline'>
						<label type='button' id='viewing' class='btn btn-light' data-toggle='modal' data-target='#call-view' data-callid='".$app["apparatus_call"]."' data-appid='".$apparatus."'>View Call</label>
						</div>
						</form>
						";

                $datae = $database->select('mdt_apparatus', [
        'apparatus_name',
        'apparatus_status',
        'apparatus_call',
        ], []);
                $jsondatae = json_encode($datae);
                $arre = json_decode($jsondatae, true);
                $onlyUnitAttached = false;
                $x=0;
                foreach ($arre as $key => $item) {
                    if ($item["apparatus_call"] == $app["apparatus_call"]) {
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
					<input type='hidden' name='apparatus_id1' id='apparatus_id1' value=".$apparatus.">
					<input type='hidden' name='unit_call1' id='unit_call1' value='none'>
					<a onclick='detachFromONLY()'><input type='button' id='detachFromONLY' onclick='detachFromONLY();' value='Detach' class='btn btn-secondary'/></a>
					</form>
							";
                } else {
                    echo"
					<form class='form-inline' method='post'>
					<input type='hidden' name='apparatus_id1' id='apparatus_id1' value=".$apparatus.">
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
						<input type='hidden' name='fcall_id' id='fcall_id' value='".$app["apparatus_call"]."'>
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
