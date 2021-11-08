function createCivWarrant(e) {
  var warrant_desc = $("#warrant_desc" + e).val();
  var warrant_owner = $("#warrant_owner" + e).val();
  var warrant_creator = $("#bolo_name" + e).val();
  $.post("../leo/createwarrant.php", {
    warrant_desc: warrant_desc,
    warrant_owner: warrant_owner,
    warrant_creator: warrant_creator
  }, function(data) {
    $("#createWarrant-Form" + e)[0].reset();
  });
  document.getElementById("closeWarrantModal" + e).click();
}