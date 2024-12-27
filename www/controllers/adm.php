<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\ForumPrive;
use Adhoc\Model\Groupe;
use Adhoc\Model\Membre;
use Adhoc\Model\Style;
use Adhoc\Model\TypeMusicien;
use Adhoc\Utils\AdHocTwigBootstrap;
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

        $twig = new AdhocTwigBootstrap();

        $twig->assign('title', "AD'HOC : Administration du site");
        $twig->assign('description', "Association oeuvrant pour le développement de la vie musicale en Essonne depuis 1996. Promotion d'artistes, Pédagogie musicale, Agenda concerts, Communauté de musiciens ...");

        Trail::getInstance()
            ->addStep("Privé");

        $twig->assign('forums', ForumPrive::getForums());

        return $twig->render('adm/index.twig');
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

        $twig = new AdhocTwigBootstrap();

        $page = (int) Route::params('page');

        $twig->assign(
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
        $twig->assign('nb_items', Groupe::count());
        $twig->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('adm/groupes/index.twig');
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

        $twig = new AdhocTwigBootstrap();
        $twig->assign('groupe', $groupe);
        return $twig->render('adm/groupes/show.twig');
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

        if (!is_null(Route::params('order_by'))) {
            $order_by = Route::params('order_by');
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

        $twig = new AdhocTwigBootstrap();

        $twig->assign('membres', $membres);

        $twig->assign('sort', $sort);
        $twig->assign('sortinv', $sortinv);
        $twig->assign('page', $page);

        // test ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return $twig->render('adm/membres/index-res.twig');
        }

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Membres", "/adm/membres");

        $twig->assign('types_membre', Membre::getTypesMembre());
        $twig->assign('types_musicien', TypeMusicien::findAll());

        $twig->assign(
            'search',
            [
                'pseudo' => $pseudo,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'email' => $email,
            ]
        );

        // pagination
        $twig->assign('nb_items', $nb_membres);
        $twig->assign('nb_items_per_page', ADM_NB_MEMBERS_PER_PAGE);
        $twig->assign('link_base_params', 'order_by=' . $order_by . '&sort=' . $sort);

        return $twig->render('adm/membres/index.twig');
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

        $twig = new AdhocTwigBootstrap();
        $twig->assign('membre', $membre);
        return $twig->render('adm/membres/show.twig');
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

        $twig = new AdhocTwigBootstrap();
        $twig->assign('membre', $membre);
        return $twig->render('adm/membres/delete.twig');
    }

    /**
     * @return string
     */
    public static function groupeDeStyle(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $twig = new AdhocTwigBootstrap();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupe de Style");

        $groupes = Groupe::findAll();
        $twig->assign('groupes', $groupes);

        return $twig->render('adm/groupe-de-style.twig');
    }

    /**
     * @return ?string
     */
    public static function groupeDeStyleId(): ?string
    {
        if (Tools::isSubmit('form-groupe-de-style')) {
            self::groupeDeStyleSubmit();
            return null;
        }

        Tools::auth(Membre::TYPE_INTERNE);

        $id = (int) Route::params('id');

        $db = DataBase::getInstance();
        $twig = new AdhocTwigBootstrap();

        $groupe = Groupe::getInstance($id);

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Groupe de Style", "/adm/groupe-de-style")
            ->addStep($groupe->getName());

        // styles du groupe sélectionné
        $sql = "SELECT `id_style` "
             . "FROM `adhoc_groupe_style` "
             . "WHERE `id_groupe` = " . $groupe->getIdGroupe() . " "
             . "ORDER BY `ordre` ASC "
             . "LIMIT 0, 3";
        $stmt = $db->pdo->query($sql);
        $sty = [0, 0, 0];
        $cpt = 0;
        while (list($id_style) = $stmt->fetch()) {
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
                $form_style[$cpt_style] .= "<option value=\"" . $style->getIdStyle() . "\"";
                if ($style->getIdStyle() === $sty[$cpt_style]) {
                    $form_style[$cpt_style] .= " selected=\"selected\"";
                }
                $form_style[$cpt_style] .= ">" . $style->getName() . "</option>\n";
            }
            $form_style[$cpt_style] .= "</select>";
        }

        $twig->assign('groupe', $groupe);
        $twig->assign('form_style', $form_style);

        return $twig->render('adm/groupe-de-style-id.twig');
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
             . "WHERE `id_groupe` = " . $id_groupe;
        $res = $db->pso->query($sql);

        foreach ($style as $ordre => $id_style) {
            $ordre += 1;
            if ($id_style > 0) {
                $sql = "INSERT INTO `adhoc_groupe_style` "
                     . "(`id_groupe`, `id_style`, `ordre`) "
                     . "VALUES (" . $id_groupe . ", " . $id_style . ", " . $ordre . ")";
                try {
                    $res = $db->pdo->query($sql);
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
    public static function deleteAccount(): string
    {
        Tools::auth(Membre::TYPE_ADMIN);

        $db = DataBase::getInstance();

        $out = '';

        $twig = new AdhocTwigBootstrap();

        Trail::getInstance()
            ->addStep("Privé", "/adm")
            ->addStep("Suppression Compte");

        isset($_GET['action']) ? $action = $_GET['action'] : $action = 'show';
        $twig->assign('action', $action);

        isset($_GET['email']) ? $email = trim($_GET['email']) : $email = '';
        $twig->assign('email', $email);

        isset($_GET['id']) ? $id = (int) $_GET['id'] : $id = '';
        $twig->assign('id', $id);

        switch ($action) {
            case 'show':
            default:
                $out .= "<table>";

                if ($email !== '') {
                    $sql = "SELECT `id_contact`, `email` FROM `adhoc_contact` WHERE `email` = '" . $email . "'";
                    $stmt = $db->pdo->query($sql);
                    if (list($id) = $stmt->fetch()) {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> trouvé - id_contact : <strong>" . $id . "</strong></td></tr>";
                    } else {
                        $out .= "<tr><td>Email <strong>" . $email . "</strong> non trouvé</td></tr>";
                    }
                }

                if ($id > 0) {
                    $sql = "SELECT `email` FROM `adhoc_contact` WHERE `id_contact` = " . $id;
                    $stmt = $db->pdo->query($sql);
                    if (list($email) = $stmt->fetch()) {
                        $out .= "<tr><td>table contact : <strong>oui</strong> - email = <strong>" . $email . "</strong> - <a href='/adm/delete-account?action=delete&id=" . $id . "'>EFFACER TOUT LE COMPTE</a></td></tr>";
                    } else {
                        $out .= "<tr><td>table contact : <strong>non</strong></td></tr>";
                    }

                    $sql = "SELECT `pseudo`, `last_name`, `first_name`, `created_at`, `modified_at`, `visited_at` FROM `adhoc_membre` WHERE `id_contact` = " . $id;
                    $stmt = $db->pdo->query($sql);
                    if (list($pseudo, $nom, $prenom, $crea, $modif, $visite) = $stmt->fetch()) {
                        $out .= "<tr><td>table membre : <strong>oui</strong> - pseudo = <strong>" . $pseudo . "</strong> - nom = <strong>" . $nom . "</strong> - prenom = <strong>" . $prenom . "</strong><br />";
                        $out .= "crea : " . $crea . " - modif : " . $modif . " - visite : " . $visite . "</td></tr>";
                    } else {
                        $out .= "<tr><td>table membre : <strong>non</strong></td></tr>";
                    }

                    $sql  = "SELECT `id_contact` FROM `adhoc_groupe_membre` WHERE `id_contact` = " . $id;
                    $res  = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
                    $out .= "<tr><td>table groupe_membre <strong>" . $nb . " groupe(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_video` WHERE `id_contact` = " . $id;
                    $res  = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
                    $out .= "<tr><td>table video : <strong>" . $nb . " video(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_audio` WHERE `id_contact` = " . $id;
                    $res  = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
                    $out .= "<tr><td>table audio : <strong>" . $nb . " audio(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_photo` WHERE `id_contact` = " . $id;
                    $res  = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
                    $out .= "<tr><td>table photo : <strong>" . $nb . " photo(s)</strong></td></tr>";
                    /*
                    $sql  = "SELECT `id_contact` FROM `adhoc_forums` WHERE `id_contact` = " . $id;
                    $res  = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
                    $out .= "<tr><td>table forums : <strong>" . $nb . " message(s)</strong></td></tr>";

                    $sql  = "SELECT `id_contact` FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
                    $stmt = $db->pdo->query($sql);
                    $nb   = count($stmt->fetchAll(\PDO::FETCH_COLUMN));
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

        $twig->assign('content', $out);

        return $twig->render('adm/delete-account.twig');
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

        if ($id === 0) {
            return 'id invalide';
        }

        // on delete pas l'email dans le cas où c'est juste l'inactivité
        // du compte mais l'email répond bien
        $sql  = "DELETE FROM `adhoc_contact` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->pdo->query($sql);
        $out .= "*** table contact effacée pour id_contact : " . $id . "<br />";

        $sql  = "DELETE FROM `adhoc_membre` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->pdo->query($sql);
        $out .= "*** table membre effacée pour id_contact : " . $id . "<br />";

        /*
        $sql  = "DELETE FROM `adhoc_suivi_thread` WHERE `id_contact` = " . $id;
        $out .= $sql . "<br />";
        $db->pdo->query($sql);
        $out .= "*** table suivi_thread effacée pour id_contact : " . $id . "<br />";
        */

        $out .= "<a href=\"/adm/delete-account\" class=\"button\">retour</a>";

        $twig = new AdhocTwigBootstrap();

        $twig->assign('content', $out);

        return $twig->render('adm/delete-account.twig');
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

        $twig = new AdhocTwigBootstrap();

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

        $twig->assign('action', $action);
        $twig->assign('from', $from);
        $twig->assign('id_groupe', $id_groupe);
        $twig->assign('id_contact', $id_contact);
        $twig->assign('types', TypeMusicien::findAll());

        switch ($action) {
            case "create":
                $twig->assign('action_lib', 'Ajouter');
                break;
            case "edit":
                $twig->assign('action_lib', 'Editer');
                break;
            case "delete":
                $twig->assign('action_lib', 'Supprimer');
                break;
            default:
                die();
        }

        return $twig->render('adm/appartient-a.twig');
    }
}
