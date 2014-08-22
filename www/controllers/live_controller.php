<?php

define('IMAP_HOST', "ns0.ovh.net");
define('IMAP_USER', "live%40adhocmusic.com"); // urlencodé
define('IMAP_PASS', "squallpowa");
define('IMAP_URI', 'imap://' . IMAP_USER . ':' . IMAP_PASS . '@' . IMAP_HOST . ':143/INBOX');

class Controller
{
    public static function live()
    {
        $trail = Trail::getInstance();
        $trail->addStep("Retransmission du concert AD'HOC du Samedi 12 Mai 2012");

        $smarty = new AdHocSmarty();
        $smarty->assign('og_image', STATIC_URL . '/img/onair.jpg');
        $smarty->assign('title', "Suivez en Live le concert AD'HOC du Samedi 12 Mai 2012");
        $smarty->assign('description', "Venez chatter avec les membres AD'HOC, la communauté des musiciens et amateurs de musique en assistant en live aux concerts AD'HOC");
        $smarty->assign('menuselected', 'chat');

        if(Tools::isAuth()) {
            $smarty->assign('chat_enabled', true);
        } else {
            $_SESSION['redirect_after_auth'] = '/live';
        }

        $smarty->assign('width', '640');
        $smarty->assign('height', '360');
        $smarty->assign('html5', strstr($_SERVER['HTTP_USER_AGENT'], "Firefox"));

        return $smarty->fetch('live.tpl');
    }

    public static function chat_get_online()
    {
        if(Tools::isAuth() === false) {
            return '';
        }

        $members = Chat::getOnline(array(
            'id_contact' => $_SESSION['membre']->getId(),
            'pseudo'     => $_SESSION['membre']->getPseudo(),
            'ip'         => $_SESSION['ip'],
            'host'       => $_SESSION['host'],
        ));

        $out = '';

        if(is_array($members))
        {
            $out .= '<ul>';
            foreach($members as $member)
            {
                $out .= '<li><a href="/membres/show/'. $member['id_contact'] . '"><strong>' . $member['pseudo'] . '</strong></a></li>';
            }
            $out .= '</ul>';
        }

        return $out;
    }

    public static function chat_get_last_messages()
    {
        if(Tools::isAuth() === false) {
            return '';
        }

        $messages = Chat::getLastMessages(17);

        $out = '';
        if(is_array($messages))
        {
            foreach($messages as $message)
            {
                $out .= date('H:i:s', (int) $message['ts']) . ' &lt;<strong>' . $message['pseudo'] . '</strong>&gt; ' . $message['message'] . "<br />\n";
            }
        }
        return $out;
    }

    public static function chat_send_message()
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $id_contact = (int) $_SESSION['membre']->getId();
        $pseudo     = (string) $_SESSION['membre']->getPseudo();
        $message    = trim((string) Route::params('message'));

        return Chat::sendMessage($id_contact, $pseudo, $message);
    }

    /**
     * traite tous les mails de la boite live@adhocmusic.com
     *
     * @see http://www.spicypeanut.net/mail_imap/index.html
     */
    public static function popage()
    {
        // PEAR fait plein de notice/deprecated
        error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

        require_once 'Mail/IMAPv2.php';

        $msg = new Mail_IMAPv2();

        $msg->connect(IMAP_URI, true);
        $msgcount = $msg->messageCount();

        Log::write('popage', "Connexion IMAP à live@adhocmusic.com ", true);
        Log::write('popage', "Messages trouvés : " . $msgcount, true);

        for ($mid = 1 ; $mid <= $msgcount ; $mid++)
        {
            Log::write('popage', "analyse message " . $mid, true);

            $msg->getHeaders($mid);
            $msg->getParts($mid);

            if((int) $msg->header[$mid]['Size'] < 20000) {
                Log::write('popage', "Message " . $mid . " inférieur à 20 Ko => delete", true);
                $msg->delete($mid);
                continue;
            }

            $title = trim((string) $msg->header[$mid]['subject']);
            $credits = trim((string) $msg->header[$mid]['fetchfrom']);
            $email = trim((string) $msg->header[$mid]['from'][0]);
            $id_contact = (int) Membre::getIdByEmail($email);

            // todo log email provenance, compte membre trouvé ...
            Log::write('popage', "Titre : " . $title, true);
            Log::write('popage', "Crédits : " . $credits, true);
            Log::write('email', "Email : " . $email, true);
            Log::write('id_contact', "Membre : " . $id_contact, true);

            $parts = array();

            // inline parts
            if (isset($msg->msg[$mid]['in']) && count($msg->msg[$mid]['in']) > 0) {
                foreach ($msg->msg[$mid]['in']['pid'] as $i => $inid) {
                    if((string) $msg->msg[$mid]['in']['ftype'][$i] == 'image/jpeg' &&
                       (int) $msg->msg[$mid]['in']['fsize'][$i] > 20000) {
                        $parts[] = $inid;
                        Log::write('popage', "JPEG 'inline' trouvé : " . $msg->msg[$mid]['in']['fsize'][$i] . " octets", true);
                    }
                }
            }

            // attachments parts
            if (isset($msg->msg[$mid]['at']) && count($msg->msg[$mid]['at']) > 0) {
                foreach ($msg->msg[$mid]['at']['pid'] as $i => $atid) {
                    if((string) $msg->msg[$mid]['at']['ftype'][$i] == 'image/jpeg' &&
                       (int) $msg->msg[$mid]['at']['fsize'][$i] > 20000) {
                        $parts[] = $atid;
                        Log::write('popage', "JPEG 'attachment' trouvé : " . $msg->msg[$mid]['at']['fsize'][$i] . " octets", true);
                    }
                }
            }

            foreach($parts as $pid) {

                Log::write('popage', "parsing msg " . $mid . "  part " . $pid, true);

                $body = $msg->getBody($mid, $pid);

                $tmpImg = ADHOC_ROOT_PATH . '/from-live/' . md5(time() . rand());
                $ok = file_put_contents($tmpImg, $body['message'], LOCK_EX);

                $data = array(
                    'name' => $title,
                    'credits' => $credits,
                    'id_groupe' => 0,
                    'id_lieu' => 1,
                    'id_event' => 5602, // 5 mars 2011
                    'id_contact' => $id_contact,
                    'id_structure' => 0,
                    'online' => true,
                );

                $photo = Photo::init();
                $photo->setName($data['name']);
                $photo->setCredits($data['credits']);
                $photo->setIdGroupe($data['id_groupe']);
                $photo->setIdLieu($data['id_lieu']);
                $photo->setIdEvent($data['id_event']);
                $photo->setIdContact($data['id_contact']);
                $photo->setIdStructure($data['id_structure']);
                $photo->setOnline($data['online']);
                $photo->setCreatedNow();
                $photo->save();

                $objImg = new Image($tmpImg);
                $objImg->setType(IMAGETYPE_JPEG);
                $objImg->setMaxWidth(1024);
                $objImg->setMaxHeight(768);
                $objImg->setDestFile(ADHOC_ROOT_PATH . '/static/media/photo/' . $photo->getId() . '.jpg');
                $objImg->write();

                unlink($tmpImg);

                Log::action(Log::ACTION_PHOTO_CREATE, $id);

                $msg->unsetParts($mid);
                $msg->unsetHeaders($mid);

                $msg->delete($mid);

                Log::write('popage', "Effacement du message " . $mid);

            }

        }

        $msg->expunge();
        $msg->close();

        Log::write('popage', "Déconnexion IMAP", true);

        $smarty = new AdHocSmarty();
        $smarty->assign('log', Log::getLog());
        return $smarty->fetch('live/popage.tpl');
    }
}
