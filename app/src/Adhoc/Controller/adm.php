<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\ForumPrive;
use Adhoc\Model\Groupe;
use Adhoc\Model\Membre;
use Adhoc\Model\Reference\Style;
use Adhoc\Model\Reference\TypeMusicien;
use Adhoc\Utils\AdHocSmarty;
use Adhoc\Utils\DataBase;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Tools;
use Adhoc\Utils\Trail;

define('ADM_NB_MEMBERS_PER_PAGE', 25);

final class Controller
{
    /**
     * @return string
     */
    public static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $smarty->assign('title', "AD'HOC : Administration du site");
        $smarty->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep("Privé");

        $smarty->assign('forums', ForumPrive::getForums());

        return $smarty->fetch('adm/index.tpl');
    }

    /**
     * @return string
     */
    public static function groupesIndex(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupes");

        $smarty = new AdHocSmarty();

        $page = (int) Route::params('page');

        $smarty->assign(
            'groupes',
            Groupe::find(
                [
                    'order_by' => 'name',
                    'sort' => 'ASC',
                    'start' => $page * ADM_NB_MEMBERS_PER_PAGE,
                    'limit' => ADM_NB_MEMBERS_PER_PAGE,
                ]
            )
        );

        // pagination
        $smarty->assign('nb_items', Groupe::count());
        $smarty->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('adm/groupes/index.tpl');
    }

    /**
     * @return string
     */
    public static function groupesShow(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id_groupe = (int) Route::params('id');

        $groupe = Groupe::getInstance($id_groupe);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupes", "/adm/groupes")
            ->addStep($groupe->getName());

        $smarty = new AdHocSmarty();
        $smarty->assign('groupe', $groupe);
        return $smarty->fetch('adm/groupes/show.tpl');
    }

    /**
     * @return string
     */
    public static function membresIndex(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (((string) Route::params('sort') === 'DESC')) {
            $sort = 'DESC';
            $sortinv = 'ASC';
        } else {
            $sort = 'ASC';
            $sortinv = 'DESC';
        }

        if ((string) Route::params('order_by')) {
            $order_by = (string) Route::params('order_by');
        } else {
            $order_by = 'id_contact';
        }

        $page = (int) Route::params('page');

        $pseudo = trim((string) Route::params('pseudo'));
        $email = trim((string) Route::params('email'));
        $last_name = trim((string) Route::params('last_name'));
        $first_name = trim((string) Route::params('first_name'));

        $membres = Membre::find(
            [
                'pseudo'     => $pseudo,
                'email'      => $email,
                'last_name'  => $last_name,
                'first_name' => $first_name,
                'order_by'   => $order_by,
                'sort'       => $sort,
                'start'      => $page * ADM_NB_MEMBERS_PER_PAGE,
                'limit'      => ADM_NB_MEMBERS_PER_PAGE,
            ]
        );

        $nb_membres = Membre::count();

        $smarty = new AdHocSmarty();

        $smarty->assign('membres', $membres);

        $smarty->assign('sort', $sort);
        $smarty->assign('sortinv', $sortinv);
        $smarty->assign('page', $page);

        // test ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return $smarty->fetch('adm/membres/index-res.tpl');
        }

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Membres", "/adm/membres");

        $smarty->assign('types_membre', Membre::getTypesMembre());
        $smarty->assign('types_musicien', TypeMusicien::findAll());

        $smarty->assign(
            'search',
            [
                'pseudo' => $pseudo,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'email' => $email,
            ]
        );

        // pagination
        $smarty->assign('nb_items', $nb_membres);
        $smarty->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $smarty->assign('link_base_params', 'order_by=' . $order_by . '&sort=' . $sort);

        return $smarty->fetch('adm/membres/index.tpl');
    }

    /**
     * @return string
     */
    public static function membresShow(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Membres", "/adm/membres")
            ->addStep($membre->getPseudo());

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/show.tpl');
    }

    /**
     * @return string
     */
    public static function membresDelete(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $id = (int) Route::params('id');

        $membre = Membre::getInstance($id);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Membres", "/adm/membres")
            ->addStep("Suppresion de " . $membre->getPseudo());

        // ***

        //$membre->delete();
        //$contact = Contact::getInstance($id);
        //$contact->delete();

        // ***

        $smarty = new AdHocSmarty();
        $smarty->assign('membre', $membre);
        return $smarty->fetch('adm/membres/delete.tpl');
    }

    /**
     * @return string
     */
    public static function groupeDeStyle(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupe de Style");

        $groupes = Groupe::findAll();
        $smarty->assign('groupes', $groupes);

        return $smarty->fetch('adm/groupe-de-style.tpl');
    }

    /**
     * @return string
     */
    public static function groupeDeStyleId(): string
    {
        if (Tools::isSubmit('form-groupe-de-style')) {
            return self::groupeDeStyleSubmit();
        }

        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();
        $smarty = new AdHocSmarty();

        $groupe = Groupe::getInstance($id);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupe de Style", "/adm/groupe-de-style")
            ->addStep($groupe->getName());

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
        for ($cpt_style = 0; $cpt_style < 3; $cpt_style++) {
            $form_style[$cpt_style]  = '';
            $form_style[$cpt_style] .= "<select name=\"style[" . $cpt_style . "]\">";
            $form_style[$cpt_style] .= "<option value=\"0\">---</option>\n";
            foreach (Style::findAll() as $style) {
                $form_style[$cpt_style] .= "<option value=\"" . $style->getId() . "\"";
                if ($style->getId() === $sty[$cpt_style]) {
                    $form_style[$cpt_style] .= " selected=\"selected\"";
                }
                $form_style[$cpt_style] .= ">" . $style->getName() . "</option>\n";
            }
            $form_style[$cpt_style] .= "</select>";
        }

        $smarty->assign('groupe', $groupe);
        $smarty->assign('form_style', $form_style);

        return $smarty->fetch('adm/groupe-de-style-id.tpl');
    }

    /**
     * @return void
     */
    public static function groupeDeStyleSubmit(): void
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
                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        Tools::redirect('/adm/groupe-de-style');
    }

    /**
     * @return string
     */
    public static function logAction(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (int) Route::params('action');

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Log Action");

        $smarty = new AdHocSmarty();
        $smarty->assign('actions', Log::getActions());
        $smarty->assign('logs', Log::getLogsAction($action));
        return $smarty->fetch('adm/log-action.tpl');
    }

    /**
     * @return string
     */
    public static function deleteAccount(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $db = DataBase::getInstance();

        $out = '';

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Suppression Compte");

        !empty($_GET['action']) ? $action = (string) $_GET['action'] : $action = 'show';
        $smarty->assign('action', $action);

        !empty($_GET['email']) ? $email = (string) trim($_GET['email']) : $email = '';
        $smarty->assign('email', $email);

        !empty($_GET['id']) ? $id = (int) $_GET['id'] : $id = '';
        $smarty->assign('id', $id);

        switch ($action) {
            case 'show':
            default:
                $out .= "<table>";

                if ($email !== '') {
                    $sql = "SELECT `id_contact`, `email` FROM `adhoc_contact` WHERE `email` = '" . $email . "'";
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

                    $sql = "SELECT `pseudo`, `last_name`, `first_name`, `created_at`, `modified_at`, `visited_at` FROM `adhoc_membre` WHERE `id_contact` = " . $id;
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

    /**
     * @return string
     */
    public static function deleteAccountSubmit(): string
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
        $out .= "*** table contact effacée pour id_contact : " . $id . "<br />";

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

    /**
     * @return string
     */
    public static function appartientA(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $action = (string) Route::params('action');
        $from = (string) Route::params('from');
        $id_groupe = (int) Route::params('groupe');
        $id_contact = (int) Route::params('membre');
        $id_type_musicien = (int) Route::params('type');

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Liaison Membre / Groupe");

        if (Tools::isSubmit('form-appartient-a')) {
            $groupe = Groupe::getInstance($id_groupe);
            switch ($action) {
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

            switch ($from) {
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
        $smarty->assign('types', TypeMusicien::findAll());

        switch ($action) {
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
        }

        return $smarty->fetch('adm/appartient-a.tpl');
    }
}
