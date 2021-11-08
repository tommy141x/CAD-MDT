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
   $query_name = $_POST['name'];
   $data = $database->select('mdt_characters', [
    'char_name',
    'char_dob',
    'char_address',
    'char_dl',
    'char_wl'
    ], ['char_name[=]'=>$query_name]);

    $jsondata = json_encode($data);
    $arr = json_decode($jsondata, true);


   $wdata = $database->select('mdt_warrants', [
    'warrant_desc',
    'warrant_creator'
    ], ['warrant_owner[=]'=>$query_name]);

    $wjsondata = json_encode($wdata);
    $warrantarray = json_decode($wjsondata, true);
    global $has_warrant;
    if (count($warrantarray)==0) {
        $has_warrant=false;
    } else {
        $has_warrant=true;
    }

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

    $cdata = $database->select('mdt_citations', [
        'cit_creator',
        'cit_type',
        'cit_details',
        'cit_street',
        'cit_postal',
        'cit_fine',
        'cit_date'
        ], ['cit_owner[=]'=>$query_name]);

        $cjsondata = json_encode($cdata);
        $citationarray = json_decode($cjsondata, true);
        global $has_citation;
        if (count($citationarray)==0) {
            $has_citation=false;
        } else {
            $has_citation=true;
        }

        $adata = $database->select('mdt_arrests', [
            'arr_creator',
            'arr_type',
            'arr_details',
            'arr_street',
            'arr_postal',
            'arr_date'
            ], ['arr_owner[=]'=>$query_name]);

            $ajsondata = json_encode($adata);
            $arrestarray = json_decode($ajsondata, true);
            global $has_arrest;
            if (count($arrestarray)==0) {
                $has_arrest=false;
            } else {
                $has_arrest=true;
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
						  ";
        if ($has_warrant == true) {
            echo "
                            <a data-toggle='collapse' href='#collapse' aria-expanded='false' aria-controls='collapse'> ".$char["char_name"]." - ".$char["char_dob"]." <code>ACTIVE-WARRANT</code></a> ";
        } else {
            echo "
                            <a data-toggle='collapse' href='#collapse' aria-expanded='false' aria-controls='collapse'> ".$char["char_name"]." - ".$char["char_dob"]."</a> ";
        }
        echo "
                          </h5>
                        </div>
                        <div id='collapse' class='collapse' role='tabpanel' aria-labelledby='heading' data-parent='#accordion-5'>
                          <div class='card-body'>
						  <a style='font-weight:450;'>Address:</a>  ".$char["char_address"]."
						  <br>
						  <a style='font-weight:450;'>Drivers License:</a>  ".$char["char_dl"]."
						  <br>
						  <a style='font-weight:450;'>Weapons License:</a>  ".$char["char_wl"]."
							<br>
						  ";
							if($has_records){
			            echo "<a style='font-weight:450;'>Has Medical Priors:</a>  Yes";
							}else{
			            echo "<a style='font-weight:450;'>Has Medical Priors:</a>  No";
							}
        if ($has_warrant) {
            echo "<br>";
            foreach ($warrantarray as $key => $warrant) {
                echo "
						  <form style='height:8px;' id='clearWarrant-Form".$key."' method='post'>
						  <input type='hidden' name='warrant_desc".$key."' id='warrant_desc".$key."' value='".$warrant["warrant_desc"]."'>
						  <input type='hidden' name='warrant_owner".$key."' id='warrant_owner".$key."' value='".$char["char_name"]."'>
						  ";
                if (strlen($warrant["warrant_desc"]) > 20) {
                    echo "
							<a style='font-weight:450;'>ACTIVE WARRANT:</a> <code>".substr($warrant["warrant_desc"], 0, 20).'... ('.$warrant["warrant_creator"].") - <a id='".$key."' href='javascript:clearWarrant(".$key.")'>CLEAR</a></code>
							</form>
							";
                } else {
                    echo "
							<a style='font-weight:450;'>ACTIVE WARRANT:</a> <code>".$warrant["warrant_desc"].' ('.$warrant["warrant_creator"].") - <a id='".$key."' href='javascript:clearWarrant(".$key.")'>CLEAR</a></code>
							</form>
							";
                }
            }
        }
        echo "
						  <div style='position: absolute; text-align: right; display: inline-block; bottom:20px; left:55%;'>
						   <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#CreateWarrant'>Create Warrant</button>
						   <button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#viewPriors'>Citations / Arrests</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#viewRecords'>Medical History</button>
							</div>
						  </div>
                        </div>
                      </div>


					  <div class='modal fade' id='createWarrant' tabindex='-1' role='dialog' aria-labelledby='ModalELabel' aria-hidden='true' data-backdrop=false>
                      <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='ModalELabel'>CREATE WARRANT</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
						  <form id='createWarrant-Form' method='post'>
                          <div class='modal-body'>
							<div class='input-group'>
								<div class='input-group-prepend'>
								<span class='input-group-text'>WARRANT</span>
								</div>
								<input type='text' id='warrant_desc' class='form-control' placeholder='Warrant Description' required>
								<input type='hidden' name='warrant_owner' id='warrant_owner' value='".$char["char_name"]."'>
							</div>
							<div id='officername'></div>
                          </div>
                          <div class='modal-footer'>
                            <a onclick='javascript:createWarrant()'><button id='createWarrant' type='button' class='btn btn-danger'>Create</button></a>
						  </form>
                            <button type='button' id='closeWarrantModal' class='btn btn-light' data-dismiss='modal'>Cancel</button>
                          </div>
                        </div>
					  </div>
                    </div>

					<div class='modal fade' id='viewPriors' role='dialog' aria-labelledby='viewPriorsLabel' aria-hidden='true' data-backdrop=false>
					<div class='modal-dialog modal-lg' role='document'>
					  <div class='modal-content'>
						<div class='modal-header'>
						  <h5 class='modal-title' id='viewPriorsLabel'>".$char["char_name"]."'s Query</h5>
						  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						  </button>
						</div>
						<div class='modal-body'>
						<h3>Citations</h3>
						<div class='table-responsive w-100'>
    <table class='table'>
      <thead>
        <tr class='bg-dark text-white'>
          <th>Type</th>
          <th>Description</th>
          <th>Location</th>
          <th class='text-right'>Fine</th>
          <th class='text-right'>Date</th>
          <th class='text-right'>Written By</th>
        </tr>
      </thead>
	  <tbody>
	  ";
        if ($has_citation == true) {
            foreach ($citationarray as $key => $cit) {
                $details = strlen($cit["cit_details"]) > 20 ? substr($cit["cit_details"], 0, 20)."..." : $cit["cit_details"];
                $street = strlen($cit["cit_street"]) > 17 ? substr($cit["cit_street"], 0, 17)."..." : $cit["cit_street"];
                echo "
        <tr class='text-right'>
          <td class='text-left'>".$cit["cit_type"]."</td>
          <td class='text-left'>".$details."</td>
          <td class='text-left'>".$street.", #".$cit["cit_postal"]."</td>
          <td>$".$cit["cit_fine"]."</td>
          <td>".$cit["cit_date"]."</td>
          <td>".$cit["cit_creator"]."</td>
		</tr>
		";
            }
        } else {
            echo "<p style='color:green;'>NO CITATIONS ON RECORD</p>";
        }
        echo "
      </tbody>
    </table>
  </div>
	<hr>
  <h3>Arrests</h3>
  <div class='table-responsive w-100'>
  <table class='table'>
	<thead>
	  <tr class='bg-dark text-white'>
		<th>Reason</th>
		<th>Description</th>
		<th>Location</th>
		<th class='text-right'>   </th>
		<th class='text-right'>Date</th>
		<th class='text-right'>Arrested By</th>
	  </tr>
	</thead>
	<tbody>
	";
        if ($has_arrest == true) {
            foreach ($arrestarray as $key => $arr) {
                $details = strlen($arr["arr_details"]) > 20 ? substr($arr["arr_details"], 0, 20)."..." : $arr["arr_details"];
                $street = strlen($arr["arr_street"]) > 17 ? substr($arr["arr_street"], 0, 17)."..." : $arr["arr_street"];
                echo "
	  <tr class='text-right'>
		<td class='text-left'>".$arr["arr_type"]."</td>
		<td class='text-left'>".$details."</td>
		<td class='text-left'>".$street.", #".$arr["arr_postal"]."</td>
		<td>   </td>
		<td>".$arr["arr_date"]."</td>
		<td>".$arr["arr_creator"]."</td>
	  </tr>
	  ";
            }
        } else {
            echo "<p style='color:green;'>NO ARRESTS ON RECORD</p>";
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
