<?php
//Include database connection
if ($_POST['callid']) {
    require '../connectdb.php';
    require '../login/steamauth/steamauth.php';
    include('../login/steamauth/userInfo.php');
    $cid = $_POST['callid']; //escape string
    $sid = $_POST['steamid']; //escape string


    $data11 = $database->select('mdt_apparatus', [
        'id',
        'apparatus_name',
        'apparatus_status',
        'apparatus_call',
    ], []);

    $jsondata11 = json_encode($data11);
    $arr11 = json_decode($jsondata11, true);

    $data = $database->select('mdt_units', [
    'steam_id',
    'unit_callsign',
    'unit_name',
    'unit_status',
    'unit_call',
    'unit_panic',
    'unit_division',
    'unit_status'
    ], []);

    $jsondata = json_encode($data);
    $arr = json_decode($jsondata, true);

    $data2 = $database->select('mdt_calls', [
    'call_name',
    'call_description',
    'call_location',
    'call_postal',
    'call_type',
    'call_isPriority'
    ], ['id[=]'=>$cid]);

    $jsondata2 = json_encode($data2);
    $arr2 = json_decode($jsondata2, true);
    $call = $arr2[0];

    $callquery = $database->query("SELECT unit_call FROM mdt_units WHERE steam_id='".$steamprofile['steamid']."'");
    $callresult = $callquery->fetch(PDO::FETCH_ASSOC);
    global $thisunitcallstatus;
    foreach ($callresult as $key => $value) {
        $thisunitcallstatus = ($callresult[$key]);
    }

    $callid = $cid.substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
    if ($thisunitcallstatus == $cid) {
        $attached = true;
    } else {
        $attached = false;
    }

    $attachedOtherCall = false;
    if ((!($thisunitcallstatus == "none")) and (!($thisunitcallstatus == $cid))) {
        $attachedOtherCall = true;
    }
    $noUnitsAttached = true;

    foreach ($arr as $key => $item) {
        if ($item["unit_call"] == $cid) {
            $noUnitsAttached = false;
        }
    }
    foreach ($arr11 as $key => $item2) {
        if ($item2["apparatus_call"] == $cid) {
            $noUnitsAttached = false;
        }
    }

    $onlyUnitAttached = false;
    $x=0;
    foreach ($arr as $key => $item) {
        if ($item["unit_call"] == $cid) {
            $x++;
        }
    }
    if (($thisunitcallstatus == $cid) and ($x==1)) {
        $onlyUnitAttached = true;
    }

    //MODAL CONTENT
    echo "
						<div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel-2'>".strtoupper($call["call_type"])." - #".$callid."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <h6>CALLER ID: ".$call["call_name"]."</h6>
                            <h6>LOCATION: ".$call["call_location"]." #".$call["call_postal"]."</h6>
                            <h6>DESCRIPTION: ".$call["call_description"]."</h6>
							<div class='card card-inverse-light'>
								<div class='card-body'>
									<h5>ATTACHED UNITS</h5>
									";
    foreach ($arr as $key => $item) {
        if ($item["unit_division"] == "LEO") {
            $div = "";
        } else {
            $div = " [".$item["unit_division"]."]";
        }
        if ($item["steam_id"] == $sid) {
            if ($item["unit_call"] == $cid) {
                echo "
											<p id='togglex' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"].$div." [".$item["unit_status"]."]</p>
											";
            } else {
                echo "
											<p id='togglex' class='mb-4' hidden> ".$item["unit_callsign"]." // ".$item["unit_name"].$div." [".$item["unit_status"]."]</p>
											";
            }
            echo "
											<p id='toggley' class='mb-4' hidden>There are currently no units attached.</p>
										";
        } elseif ($item["unit_call"] == $cid) {
            echo "
									<p class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"]." [".$item["unit_status"].$div."]</p>
									";
        }
    }
    foreach ($arr11 as $key => $item) {
        if ($item["apparatus_call"] == $cid) {
            echo "
									<p class='mb-4'> ".$item["apparatus_name"]." [".$item["apparatus_status"]."]</p>
									";
        }
    }
    if ($noUnitsAttached == true) {
        ?>
										<script type='text/javascript'>
										NoUnitAttached();
										</script>
										<?php
    }
    echo "
								</div>
							</div>
                          </div>
                          <div class='modal-footer'>
						  ";
    if (($attached == true) and ($onlyUnitAttached == true)) {
        //You are the ONLY Unit Attached to THIS CALL.
        echo"
					<form class='form-inline' id='detachFromONLY-Form' method='post'>
					<input type='hidden' name='steam_id1' id='steam_id1' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call1' id='unit_call1' value='none'>
					<a onclick='detachFromONLY()'><input type='button' id='detachFromONLY' onclick='detachFromONLY();' value='Detach' class='btn btn-light'/></a>
					</form>
							";
    } else {
        echo"
					<form class='form-inline' id='detachFromONLY-Form' method='post'>
					<input type='hidden' name='steam_id1' id='steam_id1' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call1' id='unit_call1' value='none'>
					<a onclick='detachFromONLY()'><input type='button' id='detachFromONLY' onclick='detachFromONLY();' value='Detach' class='btn btn-light'/></a>
					</form>
						<script>
						document.getElementById('detachFromONLY-Form').hidden = true;
						</script>
							";
    }
    if (($attached == true) and ($onlyUnitAttached == false)) {
        //You are attached with other units on THIS CALL.
        echo"
					<form class='form-inline' id='attachedWOther-Form' method='post'>
					<input type='hidden' name='steam_id2' id='steam_id2' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call2' id='unit_call2' value='none'>
					<a onclick='attachedWOther()'><input type='button' id='attachedWOther' onclick='attachedWOther();' value='Detach' class='btn btn-light'/></a>
					</form>
							";
    } else {
        echo"
					<form class='form-inline' id='attachedWOther-Form' method='post'>
					<input type='hidden' name='steam_id2' id='steam_id2' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call2' id='unit_call2' value='none'>
					<a onclick='attachedWOther()'><input type='button' id='attachedWOther' onclick='attachedWOther();' value='Detach' class='btn btn-light'/></a>
					</form>
						<script>
						document.getElementById('attachedWOther-Form').hidden = true;
						</script>
							";
    }
    if ($attachedOtherCall == true) {
        //You are attached to another CALL.
        echo"
							<form class='form-inline'>
                            <button type='button' class='btn btn-light' disabled>Attach</button>
							</form>
							";
    } else {
        if (($attached == false) and ($noUnitsAttached == true)) {
            //You are not attached to anything and there are no units attached to this call.
            echo"
					<form class='form-inline' id='attachAlone-Form' method='post'>
					<input type='hidden' name='steam_id3' id='steam_id3' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call3' id='unit_call3' value='".$cid."'>
					<a onclick='attachAlone()'><input type='button' id='attachAlone' onclick='attachAlone();' value='Attach' class='btn btn-light'/></a>
					</form>
							";
        } else {
            echo"
					<form class='form-inline' id='attachAlone-Form' method='post'>
					<input type='hidden' name='steam_id3' id='steam_id3' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call3' id='unit_call3' value='".$cid."'>
					<a onclick='attachAlone()'><input type='button' id='attachAlone' onclick='attachAlone();' value='Attach' class='btn btn-light'/></a>
					</form>
						<script>
						document.getElementById('attachAlone-Form').hidden = true;
						</script>
							";
        }
        if (($attached == false) and ($noUnitsAttached == false)) {
            //You are not attached to anything and this call has units.
            echo"
					<form class='form-inline' id='attachWOther-Form' method='post'>
					<input type='hidden' name='steam_id4' id='steam_id4' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call4' id='unit_call4' value='".$cid."'>
					<a onclick='attachWOther()'><input type='button' id='attachWOther' onclick='attachWOther();' value='Attach' class='btn btn-light'/></a>
					</form>
							";
        } else {
            echo"
					<form class='form-inline' id='attachWOther-Form' method='post'>
					<input type='hidden' name='steam_id4' id='steam_id4' value=".$steamprofile['steamid'].">
					<input type='hidden' name='unit_call4' id='unit_call4' value='".$cid."'>
					<a onclick='attachWOther()'><input type='button' id='attachWOther' onclick='attachWOther();' value='Attach' class='btn btn-light'/></a>
					</form>
						<script>
						document.getElementById('attachWOther-Form').hidden = true;
						</script>
							";
        }
    }
    echo "
							<form class='form-inline' id='clearCall-Form' method='post'>
							<input type='hidden' name='fcall_id' id='fcall_id' value='".$cid."'>
                            <a onclick='clearCall()'><button type='button' id='clearCall' onclick='clearCall();' class='btn btn-light'>Clear Call</button></a>
                            <input type='hidden' id='closeCallModal' name='closeCallModal' type='button' class='btn btn-danger' data-dismiss='modal' value='Close'/>
							</form>
							<form class='form-inline'>
                            <button id='closeCallModal' name='closeCallModal' type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
							</form>
                          </div>
                        </div>
	";
}
?>
