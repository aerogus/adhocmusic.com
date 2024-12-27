/* global document, jQuery, location, XMLHttpRequest */

jQuery(document).ready(function ($) {

  'use strict';

  function deleteMessage(id, mode) {
    let params = 'mode=' + mode + '&id=' + id;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0)) {
        location.reload(true);
      }
    };
    xhr.open('POST', '/messagerie/delete.json', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Content-length', params.length);
    xhr.setRequestHeader('Connection', 'close');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(params);
  }

  $('.del-msg-to').click(function () {
    deleteMessage($(this).data('msg-id'), 'to');
  });

  $('.del-msg-from').click(function () {
    deleteMessage($(this).data('msg-id'), 'from');
  });

  $('#form-message-write').submit(function () {
    let valid = true;
    if ($('#text').val().length === 0) {
      $('#text').prev('.error').fadeIn();
      valid = false;
    } else {
      $('#text').prev('.error').fadeOut();
    }
    return valid;
  });

  $('#pseudo').keyup(function () {
    $.getJSON('/membres/autocomplete-pseudo.json', {
      q: $(this).val()
    }, function (data) {
      $('#suggests').empty();
      $('<ul>').appendTo('#suggests');
      $.each(data, function (key, val) {
        $('<li><a href="/messagerie/write?pseudo=' + encodeURIComponent(val.pseudo) + '">' + encodeURIComponent(val.pseudo) + '</li>').appendTo('#suggests');
      });
      $('</ul>').appendTo('#suggests');
    });
  });

});
