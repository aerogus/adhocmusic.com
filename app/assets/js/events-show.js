/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  function rsvp(id_event, action) {
    $.ajax({
      type: 'POST',
      url: 'https://graph.facebook.com/' + id_event + '/' + action,
      data: {
        access_token: $('#fb-access-token').val()
      }
    });
  }

  $('.fb-event-attending').click(function () {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'attending');
  });

  $('.fb-event-maybe').click(function () {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'maybe');
  });

  $('.fb-event-declined').click(function () {
    rsvp($(this).parent().attr('id').replace('fb-event-', ''), 'declined');
  });

});
