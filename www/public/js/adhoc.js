/* global $, document, jQuery, window, alert */

var adhoc = {

  init: function () {
    adhoc.menu();
    adhoc.scrollToTop();
  },

  menu: function () {
    let menuSelected = false;
    $('#btn-burger').click(function() {
      if (!menuSelected) {
        $(this).addClass('selected');
        $('.top-menu').addClass('selected');
        menuSelected = true;
      } else {
        $(this).removeClass('selected')
        $('.top-menu').removeClass('selected');
        menuSelected = false;
      }
    });
  },

  scrollToTop: function () {
    let toUp = $('#up');

    toUp.click(function () {
      adhoc.autoScroll();
      return false;
    });

    $(window).scroll(function () {
      if ($(window).scrollTop() > 150) {
        toUp.fadeIn();
      } else {
        toUp.fadeOut();
      }
    });
  },

  autoScroll: function (callback) {
    $('html,body').stop().animate({
      scrollTop: 0
    }, 600, function () {
      if (typeof callback === 'function') {
        callback.call(this);
      }
    });
  }

};

function validateEmail(email) {
  let re = /\S+@\S+\.\S+/;
  return re.test(email);
}

jQuery(document).ready(function ($) {

  'use strict';

  $('.nojs').hide();

  $('#form-newsletter').submit(function () {
    if ($('#email').val() === '' || validateEmail($('#email').val()) === 0) {
      alert('Précisez un email valide');
      return false;
    }
    return true;
  });

  adhoc.init();

  // menu
  $('ul#menu_haut li').hover(function () {
    $(this).find('ul').show();
  }, function () {
    $(this).find('ul').hide();
  });

});
