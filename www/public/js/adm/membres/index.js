/* global document, jQuery */

jQuery(document).ready(function ($) {

  'use strict';

   $('#table').DataTable({
      bLengthChange: false, /* pas le choix du nombre d'éléments par page */
      searching: false, /* pas de bloc de recherche */
      ajax: {
        url: '/adm/membres/dt.json',
        data: function (d) {
          d.pseudo = $('#pseudo').val();
          d.last_name = $('#last_name').val();
          d.first_name = $('#first_name').val();
          d.email = $('#email').val();
          d.length = 250;
        }
      },
      processing: true,
      serverSide: true,
      pageLength: 250,
      columns: [
        { data: 'id_contact' },
        { data: 'pseudo' },
        { data: 'last_name' },
        { data: 'first_name' },
        { data: 'email' },
        { data: 'created_at' },
        { data: 'updated_at' },
        { data: 'visited_at' },
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
