<?php

/**
 * fonctions et modifiers custom pour Smarty
 */
class AdHocSmarty extends Smarty
{
    protected static $pseudos = [];
    protected static $avatars = [];
    protected $script_vars = [];

    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        // paths
        $this->setTemplateDir(SMARTY_TEMPLATE_PATH);
        $this->setCompileDir(SMARTY_TEMPLATE_C_PATH);
        $this->setCacheDir(SMARTY_TEMPLATE_C_PATH);

        // errors
        $this->error_reporting = E_ALL & ~E_NOTICE;
        $this->muteExpectedErrors();

        // fonctions smarty
        $this->registerPlugin('function', 'audio_player', ['AdHocSmarty', 'function_audio_player']);
        $this->registerPlugin('function', 'pagination', ['AdHocSmarty', 'function_pagination']);
        $this->registerPlugin('function', 'html_input_date_hourminute', ['AdHocSmarty', 'function_html_input_date_hourminute']);
        $this->registerPlugin('function', 'calendar', ['AdHocSmarty', 'function_calendar']);
        $this->registerPlugin('function', 'image', ['EmailSmarty', 'function_image']);

        // modifiers smarty
        $this->registerPlugin('modifier', 'format_size', ['AdHocSmarty', 'modifier_format_size']);
        $this->registerPlugin('modifier', 'pseudo_by_id', ['AdHocSmarty', 'modifier_pseudo_by_id']);
        $this->registerPlugin('modifier', 'avatar_by_id', ['AdHocSmarty', 'modifier_avatar_by_id']);
        $this->registerPlugin('modifier', 'display_on_off_icon', ['AdHocSmarty', 'modifier_display_on_off_icon']);
        $this->registerPlugin('modifier', 'json_encode_numeric_check', ['AdHocSmarty', 'modifier_json_encode_numeric_check']);

        // assignations générales
        $this->assign('title', "♫ AD'HOC : Les Musiques Actuelles");
        $this->assign('svnrev', '6666'/*Tools::getHeadRevision()*/);
        $this->assign('sessid', session_id());
        $this->assign('menuselected', null);
        $this->assign('HOME_URL', HOME_URL);
        $this->assign('uri', $_SERVER['REQUEST_URI']);
        $this->assign('url', HOME_URL . $_SERVER['REQUEST_URI']);
        $this->assign('fb_app_id', FB_APP_ID);
        $this->assign('fb_page_id', FB_PAGE_ID);
        $this->assign('fb_login_url', $GLOBALS['fb_login_url']);

        if (!empty($_SESSION['membre'])) {
            $this->assign('me', $_SESSION['membre']);
        }

        if (defined('ADHOC_COUNTERS')) {
            if (!empty($_SESSION['membre'])) {
                $this->assign('is_auth', true);

                $this->assign('my_counters', [
                    'nb_unread_messages' => (int) Messagerie::getMyUnreadMessagesCount(),
                    'nb_messages'        => (int) Messagerie::getMyMessagesCount(),
                ]);

            } else {
                $this->assign('is_auth', false);
                $this->assign('my_counters', false);
            }
        }

        $this->enqueue_style('/css/adhoc.20180225.css');

        $this->enqueue_script('/js/jquery-3.3.1.min.js');
        $this->enqueue_script('/js/adhoc.20180225.js');

        return $this;
    }

    /* début fonctions */

    /**
     * retourne le player audio
     *
     * @param array ['type'] ['id']
     * @return string
     * @todo les paramètres du dewplayer ont du changer avec la nouvelle version
     * @see http://www.alsacreations.fr/dewplayer
     */
    static function function_audio_player(array $params) : string
    {
        if (!array_key_exists('id', $params)) {
            return '';
        }
        if (!array_key_exists('type', $params)) {
            $params['type']  = 'dewplayer';
        }

        $bgcolor = '666666';

        if ($params['type'] === 'player_mp3_multi') {
            $id_groupe = $params['id'];
        } elseif ($params['type'] === 'webradio') {
            $chemin = $params['id'];
            $type = 'dewplayer';
        } else {
            $chemin = '';
            if (is_numeric($params['id'])) {
                $chemin .= MEDIA_URL . '/media/audio/'.$params['id'].'.mp3';
            } elseif (is_array($params['id'])) {
                $first  = true;
                foreach ($params['id'] as $id) {
                    if (!$first) { $chemin .= '|'; }
                    $chemin .= MEDIA_URL . '/media/audio/'.$id.'.mp3';
                    $first = false;
                }
            } else {
                return false;
            }
        }

        switch ($params['type'])
        {
            case 'dewplayer-mini':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="160" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="200" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer-multi':
                return '<object type="application/x-shockwave-flash" data="/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="240" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="/swf/dewplayer-multi.swf?mp3='.urlencode($chemin).'.mp3&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_multi':
                return '<object type="application/x-shockwave-flash" data="/swf/player_mp3_multi.swf" width="250" height="150">'."\n"
                     . '<param name="movie" value="/swf/player_mp3_multi.swf" />'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="FlashVars" value="configxml=http://www.adhocmusic.com/groupes/playlist/'.$id_groupe.'.xml&amp;skin" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_nano':
                return '<object type="application/x-shockwave-flash" data="/swf/player_mp3_maxi.swf" width="25" height="20">'."\n"
                     . '<param name="movie" value="/swf/player_mp3_maxi.swf" />'."\n"
                     . '<param name="FlashVars" value="mp3='.urlencode($chemin).'&amp;bgcolor=2f2f2f&amp;showslider=0&amp;width=25" />'."\n"
                     . '</object>'."\n";
                break;
        }

        return false;
    }

    /**
     * Méthode de pagination
     *
     * @param array ['nb_items']* ['nb_items_per_page']* ['page']*
     *              ['link_page'] ['link_base_params']
     *              ['nb_links'] ['separator']
     * @return string
     */
    static function function_pagination(array $params) : string
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

        if (array_key_exists('link_base_params', $params) && $params['link_base_params'] !== '') {
            $link_base_params = '?'.$params['link_base_params'].'&amp;';
        } else {
            $link_base_params = '?';
        }

        if ($p->hasPagination()) {
            $out .= '<div class="pagination">';
            if ($p->getNbPages() <= $p->getNbLinks()) {
                 // pagination simple 1 2 3 4 5
                 for ($i = $p->getFirstPage() ; $i <= $p->getLastPage() ; $i++) {
                     $p->setCurrentPage($i);
                     $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>';
                 }
            } else {
                // pagination étendue
                if ($p->getSelectedPage() < ($p->getNbLinks() - 2)) {
                    // type début  : 1 2 3 4 ... 50
                    for ($i = $p->getFirstPage() ; $i < $p->getNbLinks() - 1 ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>';
                    }
                    $out .= '…';
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getLastPage().'">'.$p->getLastPageNum().'</a>';
                } elseif ($p->getSelectedPage() > ($p->getNbPages() - $p->getNbLinks() + 1)) {
                    // type fin    : 1 ... 47 48 49 50
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getFirstPage().'">'.$p->getFirstPageNum().'</a>';
                    $out .= '…';
                    for ($i = $p->getLastPage() - $p->getNbLinks() + 2 ; $i <= $p->getLastPage() ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>';
                    }
                } else {
                    // type milieu : 1 ... 24 25 26 ... 50
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getFirstPage().'">'.$p->getFirstPageNum().'</a>';
                    $out .= '…';
                    for ($i = ($p->getSelectedPage() - floor($p->getNbLinks() / 2) + 1) ; $i < ($p->getSelectedPage() + floor($p->getNbLinks() / 2)) ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>';
                    }
                    $out .= '…';
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getLastPage().'">'.$p->getLastPageNum().'</a>';
                }
            }
            $out .= '</div>';
        }
        return $out;
    }

    /**
     * @param array ['hour'] ['minute'] ['step']
     */
    static function function_html_input_date_hourminute(array $params) : string
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

        $hourminute = str_pad((int) $hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad((int) $minute, 2, '0', STR_PAD_LEFT);

        $out = '';
        for ($h = 0 ; $h < 24 ; $h++) {
            for ($m = 0 ; $m < 60 ; $m += $step) {
                $hm = str_pad((int) $h, 2, '0', STR_PAD_LEFT) . ':' . str_pad((int) $m, 2, '0', STR_PAD_LEFT);
                $out .= "<option value=\"".$hm."\"";
                if ($hm == $hourminute) {
                    $out .= " selected=\"selected\"";
                }
                $out .= ">".$hm."</option>\n";
            }
        }

        return $out;
    }

    /**
     * @param array ['year'] ['month'] ['day']
     */
    static function function_calendar(array $params) : string
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
        for ($x = 0 ; $x < $blank_days ; $x++) {
            $cal[$row][$trow]['num'] = null;
            $cal[$row][$trow]['link'] = null;
            $cal[$row][$trow]['title'] = null;
            $trow++;
        }

        // création tableau
        for ($x = 1 ; $x <= $nb_days_in_month ; $x++) {
            // nouvelle semaine
            if (($x + $blank_days - 1) % 7 == 0) {
                $row++;
            }
            $date = date('Y-m-d', mktime(0, 0, 0, $month, $x, $year));
            $cal[$row][$trow]['num'] = $x;
            $cal[$row][$trow]['selected'] = false;
            if ($day == $x) {
                $cal[$row][$trow]['selected'] = true;
            }
            if (array_key_exists($date, $events)) {
                $cal[$row][$trow]['link'] = '?y='.$year.'&m='.$month.'&d='.$x;
                $cal[$row][$trow]['title'] = $events[$date] . ' events';
            } else {
                $cal[$row][$trow]['link'] = null;
                $cal[$row][$trow]['title'] = null;
            }
            $trow++;
        }

        // blancs de fin de mois
        while ((($nb_days_in_month + $blank_days) % 7) !== 0 ) {
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
     * formatage d'un poids de fichier
     *
     * @param int $size
     * @return string
     */
    static function modifier_format_size(int $size) : string
    {
        $sizes = ["  o", " Ko", " Mo", " Go", " To", " Po", " Eo", " Zo", " Yo"];
        if ($size == 0) {
            return('0  o');
        } else {
            return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
        }
    }

    /**
     * récupère le pseudo à partir de l'id_contact et fait un cache
     * pour l'instance
     */
    static function modifier_pseudo_by_id(int $id_contact) : string
    {
        if (array_key_exists($id_contact, self::$pseudos)) {
            return self::$pseudos[$id_contact];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT `pseudo` "
             . "FROM `adhoc_membre` "
             . "WHERE `id_contact` = " . (int) $id_contact;

        self::$pseudos[$id_contact] = $db->queryWithFetchFirstField($sql);

        return self::$pseudos[$id_contact];
    }

    /**
     * récupère l'avatar à partir de l'id_contact et fait un cache
     * pour l'instance
     */
    static function modifier_avatar_by_id(int $id_contact) : string
    {
        if (array_key_exists($id_contact, self::$avatars)) {
            return self::$avatars[$id_contact];
        }

        $url = '';
        if (file_exists(MEDIA_PATH . '/membre/' . $id_contact . '.jpg')) {
            $url = MEDIA_URL . '/membre/' . $id_contact . '.jpg';
        }

        self::$avatars[$id_contact] = $url;

        return self::$avatars[$id_contact];
    }

    /**
     * récupère l'url de l'icone (tick/cross) relative à une valeur booléenne
     */
    static function modifier_display_on_off_icon(bool $val) : string
    {
        if ((bool) $val) {
            $icon = 'enabled.png';
        } else {
            $icon = 'disabled.png';
        }
        return '<img src="/img/icones/' . $icon . '" alt="">';
    }

    /**
     * @param mixed $val
     */
    static function modifier_json_encode_numeric_check($val)
    {
        return json_encode($val, JSON_NUMERIC_CHECK);
    }

    /* fin modifiers */

    /**
     * Ajoute d'une feuille de style
     *
     * @param string $style_name url de la feuille de style
     */
    function enqueue_style($style_name)
    {
        $this->append('stylesheets', $style_name);
    }

    /**
     * Ajoute un javascript externe dans le footer
     *
     * @param string $script_name url du script
     * @param bool $in_footer
     */
    function enqueue_script($script_name, $in_footer = true)
    {
        if ($in_footer) {
            $this->append('footer_scripts', $script_name);
        } else {
            $this->append('header_scripts', $script_name);
        }
    }

    /**
     * ajoute une variable js utilisable dans les scripts du footer
     * 
     * @param string $key
     * @param string $val
     */
    function enqueue_script_var($key, $val)
    {
        $this->script_vars[$key] = $val;
        $this->assign('script_vars', $this->script_vars);
    }

    /**
     * imprime un javascript en ligne dans le footer
     *
     * @param string $script
     */
    function print_inline_script($script)
    {
        $this->append('inline_scripts', $script);
    }

    /**
     * on hérite de Smarty::fetch
     *
     * @param string $ |object $template the resource handle of the template file  or template object
     * @param mixed $cache_id cache id to be used with this template
     * @param mixed $compile_id compile id to be used with this template
     * @param object $parent next higher level of Smarty variables
     */
    function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false)
    {
        /* fil d'ariane */
        $trail = Trail::getInstance();
        $this->assign('trail', $trail->getPath());

        return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
    }
}
