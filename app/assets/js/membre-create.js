$(function() {

  $.ajaxSetup( { "async": false } );

  $('#email').focus(function() {
    $('#bubble_email').fadeIn();
  });

  $('#pseudo').focus(function() {
    $('#bubble_pseudo').fadeIn();
  });

  $('#pseudo').blur(function() {
    if($(this).val().length > 2) {
      // check dispo du pseudo
      var pseudo = $('#pseudo').val();
      $.getJSON('/auth/check-pseudo.json', { pseudo:pseudo }, function(data) {
        if(data.status == 'KO_PSEUDO_UNAVAILABLE') {
          $('#error_pseudo_unavailable').fadeIn();
        }
        if(data.status == 'OK') {
          $('#error_pseudo_unavailable').fadeOut();
        }
      });
    }
  });

  $('#email').blur(function() {
    if($(this).val().length > 2) {
      // check existence email
      var email = $('#email').val();
      $.getJSON('/auth/check-email.json', { email:email }, function(data) {
        if(data.status == 'KO_INVALID_EMAIL') {
            $('#error_invalid_email').fadeIn();
            $('#error_already_member').fadeOut();
        }
        if(data.status == 'KO_ALREADY_MEMBER') {
            $('#error_invalid_email').fadeOut();
            $('#error_already_member').fadeIn();
        }
        if(data.status == 'OK') {
            $('#error_invalid_email').fadeOut();
            $('#error_already_member').fadeOut();
        }
      });
    }
  });

  $('#id_country').keypress(function() {
    $('#id_country').trigger('change');
  });

  $('#id_region').keypress(function() {
    $('#id_region').trigger('change');
  });

  $('#id_departement').keypress(function() {
    $('#id_departement').trigger('change');
  });

  $('#id_country').change(function() {
    var id_country = $('#id_country').val();
    var membre_id_region = '{$data.id_region}';
    $('#id_region').empty();
    $('#id_departement').empty();
    $('#id_city').empty();
    $('<option value="0">---</option>').appendTo('#id_region');
    $.getJSON('/geo/getregion.json', { c:id_country }, function(data) {
      var selected = '';
      $.each(data, function(region_id, region_name) {
        if(membre_id_region == region_id) { selected = ' selected="selected"'; } else { selected = ''; }
        $('<option value="'+region_id+'"'+selected+'>'+region_name+'</option>').appendTo('#id_region');
      });
    });
    if(id_country != 'FR') {
        $('#id_departement').hide();
        $('#id_city').hide();
    } else {
        $('#id_departement').show();
        $('#id_city').show();
    }
  });

  $('#id_region').change(function() {
    var id_country = $('#id_country').val();
    var id_region = $('#id_region').val();
    var membre_id_departement = '{$data.id_departement}';
    $('#id_departement').empty();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_departement');
      $.getJSON('/geo/getdepartement.json', { r:id_region }, function(data) {
        var selected = '';
        $.each(data, function(departement_id, departement_name) {
          if(membre_id_departement == departement_id) { selected = ' selected="selected"'; } else { selected = ''; }
          $('<option value="'+departement_id+'"'+selected+'>'+departement_id+' - '+departement_name+'</option>').appendTo('#id_departement');
        });
      });
    }
  });

  $('#id_departement').change(function() {
    var id_country = $('#id_country').val();
    var id_departement = $('#id_departement').val();
    $('#id_city').empty();
    if(id_country == 'FR') {
      $('<option value="0">---</option>').appendTo('#id_city');
      $.getJSON('/geo/getcity.json', { d:id_departement }, function(data) {
        $.each(data, function(city_id, city_name) {
          $('<option value="'+city_id+'">'+city_name+'</option>').appendTo('#id_city');
        });
      });
    }
  });

  $('#form-member-create').submit(function() {
    var validate = true;
    if($('#pseudo').val() == "") {
      $('#pseudo').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#pseudo').prev('.error').fadeOut();
    }
    if($('#email').val() == "" || validateEmail($('#email').val()) == 0) {
      $('#email').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#email').prev('.error').fadeOut();
    }
    if($('#last_name').val() == "") {
      $('#last_name').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#last_name').prev('.error').fadeOut();
    }
    if($('#first_name').val() == "") {
      $('#first_name').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#first_name').prev('.error').fadeOut();
    }
    if($('#id_country').val() == 0) {
      $('#id_country').prev('.error').fadeIn();
      validate = false;
    } else {
      $('#id_country').prev('.error').fadeOut();
    }
    return validate;
  });

  $('#id_country').trigger('change');
  $('#id_region').trigger('change');
  $('#id_departement').trigger('change');

});
