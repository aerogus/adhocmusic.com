$(function () {

  $("#text").focus(function () {
    $("#warning").fadeIn();
  });

  $("#form-contact").submit(function () {
    var valid = true;
    if ($("#name").val() === "") {
      $("#error_name").fadeIn();
      valid = false;
    } else {
      $("#error_name").fadeOut();
    }
    if ($("#email").val() === "" || !validateEmail($("#email").val())) {
      $("#error_email").fadeIn();
      valid = false;
    } else {
      $("#error_email").fadeOut();
    }
    if ($("#subject").val() === "") {
      $("#error_subject").fadeIn();
      valid = false;
    } else {
      $("#error_subject").fadeOut();
    }
    if ($("#text").val() === "") {
      $("#error_text").fadeIn();
      valid = false;
    } else {
      $("#error_text").fadeOut();
    }
    return valid;
  });

});
