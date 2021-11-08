function activateDispatch() {
  document.getElementById("activateButton").style.display = "none";
  document.getElementById("deactivateButton").style.display = "block";
  $.post("activatedispatch.php", {}, function(data) {
    $("#dispatchb").html(data);
    $("#dispatchb")[0].reset();
  });
}

function deactivateDispatch() {
  document.getElementById("activateButton").style.display = "block";
  document.getElementById("deactivateButton").style.display = "none";
  $.post("deactivatedispatch.php", {}, function(data) {
    $("#dispatchb").html(data);
    $("#dispatchb")[0].reset();
  });
}

function createCall() {
  var type = $("#call_type").val();
  var desc = $("#call_desc").val();
  var loc = $("#call_loc").val();
  var postal = $("#call_postal").val();
  var steam_id = $("#steam_id").val();
  $.post("createcall.php", {
    type: type,
    desc: desc,
    loc: loc,
    postal: postal,
    steam_id: steam_id
  }, function(data) {
    $("#createCall-Form")[0].reset();
  });
  document.getElementById("closeCCallmodal").click();
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
  var name = "DISPATCH";
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

function personNCIC() {
  var name = $("#query_name").val();
  $.post("personncic.php", {
    name: name
  }, function(data) {
    $("#personNCIC-results").html(data);
  });
}

function plateNCIC() {
  var plate = $("#query_plate").val();
  $.post("platencic.php", {
    plate: plate
  }, function(data) {
    $("#plateNCIC-results").html(data);
  });
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

function logoutUnit(steamid){
$.post("logoutunit.php", {
  steamid: steamid
}, function(data) {
  $('#closeVIEWmodal').click();
});
}

function removeUnit(steamid){
$.post("detachunit.php", {
  steamid: steamid
}, function(data) {
  $("#"+steamid+"-A").hide();
  $('#'+steamid+"-A").removeAttr('hidden');
  $("#"+steamid+"-1").fadeOut();
  $("#"+steamid+"-A").hide().fadeIn("fast");
});
}

function removeUnitRefresh(steamid){
$.post("detachunit.php", {
  steamid: steamid,
  success: function(result) {
    $("#"+steamid+"-1").fadeOut();
    setTimeout(function(){$.ajax({
        type : 'post',
        url : 'fetchUnit.php', //Here you will fetch records
        data :  { id: steamid},
        success : function(data){
        $('.fetched-unit-data').html(data);//Show fetched data from database
        }
    })}, 1000);
  }
});
}

function removeApp(id){
$.post("detachapp.php", {
  id: id
}, function(data) {
  $("#"+id+"-A").hide();
  //document.getElementById(id+"-A").hidden = false;
  $('#'+id+"-A").removeAttr('hidden');
  $("#"+id+"-1").fadeOut();
  $("#"+id+"-A").hide().fadeIn("fast");
});
}

function descChange(value, callid){
    $.ajax({
        type: "GET",
        url: "descChange.php",
        data: {value: value, callid: callid},
        success: function(result) {
            $("#check").hide();
            $('#check').removeAttr('hidden');
            $("#check").hide().fadeIn("fast");
        }
    });
}

function attachUnit(unit, cid, type){
    $.ajax({
        type: "GET",
        url: "attachUnit.php",
        data: {unit: unit, cid: cid, type: type},
        success: function(result) {
          //Add Unit to the attached units window and remove them from the attachment window.
          $("#nounits").fadeOut();
          $('#nounits-A').hide();
          $('#nounits-A').removeAttr('hidden');
          $('#nounits-A').hide().fadeIn("fast");
          $("#"+unit+"-1").hide();
          $('#'+unit+"-1").removeAttr('hidden');
          $("#"+unit+"-A").fadeOut("fast");
          $("#"+unit+"-1").hide().fadeIn("fast");
        }
    });
}

function statusUpdate(callsign, name, status, unit, type){
    $.ajax({
        type: "GET",
        url: "statusUpdate.php",
        data: {status: status, unit: unit, type: type},
        success: function(result) {
          if(type == 0){
          $("#unit-modal-title").html(callsign + " // " + name + " // " + status);
        }else{
          $("#unit-modal-title").html(name + " // " + status);
        }
        }
    });
}

function createWarrant() {
  var warrant_desc = $("#warrant_desc").val();
  var warrant_owner = $("#warrant_owner").val();
  var warrant_creator = $("#bolo_name").val();
  $.post("createwarrant.php", {
    warrant_desc: warrant_desc,
    warrant_owner: warrant_owner,
    warrant_creator: warrant_creator
  }, function(data) {});
  document.getElementById("personNCIC-Submit").click();
  document.getElementById("closeWarrantModal").click();
}

var windowOpen = false;
var mapWindow = null;
function showLiveMap(){
if(windowOpen == false){
mapWindow = window.open("live-map", "", "top=200,left=250,directories=0,width=720,height=500,menubar=0,titlebar=0,location=0");
windowOpen = true;
}else{
mapWindow.close();	
mapWindow = window.open("live-map", "", "top=200,left=250,directories=0,width=720,height=500,menubar=0,titlebar=0,location=0");
windowOpen = true;
}
mapWindow.onbeforeunload = function(){
	windowOpen = false;
	mapWindow = null;
};
}
