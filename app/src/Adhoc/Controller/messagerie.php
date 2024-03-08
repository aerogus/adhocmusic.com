<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Membre;
use Adhoc\Model\Message;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Email;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

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

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/messagerie.js');

        $twig->assign('sent', (bool) Route::params('sent'));

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie');

        $db = DataBase::getInstance();

        $inbox = Message::find([
            'id_to' => (int) $_SESSION['membre']->getId(),
            'del_to' => false,
            'order_by' => 'date',
            'sort' => 'DESC',
        ]);
        $twig->assign('inbox', $inbox);

        $outbox = Message::find([
            'id_from' => (int) $_SESSION['membre']->getId(),
            'del_from' => false,
            'order_by' => 'date',
            'sort' => 'DESC',
        ]);
        $twig->assign('outbox', $outbox);

        return $twig->render('messagerie/index.twig');
    }

    /**
     * @return string
     */
    public static function read(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/messagerie.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie', '/messagerie')
            ->addStep('Lire un message');

        $db = DataBase::getInstance();

        $msg = Message::getInstance($id);
        if ($msg->getDelTo() === true) {
            throw new \Exception('message effacé');
        } elseif (($msg->getIdFrom() !== (int) $_SESSION['membre']->getId()) && ($msg->getIdTo() !== (int) $_SESSION['membre']->getId())) {
            throw new \Exception('message introuvable');
        }
        $twig->assign('msg', $msg);

        $twig->assign('pseudo_to', Membre::getInstance($msg->getIdTo())->getPseudo());
        $twig->assign('id_to', $msg->getIdFrom());
        $twig->assign('id_from', $_SESSION['membre']->getId());

        $msg->setReadTo(true);
        $msg->save();

        return $twig->render('messagerie/read.twig');
    }

    /**
     * @return string
     */
    public static function write(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->enqueueScript('/js/messagerie.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Messagerie', '/messagerie')
            ->addStep('Écrire un message');

        if (Tools::isSubmit('form-message-write')) {
            $text = (string) Route::params('text');
            $to = (int) Route::params('to');

            $db = DataBase::getInstance();

            $msg = new Message();
            $msg->setIdFrom((int) $_SESSION['membre']->getId());
            $msg->setIdTo($to);
            $msg->setText($text);
            $msg->save();

            $dest = Membre::getInstance($to);

            $data = [
                'pseudo_from' => $_SESSION['membre']->getPseudo(),
                'pseudo_to' => $dest->getPseudo(),
                'text' => $text,
            ];

            if (Email::send($dest->getContact()->getEmail(), "Vous avez reçu un message privé", 'message-received', $data)) {
                Log::action(Log::ACTION_MESSAGE, (string) $to);
                Tools::redirect('/messagerie/?sent=1');
            } else {
                $twig->assign('error', "erreur envoi email");
                return $twig->render('messagerie/write.twig');
            }
        }

        $pseudo = (string) Route::params('pseudo');
        if (($id = Membre::getIdByPseudo($pseudo) === false)) {
            die('KO');
        }

        $twig->assign('pseudo_to', $pseudo);
        $twig->assign('id_to', $id);

        return $twig->render('messagerie/write.twig');
    }

    /**
     * @return array<string,string>
     */
    public static function delete(): array
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $db = DataBase::getInstance();

        $mode = (string) Route::params('mode');
        $id   = (int) Route::params('id');

        $msg = Message::getInstance($id);
        if (($msg->getIdFrom() !== (int) $_SESSION['membre']->getId()) && ($msg->getIdTo() !== (int) $_SESSION['membre']->getId())) {
            return ['status' => 'KO']; // pas le droit d'effacer les messages des autres
        } else {
            if ($mode === 'from') {
                $msg->setDelFrom(true);
            } elseif ($mode === 'to') {
                $msg->setDelTo(true);
            } else {
                return ['status' => 'KO']; // mode inconnu
            }
            $msg->save();
            return ['status' => 'OK'];
        }
    }
}
