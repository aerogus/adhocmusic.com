<?php

declare(strict_types=1);

namespace Adhoc\Utils;

use Adhoc\Model\Event;
use Adhoc\Model\Membre;

/**
 * Fonctions et modifiers custom pour Smarty
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class AdHocSmarty extends \Smarty
{
    /**
     * @var array<int,string>
     */
    protected static array $pseudos = [];

    /**
     * @var array<int,string>
     */
    protected static array $avatars = [];

    /**
     * @var array<string,mixed>
     */
    protected array $script_vars = [];

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();

        // paths
        $this->setTemplateDir(SMARTY_TEMPLATE_PATH);
        $this->setCompileDir(SMARTY_TEMPLATE_C_PATH);
        $this->setCacheDir(SMARTY_TEMPLATE_C_PATH);

        // fonctions smarty
        $this->registerPlugin('function', 'pagination', [__NAMESPACE__ . '\AdHocSmarty', 'functionPagination']);
        $this->registerPlugin('function', 'html_input_date_hourminute', [__NAMESPACE__ . '\AdHocSmarty', 'functionHtmlInputDateHourminute']);
        $this->registerPlugin('function', 'calendar', [__NAMESPACE__ . '\AdHocSmarty', 'functionCalendar']);
        $this->registerPlugin('function', 'image', [__NAMESPACE__ . '\EmailSmarty', 'functionImage']);

        // modifiers smarty
        $this->registerPlugin('modifier', 'format_size', [__NAMESPACE__ . '\AdHocSmarty', 'modifierFormatSize']);
        $this->registerPlugin('modifier', 'pseudo_by_id', [__NAMESPACE__ . '\AdHocSmarty', 'modifierPseudoById']);
        $this->registerPlugin('modifier', 'avatar_by_id', [__NAMESPACE__ . '\AdHocSmarty', 'modifierAvatarById']);
        $this->registerPlugin('modifier', 'display_on_off_icon', [__NAMESPACE__ . '\AdHocSmarty', 'modifierDisplayOnOffIcon']);
        $this->registerPlugin('modifier', 'json_encode_numeric_check', [__NAMESPACE__ . '\AdHocSmarty', 'modifierJsonEncodeNumericCheck']);

        // assignations générales
        $this->assign('title', "♫ AD'HOC : Les Musiques Actuelles");
        $this->assign('sessid', session_id());
        $this->assign('HOME_URL', HOME_URL);
        $this->assign('uri', $_SERVER['REQUEST_URI']);
        $this->assign('url', HOME_URL . $_SERVER['REQUEST_URI']);
        $this->assign('fb_page_id', FB_PAGE_ID);
        $this->assign('robots', 'index,follow');

        if (!empty($_SESSION['membre'])) {
            $this->assign('me', $_SESSION['membre']);
            $this->assign('is_auth', true);
        } else {
            $this->assign('is_auth', false);
        }

        $this->enqueueStyle('/css/adhoc.css');

        $this->enqueueScript('/static/library/jquery@3.7.1/jquery.min.js');
        $this->enqueueScript('/js/adhoc.js');
    }

    /* début fonctions */

    /**
     * Méthode de pagination
     *
     * @param array<string,mixed> $params [
     *                                'nb_items' => int,
     *                                'nb_items_per_page' => int,
     *                                'page' => int
     *                                'link_page' => string,
     *                                'link_base_params' => string,
     *                                'nb_links' => int
     *                                'separator' => string
     *                            ]
     *
     * @return string
     */
    public static function functionPagination(array $params): string
    {
        $out = '';

        if (array_key_exists('nb_items', $params)) {
            $nb_items = (int) $params['nb_items'];
        } else {
            return '';
        }

        if (array_key_exists('nb_items_per_page', $params)) {
            $nb_items_per_page = (int) $params['nb_items_per_page'];
        } else {
            return '';
        }

        if (array_key_exists('page', $params)) {
            $page = (int) $params['page'];
        } else {
            return '';
        }

        $p = new Pagination($nb_items, $nb_items_per_page, $page);

        if (array_key_exists('nb_links', $params)) {
            $nb_links = (int) $params['nb_links'];
        } else {
            $nb_links = 5;
        }

        if (array_key_exists('link_page', $params)) {
            $link_page = (string) $params['link_page'];
        } else {
            $link_page = '';
        }

        if (
            array_key_exists('link_base_params', $params)
            && ($params['link_base_params'] !== '')
        ) {
            $link_base_params = '?' . $params['link_base_params'] . '&amp;';
        } else {
            $link_base_params = '?';
        }

        if ($p->hasPagination()) {
            $out .= '<div class="pagination">';
            if ($p->getNbPages() <= $p->getNbLinks()) {
                // pagination simple 1 2 3 4 5
                for ($i = $p->getFirstPage(); $i <= $p->getLastPage(); $i++) {
                    $p->setCurrentPage($i);
                    $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getCurrentPage() . '" class="' . $p->getClass() . '">' . $p->getCurrentPageNum() . '</a>';
                }
            } else {
                // pagination étendue
                if ($p->getSelectedPage() < ($p->getNbLinks() - 2)) {
                    // type début  : 1 2 3 4 ... 50
                    for ($i = $p->getFirstPage(); $i < $p->getNbLinks() - 1; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getCurrentPage() . '" class="' . $p->getClass() . '">' . $p->getCurrentPageNum() . '</a>';
                    }
                    $out .= '…';
                    $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getLastPage() . '">' . $p->getLastPageNum() . '</a>';
                } elseif ($p->getSelectedPage() > ($p->getNbPages() - $p->getNbLinks() + 1)) {
                    // type fin    : 1 ... 47 48 49 50
                    $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getFirstPage() . '">' . $p->getFirstPageNum() . '</a>';
                    $out .= '…';
                    for ($i = $p->getLastPage() - $p->getNbLinks() + 2; $i <= $p->getLastPage(); $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getCurrentPage() . '" class="' . $p->getClass() . '">' . $p->getCurrentPageNum() . '</a>';
                    }
                } else {
                    // type milieu : 1 ... 24 25 26 ... 50
                    $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getFirstPage() . '">' . $p->getFirstPageNum() . '</a>';
                    $out .= '…';
                    for ($i = (int) ($p->getSelectedPage() - floor($p->getNbLinks() / 2) + 1); $i < (int) ($p->getSelectedPage() + floor($p->getNbLinks() / 2)); $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getCurrentPage() . '" class="' . $p->getClass() . '">' . $p->getCurrentPageNum() . '</a>';
                    }
                    $out .= '…';
                    $out .= '<a href="' . $link_page . $link_base_params . 'page=' . $p->getLastPage() . '">' . $p->getLastPageNum() . '</a>';
                }
            }
            $out .= '</div>';
        }
        return $out;
    }

    /**
     * @param array<string,int> $params ['hour']
     *                                  ['minute']
     *                                  ['step']
     *
     * @return string
     */
    public static function functionHtmlInputDateHourminute(array $params): string
    {
        $hour = 0;
        if (array_key_exists('hour', $params)) {
            $hour = (int) $params['hour'];
        }

        $minute = 0;
        if (array_key_exists('minute', $params)) {
            $minute = (int) $params['minute'];
        }

        $step = 30;
        if (array_key_exists('step', $params)) {
            $step = (int) $params['step'];
        }

        $hourminute = str_pad((string) $hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string) $minute, 2, '0', STR_PAD_LEFT);

        $out = '';
        for ($h = 0; $h < 24; $h++) {
            for ($m = 0; $m < 60; $m += $step) {
                $hm = str_pad((string) $h, 2, '0', STR_PAD_LEFT) . ':' . str_pad((string) $m, 2, '0', STR_PAD_LEFT);
                $out .= "<option value=\"" . $hm . "\"";
                if ($hm === $hourminute) {
                    $out .= " selected=\"selected\"";
                }
                $out .= ">" . $hm . "</option>\n";
            }
        }

        return $out;
    }

    /**
     * @param array<string,int> $params ['year']
     *                                  ['month']
     *                                  ['day']
     *
     * @return string
     */
    public static function functionCalendar(array $params): string
    {
        $now  = time();
        $months = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        $cal  = [];

        $year = date('Y', $now);
        if (array_key_exists('year', $params)) {
             $year = (int) $params['year'];
        }

        $month = date('m', $now);
        if (array_key_exists('month', $params)) {
            $month = (int) $params['month'];
        }

        $day = date('d', $now);
        if (array_key_exists('day', $params)) {
            $day = (int) $params['day'];
        }

        $start_day = mktime(0, 0, 0, $month, 1, $year); // ts du 1er du mois
        $start_day_number = date('w', $start_day);      // n° du jour du 1er du mois (0-6)
        $nb_days_in_month = date('t', $start_day);      // nombre de jours dans le mois
        $row  = 0; // n° ligne
        $trow = 0; // compteur global

        $blank_days = $start_day_number - 1;
        if ($blank_days < 0) {
            $blank_days = 7 - abs($blank_days);
        }

        $events = Event::getEventsForAMonth($year, $month);

        // blancs de début de mois
        for ($x = 0; $x < $blank_days; $x++) {
            $cal[$row][$trow]['num'] = null;
            $cal[$row][$trow]['link'] = null;
            $cal[$row][$trow]['title'] = null;
            $trow++;
        }

        // création tableau
        for ($x = 1; $x <= $nb_days_in_month; $x++) {
            // nouvelle semaine
            if (($x + $blank_days - 1) % 7 === 0) {
                $row++;
            }
            $date = date('Y-m-d', mktime(0, 0, 0, $month, $x, $year));
            $cal[$row][$trow]['num'] = $x;
            $cal[$row][$trow]['selected'] = false;
            if ($day === $x) {
                $cal[$row][$trow]['selected'] = true;
            }
            if (array_key_exists($date, $events)) {
                $cal[$row][$trow]['link'] = '?y=' . $year . '&m=' . $month . '&d=' . $x;
                $cal[$row][$trow]['title'] = $events[$date] . ' events';
            } else {
                $cal[$row][$trow]['link'] = null;
                $cal[$row][$trow]['title'] = null;
            }
            $trow++;
        }

        // blancs de fin de mois
        while ((($nb_days_in_month + $blank_days) % 7) !== 0) {
            $cal[$row][$trow]['num'] = null;
            $cal[$row][$trow]['link'] = null;
            $cal[$row][$trow]['title'] = null;
            $nb_days_in_month++;
            $trow++;
        }

        if ($month === 1) {
            $prev_month = 12;
            $prev_year = $year - 1;
        } else {
            $prev_month = $month - 1;
            $prev_year = $year;
        }
        if ($month === 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $month + 1;
            $next_year = $year;
        }

        $smarty = new AdHocSmarty();
        $smarty->assign('months', $months);
        $smarty->assign('month', $month);
        $smarty->assign('year', $year);
        $smarty->assign('cal', $cal);
        $smarty->assign('prev_month', $prev_month);
        $smarty->assign('prev_year', $prev_year);
        $smarty->assign('next_month', $next_month);
        $smarty->assign('next_year', $next_year);
        return $smarty->fetch('events/calendar.tpl');
    }

    /* fin fonctions */

    /* début modifiers */

    /**
     * Formatage d'un poids de fichier
     *
     * @param int $size taille
     *
     * @return string
     */
    public static function modifierFormatSize(int $size): string
    {
        $sizes = ["  o", " Ko", " Mo", " Go", " To", " Po", " Eo", " Zo", " Yo"];
        if ($size === 0) {
            return '0  o';
        } else {
            return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
        }
    }

    /**
     * Récupère le pseudo à partir de l'id_contact et fait un cache
     * pour l'instance
     *
     * @param int $id_contact id_contact
     *
     * @return string
     */
    public static function modifierPseudoById(int $id_contact): string
    {
        if (array_key_exists($id_contact, self::$pseudos)) {
            return self::$pseudos[$id_contact];
        }

        self::$pseudos[$id_contact] = Membre::getInstance($id_contact)->getPseudo();

        return self::$pseudos[$id_contact];
    }

    /**
     * Récupère l'avatar à partir de l'id_contact et fait un cache
     * pour l'instance
     *
     * @param int $id_contact id_contact
     *
     * @return string
     */
    public static function modifierAvatarById(int $id_contact): string
    {
        if (array_key_exists($id_contact, self::$avatars)) {
            return self::$avatars[$id_contact];
        }

        $url = '';
        if (file_exists(MEDIA_PATH . '/membre/' . (string) $id_contact . '.jpg')) {
            $url = MEDIA_URL . '/membre/' . (string) $id_contact . '.jpg';
        }

        self::$avatars[$id_contact] = $url;

        return self::$avatars[$id_contact];
    }

    /**
     * Récupère l'url de l'icone (tick/cross) relative à une valeur booléenne
     *
     * @param bool $val val
     *
     * @return string
     */
    public static function modifierDisplayOnOffIcon(bool $val): string
    {
        return $val ? '✓' : '';
    }

    /**
     * @param mixed $val val
     *
     * @return string
     */
    public static function modifierJsonEncodeNumericCheck($val): string
    {
        return json_encode($val, JSON_NUMERIC_CHECK);
    }

    /* fin modifiers */

    /**
     * Ajoute d'une feuille de style
     *
     * @param string $style_name url de la feuille de style
     *
     * @return void
     */
    public function enqueueStyle(string $style_name): void
    {
        $this->append('stylesheets', $style_name);
    }

    /**
     * Ajoute un javascript externe dans le footer
     *
     * @param string $script_name url du script
     * @param bool $in_footer
     *
     * @return void
     */
    public function enqueueScript(string $script_name, bool $in_footer = true): void
    {
        if ($in_footer) {
            $this->append('footer_scripts', $script_name);
        } else {
            $this->append('header_scripts', $script_name);
        }
    }

    /**
     * Ajoute une variable js utilisable dans les scripts du footer
     *
     * @param string $key   key
     * @param mixed  $value value
     *
     * @return void
     */
    public function enqueueScriptVar(string $key, $value): void
    {
        $this->script_vars[$key] = $value;
        $this->assign('script_vars', $this->script_vars);
    }

    /**
     * Ajoute plusieurs variables js utilisables dans les scripts du footer
     *
     * @param array<string,mixed> $vars ['key1' => value1, 'key2' => value2]
     *
     * @return void
     */
    public function enqueueScriptVars(array $vars): void
    {
        foreach ($vars as $key => $value) {
            $this->enqueueScriptVar($key, $value);
        }
    }

    /**
     * Imprime un javascript en ligne dans le footer
     *
     * @param string $script script
     *
     * @return void
     */
    public function printInlineScript(string $script): void
    {
        $this->append('inline_scripts', $script);
    }

    /**
     * On hérite de Smarty::fetch
     *
     * @param string $template the resource handle of the template file or template object
     * @param mixed  $cache_id cache id to be used with this template
     * @param mixed  $compile_id compile id to be used with this template
     * @param object $parent next higher level of Smarty variables
     *
     * @return string
     */
    public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null): string
    {
        // fil d'ariane
        $this->assign('trail', Trail::getInstance()->getPath());

        return parent::fetch($template, $cache_id, $compile_id, $parent);
    }
}
