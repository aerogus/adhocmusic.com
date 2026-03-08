/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

   $('#table').DataTable({
      paging: false,
      search: true,
      order: [], // pas de tri initial côté client
      language: {
          url: '/static/library/dataTables@2.3.6/fr_FR.json'
      },
      columnDefs: [
        { orderable: true, targets: [0,1,2,3,4] },
        { orderable: false, targets: '_all' }
      ]
  });

});
