<?php
require '../connectdb.php';
$data = $database->select('mdt_apparatus', [
    'id',
    'apparatus_name',
    'apparatus_status',
    'apparatus_call',
], ['id[=]'=>$_POST["id"]]);
$jsondata = json_encode($data);
$arr = json_decode($jsondata, true);
$app = $arr[0];

$data2 = $database->select('mdt_units', [
'steam_id',
'unit_callsign',
'unit_name',
'unit_status',
'unit_call',
'unit_panic',
'unit_division',
'unit_status'
], ['unit_call[=]'=>$_POST["id"]]);
$jsondata2 = json_encode($data2);
$arr2 = json_decode($jsondata2, true);


$attached = false;
global $call;
global $callid;
if($app["apparatus_call"] != "none"){
$attached =true;
$data4 = $database->select('mdt_calls', [
'call_name',
'call_description',
'call_location',
'call_postal',
'call_type',
'call_isPriority'
], ['id[=]'=>$app["apparatus_call"]]);

$jsondata4 = json_encode($data4);
$arr4 = json_decode($jsondata4, true);
$call = $arr4[0];
$callid = $app["apparatus_call"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);
}

echo "
  <div class='modal-content'>
    <div class='modal-header'>
      <h5 class='modal-title' id='unit-modal-title'>".$app["apparatus_name"]." // ".$app["apparatus_status"]."</h5>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
    <div class='modal-body'>
    <form style='margin-top:-20px; margin-left:350px;' id='status-form' class='form-inline'>
    <select style='width:90px;' onchange='statusUpdate(".'"'.'"'.", ".'"'.$app["apparatus_name"].'"'.", this.value, ".'"'.$app["id"].'"'.", 1);' id='status-selec' class='form-control'>
    <option value='".$app["apparatus_status"]."'>".$app["apparatus_status"]."</option>";
    $statusARR = array('10-8', '10-7', '10-6', '10-23', '10-97', '10-42');
    foreach ($statusARR as $key => $item) {
          if($item != $app["apparatus_status"]){
          echo "<option value='".$item."'>".$item."</option>";
          }
    }
    echo "
    </select>
    </form>
    ";
    if($attached){
      echo "<p style='margin-top:-45px; font-weight:450;'>Currently Attached to Call #".$callid."</p>";
    }else{
      echo "<p style='margin-top:-45px; font-weight:450;'>Not Currently Attached to a Call.</p>";
    }
echo "
<div class='card card-inverse-light' style='margin-top:15px;'>
<div class='card-body'>
<h5>UNITS ON APPARATUS</h5>
      ";


          foreach ($arr2 as $key => $item) {
                  echo "
                    <p id='".$item["steam_id"]."-1' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"]." [<a href='javascript:logoutUnit(".'"'.$item["steam_id"].'"'.")' style='color:red;'>LOGOUT</a>]</p>
                    ";
          }
          echo "
      								</div>
      							</div>
    </div>
    <div class='modal-footer'>
      <button type='button' id='closeVIEWmodal' class='btn btn-inverse-light' data-dismiss='modal'>Close</button>
    </div>
  </div>
";
?>
