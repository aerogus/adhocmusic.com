<?php

/**
 * @package adhoc
 */

/**
 * Classe Article
 *
 * Classe de gestion des Articles
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Article extends ObjectModel
{
    /**
     * constantes des rubriques
     */
    const RUBRIQUE_CHRONIQUES = 2;
    const RUBRIQUE_ITW        = 3;
    const RUBRIQUE_DOSSIERS   = 4;
    const RUBRIQUE_PEDAGOGIE  = 5;
    const RUBRIQUE_LIVE       = 7;
    const RUBRIQUE_PRESSE     = 8;

    /**
     * constantes pour adhoc_article_liens
     */
    const TYPE_LIEN_EVENT  = 1;
    const TYPE_LIEN_GROUPE = 2;

    /**
     * Tableau des rubriques
     *
     * @var array
     */
    protected static $_rubriques = array(
        self::RUBRIQUE_CHRONIQUES => array(
            'id' => self::RUBRIQUE_CHRONIQUES,
            'alias' => "chroniques",
            'title' => "Chroniques",
            'description' => "Les Chroniques d'Albums",
            'image' => "",
            'url' => "/articles/chroniques",
        ),
        self::RUBRIQUE_PEDAGOGIE => array(
            'id' => self::RUBRIQUE_PEDAGOGIE,
            'alias' => "pedagogie",
            'title' => "Pédagogie",
            'description' => "Pédagogie musicale",
            'image' => "",
            'url' => "/articles/pedagogie",
        ),
        self::RUBRIQUE_LIVE => array(
            'id' => self::RUBRIQUE_LIVE,
            'alias' => "live",
            'title' => "Live Reports",
            'description' => "Les chroniques de concerts",
            'image' => "",
            'url' => "/articles/live",
        ),
        self::RUBRIQUE_DOSSIERS => array(
            'id' => self::RUBRIQUE_DOSSIERS,
            'alias' => "dossiers",
            'title' => "Dossiers",
            'description' => "Dossiers spéciaux",
            'image' => "",
            'url' => "/articles/dossiers",
        ),
        self::RUBRIQUE_ITW => array(
            'id' => self::RUBRIQUE_ITW,
            'alias' => "interviews",
            'title' => "Interviews",
            'description' => "Interviews d'artistes, groupes ...",
            'image' => "",
            'url' => "/articles/interviews",
        ),
        self::RUBRIQUE_PRESSE => array(
            'id' => self::RUBRIQUE_PRESSE,
            'alias' => "locale",
            'title' => "Revue de presse",
            'description' => "Toute l'actualité musicale locale dans la presse",
            'image' => "",
            'url' => "/articles/locale",
        ),
    );

    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_article';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_article';

    /**
     * @var int
     */
    protected $_id_article = 0;

    /**
     * Date de création
     * @var string
     */
    protected $_created_on = '';

    /**
     * Date de modification
     * @var string
     */
    protected $_modified_on = '';

    /**
     * id de l'auteur
     * @var int
     */
    protected $_id_contact = 0;

    /**
     * pseudo de l'auteur
     * @var string
     */
    protected $_pseudo = '';

    /**
     * Rubrique de l'article
     * @var int
     */
    protected $_id_rubrique = 0;

    /**
     * titre de l'article
     * @var string
     */
    protected $_title = '';

    /**
     * Alias de l'article
     * @var string
     */
    protected $_alias = '';

    /**
     * introduction de l'article
     * @var string
     */
    protected $_intro = '';

    /**
     * contenu de l'article
     * @var string
     */
    protected $_text = '';

    /**
     * article en ligne ?
     * @var bool
     */
    protected $_online = false;

    /**
     * nom de consultation
     * @var int
     */
    protected $_visite = 0;

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * - booléen (= bool)
     * ceci est utile pour la formation de la requête
     * @var array
     */
    protected static $_all_fields = array(
        'created_on'  => 'str',
        'modified_on' => 'str',
        'id_contact'  => 'num',
        'id_rubrique' => 'num',
        'title'       => 'str',
        'alias'       => 'str',
        'intro'       => 'str',
        'text'        => 'str',
        'online'      => 'bool',
        'visite'      => 'num',
    );

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     * @var array
     */
    protected $_modified_fields = array();

    /* début getters */

    /**
     * @return string
     */
    public function getCreatedOn()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (string) $this->_created_on;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCreatedOnTs()
    {
        if(Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getModifiedOn()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (string) $this->_modified_on;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getModifiedOnTs()
    {
        if(Date::isDateTimeOk($this->_modified_on)) {
            return (int) strtotime($this->_modified_on);
        }
        return false;
    }

    /**
     * @return int
     */
    public function getIdContact()
    {
        return (int) $this->_id_contact;
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return (string) $this->_pseudo;
    }

    /**
     * @return int
     */
    public function getIdRubrique()
    {
        return (int) $this->_id_rubrique;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string) $this->_title;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return (string) $this->_alias;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return (string) $this->_intro;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return (string) $this->_text;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return self::getImageById($this->getId(), $this->getIdRubrique());
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getImageById($id_article, $id_rubrique = null)
    {
        // image 100x100 de l'image
        $p = STATIC_URL . '/media/article/p/' . $id_article . '.jpg';
        return $p;
        /*
        if(file_exists($p)) {
            return self::_getWwwPath() . '/media/article/p/' . $id_article . '.jpg';
        }
        if($id_rubrique) {
            // fallback image 100x100 de la rubrique
            $r = STATIC_URL . '/media/article/r/' . $id_rubrique . '.jpg';
            if(file_exists($r) {
                return self::_getWwwPath() . '/media/article/r' . $id_rubrique . '.jpg';
            }
        }
        */
        return false;
    }

    /**
     * @return bool
     */
    public function getOnline()
    {
        return (bool) $this->_online;
    }

    /**
     * @return int
     */
    public function getVisite()
    {
        return (int) $this->_visite;
    }

    /**
     * @return string
     */
    public function getUrl($type = null)
    {
        return self::getUrlById($this->getId(), $this->getAlias(), $type);
    }

    /**
     * @return string
     */
    public static function getUrlById($id_article, $alias, $type = null)
    {
        if($type == 'www') {
            return 'http://www.adhocmusic.com/articles/show/' . $id_article . '-' . $alias;
        }
        return DYN_URL . '/articles/show/' . $id_article . '-' . $alias;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string
     */
    public function setCreatedOn($val)
    {
        if($this->_created_on != $val)
        {
            $this->_created_on = (string) $val;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * @param string
     */
    public function setModifiedOn($val)
    {
        if($this->_modified_on != $val)
        {
            $this->_modified_on = (string) $val;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * @param int
     */
    public function setIdContact($val)
    {
        if($this->_id_contact != $val)
        {
            $this->_id_contact = (int) $val;
            $this->_modified_fields['id_contact'] = true;
        }
    }

    /**
     * @param int
     */
    public function setIdRubrique($val)
    {
        if($this->_id_rubrique != $val)
        {
            $this->_id_rubrique = (int) $val;
            $this->_modified_fields['id_rubrique'] = true;
        }
    }

    /**
     * @param string
     */
    public function setTitle($val)
    {
        if($this->_title != $val)
        {
            $this->_title = (string) $val;
            $this->_modified_fields['title'] = true;
        }
    }

    /**
     * @param string
     */
    public function setAlias($val)
    {
        $val = self::genAlias($val);

        if($this->_alias != $val)
        {
            $this->_alias = (string) $val;
            $this->_modified_fields['alias'] = true;
        }
    }

    /**
     * @param string
     */
    public function setRawAlias($val)
    {
        if($this->_alias != $val)
        {
            $this->_alias = (string) $val;
            $this->_modified_fields['alias'] = true;
        }
    }

    /**
     * @param string
     */
    public function setIntro($val)
    {
        if($this->_intro != $val)
        {
            $this->_intro = (string) $val;
            $this->_modified_fields['intro'] = true;
        }
    }

    /**
     * @param string
     */
    public function setText($val)
    {
        if($this->_text != $val)
        {
            $this->_text = (string) $val;
            $this->_modified_fields['text'] = true;
        }
    }

    /**
     * @param int
     */
    public function setOnline($val)
    {
        if($this->_online != $val)
        {
            $this->_online = (int) $val;
            $this->_modified_fields['online'] = true;
        }
    }

    /**
     * @param int
     */
    public function setVisite($val)
    {
        if($this->_visite != $val)
        {
            $this->_visite = (int) $val;
            $this->_modified_fields['visite'] = true;
        }
    }

    /* fin setters */

    /**
     * Défini la date de modification
     */
    public function setCreatedNow()
    {
        $now = date('Y-m-d H:i:s');

        if($this->_created_on != $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }
    }

    /**
     * Défini la date de modification
     */
    public function setModifiedNow()
    {
        $now = date('Y-m-d H:i:s');

        if($this->_modified_on != $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }
    }

    /**
     * ajoute une visite
     */
    public function addVisite()
    {
        $this->setVisite($this->getVisite() + 1);
        $this->save();
    }

    /**
     * @static
     * @return int
     */
    public static function getMyArticlesCount()
    {
        if(empty($_SESSION['membre'])) {
            throw new AdHocUserException('non identifié');
        }

        if(isset($_SESSION['my_counters']['nb_articles'])) {
            return $_SESSION['my_counters']['nb_articles'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_article . "` "
             . "WHERE `id_contact` = " . (int) $_SESSION['membre']->getId();

        $nb_articles = $db->queryWithFetchFirstField($sql);

        $_SESSION['my_counters']['nb_articles'] = $nb_articles;

        return $_SESSION['my_counters']['nb_articles'];
    }

    /**
     * @static
     * @param int id_contact
     * @return int
     */
    public static function getArticlesCount($id_rubrique = null)
    {
        if(is_null($id_rubrique) && isset($_SESSION['global_counters']['nb_articles'])) {
            return $_SESSION['global_counters']['nb_articles'];
        }

        $db = DataBase::getInstance();

        $sql = "SELECT COUNT(*) "
             . "FROM `" . self::$_db_table_article . "` "
             . "WHERE 1 ";

        if(!is_null($id_rubrique)) {
            $sql .= "AND `id_rubrique` = " . (int) $id_rubrique;
        }

        $nb_articles = $db->queryWithFetchFirstField($sql);

        if(is_null($id_rubrique)) {
            $_SESSION['global_counters']['nb_articles'] = $nb_articles;
        }

        return $nb_articles;
    }

    /**
     * retourne une liste d'articles en fonction de critères donnés
     *
     * @param array
     * @return array
     */
    public static function getArticles($params = array())
    {
        $debut = 0;
        if(isset($params['debut'])) {
            $debut = (int) $params['debut'];
        }

        $limit = 10;
        if(isset($params['limit'])) {
            if($params['limit'] === false) {
                $limit = false;
            } else {
                $limit = (int) $params['limit'];
            }
        }

        $sens = "ASC";
        if(isset($params['sens']) && $params['sens'] == "DESC") {
            $sens = "DESC";
        }

        $sort = "id_article";
        if(isset($params['sort'])
          && ($params['sort'] == "created_on" || $params['sort'] == "random")) {
            $sort = $params['sort'];
        }

        $tab_id       = array();
        $tab_contact  = array();
        $tab_rubrique = array();

        if(array_key_exists('id', $params))       { $tab_id       = explode(",", $params['id']); }
        if(array_key_exists('contact', $params))  { $tab_contact  = explode(",", $params['contact']); }
        if(array_key_exists('rubrique', $params)) { $tab_rubrique = explode(",", $params['rubrique']); }

        $db = DataBase::getInstance();

        $sql = "SELECT `a`.`id_article` AS `id`, `a`.`created_on`, `a`.`modified_on`, `a`.`title`, `a`.`alias`, `a`.`intro`, "
             . "`a`.`visite`, `a`.`online`, `a`.`id_rubrique`, `a`.`id_contact`, `m`.`pseudo` "
             . "FROM `" . self::$_db_table_article . "` `a`, `" . self::$_db_table_membre . "` `m` "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` ";

        if(array_key_exists('online', $params)) {
            if($params['online']) {
                $online = 'TRUE';
            } else {
                $online = 'FALSE';
            }
            $sql .= "AND `a`.`online` = " . $online . " ";
        }

        if(count($tab_id) && ($tab_id[0] != 0)) {
            $sql .= "AND `a`.`id_article` IN (" . implode(',', $tab_id) . ") ";
        }

        if(count($tab_contact) && ($tab_contact[0] != 0)) {
            $sql .= "AND `a`.`id_contact` IN (" . implode(',', $tab_contact) . ") ";
        }

        if(count($tab_rubrique) && ($tab_rubrique[0] != 0)) {
            $sql .= "AND `a`.`id_rubrique` IN (" . implode(',', $tab_rubrique) . ") ";
        }

        $sql .= "ORDER BY ";
        if($sort == "random") {
            $sql .= "RAND(" . time() . ") ";
        } else {
            $sql .= "`" . $sort . "` " . $sens . " ";
        }

        if($limit) {
            $sql .= "LIMIT " . $debut . ", " . $limit;
        }

        $res = $db->queryWithFetch($sql);

        foreach($res as $id => $_res) {
            $res[$id]['url'] = self::getUrlById($_res['id'], $_res['alias']);
            $res[$id]['image'] = self::getImageById($_res['id'], $_res['id_rubrique']);
            $res[$id]['rubrique'] = self::getRubriqueName($_res['id_rubrique']);
            $res[$id]['rubrique_icon'] = STATIC_URL . '/img/rubriques/' . self::$_rubriques[$_res['id_rubrique']]['alias'] . '.png';
            $res[$id]['rubrique_title'] = self::$_rubriques[$_res['id_rubrique']]['title'];
            $res[$id]['rubrique_alias'] = self::$_rubriques[$_res['id_rubrique']]['alias'];
            $res[$id]['rubrique_description'] = self::$_rubriques[$_res['id_rubrique']]['description'];
        }

        if($limit == 1) {
            $res = array_pop($res);
        }

        return $res;
    }

    /**
     *
     */
    protected function _loadFromDb()
    {
        $db  = DataBase::getInstance();

        $sql = "SELECT `a`.`id_article`, `a`.`created_on`, `a`.`modified_on`, `a`.`id_contact`, `m`.`pseudo`, "
             . "`a`.`id_rubrique`, `a`.`title`, `a`.`alias`, `a`.`intro`, `a`.`text`, "
             . "`a`.`online`, `a`.`visite` "
             . "FROM `" . self::$_db_table_article . "` `a`, `" . self::$_db_table_membre . "` `m` "
             . "WHERE `m`.`id_contact` = `a`.`id_contact` "
             . "AND `a`.`id_article` = " . (int) $this->getId();

        if($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new AdHocUserException('Article introuvable', EXCEPTION_USER_UNKNOW_ID);
    }

    public static function getLastArticlesByRubriques($nb_articles = 2)
    {
        // nb_articles entre 2 et 5

        $db  = DataBase::getInstance();

        $sql = "SELECT a1.* "
             . "FROM adhoc_article a1 "
             . "LEFT OUTER JOIN adhoc_article a2 "
             . "ON (a1.id_rubrique = a2.id_rubrique AND a1.id_article < a2.id_article) "
             . "WHERE a1.online "
             . "GROUP BY a1.id_article "
             . "HAVING COUNT(*) < " . (int) $nb_articles . " "
             . "ORDER BY id_rubrique ASC, created_on DESC";

        $res = $db->queryWithFetch($sql);

        $tab = array();
        foreach($res as $_res)
        {
            if(!array_key_exists($_res['id_rubrique'], $tab)) {
                $_tab['id_rubrique'] = array();
                $cpt = 0;
            }
            $tab[$_res['id_rubrique']][$cpt] = $_res;
            $tab[$_res['id_rubrique']][$cpt]['url'] = self::getUrlById($_res['id_article'], $_res['alias']);
            $tab[$_res['id_rubrique']][$cpt]['image'] = self::getImageById($_res['id_article'], $_res['id_rubrique']);
            $cpt++;
        }

        return $tab;
    }

    /**
     * retourne la liste des rubriques
     *
     * @return array
     */
    public static function getRubriques($count_article = false)
    {
        if($count_article) {
            $db  = DataBase::getInstance();

            $sql = "SELECT `a`.`id_rubrique` AS `id_rubrique`, COUNT(*) AS `nb_articles` "
                 . "FROM `" . self::$_db_table_article . "` `a` "
                 . "WHERE `a`.`online` "
                 . "GROUP BY `a`.`id_rubrique`";

            $res = $db->queryWithFetch($sql);

            foreach($res as $_res) {
                self::$_rubriques[$_res['id_rubrique']]['nb_articles'] = $_res['nb_articles'];
            }
        }

        return self::$_rubriques;
    }

    /**
     * retourne les infos sur une rubrique
     *
     * @return array
     */
    public static function getRubrique($cle)
    {
        if(array_key_exists($cle, self::$_rubriques)) {
            return self::$_rubriques[$cle];
        }
        return false;
    }

    /**
     * retourne le nom d'une rubrique
     *
     * @param int
     * @return string
     */
    public static function getRubriqueName($cle)
    {
        if(array_key_exists($cle, self::$_rubriques)) {
            return self::$_rubriques[$cle]['title'];
        }
        return false;
    }

    /**
     * retourne l'alias d'une rubrique
     *
     * @param int
     * @return string
     */
    public static function getRubriqueAlias($cle)
    {
        if(array_key_exists($cle, self::$_rubriques)) {
            return self::$_rubriques[$cle]['alias'];
        }
        return false;
    }

    /**
     * retourne la description d'une rubrique
     *
     * @param int
     * @return string
     */
    public static function getRubriqueDescription($cle)
    {
        if(array_key_exists($cle, self::$_rubriques)) {
            return self::$_rubriques[$cle]['description'];
        }
        return false;
    }

    /**
     * retourne la clé à partir de l'alias
     *
     * @param string
     * @return int
     */
    public static function getIdRubriqueByAlias($alias)
    {
        foreach(self::$_rubriques as $rubrique)
        {
            if($rubrique['alias'] === $alias) {
                return (int) $rubrique['id'];
            }
        }
        return false;
    }

    /**
     * retourne l'"alias" d'un titre d'article à partir de son nom réel
     * (= filtre les caratères non url-compliant)
     *
     * @param string $title
     * @return string
     */
    public static function genAlias($title)
    {
        $alias = trim($title);
        $alias = strtolower($alias);
        $alias = Tools::removeAccents($alias);
        $from = array('.', ' ', "'", '"', '&' , '(', ')', '!', '/', '#');
        $to   = array('-', '-', '' , '' , 'et', '' , '' , '' , '-', '');
        $alias = str_replace($from, $to, $alias);
        return $alias;
    }
}
