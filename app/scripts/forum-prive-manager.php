#!/usr/bin/php
<?php

require_once __DIR__ . '/../config.php';

// id_contact à ajouter
$to_add = [
2819866
];

// ajouter des personnes aux forums privés
foreach (['a', 'b', 'e', 's', 't'] as $id_forum) {
  foreach ($to_add as $id_contact) {
    ForumPrive::addSubscriberToForum($id_contact, $id_forum);
  }
}

// retirer des personnes aux forums privés
//ForumPrive::delSubscriberToForum(3, 's');
/*
// id_contact à retirer
$to_del = [
];

foreach ($to_del as $id_contact) {
  $r = ForumPrive::delAllSubscriptions($id_contact);
  var_dump($r);
}
*/
