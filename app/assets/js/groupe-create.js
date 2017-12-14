$(function() {
  $('#form-groupe-create').submit(function() {
    var valid = true;
    if($('#name').val().length === 0) {
      $('#error_name').fadeIn();
      valid = false;
    } else {
      $('#error_name').fadeOut();
    }
    if($('#style').val().length === 0) {
      $('#error_style').fadeIn();
      valid = false;
    } else {
      $('#error_style').fadeOut();
    }
    if($('#influences').val().length === 0) {
      $('#error_influences').fadeIn();
      valid = false;
    } else {
      $('#error_influences').fadeOut();
    }
    if($('#lineup').val().length === 0) {
      $('#error_lineup').fadeIn();
      valid = false;
    } else {
      $('#error_lineup').fadeOut();
    }
    if($('#mini_text').val().length === 0 || $('#mini_text').val().length > 255) {
      $('#error_mini_text').fadeIn();
      valid = false;
    } else {
      $('#error_mini_text').fadeOut();
    }
    if($('#text').val().length === 0) {
      $('#error_text').fadeIn();
      valid = false;
    } else {
      $('#error_text').fadeOut();
    }
    return valid;
  });
});
