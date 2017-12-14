$(function () {

  var map = $('#map');
  var played = false;
  var modal = false;
  var x = null;
  var y = null;
  var age_du_capitaine = 588;
  var nombre_de_dieses_a_la_cle = 298;

  map.click(function (e) {
    if (modal || played) {
      return;
    }
    x = e.pageX - $(this).offset().left;
    y = e.pageY - $(this).offset().top;
    set_target(x, y);
    confirmation_box();
  });

  // positionne la cible
  function set_target(x, y) {
    $('.target')
      .css('top', y-16 + 'px')
      .css('left', x-16 + 'px')
      .show();
  }

  // click sur confirmer
  $('.yes').click(function (e) {
    e.stopPropagation();
    $('.popup').hide();
    push_participation();
    overlay();
    modal = false;
  });

  // click sur annuler
  $('.no').click(function (e) {
    e.stopPropagation();
    $('.target').hide();
    $('.popup').hide();
    $('#map').find('.overlay').remove();
    modal = false;
  });

  // affiche popup
  function confirmation_box() {
    $('.popup')
      .css('top', y+10 + 'px')
      .css('left', x-20 + 'px')
      .css('display', 'inline-block');
    modal = true;
  }

  // envoi la réponse
  function push_participation() {
    $.post('/concours/ou-est-pidou', {
      'x': x,
      'y': y,
      'd': distance(),
      'n': $('#conc_name').val(),
      'p': $('#conc_phone').val()
    }, function () {
      congrats();
      played = true;
    });
  }

  // surimpression carte ign
  function overlay() {
    $('<div/>')
      .addClass('overlay')
      .appendTo(map);
  }

  // affichage merci
  function congrats() {
    $('.congrats').show();
  }

  // calcul distance
  function distance() {
    var dx = Math.abs(x - age_du_capitaine);
    var dy = Math.abs(y - nombre_de_dieses_a_la_cle);
    return Math.sqrt(Math.pow(dx,2) + Math.pow(dy,2));
  }

});
