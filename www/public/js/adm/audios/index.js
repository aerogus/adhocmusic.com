/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

   $('#table').DataTable({
      bLengthChange: false, // pas le choix du nombre d'éléments par page
      searching: false, // pas de bloc de recherche
      ajax: {
        url: '/adm/audios/dt.json',
        data: function (d) {
          d.length = 250;
        }
      },
      processing: true,
      serverSide: true,
      pageLength: 250,
      columns: [
        { data: 'id_audio' },
        { data: 'name' },
        { data: 'name' },
        { data: 'name' },
        { data: 'name' },
        { data: 'created_at' },
        { data: 'updated_at' },
      ],
      order: [], // pas de tri initial côté client
      language: {
          url: '/static/library/dataTables@2.3.6/fr_FR.json'
      },
      columnDefs: [
        { orderable: true, targets: '_all' }
      ]
  });

});
