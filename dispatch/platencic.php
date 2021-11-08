<html>
	<head>
      <link rel="stylesheet" href="../assets/vendors/select2/select2.min.css">
      <link rel="stylesheet" href="../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/css/modern-horizontal/style.css">
	</head>
</html>
<?php
   require '../connectdb.php';
   $query_plate = $_POST['plate'];
   $data = $database->select('mdt_vehicles', [
    'veh_owner_name',
    'veh_model',
    'veh_color',
    'veh_flags'
    ], ['veh_plate[=]'=>$query_plate]);
    
    $jsondata = json_encode($data);
    $arr = json_decode($jsondata, true);

    if (count($arr)==0) {
        echo "<code>Error - No Results Found</code>";
    } else {
        $veh = $arr[0];
        echo "
	<div class='accordion accordion-filled' id='accordion-5' role='tablist'>
	<div class='card'>
                        <div class='card-header' role='tab' id='heading'>
                          <h5 class='mb-0'>
                            <a data-toggle='collapse' href='#collapse' aria-expanded='false' aria-controls='collapse'> ".$veh["veh_model"]." - ".$query_plate."</a>
                          </h5>
                        </div>
                        <div id='collapse' class='collapse' role='tabpanel' aria-labelledby='heading' data-parent='#accordion-5'>
                          <div class='card-body'> 
						  <a style='font-weight:450;'>Registered Owner:</a>  ".$veh["veh_owner_name"]."
						  <br>
						  <a style='font-weight:450;'>Plate:</a>  ".$query_plate."
						  <br>
						  <a style='font-weight:450;'>Model:</a>  ".$veh["veh_model"]."
						  <br>
						  <a style='font-weight:450;'>Color:</a>  ".$veh["veh_color"]."
						  <br>
						  <a style='font-weight:450;'>Flags:</a>  ".$veh["veh_flags"]."
						  <div style='float: right; text-align: right; display: inline-block;'>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#EditFlags'>Edit Flags</button>
							</div>
						  </div>
                        </div>
                      </div>
					  <div class='modal fade' id='EditFlags' tabindex='-1' role='dialog' aria-labelledby='EditFlagsLabel' aria-hidden='true' data-backdrop=false>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='EditFlagsLabel'>Edit Vehicle Flags</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
						  <form id='editVehicleFlags-Form' method='post'>
						  <input type='hidden' name='veh_plate' id='veh_plate' value='".$query_plate."'>
                          <div class='modal-body'><div class='input-group mb-2 mr-sm-2 mb-sm-0'>
						  <select name='veh_flags' class='js-example-basic-single' id='veh_flags' style='width:100%'>
						  ";
        if ($veh["veh_flags"] == "Valid Registration") {
            echo "
							  <option value='Valid Registration'>Valid Registration</option>
							<option value='Expired Registration'>Expired Registration</option>
							<option value='STOLEN'>STOLEN</option>
							  ";
        } elseif ($veh["veh_flags"] == "Expired Registration") {
            echo "
							<option value='Expired Registration'>Expired Registration</option>
							  <option value='Valid Registration'>Valid Registration</option>
							<option value='STOLEN'>STOLEN</option>
							  ";
        } else {
            echo "
							<option value='STOLEN'>STOLEN</option>
							  <option value='Valid Registration'>Valid Registration</option>
							<option value='Expired Registration'>Expired Registration</option>
							  ";
        }
        echo "
						  </select>
							</div>
                          </div>
                          <div class='modal-footer'>
                            <a onclick='javascript:editVehicleFlags()'><button id='editVehicleFlags' type='button' class='btn btn-danger'>Edit</button></a>
						  </form>
                            <button type='button' id='closeVehEditModal' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
					  </div>
                    </div>
	";
    }
?>
<html>
    <script src="../assets/vendors/select2/select2.min.js"></script>
    <script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="../assets/js/typeahead.js"></script>
    <script src="../assets/js/select2.js"></script>
</html>