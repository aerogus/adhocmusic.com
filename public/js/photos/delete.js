/*globals jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('#form-photo-delete').submit(function () {
    return window.confirm('Confirmer la suppression de cette photo ?');
  });

});
