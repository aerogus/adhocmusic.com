/*global jQuery, window, alert */

var adhoc = {

  init: function () {
    adhoc.menu();
    adhoc.scrollToTop();
  },

  menu: function () {
    var menuSelected = false;
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
    var toUp = $('#up');

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
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
}

function toggleDiv(id) {
  var div = document.getElementById(id);
  if (div.style.display === 'none') {
    div.style.display = 'block';
  } else {
    div.style.display = 'none';
  }
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

  // thumbnail photo et video
  $('.thumb-80').hover(function () {
    $(this).children('.overlay-80').css('visibility', 'visible');
  }, function () {
    $(this).children('.overlay-80').css('visibility', 'hidden');
  });

  $('#form-login').submit(function () {
    var valid = true;
    if (!$('#login-pseudo').val().length) {
      $('#login-pseudo').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#login-pseudo').prev('.error').fadeOut();
    }
    if (!$('#login-password').val().length) {
      $('#login-password').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#login-password').prev('.error').fadeOut();
    }
    return valid;
  });

});
