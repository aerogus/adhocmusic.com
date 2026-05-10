/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

   $('#table').DataTable({
      lengthChange: false, /* pas le choix du nombre d'éléments par page */
      searching: false, /* pas de bloc de recherche */
      pageLength: 250,
      order: [], // pas de tri initial côté client
      language: {
          url: '/static/library/dataTables@2.3.7/fr_FR.json'
      },
      columnDefs: [
        { orderable: true, targets: [0] },
        { orderable: false, targets: '_all' }
      ]
  });

});
