<?php

/**
 * fonctions et modifiers custom pour Smarty
 */
class AdHocSmarty extends Smarty
{
    protected static $pseudos = array();
    protected static $avatars = array();

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
        $this->registerPlugin('function', 'audio_player', array('AdHocSmarty', 'function_audio_player'));
        $this->registerPlugin('function', 'pagination', array('AdHocSmarty', 'function_pagination'));
        $this->registerPlugin('function', 'html_input_date_hourminute', array('AdHocSmarty', 'function_html_input_date_hourminute'));
        $this->registerPlugin('function', 'calendar', array('AdHocSmarty', 'function_calendar'));
        $this->registerPlugin('function', 'css_border_radius', array('AdHocSmarty', 'function_css_border_radius'));
        $this->registerPlugin('function', 'image', array('EmailSmarty', 'function_image'));

        // modifiers smarty
        $this->registerPlugin('modifier', 'format_size', array('AdHocSmarty', 'modifier_format_size'));
        $this->registerPlugin('modifier', 'pseudo_by_id', array('AdHocSmarty', 'modifier_pseudo_by_id'));
        $this->registerPlugin('modifier', 'avatar_by_id', array('AdHocSmarty', 'modifier_avatar_by_id'));
        $this->registerPlugin('modifier', 'display_on_off_icon', array('AdHocSmarty', 'modifier_display_on_off_icon'));

        // blocks smarty
        $this->registerPlugin('block', 't', array('AdHocSmarty', 'block_t'));

        // assignations générales
        $this->assign('title', "♫ AD'HOC : Les Musiques Actuelles");
        $this->assign('svnrev', '6666'/*Tools::getHeadRevision()*/);
        $this->assign('sessid', session_id());
        $this->assign('menuselected', null);
        $this->assign('uri', $_SERVER['REQUEST_URI']);
        $this->assign('url', DYN_URL . $_SERVER['REQUEST_URI']);
        $this->assign('fb_app_id', FB_ADHOCMUSIC_APP_ID);
        $this->assign('fb_page_id', FB_ADHOCMUSIC_PAGE_ID);

        if(defined('STATIC_URL')) {
            $this->config_vars['STATIC_URL'] = STATIC_URL;
        }

        if(!empty($_SESSION['membre'])) {
            $this->assign('me', $_SESSION['membre']);
        }

        if(defined('ADHOC_COUNTERS')) {
            if(!empty($_SESSION['membre'])) {
                $this->assign('is_auth', true);

                $this->assign('my_counters', array(
                    'nb_unread_messages' => (int) Messagerie::getMyUnreadMessagesCount(),
                    'nb_messages'        => (int) Messagerie::getMyMessagesCount(),
                    //'nb_groupes'         => (int) Groupe::getMyGroupesCount(),
                    //'nb_photos'          => (int) Photo::getMyPhotosCount(),
                    //'nb_audios'          => (int) Audio::getMyAudiosCount(),
                    //'nb_videos'          => (int) Video::getMyVideosCount(),
                    //'nb_events'          => (int) Event::getMyEventsCount(),
                    //'nb_lieux'           => (int) Lieu::getMyLieuxCount(),
                ));

            } else {
                $this->assign('is_auth', false);
                $this->assign('my_counters', false);
            }
            $this->assign('global_counters', array(
                'nb_groupes' => 426,// (int) Groupe::getGroupesCount(Groupe::ETAT_ACTIF),
                'nb_events'  => 5401,// (int) Event::getEventsCount(),
                'nb_lieux'   => 1759,// (int) Lieu::getLieuxCount(),
            ));
        }

        $this->enqueue_style('/css/adhoc.css?v=20150909');

        $this->enqueue_script('/js/jquery-2.2.0.min.js');
        $this->enqueue_script('/js/adhoc.20160124.js');

        $this->print_inline_script(file_get_contents(ADHOC_ROOT_PATH . '/app/assets/js/google-analytics.js'));
        $this->print_inline_script(file_get_contents(ADHOC_ROOT_PATH . '/app/assets/js/facebook-sdk.js'));

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
    static function function_audio_player($params)
    {
        if(!array_key_exists('id', $params)) {
            return '';
        }
        if(!array_key_exists('type', $params)) {
            $params['type']  = 'dewplayer';
        }

        $bgcolor = '666666';

        if($params['type'] === 'player_mp3_multi') {
            $id_groupe = $params['id'];
        } elseif($params['type'] === 'webradio') {
            $chemin = $params['id'];
            $type = 'dewplayer';
        } else {
            $chemin = '';
            if(is_numeric($params['id'])) {
                $chemin .= STATIC_URL . '/media/audio/'.$params['id'].'.mp3';
            } elseif(is_array($params['id'])) {
                $first  = true;
                foreach($params['id'] as $id) {
                    if(!$first) { $chemin .= '|'; }
                    $chemin .= STATIC_URL . '/media/audio/'.$id.'.mp3';
                    $first = false;
                }
            } else {
                return false;
            }
        }

        switch($params['type'])
        {
            case 'dewplayer-mini':
                return '<object type="application/x-shockwave-flash" data="' . STATIC_URL . '/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="160" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="' . STATIC_URL. '/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer':
                return '<object type="application/x-shockwave-flash" data="' . STATIC_URL . '/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="200" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="' . STATIC_URL . '/swf/dewplayer.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'dewplayer-multi':
                return '<object type="application/x-shockwave-flash" data="' . STATIC_URL . '/swf/dewplayer-mini.swf?mp3='.urlencode($chemin).'&amp;bgcolor='.$bgcolor.'&amp;showtime=1" width="240" height="20">'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="movie" value="' . STATIC_URL . '/swf/dewplayer-multi.swf?mp3='.urlencode($chemin).'.mp3&amp;bgcolor='.$bgcolor.'&amp;showtime=1" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_multi':
                return '<object type="application/x-shockwave-flash" data="' . STATIC_URL . '/swf/player_mp3_multi.swf" width="250" height="150">'."\n"
                     . '<param name="movie" value="' . STATIC_URL . '/swf/player_mp3_multi.swf" />'."\n"
                     . '<param name="wmode" value="transparent" />'."\n"
                     . '<param name="FlashVars" value="configxml=http://www.adhocmusic.com/groupes/playlist/'.$id_groupe.'.xml&amp;skin" />'."\n"
                     . '</object>'."\n";
                break;

            case 'player_mp3_nano':
                return '<object type="application/x-shockwave-flash" data="' . STATIC_URL . '/swf/player_mp3_maxi.swf" width="25" height="20">'."\n"
                     . '<param name="movie" value="' . STATIC_URL . '/swf/player_mp3_maxi.swf" />'."\n"
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
    static function function_pagination($params)
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

        if (array_key_exists('link_base_params', $params) && $params['link_base_params'] != '') {
            $link_base_params = '?'.$params['link_base_params'].'&amp;';
        } else {
            $link_base_params = '?';
        }

        if ($p->hasPagination()) {
            $out .= '<div class="pagination">' . "\n";
            if($p->getNbPages() <= $p->getNbLinks()) {
                 // pagination simple 1 2 3 4 5
                 for($i = $p->getFirstPage() ; $i <= $p->getLastPage() ; $i++) {
                     $p->setCurrentPage($i);
                     $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>' . "\n";
                 }
            } else {
                // pagination étendue
                if($p->getSelectedPage() < ($p->getNbLinks() - 2)) {
                    // type début  : 1 2 3 4 ... 50
                    for($i = $p->getFirstPage() ; $i < $p->getNbLinks() - 1 ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>' . "\n";
                    }
                    $out .= ' ... ' . "\n";
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getLastPage().'" class="unselectedpage">'.$p->getLastPageNum().'</a>' . "\n";
                } elseif($p->getSelectedPage() > ($p->getNbPages() - $p->getNbLinks() + 1)) {
                    // type fin    : 1 ... 47 48 49 50
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getFirstPage().'" class="unselectedpage">'.$p->getFirstPageNum().'</a>' . "\n";
                    $out .= ' ... ' . "\n";
                    for($i = $p->getLastPage() - $p->getNbLinks() + 2 ; $i <= $p->getLastPage() ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>' . "\n";
                    }
                } else {
                    // type milieu : 1 ... 24 25 26 ... 50
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getFirstPage().'" class="unselectedpage">'.$p->getFirstPageNum().'</a>' . "\n";
                    $out .= ' ... ';
                    for($i = ($p->getSelectedPage() - floor($p->getNbLinks() / 2) + 1) ; $i < ($p->getSelectedPage() + floor($p->getNbLinks() / 2)) ; $i++) {
                        $p->setCurrentPage($i);
                        $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getCurrentPage().'" class="'.$p->getClass().'">'.$p->getCurrentPageNum().'</a>' . "\n";
                    }
                    $out .= ' ... ' . "\n";
                    $out .= '<a href="'.$link_page.$link_base_params.'page='.$p->getLastPage().'" class="unselectedpage">'.$p->getLastPageNum().'</a>' . "\n";
                }
            }
            $out .= '</div>';
        }
        return $out;
    }

    /**
     * @param array ['hour'] ['minute'] ['step']
     */
    static function function_html_input_date_hourminute($params)
    {
        $hour = 0;
        if(array_key_exists('hour', $params)) {
            $hour = (int) $params['hour'];
        }

        $minute = 0;
        if(array_key_exists('minute', $params)) {
            $minute = (int) $params['minute'];
        }

        $step = 30;
        if(array_key_exists('step', $params)) {
            $step = (int) $params['step'];
        }

        $hourminute = str_pad((int) $hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad((int) $minute, 2, '0', STR_PAD_LEFT);

        $out = '';
        for ($h = 0 ; $h < 24 ; $h++) {
            for ($m = 0 ; $m < 60 ; $m += $step) {
                $hm = str_pad((int) $h, 2, '0', STR_PAD_LEFT) . ':' . str_pad((int) $m, 2, '0', STR_PAD_LEFT);
                $out .= "<option value=\"".$hm."\"";
                if($hm == $hourminute) {
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
    static function function_calendar($params)
    {
        $now  = time();
        $months = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        $cal  = array();

        $year = date('Y', $now);
        if(array_key_exists('year', $params)) {
             $year = (int) $params['year'];
        }

        $month = date('m', $now);
        if(array_key_exists('month', $params)) {
            $month = (int) $params['month'];
        }

        $day = date('d', $now);
        if(array_key_exists('day', $params)) {
            $day = (int) $params['day'];
        }

        $start_day = mktime(0, 0, 0, $month, 1, $year); // ts du 1er du mois
        $start_day_number = date('w', $start_day);      // n° du jour du 1er du mois (0-6)
        $nb_days_in_month = date('t', $start_day);      // nombre de jours dans le mois
        $row  = 0; // n° ligne
        $trow = 0; // compteur global

        $blank_days = $start_day_number - 1;
        if($blank_days < 0) {
            $blank_days = 7 - abs($blank_days);
        }

        $events = Event::getEventsForAMonth($year, $month);

        // blancs de début de mois
        for($x = 0 ; $x < $blank_days ; $x++) {
            $cal[$row][$trow]['num'] = null;
            $cal[$row][$trow]['link'] = null;
            $cal[$row][$trow]['title'] = null;
            $trow++;
        }

        // création tableau
        for($x = 1 ; $x <= $nb_days_in_month ; $x++) {
            // nouvelle semaine
            if(($x + $blank_days - 1) % 7 == 0) {
                $row++;
            }
            $date = date('Y-m-d', mktime(0, 0, 0, $month, $x, $year));
            $cal[$row][$trow]['num'] = $x;
            $cal[$row][$trow]['selected'] = false;
            if($day == $x) {
                $cal[$row][$trow]['selected'] = true;
            }
            if(array_key_exists($date, $events)) {
                $cal[$row][$trow]['link'] = '?y='.$year.'&m='.$month.'&d='.$x;
                $cal[$row][$trow]['title'] = $events[$date] . ' events';
            } else {
                $cal[$row][$trow]['link'] = null;
                $cal[$row][$trow]['title'] = null;
            }
            $trow++;
        }

        // blancs de fin de mois
        while((($nb_days_in_month + $blank_days) % 7) != 0 ) {
            $cal[$row][$trow]['num'] = null;
            $cal[$row][$trow]['link'] = null;
            $cal[$row][$trow]['title'] = null;
            $nb_days_in_month++;
            $trow++;
        }

        if($month == 1) {
            $prev_month = 12;
            $prev_year = $year - 1;
        } else {
            $prev_month = $month - 1;
            $prev_year = $year;
        }
        if($month == 12) {
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

    /**
     * compatibilité css multi-browser
     * @param array ['radius']
     */
    static function function_css_border_radius($params)
    {
        $css  = "border-radius: " . $params['radius'] . ";\n";
        $css .= "    -moz-border-radius: " . $params['radius'] . ";\n";
        $css .= "    -webkit-border-radius: " . $params['radius'] . ";\n";
        return $css;
    }

    /* fin fonctions */

    /* début modifiers */

    /**
     * formatage d'un poids de fichier
     *
     * @param int $size
     * @return string
     */
    static function modifier_format_size($size)
    {
        $sizes = array("  o", " Ko", " Mo", " Go", " To", " Po", " Eo", " Zo", " Yo");
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
    static function modifier_pseudo_by_id($id_contact)
    {
        if(array_key_exists($id_contact, self::$pseudos)) {
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
    static function modifier_avatar_by_id($id_contact)
    {
        if(array_key_exists($id_contact, self::$avatars)) {
            return self::$avatars[$id_contact];
        }

        $url = '';
        if(file_exists(ADHOC_ROOT_PATH . '/media/membre/' . $id_contact . '.jpg')) {
            $url = STATIC_URL . '/media/membre/' . $id_contact . '.jpg';
        }

        self::$avatars[$id_contact] = $url;

        return self::$avatars[$id_contact];
    }

    /**
     * récupère l'url de l'icone (tick/cross) relative à une valeur booléenne
     */
    static function modifier_display_on_off_icon($val)
    {
        if((bool) $val) {
            $icon = 'enabled.png';
        } else {
            $icon = 'disabled.png';
        }
        return '<img src="' . STATIC_URL . '/img/icones/' . $icon . '" alt="" />';
    }

    /* fin modifiers */

    /**
     * translate
     *
     * @param unknown_type $string
     * @param unknown_type $arguments
     * @param unknown_type $options
     * @throws Exception
     */
    static function translate($string, $arguments = array(), $options = array())
    {
        $module = empty($options['module']) ? false : $options['module'];
        $locale = empty($options['locale']) ? false : $options['locale'];

        $plural = (is_array($string) && isset($string[1])) ? $string[1] : false;
        $string = (is_array($string) && isset($string[0])) ? $string[0] : (string) $string;

        $out = $string;

        if ($plural && !isset($arguments['count'])) {
            throw new Exception("You need to supply a 'count' argument when using plural form.");
        }

        if ($module) {
            if ($plural) {
                $out = dngettext($module, $string, $plural, (int) $arguments['count']);
            } else {
                $out = dgettext($module, $string);
            }
        } else {
            if ($plural) {
                $out = ngettext($string, $plural, (int) $arguments['count']);
            } else {
                $out = gettext($string);
            }
        }
        if (count($arguments)) {
            foreach ($arguments as $key => $value) {
                $out = str_replace('%' . $key, $value, $out);
            }
        }

        return $out;
    }

    /**
     * block t
     *
     * @param unknown_type $params
     * @param unknown_type $text
     * @param unknown_type $smarty
     * @param unknown_type $repeat
     */
    static function block_t($params, $text, $smarty, &$repeat)
    {
        if (is_null($text)) {
            return;
        }
        $text = trim($text);
        $options = array(
            'module' => isset($params['module']) ? $params['module'] : false,
            'locale' => isset($params['locale']) ? $params['locale'] : false
        );
        $assign = isset($params['assign']) ? $params['assign'] : false;
        $escape = isset($params['escape']) ? $params['escape'] : false;
        $escape_args = isset($params['escape_args']) ? $params['escape_args'] : 'html';

        $plural = isset($params['plural']) ? trim($params['plural']) : false;

        unset($params['escape'], $params['assign'], $params['locale'], $params['module'],
            $params['escape_args'], $params['plural']);

        if (!empty($params['id'])) {
            $id = $params['id'];
            $plural_id = $id . '_PLURAL';
        } else {
            $id = false;
        }
        unset($params['id']);
        if (count($params) && $escape_args) {
            foreach ($params as $key=>$value) {
                $params[$key] = self::smarty_modifier_escape($value, $escape_args);
            }
        }
        assert(empty($id));
        if ($id) {
            $out = locale::translate($plural ? array($id, $plural_id) : $id, $params, $options);
        }
        if (empty($out) || ($id && ($out == $id || $out == $plural_id))) {
            $out = self::translate($plural ? array($text, $plural) : $text, $params, $options);
        }
        if ($escape) {
            if ($escape === 'jquery_metadata') {
                $out = self::smarty_modifier_escape(smarty_modifier_escape($out, 'javascript'), 'html');
            } else {
                $out = self::smarty_modifier_escape($out, $escape);
            }
        }
        if ($assign) {
            $smarty->assign($assign, $out);
            return TRUE;
        }
        return $out;
    }

    /**
     * Ajoute d'une feuille de style
     *
     * @param string $style_name url de la feuille de style
     */
    function enqueue_style($style_name)
    {
        $this->append('styles', $style_name);
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
        if(defined('TRAIL_ENABLED')) {
            $trail = Trail::getInstance();
            $this->assign('trail', $trail->getPath());
        }

        return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
    }
}
