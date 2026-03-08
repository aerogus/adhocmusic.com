/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

   $('#table').DataTable({
      bLengthChange: false, /* pas le choix du nombre d'éléments par page */
      searching: false, /* pas de bloc de recherche */
      pageLength: 250,
      order: [], // pas de tri initial côté client
      language: {
          url: '/static/library/dataTables@2.3.6/fr_FR.json'
      },
      columnDefs: [
        { orderable: true, targets: '_all' }
      ]
  });

});
