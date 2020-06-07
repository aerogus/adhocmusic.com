/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-audio-delete').submit(function () {
    return window.confirm('Confirmer la suppression de cet audio ?');
  });

});
