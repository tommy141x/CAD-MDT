function SubmitFormData0() {
  $("#SubmitFormData0").removeClass("btn-outline-danger");
  $("#SubmitFormData0").addClass("btn-danger");
  $("#SubmitFormData0").prop("disabled", true);
  $("#SubmitFormData1").removeClass("btn-danger");
  $("#SubmitFormData1").prop("disabled", false);
  $("#SubmitFormData1").addClass("btn-outline-danger");
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", true);
  $("#SubmitFormData3").prop("disabled", true);
  $("#SubmitFormData4").prop("disabled", true);
  $("#SubmitFormData5").prop("disabled", true);
  $("#SubmitFormData6").prop("disabled", true);
  $("#SubmitFormData7").prop("disabled", true);
  var unit_status = $("#unit_status0").val();
  var steam_id = $("#steam_id0").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-0").html(data);
    $("#status-form-0")[0].reset();
  });
}

function SubmitFormData1() {
  $("#SubmitFormData0").removeClass("btn-danger");
  $("#SubmitFormData0").addClass("btn-outline-danger");
  $("#SubmitFormData0").prop("disabled", false);
  $("#SubmitFormData1").removeClass("btn-outline-danger");
  $("#SubmitFormData1").prop("disabled", true);
  $("#SubmitFormData1").addClass("btn-danger");
  $("#SubmitFormData2").removeClass("btn-outline-danger");
  $("#SubmitFormData2").addClass("btn-danger");
  $("#SubmitFormData2").prop("disabled", true);
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status1").val();
  var steam_id = $("#steam_id1").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-1").html(data);
    $("#status-form-1")[0].reset();
  });
  var myAudio = document.getElementById("on-duty");
  myAudio.play();
}

function SubmitFormData2() {
  $("#SubmitFormData2").removeClass("btn-outline-danger");
  $("#SubmitFormData2").addClass("btn-danger");
  $("#SubmitFormData2").prop("disabled", true);
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status2").val();
  var steam_id = $("#steam_id2").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-2").html(data);
    $("#status-form-2")[0].reset();
  });
}

function SubmitFormData3() {
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", false);
  $("#SubmitFormData3").removeClass("btn-outline-danger");
  $("#SubmitFormData3").addClass("btn-danger");
  $("#SubmitFormData3").prop("disabled", true);
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status3").val();
  var steam_id = $("#steam_id3").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-3").html(data);
    $("#status-form-3")[0].reset();
  });
}

function SubmitFormData4() {
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", false);
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").removeClass("btn-outline-danger");
  $("#SubmitFormData4").addClass("btn-danger");
  $("#SubmitFormData4").prop("disabled", true);
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status4").val();
  var steam_id = $("#steam_id4").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-4").html(data);
    $("#status-form-4")[0].reset();
  });
}

function SubmitFormData5() {
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", false);
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").removeClass("btn-outline-danger");
  $("#SubmitFormData5").addClass("btn-danger");
  $("#SubmitFormData5").prop("disabled", true);
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status5").val();
  var steam_id = $("#steam_id5").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-5").html(data);
    $("#status-form-5")[0].reset();
  });
}

function SubmitFormData6() {
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", false);
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").removeClass("btn-outline-danger");
  $("#SubmitFormData6").addClass("btn-danger");
  $("#SubmitFormData6").prop("disabled", true);
  $("#SubmitFormData7").removeClass("btn-danger");
  $("#SubmitFormData7").addClass("btn-outline-danger");
  $("#SubmitFormData7").prop("disabled", false);
  var unit_status = $("#unit_status6").val();
  var steam_id = $("#steam_id6").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-6").html(data);
    $("#status-form-6")[0].reset();
  });
}

function SubmitFormData7() {
  $("#SubmitFormData2").removeClass("btn-danger");
  $("#SubmitFormData2").addClass("btn-outline-danger");
  $("#SubmitFormData2").prop("disabled", false);
  $("#SubmitFormData3").removeClass("btn-danger");
  $("#SubmitFormData3").addClass("btn-outline-danger");
  $("#SubmitFormData3").prop("disabled", false);
  $("#SubmitFormData4").removeClass("btn-danger");
  $("#SubmitFormData4").addClass("btn-outline-danger");
  $("#SubmitFormData4").prop("disabled", false);
  $("#SubmitFormData5").removeClass("btn-danger");
  $("#SubmitFormData5").addClass("btn-outline-danger");
  $("#SubmitFormData5").prop("disabled", false);
  $("#SubmitFormData6").removeClass("btn-danger");
  $("#SubmitFormData6").addClass("btn-outline-danger");
  $("#SubmitFormData6").prop("disabled", false);
  $("#SubmitFormData7").removeClass("btn-outline-danger");
  $("#SubmitFormData7").addClass("btn-danger");
  $("#SubmitFormData7").prop("disabled", true);
  var unit_status = $("#unit_status7").val();
  var steam_id = $("#steam_id7").val();
  $.post("status.php", {
    unit_status: unit_status,
    steam_id: steam_id
  }, function(data) {
    $("#results-7").html(data);
    $("#status-form-7")[0].reset();
  });
}

function personNCIC() {
  $("#personNCIC-results").fadeOut('fast');
  var name = $("#query_name").val();
  $.post("personncic.php", {
    name: name
  }, function(data) {
    $("#personNCIC-results").hide().html(data).fadeIn('slow');
  });
}

function plateNCIC() {
  $("#plateNCIC-results").fadeOut('fast')
  var plate = $("#query_plate").val();
  $.post("platencic.php", {
    plate: plate
  }, function(data) {
    $("#plateNCIC-results").hide().html(data).fadeIn('slow');
  });
}

function createWarrant() {
  var warrant_desc = $("#warrant_desc").val();
  var warrant_owner = "DISPATCH";
  var warrant_creator = $("#bolo_name").val();
  $.post("createwarrant.php", {
    warrant_desc: warrant_desc,
    warrant_owner: warrant_owner,
    warrant_creator: warrant_creator
  }, function(data) {});
  document.getElementById("personNCIC-Submit").click();
  document.getElementById("closeWarrantModal").click();
}

function createCitation() {
  var cit_owner = $("#cit_owner").val();
  var cit_creator = $("#bolo_name").val();
  var cit_type = $("#cit_type").val();
  var cit_details = $("#cit_details").val();
  var cit_street = $("#cit_street").val();
  var cit_postal = $("#cit_postal").val();
  var cit_fine = $("#cit_fine").val();
  $.post("createcitation.php", {
    cit_owner: cit_owner,
    cit_creator: cit_creator,
    cit_type: cit_type,
    cit_details: cit_details,
    cit_street: cit_street,
    cit_postal: cit_postal,
    cit_fine: cit_fine
  }, function(data) {
    $("#CreateCIT-Form")[0].reset();
    document.getElementById("personNCIC-Submit").click();
  });
  document.getElementById("closeCitationModal").click();
}

function createArrest() {
  var arr_owner = $("#arr_owner").val();
  var arr_creator = $("#bolo_name").val();
  var arr_type = $("#arr_type").val();
  var arr_details = $("#arr_details").val();
  var arr_street = $("#arr_street").val();
  var arr_postal = $("#arr_postal").val();
  $.post("createarrest.php", {
    arr_owner: arr_owner,
    arr_creator: arr_creator,
    arr_type: arr_type,
    arr_details: arr_details,
    arr_street: arr_street,
    arr_postal: arr_postal
  }, function(data) {
    $("#CreateARR-Form")[0].reset();
    document.getElementById("personNCIC-Submit").click();
  });
  document.getElementById("closeArrestModal").click();
}

function clearWarrant(e) {
  //Detaching from a call where this client was the only unit.
  var form_id = e;
  var warrant_desc = $("#warrant_desc" + form_id).val();
  var warrant_owner = $("#warrant_owner" + form_id).val();
  $.post("clearwarrant.php", {
    warrant_desc: warrant_desc,
    warrant_owner: warrant_owner
  }, function(data) {});
  document.getElementById("clearWarrant-Form" + form_id).hidden = true;
}

function editVehicleFlags() {
  //Detaching from a call where this client was the only unit.
  var veh_flags = $("#veh_flags").val();
  var veh_plate = $("#veh_plate").val();
  $.post("editVeh.php", {
    veh_flags: veh_flags,
    veh_plate: veh_plate
  }, function(data) {
    $("#editVehicleFlags-Form")[0].reset();
    document.getElementById("plateNCIC-Submit").click();
  });
  document.getElementById("closeVehEditModal").click();
}

function NoUnitAttached() {
  document.getElementById("toggley").hidden = false;
}

function detachFromONLY() {
  //Detaching from a call where this client was the only unit.
  var steam_id = $("#steam_id1").val();
  var unit_call = "none";
  $.post("attachments.php", {
    unit_call: unit_call,
    steam_id: steam_id
  }, function(data) {
    $("#detachFromONLY-Form")[0].reset();
  });
  document.getElementById("togglex").hidden = true;
  document.getElementById("toggley").hidden = false;
  document.getElementById("detachFromONLY-Form").hidden = true;
  document.getElementById("attachAlone-Form").hidden = false;
  var myAudio = document.getElementById("detach");
  myAudio.play();
}

function attachedWOther() {
  //Detaching from a call where there are multiple units.
  var steam_id = $("#steam_id2").val();
  var unit_call = "none";
  $.post("attachments.php", {
    unit_call: unit_call,
    steam_id: steam_id
  }, function(data) {
    $("#attachedWOther-Form")[0].reset();
  });
  document.getElementById("togglex").hidden = true;
  document.getElementById("attachedWOther-Form").hidden = true;
  document.getElementById("attachWOther-Form").hidden = false;
  var myAudio = document.getElementById("detach");
  myAudio.play();
}

function attachAlone() {
  //Attaching to a call with the client being the only unit.
  var steam_id = $("#steam_id3").val();
  var unit_call = $("#unit_call3").val();
  $.post("attachments.php", {
    unit_call: unit_call,
    steam_id: steam_id
  }, function(data) {
    $("#attachAlone-Form")[0].reset();
  });
  document.getElementById("togglex").hidden = false;
  document.getElementById("toggley").hidden = true;
  document.getElementById("detachFromONLY-Form").hidden = false;
  document.getElementById("attachAlone-Form").hidden = true;
  var myAudio = document.getElementById("attach");
  myAudio.play();
}

function attachWOther() {
  //Attaching to a call where there are multiple units.
  var steam_id = $("#steam_id4").val();
  var unit_call = $("#unit_call4").val();
  $.post("attachments.php", {
    unit_call: unit_call,
    steam_id: steam_id
  }, function(data) {
    $("#attachWOther-Form")[0].reset();
  });
  document.getElementById("togglex").hidden = false;
  document.getElementById("attachedWOther-Form").hidden = false;
  document.getElementById("attachWOther-Form").hidden = true;
  var myAudio = document.getElementById("attach");
  myAudio.play();
}

function createCall() {
  var type = $("#call_type").val();
  var desc = $("#call_desc").val();
  var loc = $("#call_loc").val();
  var postal = $("#call_postal").val();
  var steam_id = $("#steam_id").val();
  var attach = $("#call_attach").val();
  $.post("createcall.php", {
    type: type,
    desc: desc,
    loc: loc,
    postal: postal,
    steam_id: steam_id,
    attach: attach
  }, function(data) {
    $("#createCall-Form")[0].reset();
  });
  document.getElementById("closeCCallmodal").click();
}

function setDivision() {
  var type = $("#division_type").val();
  var steam_id = $("#steam_id").val();
  $.post("setdivision.php", {
    type: type,
    steam_id: steam_id
  }, function(data) {
    $("#setDivision-Form")[0].reset();
  });
  document.getElementById("closeDDivisionmodal").click();
}

function clearCall() {
  var id = $("#fcall_id").val();
  $.post("clearcall.php", {
    id: id
  }, function(data) {
    $("#clearCall-Form")[0].reset();
  });
  document.getElementById("closeCallModal").click();
}

function createBolo() {
  var name = $("#bolo_name").val();
  var desc = $("#bolo_desc").val();
  $.post("createbolo.php", {
    desc: desc,
    name: name
  }, function(data) {
    $("#createBolo-Form")[0].reset();
  });
  document.getElementById("closeBOLOmodal").click();
}

function clearBolo(e) {
  var form_id = e;
  var id = $("#bolo_id" + form_id).val();
  $.post("clearbolo.php", {
    id: id
  }, function(data) {
    $("#clearBolo-Form")[0].reset();
  });
  document.getElementById("bolo_" + id).hidden = true;
  document.getElementById("no_bolo_" + id).hidden = false;
}
