$(function () {
  $("#form-lieu-create").submit(function () {
    var valid = true;
    if($("#name").val() === "") {
      $("#name").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#name").prev(".error").fadeOut();
    }
    if($("#id_type").val() === "0") {
      $("#id_type").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_type").prev(".error").fadeOut();
    }
    if($("#address").val() === "") {
      $("#address").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#address").prev(".error").fadeOut();
    }
    if($("#text").val() === "") {
      $("#text").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#text").prev(".error").fadeOut();
    }
    if($("#id_country").val() === 'FR' && $("#id_departement").val() === "0") {
      $("#id_departement").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_departement").prev(".error").fadeOut();
    }
    if($("#id_country").val() === 'FR' && $("#id_city").val() === "0") {
      $("#id_city").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_city").prev(".error").fadeOut();
    }
    if($("#id_country").val() === "0") {
      $("#id_country").prev(".error").fadeIn();
      valid = false;
    } else {
      $("#id_country").prev(".error").fadeOut();
    }
    return valid;
  });

  $('#id_country, #id_region, #id_departement').keypress(function() {
    $(this).trigger('change');
  });

  /**
   *
   */
  $('#id_country').change(function() {
    var id_country = $('#id_country').val();
    $('#id_region').empty();
    $('#id_departement').empty();
    $('#id_city').empty();
    $('<option value="0">---</option>').appendTo('#id_region');
    $.getJSON('/geo/getregion.json', { c:id_country }, function(data) {
      $.each(data, function(region_id, region_name) {
        $('<option value="'+region_id+'">'+region_name+'</option>').appendTo('#id_region');
      });
    });
    if(id_country !== 'FR') {
        $('#id_departement').hide();
        $('#id_city').hide();
    } else {
        $('#id_departement').show();
        $('#id_city').show();
    }
  });

  /**
   *
   */
  $('#id_region').change(function () {
    var id_country = $('#id_country').val();
    var id_region = $('#id_region').val();
    $('#id_departement').empty();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_departement');
      $.getJSON('/geo/getdepartement.json', { r:id_region }, function (data) {
        $.each(data, function(departement_id, departement_name) {
          $('<option value="'+departement_id+'">'+departement_id+' - '+departement_name+'</option>').appendTo('#id_departement');
        });
      });
    }
  });

  /**
   *
   */
  $('#id_departement').change(function () {
    var id_country = $('#id_country').val();
    var id_departement = $('#id_departement').val();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_city');
      $.getJSON('/geo/getcity.json', { d:id_departement }, function (data) {
        $.each(data, function(city_id, city_name) {
          $('<option value="'+city_id+'">'+city_name+'</option>').appendTo('#id_city');
        });
      });
    }
  });
});
