$(function () {

  $("#form-structure-edit").submit(function () {
    var valid = true;
    if ($("#name").val() === "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    return valid;
  });

});
