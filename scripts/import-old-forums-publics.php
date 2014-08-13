#!/usr/bin/php
<?php

/* IMPORT FORUMS PUBLICS */

require_once 'common-cli.inc.php';

$db = DataBase::getInstance();

// "SELECT * from `_adhoc_forums` WHERE NOT `id_forum` REGEXP '[[:digit:]]+'" // que les thématiques
// "SELECT * from `_adhoc_forums` WHERE `id_forum` REGEXP '[[:digit:]]+'" // que les groupes

$sql = "SELECT * from `_adhoc_forums` WHERE NOT `id_forum` REGEXP '[[:digit:]]+' ORDER BY `id` ASC";

$msgs = $db->queryWithFetch($sql);

foreach($msgs as $msg)
{
    echo "message : " . $msg['id'] . "\n";

    if($msg['id_parent'] == 0) { // new thread

        $sql = "INSERT INTO `adhoc_forum_public_thread` "
             . "(`id_forum`, `id_thread`, "
             . "`created_on`, `created_by`, `created_by_name`, `created_by_email`, "
             . "`nb_views`, `subject`, `closed`, `online`) "
             . "VALUES ('" . $db->escape($msg['id_forum']) . "', " . (int) $msg['id'] . ", "
             . "'" . $db->escape($msg['date']) . "', " . (int) $db->escape($msg['id_contact']) . ", '" . $db->escape($msg['name']) . "', '" . $db->escape($msg['email']) . "', "
             . (int) $msg['visite'].", '" . $db->escape($msg['subject']) . "', " . (int) $msg['clos'] . ", " . (int) $msg['online'] . ")";
        $db->query($sql);
        echo $sql ."\n";

        $id_thread = (int) $msg['id'];
        $new_thread = true;

    } else { // pas new thread

        $id_thread = (int) $msg['id_parent'];
        $new_thread = false;

    }

    $sql = "INSERT INTO `adhoc_forum_public_message` "
         . "(`id_message`, `id_thread`, `created_on`, `modified_on`, "
         . "`created_by`, `modified_by`, `created_by_name`, `modified_by_name`, "
         . "`created_by_email`, `modified_by_email`, `text`, "
         . "`ip`, `host`) "
         . "VALUES (" . (int) $msg['id'] . ", " . (int) $id_thread . ",'" . $db->escape($msg['date']) . "', '" . $db->escape($msg['dateLast']) . "', "
         . (int) $msg['id_contact'] . ", " . (int) $msg['id_contactLast'] . ", '" . $db->escape($msg['name']) . "', '" . $db->escape($msg['nameLast']) . "', "
         . "'" . $db->escape($msg['email']) . "', '" . $db->escape($msg['emailLast']) . "', '" . $db->escape($msg['text']) . "', "
         . "'" . $db->escape($msg['ip']) . "', '" . $db->escape($msg['host']) . "')";

    $db->query($sql);
    echo $sql . "\n";

    $sql = "UPDATE `adhoc_forum_public_thread` "
         . "SET `nb_messages` = `nb_messages` + 1, "
         . "`modified_on` = '" . $db->escape($msg['date']) . "', "
         . "`modified_by` = " . (int) $msg['id_contact'] . ", "
         . "`modified_by_name` = '" . $db->escape($msg['name']) . "', "
         . "`modified_by_email` = '" . $db->escape($msg['email']) . "' "
         . "WHERE `id_thread` = " . (int) $id_thread;
    echo $sql . "\n";
    $db->query($sql);

    $sql = "UPDATE `adhoc_forum_public_info` "
         . "SET `nb_messages` = `nb_messages` + 1, "
         . "`id_contact` = " . (int) $msg['id_contact'] . ", "
         . "`date` = '" . $db->escape($msg['date']) . "' ";
    if($new_thread) {
        $sql .= ", `nb_threads` = `nb_threads` + 1 ";
    }
    $sql .= "WHERE `id_forum` = '" . $db->escape($msg['id_forum']) . "'";
    echo $sql . "\n";
    $db->query($sql);

    flush();
}
