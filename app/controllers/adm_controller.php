<?php

define('ADM_TAG_NB_TAGS_PER_PHOTO', 4);
define('ADM_TAG_NB_PHOTOS_PER_PAGE', 180);

define('ADM_NB_MEMBERS_PER_PAGE', 25);

define('ADM_NB_GROUPES_PER_PAGE', 1000);

define('ADM_NEWSLETTER_CURRENT_ID', 72);
define('ADM_NEWSLETTER_NB_EMAILS_PER_LOT', 400);
define('ADM_NEWSLETTER_GROUPE_CURRENT_ID', 37);

final class Controller
{
    static function index() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $trail = Trail::getInstance();
        $trail->addStep("Privé");

        $smarty->assign('forums', ForumPrive::getForums());

        $smarty->enqueue_script('https://p.trellocdn.com/embed.min.js');

        return $smarty->fetch('adm/index.tpl');
    }

    static function groupes_index() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $sens = (string) Route::params('sens');
        $sort = (string) Route::params('sort');

        if ($sens === 'DESC') {
            $sens = 'DESC';
            $sensinv = 'ASC';
        } else {
            $sens = 'ASC';
            $sensinv = 'DESC';
        }

        if (!$sort) {
            $sort = 'id_contact';
        }

        $page = (int) Route::params('page');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupes");

        $smarty = new AdHocSmarty();

        $groupes = Groupe::getGroupes(
            [
                'sort'  => $sort,
                'sens'  => $sens,
                'debut' => $page * ADM_NB_GROUPES_PER_PAGE,
                'limit' => ADM_NB_GROUPES_PER_PAGE,
            ]
        );

        $nb_groupes = Groupe::getGroupesCount(null, true);

        $smarty->assign('sensinv', $sensinv);
        $smarty->assign('groupes', $groupes);

        // pagination
        $smarty->assign('page', $page);
        $smarty->assign('nb_items', $nb_groupes);
        $smarty->assign('nb_items_per_page', ADM_NB_GROUPES_PER_PAGE);

        return $smarty->fetch('adm/groupes/index.tpl');
    }

    static function groupes_show() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_groupe = (int) Route::params('id');

        $groupe = Groupe::getInstance($id_groupe);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupes", "/adm/groupes/");
        $trail->addStep($groupe->getName());

        $smarty = new AdHocSmarty();
        $smarty->assign('groupe', $groupe);
        return $smarty->fetch('adm/groupes/show.tpl');
    }

    static function membres_index() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (((string) Route::params('sens') === 'DESC')) {
            $sens = 'DESC';
            $sensinv = 'ASC';
        } else {
            $sens = 'ASC';
            $sensinv = 'DESC';
        }

        if ((string) Route::params('sort')) {
            $sort = (string) Route::params('sort');
        } else {
            $sort = 'id_contact';
        }

        $page = (int) Route::params('page');

        $pseudo = trim((string) Route::params('pseudo'));
        $email = trim((string) Route::params('email'));
        $last_name = trim((string) Route::params('last_name'));
        $first_name = trim((string) Route::params('first_name'));

        $tab_id = [];
        //$with_groupe = (bool) Route::params('with_groupe');
        //$id_groupe = (int) Route::params('id_groupe');
        //$id_type_musicien = (int) Route::params('id_type_musicien');

        $membres = Membre::getMembres([
            /*'id'         => $tab_id,*/
            'pseudo'     => $pseudo,
            'email'      => $email,
            'last_name'  => $last_name,
            'first_name' => $first_name,
            'sort'  => $sort,
            'sens'  => $sens,
            'debut' => $page * ADM_NB_MEMBERS_PER_PAGE,
            'limit' => ADM_NB_MEMBERS_PER_PAGE,
        ]);

        $nb_membres = Membre::getMembresCount(); // hors critères !

        $smarty = new AdHocSmarty();

        $smarty->assign('membres',  $membres);

        $smarty->assign('sens', $sens);
        $smarty->assign('sensinv', $sensinv);
        $smarty->assign('page', $page);

        // test ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return $smarty->fetch('adm/membres/index-res.tpl');
        }

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");

        $smarty->assign('types_membre', Membre::getTypesMembre());
        $smarty->assign('types_musicien', Membre::getTypesMusicien());

        $smarty->assign('search', [
            'pseudo' => $pseudo,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'email' => $email,
            'with_groupe' => false,
            'id_groupe' => 0,
            'id_type_musicien' => 0,
        ]);

        // pagination
        $smarty->assign('nb_items', $nb_membres);
        $smarty->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $smarty->assign('link_base_params', 'sort='.$sort.'&sens='.$sens);

        return $smarty->fetch('adm/membres/index.tpl');
    }

    static function membres_show() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");
        $trail->addStep($membre->getPseudo());

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/show.tpl');
    }

    static function membres_delete() : string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Membres", "/adm/membres/");
        $trail->addStep("Suppresion de " . $membre->getPseudo());

        // ***

        //$membre->delete();
        //$contact = Contact::getInstance($id);
        //$contact->delete();

        // ***

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/delete.tpl');
    }

    static function stats() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $m = false;
        if (isset($_GET['m'])) {
            $m = substr($_GET['m'], 0, 1);
        }

        $domaine = false;
        if (isset($_GET['domaine'])) {
            $domaine = $_GET['domaine'];
        }

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        $modules = [
            '1' => "Inscriptions membres par mois",
            '2' => "Inscriptions groupes par mois",
            '3' => "Top contributeurs photos",
            '4' => "Top contributeurs audios",
            '5' => "Top contributeurs vidéos",
            '6' => "Top contributeurs messages forums",
            '7' => "Top contributeurs lieux",
            '8' => "Top contributeurs dates",
            '9' => "Dernières connexions",
            'A' => "Top lieux",
            'B' => "Nombre de lieux par département",
            'C' => "Nombre de lieux par région",
            'D' => "Top Visites Groupes",
            'H' => "Domaines Emails",
            'I' => "Nombre d'événements annoncés par mois",
            'J' => "Répartition des vidéos par hébergeur",
            'K' => "Nombre de photos par lieu",
        ];

        $smarty->assign('modules', $modules);

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        if ($m) {
            $trail->addStep($modules[$m]);
        }

        switch ($m)
        {
            case '1': $module = Stats::getNbInscriptionMembreByMonth(); break;
            case '2': $module = Stats::getNbInscriptionGroupeByMonth(); break;
            case '3': $module = Stats::getTopPhotosSenders(); break;
            case '4': $module = Stats::getTopAudiosSenders(); break;
            case '5': $module = Stats::getTopVideosSenders(); break;
            case '6': $module = Stats::getTopMessagesForumsSenders(); break;
            case '7': $module = Stats::getTopLieuxSenders(); break;
            case '8': $module = Stats::getTopEventsSenders(); break;
            case '9': $module = Stats::getLastConnexions(50); break;
            case 'A': $module = Stats::getTopLieux(); break;
            case 'B': $module = Stats::getNbLieuxByDepartement(); break;
            case 'C': $module = Stats::getNbLieuxByRegion(); break;
            case 'D': $module = Stats::getTopVisitesGroupes(); break;
            case 'H': $module = Stats::getEmailsForDomaine($domaine); break;
            case 'H': $module = Stats::getEmailsDomaines(); break;
            case 'I': $module = Stats::getNbEventsByMonth(); break;
            case 'J': $module = Stats::getRepartitionVideos(); break;
            case 'K': $module = Stats::getTopPhotosLieux(); break;
            default:  $module = false; break;
        }

        $smarty->assign('m', $m);
        $smarty->assign('module', $module);

        return $smarty->fetch('adm/stats.tpl');
    }

    static function stats_top_groupes() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Top Groupes");

        $db = DataBase::getInstance();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        // liste des groupes ayant le plus joué à Epinay
        $sql = "SELECT `g`.`id_groupe`, `g`.`name` AS `nom_groupe`, "
             . "`e`.`id_event`, `e`.`name` AS `nom_event`, `e`.`date` "
             . "FROM `adhoc_event` `e`, `adhoc_participe_a` `p`, `adhoc_groupe` `g`, `adhoc_organise_par` `o` "
             . "WHERE `e`.`id_event` = `o`.`id_event` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `o`.`id_structure` = 1 "
             . "AND `e`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `e`.`date` DESC";

        $rows = $db->queryWithFetch($sql);

        $tab = [];
        foreach ($rows as $row) {
            $tab[$row['id_groupe']]['id_groupe'] = $row['id_groupe'];
            $tab[$row['id_groupe']]['nom_groupe'] = $row['nom_groupe'];
            $tab[$row['id_groupe']]['events'][] = [
                'id'   => $row['id_event'],
                'name' => $row['nom_event'],
                'date' => $row['date'],
            ];
        }

        $ordre = [];
        foreach ($tab as $id_groupe => $inf) {
            $ordre[$id_groupe] = count($inf['events']);
        }

        arsort($ordre);

        $data = [];
        $rank = 1;
        foreach ($ordre as $id_groupe => $nb) {
            $data[$rank] = $tab[$id_groupe];
            $data[$rank]['nb'] = $nb;
            $rank++;
        }

        $smarty->assign('tops', $data);

        return $smarty->fetch('adm/stats-top-groupes.tpl');
    }

    static function stats_top_membres() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Top Membres");

        $db = DataBase::getInstance();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        // listes des membres ayant le plus joué à Epinay
        $sql = "SELECT `m`.`id_contact`, `m`.`last_name`, `m`.`first_name`, "
             . "`g`.`id_groupe`, `g`.`name` AS `nom_groupe`, "
             . "`e`.`id_event`, `e`.`date`, `e`.`name` AS `nom_event` "
             . "FROM `adhoc_membre` `m`, `adhoc_appartient_a` `a`, `adhoc_event` `e`, `adhoc_participe_a` `p`, `adhoc_groupe` `g`, `adhoc_organise_par` `o` "
             . "WHERE `e`.`id_event` = `o`.`id_event` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `m`.`id_contact` = `a`.`id_contact` "
             . "AND `a`.`id_groupe` = `g`.`id_groupe` "
             . "AND `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `o`.`id_structure` = 1 "
             . "AND `e`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY `e`.`date` DESC ";

        $rows = $db->queryWithFetch($sql);

        $tab = [];
        foreach ($rows as $row)
        {
            $tab[$row['id_contact']]['id_contact'] = $row['id_contact'];
            $tab[$row['id_contact']]['first_name'] = $row['first_name'];
            $tab[$row['id_contact']]['last_name'] = $row['last_name'];
            $tab[$row['id_contact']]['events'][] = [
                'id_groupe'  => $row['id_groupe'],
                'nom_groupe' => $row['nom_groupe'],
                'id_event'   => $row['id_event'],
                'nom_event'  => $row['nom_event'],
                'date_event' => $row['date'],
            ];
        }

        $ordre = [];
        foreach ($tab as $contact => $inf)
        {
            $ordre[$contact] = count($inf['events']);
        }

        arsort($ordre);

        $data = [];
        $rank = 1;

        foreach ($ordre as $id_contact => $nb)
        {
            $data[$rank] = $tab[$id_contact];
            $data[$rank]['nb'] = $nb;
            $rank++;
        }

        $smarty->assign('tops', $data);

        return $smarty->fetch('adm/stats-top-membres.tpl');
    }

    static function stats_nl() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $full = false;
        if (isset($_GET['full'])) {
            $full = true;
        }
        $smarty->assign('full', $full);

        $lastsend = '2015-06-02 12:00:00';

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Statistiques", "/adm/stats");
        $trail->addStep("Newsletter");

        $db = DataBase::getInstance();

        // nombre d'abonnés actifs instantanés
        $smarty->assign('nb_subscribers', Newsletter::getSubscribersCount());

        // nombre d'ouvertures
        $sql = "SELECT `id_contact` "
             . "FROM `adhoc_statsnl` "
             . "WHERE `date` > '" . $db->escape($lastsend) . "' ";
        $res = $db->query($sql);
        $smarty->assign('nbo', $db->numRows($res));

        // nombre d'ouvertures uniques
        $sql = "SELECT DISTINCT `id_contact` "
             . "FROM `adhoc_statsnl` "
             . "WHERE `date` > '" . $db->escape($lastsend) . "' ";
        $res = $db->query($sql);
        $smarty->assign('nbou', $db->numRows($res));

        // on extrait tout
        $sql = "SELECT `adhoc_statsnl`.`id_newsletter`, `adhoc_statsnl`.`id_contact`, `adhoc_membre`.`pseudo`, `adhoc_contact`.`email`, `adhoc_statsnl`.`date`, "
             . "`adhoc_statsnl`.`host`, `adhoc_statsnl`.`ip`, `adhoc_statsnl`.`useragent` "
             . "FROM (`adhoc_statsnl`) "
             . "LEFT JOIN `adhoc_membre` ON (`adhoc_statsnl`.`id_contact` = `adhoc_membre`.`id_contact`) "
             . "LEFT JOIN `adhoc_contact` ON (`adhoc_statsnl`.`id_contact` = `adhoc_contact`.`id_contact`) "
             . "WHERE `adhoc_statsnl`.`date` > '" . $db->escape($lastsend) . "' "
             . "ORDER BY `adhoc_statsnl`.`date` DESC";
        $res = $db->queryWithFetch($sql);

        $smarty->assign('nls', $res);

        // les hits
        $sql = "SELECT `adhoc_newsletter_hit`.`id_newsletter`, `adhoc_newsletter_hit`.`id_contact`, `adhoc_membre`.`pseudo`, `adhoc_contact`.`email`, `adhoc_newsletter_hit`.`date`, "
             . "`adhoc_newsletter_hit`.`host`, `adhoc_newsletter_hit`.`ip`, `adhoc_newsletter_hit`.`useragent`, `adhoc_newsletter_hit`.`url` "
             . "FROM (`adhoc_newsletter_hit`) "
             . "LEFT JOIN `adhoc_membre` ON (`adhoc_newsletter_hit`.`id_contact` = `adhoc_membre`.`id_contact`) "
             . "LEFT JOIN `adhoc_contact` ON (`adhoc_newsletter_hit`.`id_contact` = `adhoc_contact`.`id_contact`) "
             . "WHERE `adhoc_newsletter_hit`.`date` > '" . $db->escape($lastsend) . "' "
             . "ORDER BY `adhoc_newsletter_hit`.`date` DESC";
        $res = $db->queryWithFetch($sql);

        $smarty->assign('hits', $res);

        return $smarty->fetch('adm/stats-nl.tpl');
    }

    static function groupe_de_style() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupe de Style");

        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe` AS `id`, `name`, `style`, `text`, `mini_text`, `influences` "
             . "FROM `adhoc_groupe` "
             . "ORDER BY `name` ASC";
        $res = $db->queryWithFetch($sql);

        $tab_groupes = [];
        foreach ($res as $_res) {
            $tab_groupes[$_res['id']] = $_res;
        }

        foreach ($tab_groupes as $id_grp => $grp)
        {
            $sql = "SELECT `id_style`, `ordre` "
                 . "FROM `adhoc_groupe_style` "
                 . "WHERE `id_groupe` = " . (int) $grp['id'] . " "
                 . "ORDER BY `ordre` ASC";
            $res = $db->query($sql);

            $cpt = 0;
            while (list($grp_style_id, $grp_style_ordre) = $db->fetchRow($res)) {
                $tab_groupes[$id_grp]['styles'][$grp_style_ordre] = Style::getName($grp_style_id);
                $cpt++;
            }
            if ($cpt > 0) {
                $tab_groupes[$id_grp]['bgcolor'] = '#009900'; // au moins 1 style : bien
            } else {
                $tab_groupes[$id_grp]['bgcolor'] = '#990000'; // aucun style : mal
            }
        }

        $smarty->assign('groupes', $tab_groupes);

        return $smarty->fetch('adm/groupe-de-style.tpl');
    }

    static function groupe_de_style_id() : string
    {
        if (Tools::isSubmit('form-groupe-de-style')) {
            return self::groupe_de_style_submit();
        }

        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();
        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Groupe de Style", "/adm/groupe-de-style");

        $groupe = Groupe::getInstance($id);

        $trail->addStep($groupe->getName());

        // styles du groupe sélectionné
        $sql = "SELECT `id_style` "
             . "FROM `adhoc_groupe_style` "
             . "WHERE `id_groupe` = " . $groupe->getId() . " "
             . "ORDER BY `ordre` ASC "
             . "LIMIT 0, 3";
        $res = $db->query($sql);
        $sty = [0, 0, 0];
        $cpt = 0;
        while (list($id_style) = $db->fetchRow($res)) {
            $sty[$cpt] = $id_style;
            $cpt++;
        }

        // todo: dans le tpl !!
        $form_style = [];
        for ($cpt_style = 0 ; $cpt_style < 3 ; $cpt_style ++) {
            $form_style[$cpt_style]  = '';
            $form_style[$cpt_style] .= "<select name=\"style[" . $cpt_style . "]\">";
            $form_style[$cpt_style] .= "<option value=\"0\">---</option>\n";
            foreach (Style::getHashTable() as $id_style => $nom_style) {
                $form_style[$cpt_style] .= "<option value=\"" . $id_style . "\"";
                if ($id_style == $sty[$cpt_style]) {
                    $form_style[$cpt_style] .= " selected=\"selected\"";
                }
                $form_style[$cpt_style] .= ">" . $nom_style . "</option>\n";
            }
            $form_style[$cpt_style] .= "</select>";
        }

        $smarty->assign('groupe', $groupe);
        $smarty->assign('form_style', $form_style);

        return $smarty->fetch('adm/groupe-de-style-id.tpl');
    }

    static function groupe_de_style_submit() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $db = DataBase::getInstance();

        $style = Route::params('style');
        $id_groupe = (int) Route::params('id_groupe');

        // todo: dans un objet !!
        $sql = "DELETE FROM `adhoc_groupe_style` "
             . "WHERE `id_groupe` = " . (int) $id_groupe;
        $res = $db->query($sql);

        foreach ($style as $ordre => $id_style) {
            $ordre += 1;
            if ($id_style > 0) {
                $sql = "INSERT INTO `adhoc_groupe_style` "
                     . "(`id_groupe`, `id_style`, `ordre`) "
                     . "VALUES (" . $id_groupe . ", " . $id_style . ", " . $ordre . ")";
                try {
                    $res = $db->query($sql);
                }
                catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        Tools::redirect('/adm/groupe-de-style');
    }

    static function log_action() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (int) Route::params('action');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Log Action");

        $smarty = new AdHocSmarty();
        $smarty->assign('actions', Log::getActions());
        $smarty->assign('logs', Log::getLogsAction($action));
        return $smarty->fetch('adm/log-action.tpl');
    }

    static function delete_account() : string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $db = DataBase::getInstance();

        $out = '';

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Suppression Compte");

        !empty($_GET['action']) ? $action = (string) $_GET['action'] : $action = 'show';
        $smarty->assign('action', $action);

        !empty($_GET['email']) ? $email = (string) trim($_GET['email']) : $email = '';
        $smarty->assign('email', $email);

        !empty($_GET['id']) ? $id = (int) $_GET['id'] : $id = '';
        $smarty->assign('id', $id);

        switch ($action)
        {
            case 'show':
            default:

                $out .= "<table>";

                if ($email != "") {
                    $sql = "SELECT `id_contact`, `email` FROM `adhoc_contact` WHERE `email` = '" . $db->escape($email) . "'";
                    $res = $db->query($sql);
                    if (list($id) = $db->fetchRow($res)) {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> trouvé - id_contact : <strong>" . $id . "</strong></td></tr>";
                    } else {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> non trouvé</td></tr>";
                    }
                }

                if ($id > 0) {

                    $sql = "SELECT `email` FROM `adhoc_contact` WHERE `id_contact` = " . $id;
                    $res = $db->query($sql);
                    if (list($email) = $db->fetchRow($res)) {
                        $out .= "<tr><td>table contact : <strong>oui</strong> - email = <strong>" . $email . "</strong> - <a href='/adm/delete-account?action=delete&id=" . $id . "'>EFFACER TOUT LE COMPTE</a></td></tr>";
                    } else {
                        $out .= "<tr><td>table contact : <strong>non</strong></td></tr>";
                    }

                    $sql = "SELECT `pseudo`, `last_name`, `first_name`, `created_on`, `modified_on`, `visited_on` FROM `adhoc_membre` WHERE `id_contact` = " . $id;
                    $res = $db->query($sql);
                    if (list($pseudo, $nom, $prenom, $crea, $modif, $visite) = $db->fetchRow($res)) {
                        $out .= "<tr><td>table membre : <strong>oui</strong> - pseudo = <strong>" . $pseudo . "</strong> - nom = <strong>" . $nom . "</strong> - prenom = <strong>" . $prenom . "</strong><br />";
                        $out .= "crea : " . $crea . " - modif : " . $modif . " - visite : " . $visite . "</td></tr>";
                    } else {
                        $out .= "<tr><td>table membre : <strong>non</strong></td></tr>";
                    }

                    $sql  = "SELECT `id_contact` FROM `adhoc_appartient_a` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table appartient_a <strong>" . $nb . " groupe(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_video` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table video : <strong>" . $nb . " video(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_audio` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table audio : <strong>" . $nb . " audio(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_photo` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table photo : <strong>" . $nb . " photo(s)</strong></td></tr>";
/*
                    $sql  = "SELECT `id_contact` FROM `adhoc_forums` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table forums : <strong>" . $nb . " message(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
                    $res  = $db->query($sql);
                    $nb   = $db->numRows($res);
                    $out .= "<tr><td>table suivi_thread : <strong>" . $nb . " suivi(s)</strong></td></tr>";
*/
                }

                $out .= "</table>";

                break;

            case 'delete':

                $out .= "<form method=\"post\" action=\"/adm/delete-account-submit\">"
                      . "<p>Confirmer suppression de id_contact = " . $id . "</p>"
                      . "<input type=\"submit\" class=\"button\" value=\"OUI\" />"
                      . "<input type=\"hidden\" name=\"confirm\" value=\"1\" />"
                      . "<input type=\"hidden\" name=\"id\" value=\"" . $_GET['id'] . "\" />"
                      . "</form>";

                break;
        }

        $smarty->assign('content', $out);

        return $smarty->fetch('adm/delete-account.tpl');
    }

    static function delete_account_submit() : string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();

        $out = '';

        if (!$id) {
            return 'id invalide';
        }

        // on delete pas l'email dans le cas où c'est juste l'inactivité
        // du compte mais l'email répond bien
        $sql  = "DELETE FROM `adhoc_contact` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table contact effacée pour id_contact : ". $id . "<br />";

        $sql  = "DELETE FROM `adhoc_membre` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table membre effacée pour id_contact : " . $id . "<br />";

        /*
        $sql  = "DELETE FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->query($sql);
        $out .= "*** table suivi_thread effacée pour id_contact : " . $id . "<br />";
        */

        $out .= "<a href=\"/adm/delete-account\" class=\"button\">retour</a>";

        $smarty = new AdHocSmarty();

        $smarty->assign('content', $out);

        return $smarty->fetch('adm/delete-account.tpl');
    }

    static function appartient_a() : string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (string) Route::params('action');
        $from = (string) Route::params('from');
        $id_groupe = (int) Route::params('groupe');
        $id_contact = (int) Route::params('membre');
        $id_type_musicien = (int) Route::params('type');

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Liaison Membre / Groupe");

        if (Tools::isSubmit('form-appartient-a'))
        {
            $groupe = Groupe::getInstance($id_groupe);
            switch ($action)
            {
                case 'create':
                    $groupe->linkMember($id_contact, $id_type_musicien);
                    break;
                case 'delete':
                    $groupe->unlinkMember($id_contact);
                    break;
                case 'edit':
                    $groupe->unlinkMember($id_contact);
                    $groupe->linkMember($id_contact, $id_type_musicien);
                    break;
            }

            switch ($from)
            {
                case "groupe":
                    Tools::redirect('/adm/groupes/' . $id_groupe);
                    break;
                case "membre":
                    Tools::redirect('/adm/membres/' . $id_contact);
                    break;
            }

            return 'KO';
        }

        $smarty->assign('action', $action);
        $smarty->assign('from', $from);
        $smarty->assign('id_groupe', $id_groupe);
        $smarty->assign('id_contact', $id_contact);
        $smarty->assign('types', Membre::getTypesMusicien());

        switch ($action)
        {
            case "create":
                $smarty->assign('action_lib', 'Ajouter');
                break;
            case "edit":
                $smarty->assign('action_lib', 'Editer');
                break;
            case "delete":
                $smarty->assign('action_lib', 'Supprimer');
                break;
            default:
                die();
                break;
        }

        return $smarty->fetch('adm/appartient-a.tpl');
    }
}
