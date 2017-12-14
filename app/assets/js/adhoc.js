/*global jQuery, window, screen, alert */

var adhoc = {

  init: function () {
    adhoc.scrollToTop();
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
      }
      if ($(window).scrollTop() < 150) {
        toUp.fadeOut();
      }
    });
  },

  autoScroll: function (callback) {
    var body;
    if ($.browser.webkit) {
      body = $('body');
    } else {
      body = $('html');
    }

    body.stop().animate({
      scrollTop: 0
    }, 600, function () {
      if (typeof callback === 'function') {
        callback.call(this);
      }
    });
  }

};

function validateEmail(email) {
  //var re = /^[a-z0-9._-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$/;
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

function popup(page, name, popupwidth, popupheight) {
  // screen ?
  var coordleftpopup = Math.floor((screen.width / 2)  - (popupwidth / 2));
  var coordtoppopup  = Math.floor((screen.height / 2) - (popupheight / 2));
  var param = 'width=' + popupwidth + ',height=' + popupheight + ',left=' + coordleftpopup + ',top=' + coordtoppopup + ',scrollbars=no';
  var w = window.open(page, name, param);
  w.focus();
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

  // login box
  $('#boxlogin-outter').find('span').hover(function () {
    $('#boxlogin-inner').show();
  });
  $('#boxlogin-inner').find('.boxtitle span').hover(function () {
    $('#boxlogin-inner').hide();
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
