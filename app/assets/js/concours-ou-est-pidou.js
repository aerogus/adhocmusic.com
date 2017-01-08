$(function () {

  var map = $('#map');
  var modal = false;
  var x = null;
  var y = null;
  var age_du_capitaine = 588;
  var nombre_de_dieses_a_la_cle = 298;

  map.click(function (e) {
    if (modal) {
      return;
    }
    x = e.pageX - $(this).offset().left;
    y = e.pageY - $(this).offset().top;
    set_target(x, y);
    confirmation_box();
  });

  function set_target(x, y) {
console.log(x,y);
console.log(distance());
    $('.target')
      .css('top', y-16 + 'px')
      .css('left', x-16 + 'px')
      .show();
  }
  
  $('.yes').click(function (e) {
    e.stopPropagation();
    console.log('yes');
    $('.popup').hide();
    overlay();
    modal = false;
  });
  
  $('.no').click(function (e) {
    e.stopPropagation();
    console.log('no');
    $('.target').hide();
    $('.popup').hide();
    modal = false;
  });

  function confirmation_box() {
    $('.popup')
      .css('top', y+10 + 'px')
      .css('left', x-20 + 'px')
      .css('display', 'inline-block');
    modal = true;
  }

  function overlay() {
    $('<div/>')
      .addClass('overlay')
      .appendTo(map);
  }

  function distance() {
    var dx = Math.abs(x - age_du_capitaine);
    var dy = Math.abs(y - nombre_de_dieses_a_la_cle);
    return Math.sqrt(Math.pow(dx,2) + Math.pow(dy,2));
  }

});

