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
						  ";
        if ($has_warrant == true) {
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
						  <div style='position: absolute; text-align: right; display: inline-block; bottom:20px; left:45%;'>
						   <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#CreateWarrant'>Create Warrant</button>
						   <button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#viewPriors'>Citations / Arrests</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#CreateCitation'>Write Citation</button>
						   <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#CreateArrest'>Arrest Report</button>
							</div>
						  </div>
                        </div>
                      </div>


					  <div class='modal fade' id='createWarrant' tabindex='-1' role='dialog' aria-labelledby='ModalELabel' aria-hidden='true' data-backdrop='false'>
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

					<div class='modal fade' id='viewPriors' role='dialog' aria-labelledby='viewPriorsLabel' aria-hidden='true'>
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



					<div class='modal fade' id='createArrest' role='dialog' aria-labelledby='createArrestLabel' aria-hidden='true' data-backdrop='false'>
					<div class='modal-dialog modal-lg' role='document'>
					  <div class='modal-content'>
						<div class='modal-header'>
						  <h5 class='modal-title' id='createArrestLabel'>ARREST REPORT</h5>
						  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						  </button>
						</div>
						<div class='modal-body'>
						<h3 class='text-left'>Arrest Report&nbsp;&nbsp;#".rand(101, 999)."</h3>
<div class='container-fluid d-flex justify-content-between'>
  <div class='col-lg-3 pl-0'>
	<p class='mt-5 mb-2'><b>".$char["char_name"]."</b></p>
	<p>".$char["char_dob"].",<br>".$char["char_address"]."</p>
  </div>
  <div class='col-lg-3 pr-0'>
	<p class='mt-5 mb-2 text-right'><b>San Andreas Superior Court</b></p>
	";
        if (rand(0, 10) > 9) {
            echo"
	  <p class='text-right'>Connection 🟠<br>".date("m/d/Y")."</p>
	  ";
        } else {
            echo "
	  <p class='text-right'>Connection 🟢<br>".date("m/d/Y")."</p>
	  ";
        }
        echo "
  </div>
</div>
<hr style='border-top: 1px solid red'>
						<form id='CreateARR-Form' class='form-inline'>
						<input type='hidden' name='arr_owner' id='arr_owner' value='".$char["char_name"]."'>
						<select id='arr_type' class='js-example-basic-single'>
";

        $statusCIT = array(
          "SELECT CHARGES",
          "Speeding",
          "Speeding (15+)",
          "Speeding (25+)",
          "Speeding (40+)",
          "Impeding Traffic",
          "Reckless Driving",
          "Driving with Expired License",
          "Driving with Suspended License",
          "Driving without a License",
          "Driving Under the Influence (DUI)",
          "Use of Phone while Driving",
          "Motor Vehicle Assembely",
          "Illegal Vehicle Equipment",
          "Expired Identification",
          "Forged Documentation",
          "Failure to Present Documentation",
          "Resisting Arrest",
          "Evading LEO",
          "Bribery",
          "Obstruction",
          "Providing Fake/False Information",
          "Impersonation of LEO",
          "Arson",
          "Burglary of a Building",
          "Burglary of a Vehicle",
          "Destruction to Public Property",
          "Destruction to Private Property",
          "Trespassing",
          "Armed Robbery",
          "Theft",
          "Grand Theft Auto",
          "Stolen Identification",
          "Possesion of an Illegal Weapon",
          "Brandishing a Firearm",
          "Felon in Possesion of a Firearm",
          "Open Carrying a loaded Firearm",
          "Open Carrying an unloaded Firearm",
          "Drug Distribution",
          "Posession of an unknown substance",
          "Posession of Drugs",
          "Posession of a controlled substance",
          "Harboring a Fugitive",
          "Hate Crime",
          "Indecent Exposure",
          "Participating in a Gang",
          "Inciting a Riot",
          "Participating in a Riot",
          "Unlawful Assembly",
          "Public Intoxication",
          "Drug Impairment",
          "Disorderly Conduct",
          "Solicitation of Prostitution",
          "Engaging in Prostitution",
          "Assault",
          "Assault with a Deadly Weapon",
          "Assault on LEO",
          "Battery",
          "Aggravated Battery",
          "Domestic Battery",
          "Battery on LEO",
          "Aggravated Manslaughter",
          "2nd Degree Manslaughter",
          "Vehicular Manslaughter",
          "Involuntary Manslaughter",
          "1st Degree Murder",
          "2nd Degree Murder",
          "Capital Murder",
          "Kidnapping",
          "Kidnapping an LEO",
          "Attempted Rape",
          "Commited Rape"
      );
        foreach ($statusCIT as $key => $item) {
            echo "<option value='".$item."'>".$item."</option>";
        }
        echo "
</select>
						<div class='input-group' style='margin-left:15px; width:350px;'>
							  <div class='input-group-prepend'>
							  <span class='input-group-text'>📝</span>
							  </div>
							  <input type='text' id='arr_details' class='form-control' placeholder='Details' required>
						  </div>
						<div class='input-group' style='margin-left:15px; width:250px;'>
							  <div class='input-group-prepend'>
							  <span class='input-group-text'>LOC</span>
							  </div>
							  <input type='text' id='arr_street' class='form-control' placeholder='East Joshua Rd' required>
						  </div>
						<div class='input-group' style='margin-left:15px; width:100px;'>
							  <div class='input-group-prepend'>
							  <span class='input-group-text'>#</span>
							  </div>
							  <input type='text' id='arr_postal' class='form-control' placeholder='Postal' required>
						  </div>
							<div style='margin-top:15px;'>
							<p class='page-description mt-1 w-75 text-muted'>The violator must appear in court on the date presented on the arrest; failure to do so can result in additional penalties and fines.</p>
							</div>
						  </div>
						  <div id='officername'></div>
						<div class='modal-footer'>
						<a onclick='javascript:createArrest()'><button id='createArrest' type='button' class='btn btn-danger'>Create</button></a>
						</form>
						  <button type='button' id='closeArrestModal' class='btn btn-light' data-dismiss='modal'>Cancel</button>
						</div>
					  </div>
					</div>
				  </div>




					<div class='modal fade' id='createCitation' role='dialog' aria-labelledby='createCitationLabel' aria-hidden='true' data-backdrop='false'>
					  <div class='modal-dialog modal-lg' role='document'>
						<div class='modal-content'>
						  <div class='modal-header'>
							<h5 class='modal-title' id='createCitationLabel'>CREATE CITATION</h5>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							  <span aria-hidden='true'>&times;</span>
							</button>
						  </div>
						  <div class='modal-body'>
						  <h3 class='text-left'>Citation&nbsp;&nbsp;#".rand(101, 999)."</h3>
  <div class='container-fluid d-flex justify-content-between'>
    <div class='col-lg-3 pl-0'>
      <p class='mt-5 mb-2'><b>".$char["char_name"]."</b></p>
      <p>".$char["char_dob"].",<br>".$char["char_address"]."</p>
    </div>
    <div class='col-lg-3 pr-0'>
	  <p class='mt-5 mb-2 text-right'><b>San Andreas Superior Court</b></p>
	  ";
        if (rand(0, 10) > 9) {
            echo"
		<p class='text-right'>Connection 🟠<br>".date("m/d/Y")."</p>
		";
        } else {
            echo "
		<p class='text-right'>Connection 🟢<br>".date("m/d/Y")."</p>
		";
        }
        echo "
    </div>
  </div>
  <hr style='border-top: 1px solid red'>
						  <form id='CreateCIT-Form' class='form-inline'>
						  <input type='hidden' name='cit_owner' id='cit_owner' value='".$char["char_name"]."'>
						  <select id='cit_type' class='js-example-basic-single'>
  ";

        $statusCIT = array(
            "SELECT CITATION REASON",
            "Speeding",
            "Speeding (15+)",
            "Speeding (25+)",
            "Speeding (40+)",
            "Failure to Signal",
            "Failure to Yield",
            "Failure to Obey Traffic Signal",
            "Failure to Obey Traffic Sign",
            "Impeding Traffic",
            "Reckless Driving",
            "Driving with Expired License",
            "Driving with Suspended License",
            "Driving without a License",
            "Driving Under the Influence (DUI)",
            "Use of Phone while Driving",
            "No Use of Headlights",
            "Fix It Ticket",
            "Unsafe Vehicle",
            "Motor Vehicle Assembely",
            "Defective Headlights",
            "Defective Tail Lights",
            "Defective Signal Lights",
            "Unauthorized Lights",
            "Illegal Vehicle Equipment",
            "Expired Identification",
            "Forged Documentation",
            "Failure to Present Documentation",
            "Resisting Arrest",
            "Evading LEO",
            "Bribery",
            "Obstruction",
            "Providing Fake/False Information",
            "Impersonation of LEO",
            "Arson",
            "Burglary of a Building",
            "Burglary of a Vehicle",
            "Destruction to Public Property",
            "Destruction to Private Property",
            "Trespassing",
            "Armed Robbery",
            "Theft",
            "Grand Theft Auto",
            "Stolen Identification",
            "Possesion of an Illegal Weapon",
            "Brandishing a Firearm",
            "Felon in Possesion of a Firearm",
            "Open Carrying a loaded Firearm",
            "Open Carrying an unloaded Firearm",
            "Drug Distribution",
            "Posession of an unknown substance",
            "Posession of Drugs",
            "Posession of a controlled substance",
            "Harboring a Fugitive",
            "Hate Crime",
            "Indecent Exposure",
            "Participating in a Gang",
            "Inciting a Riot",
            "Participating in a Riot",
            "Unlawful Assembly",
            "Public Intoxication",
            "Drug Impairment",
            "Disorderly Conduct",
            "Solicitation of Prostitution",
            "Engaging in Prostitution",
            "Assault",
            "Assault with a Deadly Weapon",
            "Assault on LEO",
            "Battery",
            "Aggravated Battery",
            "Domestic Battery",
            "Battery on LEO",
            "Aggravated Manslaughter",
            "2nd Degree Manslaughter",
            "Vehicular Manslaughter",
            "Involuntary Manslaughter",
            "1st Degree Murder",
            "2nd Degree Murder",
            "Capital Murder",
            "Kidnapping",
            "Kidnapping an LEO",
            "Attempted Rape",
            "Commited Rape"
        );
        foreach ($statusCIT as $key => $item) {
            echo "<option value='".$item."'>".$item."</option>";
        }
        echo "
  </select>
  						<div class='input-group' style='margin-left:10px; width:280px;'>
								<div class='input-group-prepend'>
								<span class='input-group-text'>📝</span>
								</div>
								<input type='text' id='cit_details' class='form-control' placeholder='Details' required>
							</div>
						  <div class='input-group' style='margin-left:10px; width:230px;'>
								<div class='input-group-prepend'>
								<span class='input-group-text'>LOC</span>
								</div>
								<input type='text' id='cit_street' class='form-control' placeholder='East Joshua Rd' required>
							</div>
						  <div class='input-group' style='margin-left:10px; width:100px;'>
								<div class='input-group-prepend'>
								<span class='input-group-text'>#</span>
								</div>
								<input type='text' id='cit_postal' class='form-control' placeholder='Postal' required>
							</div>
							<div class='input-group' style='margin-left:10px; width:95px;'>
								  <div class='input-group-prepend'>
								  <span class='input-group-text'>$</span>
								  </div>
								  <input type='text' id='cit_fine' class='form-control' placeholder='FINE' required>
							  </div>
							  <div style='margin-top:15px;'>
							  <p class='page-description mt-1 w-75 text-muted'>The violator must pay the required fee and/or appear in court on the date presented on the citation; failure to do so can result in the issue of a warrant, as well as additional penalties and fines.</p>
							  </div>
							</div>
							<div id='officername'></div>
						  <div class='modal-footer'>
						  <a onclick='javascript:createCitation()'><button id='createCitation' type='button' class='btn btn-primary'>Create</button></a>
						  </form>
							<button type='button' id='closeCitationModal' class='btn btn-light' data-dismiss='modal'>Cancel</button>
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
