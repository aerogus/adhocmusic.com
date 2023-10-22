<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\AdHocSmarty;
use Adhoc\Model\Trail;

/**
 *
 */
final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/messagerie.js');

        $smarty->assign('sent', (bool) Route::params('sent'));

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie');

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`id_from`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_from` = `m`.`id_contact` "
             . "AND `p`.`id_to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC";

        $smarty->assign('inbox', $db->queryWithFetch($sql));

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`id_to`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_to` = `m`.`id_contact` "
             . "AND `p`.`id_from` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_from` = FALSE "
             . "ORDER BY `p`.`date` DESC";

        $smarty->assign('outbox', $db->queryWithFetch($sql));

        return $smarty->fetch('messagerie/index.tpl');
    }

    /**
     * @return string
     */
    public static function read(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/messagerie.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie', '/messagerie')
            ->addStep('Lire un message');

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`pseudo`, `p`.`id_from`, `p`.`id_to`, `p`.`date`, `p`.`read_to`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_from` = `m`.`id_contact` "
             . "AND `p`.`id_pm` = " . (int) $id . " "
             . "AND `p`.`del_to` = FALSE "
             . "AND (`p`.`id_from` = " . (int) $_SESSION['membre']->getId() . " OR `p`.`id_to` = " . (int) $_SESSION['membre']->getId() . ")";

        $msg = $db->queryWithFetchFirstRow($sql);
        $smarty->assign('msg', $msg);

        $smarty->assign('pseudo_to', $msg['pseudo']);
        $smarty->assign('id_to', $msg['id_from']);
        $smarty->assign('id_from', $_SESSION['membre']->getId());

        $sql = "UPDATE `adhoc_messagerie` "
             . "SET `read_to` = 1 "
             . "WHERE `id_pm` = " . (int) $id;

        $db->query($sql);

        return $smarty->fetch('messagerie/read.tpl');
    }

    /**
     * @return string
     */
    public static function write(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->enqueueScript('/js/messagerie.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie', '/messagerie')
            ->addStep('Écrire un message');

        if (Tools::isSubmit('form-message-write')) {
            $text = (string) Route::params('text');
            $to = (int) Route::params('to');

            $db = DataBase::getInstance();

            $sql = "INSERT INTO `adhoc_messagerie` "
                 . "(`id_from`, `id_to`, `text`, `date`) "
                 . "VALUES (" . (int) $_SESSION['membre']->getId() . ", " . (int) $to . ", '" . $db->escape($text) . "', NOW())";

            $db->query($sql);

            $dest = Membre::getInstance($to);

            $data = [
                'pseudo_from' => $_SESSION['membre']->getPseudo(),
                'pseudo_to' => $dest->getPseudo(),
                'text' => $text,
            ];

            if (Email::send($dest->getEmail(), "Vous avez reçu un message privé", 'message-received', $data)) {
                Log::action(Log::ACTION_MESSAGE, $to);
                Tools::redirect('/messagerie/?sent=1');
            } else {
                $smarty->assign('error', "erreur envoi email");
                return $smarty->fetch('messagerie/write.tpl');
            }
        }

        $pseudo = (string) Route::params('pseudo');
        if (!($id = Membre::getIdByPseudo($pseudo))) {
            die('KO');
        }

        $smarty->assign('pseudo_to', $pseudo);
        $smarty->assign('id_to', $id);

        return $smarty->fetch('messagerie/write.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $db = DataBase::getInstance();

        $mode = (string) Route::params('mode');
        $id   = (int) Route::params('id');

        switch ($mode) {
            case "from":
                $champ = "del_from";
                break;
            case "to":
                $champ = "del_to";
                break;
            default:
                return ['status' => 'KO'];
                break;
        }

        $sql = "UPDATE `adhoc_messagerie` "
             . "SET `" . $champ . "` = TRUE "
             . "WHERE `id_pm` = " . (int) $id . " "
             . "AND (`id_from` = " . (int) $_SESSION['membre']->getId() . " "
             . "OR `id_to` = " . (int) $_SESSION['membre']->getId() . ")";

        $db->query($sql);

        return ['status' => 'OK'];
    }
}
