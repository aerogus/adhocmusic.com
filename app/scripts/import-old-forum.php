#!/usr/bin/php
<?php

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

/* 1 - IMPORT MAILING LIST ALL ARCHIVE 2002/2003 */

/*

$sql = "SELECT * from mailing_list ORDER BY id ASC";

$res = $db->queryWithFetch($sql);

$id_contacts = array(
    "guillaume.seznec@wanadoo.fr" => 1,
    "YOUDJE@aol.com" => 9, // on dit patrick ...
    "pendino.sylvain@wanadoo.fr" => 3,
    "Pouille.Yax@Wanadoo.fr" => 7,
    "guillaume@trias.fr" => 10,
    "michel.dechenaud@club-internet.fr" => 6,
    "pierre@arxeltribe.com" => 5,
    "cedricpereira1@hotmail.com" => 8,
    "gregory.chassot@free.fr" => 11,
    "Patrickrivers@aol.com" => 9,
    "vincent.pendino@wanadoo.fr" => 4,
    "dimitri@musicliveadhoc.com" => 2,
    "gregory.chassot@wanadoo.fr" => 11,
    "aissman@club-internet.fr" => 1151,
    "mpgerard@free.fr" => 5,
    "cedpereira@free.fr" => 8,
);

foreach($res as $msg) {

    echo $msg['id'] . "\n";
    
    $sql = "INSERT INTO adhoc_forum_prive_thread "
         . "(id_thread, created_on, modified_on, "
         . "created_by, modified_by, nb_messages, nb_views, subject) "
         . "VALUES (".(int) $msg['id'].", '".$msg['date']."', FALSE, "
         . (int) $id_contacts[$msg['email']].", 0, 1, 0, '" . $db->escape($msg['sujet']) . "')";

    $db->query($sql);
    echo $sql ."\n";

    $sql = "INSERT INTO adhoc_forum_prive_message "
         . "(id_message, id_thread, created_on, modified_on, created_by, modified_by, text) "
         . "VALUES (".(int) $msg['id'].",".(int) $msg['id'].",'".$msg['date']."', FALSE, ".(int) $id_contacts[$msg['email']].","
         . "0, '".$db->escape($msg['texte'])."')";

    $db->query($sql);
    echo $sql . "\n";

}

*/

/* 2 - IMPORT FORUM PRIVE 2003/2004 */

/*

$sql = "SELECT * FROM forum_prive WHERE id_parent = 0 ORDER BY id ASC";

$res = $db->queryWithFetch($sql);

// crea threads
foreach($res as $t) {

    // crea thread
    $sql = "INSERT INTO adhoc_forum_prive_thread "
         . "(created_on, modified_on, "
         . "created_by, modified_by, nb_messages, nb_views, subject) "
         . "VALUES ('".$t['date']."', '".$t['dateLast']."', "
         . $t['id_contact'] . ", " . $t['id_contactLast'] . ", 0, ".$t['visite'].", '" . $db->escape($t['sujet']) . "')";
    echo $sql . "\n";
    $db->query($sql);

    $id_thread = $db->insertId();

    // crea 1er message
    $sql = "INSERT INTO adhoc_forum_prive_message "
         . "(id_thread, created_on, modified_on, created_by, modified_by, text) "
         . "VALUES (".(int) $id_thread.",'".$t['date']."', FALSE, ".(int) $t['id_contact'].", 0, '".$db->escape($t['texte'])."')";
    echo $sql . "\n";
    $db->query($sql);

    $sql = "UPDATE adhoc_forum_prive_thread SET nb_messages = nb_messages + 1 WHERE id_thread = " . $id_thread;
    echo $sql . "\n";
    $db->query($sql);

    // recup et insert des reponses
    $sql = "SELECT * FROM forum_prive WHERE id_parent = " . $t['id'] . " ORDER BY id ASC";
    $msgs = $db->queryWithFetch($sql);
    foreach($msgs as $msg) {
         $sql = "INSERT INTO adhoc_forum_prive_message "
              . "(id_thread, created_on, modified_on, created_by, modified_by, text) "
              . "VALUES (".(int) $id_thread.",'".$msg['date']."', FALSE, ".(int) $msg['id_contact'].","
              . "0, '".$db->escape($msg['texte'])."')";
         echo $sql . "\n";
         $db->query($sql);

         $sql = "UPDATE adhoc_forum_prive_thread SET nb_messages = nb_messages + 1 WHERE id_thread = " . $id_thread;
         echo $sql . "\n";
         $db->query($sql);
    }
    
}

*/
