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
    $callid = $cid.substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
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
    echo "
						<div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel-2'>".strtoupper($call["call_type"])." - #".$callid."</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                          <div style='width:100%; margin: auto;'>
                          <div style='width:50%; float: left;'>
                            <h6>CALLER ID: ".$call["call_name"]."</h6>
                            <h6>LOCATION: ".$call["call_location"]." #".$call["call_postal"]."</h6>
                            <h6>DESCRIPTION:</h6>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0' style='width:450px;'>
                                <div class='input-group-prepend'>
                                  <span class='input-group-text'>📋</span>
                                </div>
                                <input class='form-control' onchange='descChange(this.value, ".$cid.");' value='".$call["call_description"]."'/> <div style='margin-left:5px; margin-top:6px;' id='check' hidden>✔️</div>
                            </div>
							<div class='card card-inverse-light' style='margin-top:15px;'>
								<div class='card-body'>
									<h5>ATTACHED UNITS</h5>
									";
    if ($noUnitsAttached) {
        echo "
											<p id='nounits' class='mb-4'>There are currently no units attached.</p>
              				<p id='nounits-A' class='mb-4' hidden>Unit Attached, you'll see it here after viewing this call again.</p>
										";
    } else {
        foreach ($arr as $key => $item) {
            if ($item["unit_division"] == "LEO") {
                $div = "";
            } else {
                $div = " [".$item["unit_division"]."]";
            }
            if ($item["unit_call"] == $cid) {
                echo "
									<p id='".$item["steam_id"]."-1' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"]." [".$item["unit_status"].$div."] [<a href='javascript:removeUnit(".'"'.$item["steam_id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
									";
            }else{
                echo "
									<p id='".$item["steam_id"]."-1' class='mb-4' hidden> ".$item["unit_callsign"]." // ".$item["unit_name"]." [".$item["unit_status"].$div."] [<a href='javascript:removeUnit(".'"'.$item["steam_id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
									";
            }
        }
        foreach ($arr11 as $key => $item) {
            if ($item["apparatus_call"] == $cid) {
                echo "
									<p id='".$item["id"]."-1' class='mb-4'> ".$item["apparatus_name"]." [".$item["apparatus_status"]."] [<a href='javascript:removeApp(".'"'.$item["id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
									";
            }else{
                echo "
									<p id='".$item["id"]."-1' class='mb-4' hidden> ".$item["apparatus_name"]." [".$item["apparatus_status"]."] [<a href='javascript:removeApp(".'"'.$item["id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
									";
            }
        }
    }
    echo "
								</div>
							</div>
                          </div>
                          <div style='width:50%; float: left;'>
                          <div class='col-md grid-margin stretch-card'>
                <div style='height:270px; overflow-y: auto;' class='card'>
                  <div class='card-body'>
                    <h4 class='card-title'>Unit List</h4>
                    <p class='card-description'><code>Available Units</code></p>
                          ";
                          //Put Units and Add Attach Button
                          foreach ($arr as $key => $item) {
                              if (($item["unit_call"] == "none") && ($item["unit_status"] != "10-42")) {
                                  echo "
                            <div id='".$item["steam_id"]."-A' style='margin-top:10px;' class='pl-0'>
                              ".$item["unit_callsign"]." // ".$item["unit_name"]." // ".$item["unit_status"]." // <a href='javascript:attachUnit(".'"'.$item["steam_id"].'"'.", ".$cid.", 0);' style='color:red;'>ATTACH</a> <br>
                            </div>";
                          }elseif($item["unit_call"] == $cid){
                              echo "
                        <div id='".$item["steam_id"]."-A' style='margin-top:10px;' class='pl-0' hidden>
                          ".$item["unit_callsign"]." // ".$item["unit_name"]." // ".$item["unit_status"]." // <a href='javascript:attachUnit(".'"'.$item["steam_id"].'"'.", ".$cid.", 0);' style='color:red;'>ATTACH</a> <br>
                        </div>";
                          }
                          }
                          foreach ($arr11 as $key => $item2) {
                              if (($item2["apparatus_call"] == "none") && ($item2["apparatus_status"] != "10-42")) {
                                  echo "
                            <div id='".$item2["id"]."-A' style='margin-top:10px;' class='pl-0'>
                              ".$item2["apparatus_name"]." // ".$item2["apparatus_status"]." // <a href='javascript:attachUnit(".'"'.$item2["id"].'"'.", ".$cid.", 1);' style='color:red;'>ATTACH</a> <br>
                            </div>";
                          }elseif($item2["apparatus_call"] == $cid){
                              echo "
                        <div id='".$item2["id"]."-A' style='margin-top:10px;' class='pl-0' hidden>
                          ".$item2["apparatus_name"]." // ".$item2["apparatus_status"]." // <a href='javascript:attachUnit(".'"'.$item2["id"].'"'.", ".$cid.", 1);' style='color:red;'>ATTACH</a> <br>
                        </div>";
                          }
                          }
                          echo "
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class='modal-footer'>
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
