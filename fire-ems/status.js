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
  var apparatus_status = $("#apparatus_status0").val();
  var apparatus_id = $("#apparatus_id0").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status1").val();
  var apparatus_id = $("#apparatus_id1").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status2").val();
  var apparatus_id = $("#apparatus_id2").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status3").val();
  var apparatus_id = $("#apparatus_id3").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status4").val();
  var apparatus_id = $("#apparatus_id4").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status5").val();
  var apparatus_id = $("#apparatus_id5").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status6").val();
  var apparatus_id = $("#apparatus_id6").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
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
  var apparatus_status = $("#apparatus_status7").val();
  var apparatus_id = $("#apparatus_id7").val();
  $.post("status.php", {
    apparatus_status: apparatus_status,
    apparatus_id: apparatus_id
  }, function(data) {
    $("#results-7").html(data);
    $("#status-form-7")[0].reset();
  });
}

function medQUERY() {
  $("#medQUERY-results").fadeOut('fast');
  var name = $("#query_name").val();
  $.post("medquery.php", {
    name: name
  }, function(data) {
    $("#medQUERY-results").hide().html(data).fadeIn('slow');
  });
}

function NoUnitAttached() {
  document.getElementById("toggley").hidden = false;
}

function detachFromONLY() {
  //Detaching from a call where this client was the only unit.
  var apparatus_id = $("#apparatus_id1").val();
  var apparatus_call = "none";
  $.post("attachments.php", {
    apparatus_call: apparatus_call,
    apparatus_id: apparatus_id
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
  var apparatus_id = $("#apparatus_id2").val();
  var apparatus_call = "none";
  $.post("attachments.php", {
    apparatus_call: apparatus_call,
    apparatus_id: apparatus_id
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
  var apparatus_id = $("#apparatus_id3").val();
  var apparatus_call = $("#apparatus_call3").val();
  $.post("attachments.php", {
    apparatus_call: apparatus_call,
    apparatus_id: apparatus_id
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
  var apparatus_id = $("#apparatus_id4").val();
  var apparatus_call = $("#apparatus_call4").val();
  $.post("attachments.php", {
    apparatus_call: apparatus_call,
    apparatus_id: apparatus_id
  }, function(data) {
    $("#attachWOther-Form")[0].reset();
  });
  document.getElementById("togglex").hidden = false;
  document.getElementById("attachedWOther-Form").hidden = false;
  document.getElementById("attachWOther-Form").hidden = true;
  var myAudio = document.getElementById("attach");
  myAudio.play();
}

function createReport() {
  var officer = $("#officer_name").val();
  var desc = $("#report_desc").val();
  var owner = $("#report_owner").val();
  $.post("createreport.php", {
    officer: officer,
    desc: desc,
    owner: owner
  }, function(data) {
    $("#createReport-Form")[0].reset();
    document.getElementById("closeRReportModal").click();
    document.getElementById("medQUERY-Submit").click();
  });
}

function createCall() {
  var type = $("#call_type").val();
  var desc = $("#call_desc").val();
  var loc = $("#call_loc").val();
  var postal = $("#call_postal").val();
  var apparatus_id = $("#apparatus_id").val();
  var steam_id = $("#steam_id").val();
  var attach = $("#call_attach").val();
  $.post("createcall.php", {
    type: type,
    desc: desc,
    loc: loc,
    postal: postal,
    apparatus_id: apparatus_id,
    steam_id: steam_id,
    attach: attach
  }, function(data) {
    $("#createCall-Form")[0].reset();
  });
  document.getElementById("closeCCallmodal").click();
}

function setApparatus() {
  var type = $("#apparatus_type").val();
  var steam_id = $("#steam_id").val();
  $.post("setapparatus.php", {
    type: type,
    steam_id: steam_id
  }, function(data) {
    $("#setApparatus-Form")[0].reset();
  });
  document.getElementById("closeAApparatusmodal").click();
}

function clearCall() {
  var id = $("#acall_id").val();
  $.post("clearcall.php", {
    id: id
  }, function(data) {
    $("#clearCall-Form")[0].reset();
  });
  document.getElementById("closeCallModal").click();
}
