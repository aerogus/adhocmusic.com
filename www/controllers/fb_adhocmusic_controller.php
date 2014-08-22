<?php

class Controller
{
    // app

    public static function app_install()
    {
        mail('guillaume.seznec@gmail.com', 'adhoc installed', 'adhoc installed');
        return 'install OK';
    }

    public static function app_uninstall()
    {
        mail('guillaume.seznec@gmail.com', 'adhoc uninstalled', 'adhoc uninstalled');
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

    public static function canvas_index()
    {
        if(!self::isFan())
            return self::canvas_landing();

        if($id_contact = self::isAdHocMember()) {
            $membre = Membre::getInstance($id_contact);
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'home');
        $smarty->assign('featured', Featured::getFeaturedHomepage());
        return $smarty->fetch('fb/adhocmusic/canvas/index.tpl');
    }

    public static function canvas_landing()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'home');
        return $smarty->fetch('fb/adhocmusic/tab/home.tpl');
    }

    public static function canvas_news()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'news');

        $smarty->assign('newslist', News::getNewsList(array(
            'online' => true,
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'  => 0,
            'limit'  => 3,
        )));

        return $smarty->fetch('fb/adhocmusic/canvas/news.tpl');
    }

    public static function canvas_assoce()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'assoce');
        return $smarty->fetch('fb/adhocmusic/canvas/assoce.tpl');
    }

    public static function canvas_events()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'agenda');

        $evts = Event::getEvents(array(
            'datdeb'      => date('Y-m-d'),
            'departement' => '91',
            'sort'        => 'date',
            'sens'        => 'ASC',
            'debut'       => 0,
            'limit'       => 500,
        ));

        foreach($evts as $key => $evt)
        {
            $flyer = false;
            if(file_exists(ADHOC_ROOT_PATH . '/static/media/event/'.$evt['id'].'.jpg')) {
                $flyer = '<img src="'.$evt['flyer_100_url'].'" url="/event/show/' . $evt['id'] . '" />'."\n";
            }
            $evts[$key]['flyer'] = $flyer;
        }

        $smarty->assign('evts', $evts);

        return $smarty->fetch('fb/adhocmusic/canvas/events.tpl');
    }

    public static function canvas_event()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'agenda');
        $smarty->assign('event', Event::getInstance((int) $id));
        return $smarty->fetch('fb/adhocmusic/canvas/event.tpl');
    }

    public static function canvas_groupes()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');

        $db = DataBase::getInstance();

        // on cherche les membres AD'HOC qui ont un groupe, et qui sont sur Facebook
        // @todo dans un objet MembreFacebook ?

        $sql = "SELECT DISTINCT `m`.`facebook_profile_id`, `m`.`last_name`, `m`.`first_name`, `a`.`id_groupe`, "
             . "`a`.`id_type_musicien`, `m`.`id_contact`, COUNT(*) AS `nb_photos` "
             . "FROM (`adhoc_membre` `m`, `adhoc_appartient_a` `a`) "
             . "LEFT JOIN `adhoc_est_marque_sur` `e` ON (`a`.`id_contact` = `e`.`id_contact`) "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` "
             . "AND `m`.`facebook_profile_id` > 0 "
             . "GROUP BY `a`.`id_groupe`, `e`.`id_contact` "
             . "ORDER BY `a`.`id_groupe` ASC";

        $res = $db->queryWithFetch($sql);

        $grpmbr = array();
        $cpt = 0;
        foreach($res as $membre) {
            if(!array_key_exists($membre['id_groupe'], $grpmbr)) {
                $grpmbr[$membre['id_groupe']] = array();
            }
            $grpmbr[$membre['id_groupe']][$cpt] = $membre;
            $grpmbr[$membre['id_groupe']][$cpt]['type_musicien_name'] = Membre::getTypeMusicienName($membre['id_type_musicien']);
            $cpt++;
        }

        $smarty->assign('groupes', Groupe::getGroupes(array(
            'online' => true,
            'sort'   => 'name',
            'sens'   => 'ASC',
            'limit'  => false,
        )));

        return $smarty->fetch('fb/adhocmusic/canvas/groupes.tpl');
    }

    public static function canvas_groupe()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');

        $groupe = Groupe::getInstance((int) $id);

        $smarty->assign('groupe', $groupe);

        $smarty->assign('audios', Audio::getAudios(array(
            'sort'   => 'random',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        $smarty->assign('photos', Photo::getPhotos(array(
            'sort'   => 'random',
            'limit'  => 100,
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        return $smarty->fetch('fb/adhocmusic/canvas/groupe.tpl');
    }

    public static function canvas_profil()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'membres');
        $mbr = Membre::getInstance((int) $id);
        $smarty->assign('mbr', $mbr);
        return $smarty->fetch('fb/adhocmusic/canvas/profil.tpl');
    }

    public static function canvas_lieux()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'lieux');
        $smarty->assign('lieux', Lieu::getLieuxByDep('91'));
        return $smarty->fetch('fb/adhocmusic/canvas/lieux.tpl');
    }

    public static function canvas_lieu()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'lieux');
        $smarty->assign('lieu', Lieu::getInstance($id));
        return $smarty->fetch('fb/adhocmusic/canvas/lieu.tpl');
    }

    public static function canvas_photo()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'agenda');

        if($photo = Photo::getInstance((int) $id)) {

            $photo['who'] = '';
            $first = true;
            if(is_array($photo['tag']) && count($photo['tag'])) {
                foreach($photo['tag'] as $who) {
                    if(!$first) { $photo['who'] .= ', '; }
                    $photo['who'] .= '<a href="?m=profil&id='.$who['id_contact'].'"><strong>'.$who['pseudo'].'</strong></a>';
                    $first = false;
                }
            }

            $smarty->assign('photo', $photo);

            if($photo->getIdGroupe()) {
                $groupe = Groupe::getInstance($photo->getIdGroupe());
                $smarty->assign('groupe', $groupe);
            }

            if($photo->getIdEvent()) {
                $event = Membre::getInstance($photo->getIdEvent());
                $smarty->assign('event', $event);
            }

            if($photo->getIdLieu()) {
                $lieu = Lieu::getInstance($photo->getIdLieu());
                $smarty->assign('lieu', $lieu);
            }

            if($photo->getIdContact()) {
                $membre = Membre::getInstance($photo->getIdContact());
                $smarty->assign('membre', $membre);
            }

        } else {

            $smarty->assign('error', "Photo introuvable");

        }

        return $smarty->fetch('fb/adhocmusic/canvas/photo.tpl');
    }

    public static function canvas_quiz()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'quiz');

        $groupes = FacebookQuiz::getGroupes();
        $smarty->assign('groupes', $groupes);

        $etape = 1;
        if(isset($_GET['etape'])) {
            $etape = (int) $_GET['etape'];
        }
        $smarty->assign('etape', $etape);

        switch($etape)
        {
            /**
             * 1ère étape : sélection des 5 groupes
             */
            case 1:
            default:
                // rien de particulier
                break;

            /**
             * 2ème étape : position des 5 groupes + commentaire
             */
            case 2:
                if(!isset($_GET['grp'])) {
                    $smarty->assign('etape_2_erreur', true);
                } else if(count($_GET['grp']) != 5) {
                    $smarty->assign('etape_2_erreur', true);

                } else {
                    $rang = array(
                        1 => '1er',
                        2 => '2ème',
                        3 => '3ème',
                        4 => '4ème',
                        5 => '5ème',
                    );
                    $smarty->assign('rang', $rang);
                    $selgrps = array();
                    $cpt = 0;
                    foreach($_GET['grp'] as $id_groupe => $on) {
                        if($on != 'on') {
                            continue;
                        }
                        $selgrps[$cpt]['id'] = $id_groupe;
                        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $id_groupe . '.jpg')) {
                            $pic = 'http://static.adhocmusic.com/media/groupe/m' . $id_groupe . '.jpg';
                        } else {
                            $pic = 'http://static.adhocmusic.com/img/note_adhoc_64.png';
                        }
                        $selgrps[$cpt]['name'] = Groupe::getNameById($id_groupe);
                        $selgrps[$cpt]['pic'] = $pic;
                        $cpt++;
                    }
                    $smarty->assign('selgrps', $selgrps);
                }

                break;

            /**
             * 3ème étape : confirmation / validation
             */
            case 3:
                //break; // no break

            /**
             * 4ème étape : classement
             */
            case 4:
                $smarty->assign('votes', FacebookQuiz::getVotes());
                $smarty->assign('resultats', FacebookQuiz::getResults());
                break;
        }

        return $smarty->fetch('fb/adhocmusic/canvas/quiz.tpl');
    }

    public static function canvas_quiz_callback()
    {
        // gestion des ex-aequo ...
        $tmp = array();
        $pos = array();
        $grp = array();
        foreach($_POST['rang'] as $id_groupe => $position) {
            $tmp[$id_groupe] = array(
                'position' => $position,
                'id_groupe' => $id_groupe,
            );
            $pos[$id_groupe] = $position;
            $grp[$id_groupe] = $id_groupe;
        }
        array_multisort($pos, SORT_ASC, $grp, SORT_ASC, $tmp);

        $params = array();
        global $uid; // init dans le bootstrap
        $params['facebook_uid'] = $uid;
        $params['id_groupe_1']  = $tmp[0]['id_groupe'];
        $params['id_groupe_2']  = $tmp[1]['id_groupe'];
        $params['id_groupe_3']  = $tmp[2]['id_groupe'];
        $params['id_groupe_4']  = $tmp[3]['id_groupe'];
        $params['id_groupe_5']  = $tmp[4]['id_groupe'];

        $g1 = Groupe::getInstance($params['id_groupe_1']);
        $g2 = Groupe::getInstance($params['id_groupe_2']);
        $g3 = Groupe::getInstance($params['id_groupe_3']);
        $g4 = Groupe::getInstance($params['id_groupe_4']);
        $g5 = Groupe::getInstance($params['id_groupe_5']);

        FacebookQuiz::addVote($params);

        // todo: utiliser les méthodes de l'objet Groupe
        $img = array();
        $img[1] = FB_APP_DEFAUT_AVATAR_GROUPE;
        $img[2] = FB_APP_DEFAUT_AVATAR_GROUPE;
        $img[3] = FB_APP_DEFAUT_AVATAR_GROUPE;
        $img[4] = FB_APP_DEFAUT_AVATAR_GROUPE;
        $img[5] = FB_APP_DEFAUT_AVATAR_GROUPE;
        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $params['id_groupe_1'] . '.jpg')) {
            $img[1] = 'http://static.adhocmusic.com/media/groupe/m' . $params['id_groupe_1'] . '.jpg';
        }
        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $params['id_groupe_2'] . '.jpg')) {
            $img[2] = 'http://static.adhocmusic.com/media/groupe/m' . $params['id_groupe_2'] . '.jpg';
        }
        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $params['id_groupe_3'] . '.jpg')) {
            $img[3] = 'http://static.adhocmusic.com/media/groupe/m' . $params['id_groupe_3'] . '.jpg';
        }
        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $params['id_groupe_4'] . '.jpg')) {
            $img[4] = 'http://static.adhocmusic.com/media/groupe/m' . $params['id_groupe_4'] . '.jpg';
        }
        if(file_exists(ADHOC_ROOT_PATH . '/static/media/groupe/m' . $params['id_groupe_5'] . '.jpg')) {
            $img[5] = 'http://static.adhocmusic.com/media/groupe/m' . $params['id_groupe_5'] . '.jpg';
        }

        $tpl_data = array(
            'images' => array(
                array('src' => $img[1], 'href' => $g1->getUrl()),
                array('src' => $img[2], 'href' => $g2->getUrl()),
                array('src' => $img[3], 'href' => $g3->getUrl()),
                array('src' => $img[4], 'href' => $g4->getUrl()),
                array('src' => $img[5], 'href' => $g5->getUrl()),
            )
        );

        $first = true;
        $body  = '';
        for($cpt = 1 ; $cpt <= 5 ; $cpt++) {
            if(!$first) { $body .= ', '; }
            $g = 'g' . $cpt;
            $body .= '<a href="' . $$g->getUrl() . '"> ' . $$g->getName() . '</a>';
            $first = false;
        }

        $feed = array(
            'title_template' => "{actor} a choisi ses groupes AD'HOC préférés",
            'template_data'  => $tpl_data,
            'template_id'    => FB_APP_TEMPLATE_BUNDLE_ID,
            'body_general'   => $body,
        );

        $publish = array(
            'method'  => 'feedStory',
            'content' => array(
                'feed' => $feed,
                'next' => FB_APP_ROOT_URL . '/quiz.html?etape=3',
        ));

        return $publish;
    }

    public static function canvas_about()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'about');
        return $smarty->fetch('fb/adhocmusic/canvas/about.tpl');
    }

    public static function canvas_inscrip()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'inscrip');
        return $smarty->fetch('fb/adhocmusic/canvas/inscrip.tpl');
    }

    public static function canvas_inscrip_submit()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'inscrip');
        return $smarty->fetch('fb/adhocmusic/canvas/inscrip.tpl');
    }

    /**
     * page conditions d'utilisation
     */
    public static function canvas_tos()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocmusic/canvas/tos.tpl');
    }

    /**
     * page politique de confidentialité
     */
    public static function canvas_privacy()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocmusic/canvas/privacy.tpl');
    }

    public static function canvas_contact()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocmusic/canvas/contact.tpl');
    }

    public static function canvas_contact_submit()
    {
        $smarty = new AdHocSmarty();
        return $smarty->fetch('fb/adhocmusic/canvas/contact.tpl');
    }

    // tab

    public static function tab_home()
    {
        $data = self::getSignedRequest();

        if($data['page']['liked'] == false)
            return self::tab_landing();

        return self::tab_news();
    }

    public static function tab_landing()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'home');

        return $smarty->fetch('fb/adhocmusic/tab/home.tpl');
    }

    public static function tab_news()
    {
        if(!self::isFan())
            return self::tab_landing();

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'news');

        $smarty->assign('newslist', News::getNewsList(array(
            'online' => true,
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'  => 0,
            'limit'  => 1,
        )));

       return $smarty->fetch('fb/adhocmusic/tab/news.tpl');
    }

    public static function tab_assoce()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'assoce');

        return $smarty->fetch('fb/adhocmusic/tab/assoce.tpl');
    }

    public static function tab_groupes()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');

        $smarty->assign('liste_groupes', Groupe::getGroupesByName());

        return $smarty->fetch('fb/adhocmusic/tab/groupes.tpl');
    }

    public static function tab_groupe()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'groupes');

        $groupe = Groupe::getInstance((int) $id);

        $smarty->assign('groupe', $groupe);

        $smarty->assign('audios', Audio::getAudios(array(
            'sort'   => 'random',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        $smarty->assign('f_events', Event::getEvents(array(
            'datdeb' => date('Y-m-d H:i:s'),
            'sort'   => 'date',
            'sens'   => 'DESC',
            'groupe' => (int) $groupe->getId(),
            'online' => true,
            'limit'  => 50,
        )));

        $smarty->assign('photos', Photo::getPhotos(array(
            'sort'   => 'random',
            'limit'  => 100,
            'groupe' => (int) $groupe->getId(),
            'online' => true,
        )));

        return $smarty->fetch('fb/adhocmusic/tab/groupe.tpl');
    }

    public static function tab_articles()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'articles');

        $articles = Article::getArticles(array(
            'online' => true,
            'sort'   => 'created_on',
            'sens'   => 'DESC',
            'debut'   => 0,
            'limit'   => 200,
        ));

        $smarty->assign('articles', $articles);

        return $smarty->fetch('fb/adhocmusic/tab/articles.tpl');
    }

    public static function tab_article()
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'articles');

        try {
            $article = Article::getInstance((int) $id);
        } catch(AdHocUserException $e) {
        }

        $smarty->assign('article', $article);

        return $smarty->fetch('fb/adhocmusic/tab/article.tpl');
    }

    public static function tab_events()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'events');

        return $smarty->fetch('fb/adhocmusic/tab/events.tpl');
    }

    public static function tab_event()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'events');

        return $smarty->fetch('fb/adhocmusic/tab/event.tpl');
    }

    public static function tab_lieux()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'lieux');

        return $smarty->fetch('fb/adhocmusic/tab/lieux.tpl');
    }

    public static function tab_lieu()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'lieux');

        return $smarty->fetch('fb/adhocmusic/tab/lieu.tpl');
    }

    public static function tab_about()
    {
        $smarty = new AdHocSmarty();

        $smarty->assign('menuselected', 'about');

        return $smarty->fetch('fb/adhocmusic/tab/about.tpl');
    }

    public static function tab_concours_index()
    {
        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'concours');
        $smarty->assign('concours', Concours::getActifs());
        return $smarty->fetch('fb/adhocmusic/tab/concours/index.tpl');
    }

    public static function tab_concours_show()
    {
        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");
        $trail->addStep($concours->getTitle(), "/concours/show/" . $concours->getId());

        $member = true;
        if(!($id_contact = self::isAdHocMember())) {
            $member = false;
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'concours');
        $smarty->assign('title', $concours->getTitle());
        $smarty->assign('description', "Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");
        $smarty->assign('concours', $concours);
        $smarty->assign('member', $member);
        return $smarty->fetch('fb/adhocmusic/tab/concours/show.tpl');
    }

    public static function tab_concours_play()
    {
        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $trail = Trail::getInstance();
        $trail->addStep("Jeux Concours", "/concours/");
        $trail->addStep($concours->getTitle(), "/concours/show/" . $concours->getId());

        $smarty = new AdHocSmarty();
        $smarty->assign('menuselected', 'concours');
        $smarty->assign('title', $concours->getTitle());
        $smarty->assign('description', "Jeux Concours - CDs et Places de Concerts à Gagner !");
        $smarty->assign('keywords', "musique, essonne, epinay sur orge, epinay");
        $smarty->assign('concours', $concours);
        $smarty->assign('show_form', true);

        $member = true;
        if(!($id_contact = self::isAdHocMember())) {
            $member = false;
        }
        $smarty->assign('member', $member);

        return $smarty->fetch('fb/adhocmusic/tab/concours/play.tpl');
    }

    public static function tab_concours_play_submit()
    {
        $id = (int) Route::params('id');

        $concours = new Concours($id);

        $smarty = new AdHocSmarty();

        $id_contact = self::isAdHocMember();

        $member = true;
        if(!($id_contact = self::isAdHocMember())) {
            $member = false;
        }
        $smarty->assign('member', $member);

        if(!$id_contact) {
            die('désolé, compte adhoc introuvable. vous devez avoir un compte adhoc valide sur adhocmusic.com pour jouer au jeu');
        }

        $nb_qr = $concours->getQrCount();

        try {
            $concours->addParticipant($id_contact, $_SESSION['ip'], $_SESSION['host']);
            for($i = 1 ; $i <= $nb_qr ; $i++)
            {
                $field_name = 'q' . $i;
                $concours->addReponse($id_contact, $i, (int) Route::params($field_name));
            }
            $smarty->assign('show_congrats', true);
        }
        catch(Exception $e) {
            $smarty->assign('error', 'already_played');
        }

        $smarty->assign('concours', $concours);
        $smarty->assign('menuselected', 'concours');
        return $smarty->fetch('fb/adhocmusic/tab/concours/play.tpl');
    }

    /**
     * fan de la page facebook.com/adhocmusic ?
     * @return bool
     * @deprecated
     */
    protected static function isFanOldMethod()
    {
        $data = self::getSignedRequest();

        if (empty($data["page"]["liked"])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * fan de la page facebook.com/adhocmusic ?
     * @return bool
     */
    protected static function isFan($page_id = null)
    {
        $data = self::getSignedRequest();

        if(is_null($page_id)) {
            $page_id = FB_FAN_PAGE_ID;
        }

        try {
            $likes = $_SESSION['fb']->api('/me/likes/' . $page_id);
            if(!empty($likes['data'])) {
                return true;
            } else {
                return false;
            }
        }
        catch(FacebookApiException $e) {
            // si pas loggué
            return false;
        }
    }

    /**
     * utilisateur facebook loggué ?
     * @return bool
     */
    protected static function isAuth()
    {
        if($_SESSION['fb']->getUser()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * retourne si un membre facebook loggué est aussi un membre adhoc
     * si oui retourne son id_contact, sinon 0
     * @return int
     */
    protected static function isAdHocMember()
    {
        if(!self::isAuth())
            return false;

        return (int) Membre::getIdContactByFacebookProfileId($_SESSION['fb']->getUser());
    }

    /**
     *
     */
    protected static function checkFbAuth()
    {
        $data = self::getSignedRequest();
        if (empty($data["user_id"])) {
            echo("<script>top.location.href='" . $_SESSION['fb']->getLoginUrl() . "'</script>");
        } else {
            echo ("Welcome User: " . $data["user_id"]);
        }
    }

    /**
     * return @array
     */
    protected static function getSignedRequest()
    {
        if(empty($_REQUEST['signed_request'])) {
            return false;
        }

        $signed_request = $_REQUEST["signed_request"];
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
        return $data;
    }
}
