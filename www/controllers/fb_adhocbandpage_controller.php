<?php

class Controller
{
    // app

    public static function app_install()
    {
       mail('guillaume.seznec@gmail.com', 'adhocbandpage installed', 'adhocbandpage installed');
        return 'install OK';
    }

    public static function app_uninstall()
    {
        mail('guillaume.seznec@gmail.com', 'adhocbandpage uninstalled', 'adhocbandpage uninstalled');
        return 'uninstall OK';
    }

    public static function app_settings_change()
    {
        return 'settings change OK';
    }

    public static function app_welcome()
    {
        return 'welcome OK';
    }

    public static function app_help()
    {
        return 'help OK';
    }

    // canvas

    public static function canvas_home()
    {
        return self::canvas_index();
    }

    public static function canvas_index()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/index.tpl');
    }

    public static function canvas_about()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/about.tpl');
    }

    /**
     * page politique de confidentialité
     */
    public static function canvas_privacy()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/privacy.tpl');
    }

    /**
     * page conditions d'utilisation
     */
    public static function canvas_tos()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/tos.tpl');
    }

    public static function canvas_contact()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/contact.tpl');
    }

    public static function canvas_contact_submit()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/canvas/contact.tpl');
    }

    // tab

    public static function tab_home()
    {
        if($req = $_SESSION['fb']->getSignedRequest()) {
            if(!array_key_exists('page', $req)) {
                $req['page']['id'] = 42358826046;// ecore
            }
            if($id_groupe = Groupe::getIdByFacebookPageId($req['page']['id'])) {
                return self::tab_groupe($id_groupe);
            } else {
                return self::tab_unknown_groupe();
            }
        }

        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/tab/home.tpl');
    }

    public static function tab_success()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/tab/success.tpl');
    }

    public static function tab_unknown_groupe()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocbandpage/tab/unknown-groupe.tpl');
    }

    public static function tab_groupe($id_groupe)
    {
        $smarty = new AdHocSmarty();

        $groupe = Groupe::getInstance((int) $id_groupe);

        $smarty->assign('groupe', $groupe);

        $smarty->assign('audios', Audio::getAudios(array(
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        // concerts futurs
        $smarty->assign('f_events', Event::getEvents(array(
            'datdeb' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'DESC',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 50,
        )));

        // concerts passés
        $smarty->assign('p_events', Event::getEvents(array(
            'datfin' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'DESC',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 50,
        )));

        return $smarty->fetch('fb/adhocbandpage/tab/groupe.tpl');
    }
}
