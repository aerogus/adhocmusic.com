$(function () {

  $("#form-structure-create").submit(function () {
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
