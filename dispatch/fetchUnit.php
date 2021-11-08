<?php
require '../connectdb.php';
$data = $database->select('mdt_units', [
'steam_id',
'unit_callsign',
'unit_name',
'unit_status',
'unit_call',
'unit_panic',
'unit_division',
'unit_status'
], ['steam_id[=]'=>$_POST["id"]]);

$jsondata = json_encode($data);
$arr = json_decode($jsondata, true);
$unit = $arr[0];

$attached = false;
global $call;
global $callid;
if($unit["unit_call"] != "none"){
$attached =true;
$data2 = $database->select('mdt_calls', [
'call_name',
'call_description',
'call_location',
'call_postal',
'call_type',
'call_isPriority'
], ['id[=]'=>$unit["unit_call"]]);

$jsondata2 = json_encode($data2);
$arr2 = json_decode($jsondata2, true);
$call = $arr2[0];
$callid = $unit["unit_call"].substr($call["call_postal"], 0, 1).substr($call["call_postal"], -1);

$data11 = $database->select('mdt_apparatus', [
    'id',
    'apparatus_name',
    'apparatus_status',
    'apparatus_call',
], ['apparatus_call[=]'=>$unit["unit_call"]]);

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
], ['unit_call[=]'=>$unit["unit_call"]]);

$jsondata = json_encode($data);
$arr = json_decode($jsondata, true);

}
echo "
  <div class='modal-content'>
    <div class='modal-header'>
      <h5 class='modal-title' id='unit-modal-title'>".$unit["unit_callsign"]." // ".$unit["unit_name"]." // ".$unit["unit_status"]."</h5>
      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
    <div class='modal-body'>
    <form style='margin-top:-20px; margin-left:350px;' id='status-form' class='form-inline'>
    <select style='width:90px;' onchange='statusUpdate(".'"'.$unit["unit_callsign"].'"'.", ".'"'.$unit["unit_name"].'"'.", this.value, ".'"'.$unit["steam_id"].'"'.", 0);' id='status-selec' class='form-control'>
    <option value='".$unit["unit_status"]."'>".$unit["unit_status"]."</option>";
    $statusARR = array('10-8', '10-7', '10-6', '10-23', '10-97', '10-42');
    foreach ($statusARR as $key => $item) {
          if($item != $unit["unit_status"]){
          echo "<option value='".$item."'>".$item."</option>";
          }
    }
    echo "
    </select>
    </form>
    ";
    if($attached){
      echo "<p style='margin-top:-45px; font-weight:450;'>Currently Attached to Call #".$callid."</p>


<div class='card card-inverse-light' style='margin-top:15px;'>
<div class='card-body'>
<h5>ATTACHED UNITS</h5>
      ";


          foreach ($arr as $key => $item) {
              if ($item["unit_division"] == "LEO") {
                  $div = "";
              } else {
                  $div = " [".$item["unit_division"]."]";
              }
              if($item["steam_id"] == $unit["steam_id"]){
                  echo "
                    <p id='".$item["steam_id"]."-1' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"]." [".$item["unit_status"].$div."] [<a href='javascript:removeUnitRefresh(".'"'.$item["steam_id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
                    ";
              }else{
                  echo "
                    <p id='".$item["steam_id"]."-1' class='mb-4'> ".$item["unit_callsign"]." // ".$item["unit_name"]." [".$item["unit_status"].$div."] [<a href='javascript:removeUnit(".'"'.$item["steam_id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
                    ";
              }
          }
          foreach ($arr11 as $key => $item) {
                  echo "
  									<p id='".$item["id"]."-1' class='mb-4'> ".$item["apparatus_name"]." [".$item["apparatus_status"].$div."] [<a href='javascript:removeApp(".'"'.$item["id"].'"'.")' style='color:red;'>REMOVE</a>]</p>
  									";
          }
          echo "
      								</div>
      							</div>";
    }else{
      echo "<p style='margin-top:-45px; font-weight:450;'>Not Currently Attached to a Call.</p>";
    }
    echo "
    </div>
    <div class='modal-footer'>
      <button type='button' id='logoutUnit' class='btn btn-inverse-danger' onclick='logoutUnit(".'"'.$unit["steam_id"].'"'.");'>Logout Unit</button>
      <button type='button' id='closeVIEWmodal' class='btn btn-inverse-light' data-dismiss='modal'>Close</button>
    </div>
  </div>
";
?>
