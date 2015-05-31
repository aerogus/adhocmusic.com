<?php

class Controller
{
    static function index()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('sent', (bool) Route::params('sent'));

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Messagerie");

        $db = DataBase::getInstance();

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`from`, `p`.`date`, `p`.`read`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`from` = `m`.`id_contact` "
             . "AND `p`.`to` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_to` = FALSE "
             . "ORDER BY `p`.`date` DESC";

        $smarty->assign('inbox', $db->queryWithFetch($sql));

        $sql = "SELECT `p`.`id_pm` AS `id`, `m`.`pseudo`, `p`.`to`, `p`.`date`, `p`.`read`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`to` = `m`.`id_contact` "
             . "AND `p`.`from` = " . (int) $_SESSION['membre']->getId() . " "
             . "AND `p`.`del_from` = FALSE "
             . "ORDER BY `p`.`date` DESC";

        $smarty->assign('outbox', $db->queryWithFetch($sql));

        return $smarty->fetch('messagerie/index.tpl');
    }

    static function read()
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Messagerie", "/messagerie/");
        $trail->addStep("Lire un message");

        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`pseudo`, `p`.`from`, `p`.`to`, `p`.`date`, `p`.`read`, `p`.`text` "
             . "FROM `adhoc_messagerie` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`from` = `m`.`id_contact` "
             . "AND `p`.`id_pm` = " . (int) $id . " "
             . "AND `p`.`del_to` = FALSE "
             . "AND (`p`.`from` = " . (int) $_SESSION['membre']->getId() . " OR `p`.`to` = " . (int) $_SESSION['membre']->getId() . ")";

        $msg = $db->queryWithFetchFirstRow($sql);
        $smarty->assign('msg', $msg);

        $smarty->assign('pseudo_to', $msg['pseudo']);
        $smarty->assign('id_to', $msg['from']);
        $smarty->assign('id_from', $_SESSION['membre']->getId());

        $sql = "UPDATE `adhoc_messagerie` "
             . "SET `read` = 1 "
             . "WHERE `id_pm` = " . (int) $id;

        $db->query($sql);

        return $smarty->fetch('messagerie/read.tpl');
    }

    static function write()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Tableau de bord", "/membres/tableau-de-bord");
        $trail->addStep("Messagerie", "/messagerie/");
        $trail->addStep("Ecrire un message");

        if(Tools::isSubmit('form-message-write'))
        {
            $text = (string) Route::params('text');
            $to = (int) Route::params('to');
    
            $db = DataBase::getInstance();
    
            $sql = "INSERT INTO `adhoc_messagerie` "
                 . "(`from`, `to`, `text`, `date`) "
                 . "VALUES (" . (int) $_SESSION['membre']->getId() . ", " . (int) $to . ", '" . $db->escape($text) . "', NOW())";
    
            $db->query($sql);
    
            $dest = Membre::getInstance($to);
 
            $data = array(
                'pseudo_from' => $_SESSION['membre']->getPseudo(),
                'pseudo_to' => $dest->getPseudo(),
                'text' => $text,
            );

            if(Email::send($dest->getEmail(), "Vous avez reçu un message privé", 'message-received', $data)) {
                Log::action(Log::ACTION_MESSAGE, $to);
                Tools::redirect('/messagerie/?sent=1');
            } else {
                $smarty->assign('error', "erreur envoi email");
                return $smarty->fetch('messagerie/write.tpl');
            }    
        }

        $pseudo = (string) Route::params('pseudo');
        if(!($id = Membre::getIdByPseudo($pseudo))) {
            die('KO');
        }

        $smarty->assign('pseudo_to', $pseudo);
        $smarty->assign('id_to', $id);

        return $smarty->fetch('messagerie/write.tpl');
    }

    static function delete()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $db = DataBase::getInstance();

        $mode = (string) Route::params('mode');
        $id   = (int) Route::params('id');

        switch($mode)
        {
            case "from":
                $champ = "del_from";
                break;
            case "to":
                $champ = "del_to";
                break;
            default:
                return array('status' => 'KO');
                break;
        }

        $sql = "UPDATE `adhoc_messagerie` "
             . "SET `" . $champ . "` = TRUE "
             . "WHERE `id_pm` = " . (int) $id . " "
             . "AND (`from` = " . (int) $_SESSION['membre']->getId() . " "
             . "OR `to` = " . (int) $_SESSION['membre']->getId() . ")";

        $db->query($sql);

        return array('status' => 'OK');
    }
}
