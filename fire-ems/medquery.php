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
    require '../login/steamauth/steamauth.php';
    include('../login/steamauth/userInfo.php');
   $query_name = $_POST['name'];
   $data = $database->select('mdt_characters', [
    'char_name',
    'char_dob',
    'char_address'
    ], ['char_name[=]'=>$query_name]);

    $jsondata = json_encode($data);
    $arr = json_decode($jsondata, true);


   $mdata = $database->select('mdt_medreps', [
    'report_desc',
    'report_creator',
    'report_date'
    ], ['report_owner[=]'=>$query_name]);

    $mjsondata = json_encode($mdata);
    $medicalarray = json_decode($mjsondata, true);
    global $has_records;
    if (count($medicalarray)==0) {
        $has_records=false;
    } else {
        $has_records=true;
    }

    if (count($arr)==0) {
        echo "<code>Error - No Results Found</code>";
    } else {
        $char = $arr[0];
        echo "
	<div class='accordion accordion-filled' id='accordion-5' role='tablist'>
	<div class='card'>
                        <div class='card-header' role='tab' id='heading'>
                          <h5 class='mb-0'>
                            <a data-toggle='collapse' href='#collapse' aria-expanded='false' aria-controls='collapse'> ".$char["char_name"]." - ".$char["char_dob"]."</a>
                          </h5>
                        </div>
                        <div id='collapse' class='collapse' role='tabpanel' aria-labelledby='heading' data-parent='#accordion-5'>
                          <div class='card-body'>
						  <a style='font-weight:450;'>Address:</a>  ".$char["char_address"]."
						  <br> ";
        if ($has_records) {
            echo "<a style='font-weight:450;'>Has Medical Priors:</a>  Yes";
        } else {
            echo "<a style='font-weight:450;'>Has Medical Priors:</a>  No";
        }
        echo "
						  <div style='position: absolute; text-align: right; display: inline-block; bottom:20px; left:68%;'>
						   <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#viewRecords'>View Medical Records</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#createReport'>Create Report</button>
							</div>
						  </div>
                        </div>
                      </div>


					  <div class='modal fade' id='createReport' tabindex='-1' role='dialog' aria-labelledby='ModalELabel' aria-hidden='true' data-backdrop='false'>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='ModalELabel'>CREATE MEDICAL REPORT</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
						  <form id='createReport-Form' method='post'>
                          <div class='modal-body'>
							<div class='input-group'>
								<div class='input-group-prepend'>
								<span class='input-group-text'>REPORT</span>
								</div>
								<input type='text' id='report_desc' class='form-control' placeholder='Report Description' required>
								<input type='hidden' name='report_owner' id='report_owner' value='".$char["char_name"]."'>
							</div>
							";


        $datar = $database->select('mdt_units', [
    'unit_callsign',
    'unit_name'
    ], ["steam_id[=]"=>$steamprofile['steamid']]);
        $jsondatar = json_encode($datar);
        $aee = json_decode($jsondatar, true);
        echo "<input type='hidden' name='officer_name' id='officer_name' value='".$aee[0]["unit_callsign"]." // ".$aee[0]["unit_name"]."'>";

        echo "
                          </div>
                          <div class='modal-footer'>
                            <a onclick='javascript:createReport()'><button id='createReport' type='button' class='btn btn-danger'>Create</button></a>
						  </form>
                            <button type='button' id='closeRReportModal' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
					  </div>
                    </div>

					<div class='modal fade' id='viewRecords' role='dialog' aria-labelledby='viewRecordsLabel' aria-hidden='true'>
					<div class='modal-dialog modal-lg' role='document'>
					  <div class='modal-content'>
						<div class='modal-header'>
						  <h5 class='modal-title' id='viewRecordsLabel'>".$char["char_name"]."'s Medical History</h5>
						  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						  </button>
						</div>
						<div class='modal-body'>
						<h3>Medical Reports</h3>
						<div class='table-responsive w-100'>
    <table class='table'>
      <thead>
        <tr class='bg-dark text-white'>
          <th>Description</th>
          <th class='text-right'>Date</th>
          <th class='text-right'>Written By</th>
        </tr>
      </thead>
	  <tbody>
	  ";
        if ($has_records == true) {
            foreach ($medicalarray as $key => $med) {
                $details = strlen($med["report_desc"]) > 70 ? substr($med["report_desc"], 0, 70)."..." : $med["report_desc"];
                echo "
        <tr class='text-right'>
          <td class='text-left'>".$details."</td>
          <td>".$med["report_date"]."</td>
          <td>".$med["report_creator"]."</td>
		</tr>
		";
            }
        } else {
            echo "<p style='color:green;'>NO MEDICAL HISTORY ON RECORD</p>";
        }
        echo "
      </tbody>
    </table>
  </div>
						</div>
						<div class='modal-footer'>
						  <button type='button' class='btn btn-light' data-dismiss='modal'>Close</button>
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
