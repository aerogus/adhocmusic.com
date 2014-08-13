<?php

/**
 * @package adhoc
 */

/**
 * Un Blog AD'HOC est un espace privé où un groupe peut échanger des informations
 * (texte, audio, photo ...)
 */
class Blog
{
    /**
     * liste des types d'item
     */
    const TYPE_ARTICLE     = 1;
    const TYPE_COMMENTAIRE = 2;
    const TYPE_FICHIER     = 3;

    /**
     * liste des types de fichiers attachés supportés
     */
    const TYPEMIME_JPEG = 'image/jpeg';
    const TYPEMIME_MP3  = 'audio/mpeg';

    /**
     * la pk du blog :)
     */
    protected $_id_groupe = 0;
    protected $_alias_groupe = '';

    /* db */
    protected static $_db_table_blog   = 'adhoc_blog';
    protected static $_db_table_membre = 'adhoc_membre';

    /**
     *
     */
    protected static $_instance = null;

    /**
     * Constructeur de la classe
     *
     * @param int $id_groupe
     * @return void
     */
    public function __construct($id)
    {
        $this->_id_groupe = $id;
        $this->_alias_groupe = Groupe::getAliasById($id);
        self::$_instance = $this;
    }

    /**
     *
     */
    public static function getInstance($id)
    {
        if (is_null(self::$_instance)) {
            return new Blog($id);
        }
        return self::$_instance;
    }

    /**
     *
     */
    public static function deleteInstance()
    {
        if (isset(self::$_instance)) {
            self::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     * chemin de base du blog
     * @return string
     */
    protected function _getPath()
    {
        return ADHOC_ROOT_PATH . '/media/blog/' . $this->_alias_groupe;
    }

    /**
     * retourne sous forme d'un tableau structuré les infos du blog
     */
    public function getBlog()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `b`.`id`, `b`.`id_type`, `b`.`id_parent`, `b`.`id_contact`, "
             . "`m`.`pseudo`, `b`.`title`, `b`.`text`, `b`.`date` "
             . "FROM `" . self::$_db_table_blog . "` `b`, `" . self::$_db_table_membre . "` `m` "
             . "WHERE `b`.`id_contact` = `m`.`id_contact` "
             . "AND `b`.`id_groupe` = " . (int) $this->_id_groupe . " "
             . "ORDER BY `b`.`id` ASC";

        $res  = $db->queryWithFetch($sql);

        $tab = array();
        foreach($res as $item)
        {
            if($item['id_type'] == self::TYPE_ARTICLE) {
                $tab[$item['id']] = array(
                    'id'          => $item['id'],
                    'id_contact'  => $item['id_contact'],
                    'pseudo'      => $item['pseudo'],
                    'date'        => $item['date'],
                    'title'       => $item['title'],
                    'text'        => $item['text'],
                    'comments'    => array(),
                    'nb_comments' => 0,
                    'files'       => array(),
                    'nb_files'    => 0,
                );
            }
            if($item['id_type'] == self::TYPE_COMMENTAIRE) {
                if(array_key_exists($item['id_parent'], $tab)) {
                    $tab[$item['id_parent']]['comments'][$item['id']] = array(
                        'id'         => $item['id'],
                        'id_contact' => $item['id_contact'],
                        'date'       => $item['date'],
                        'text'       => $item['text'],
                        'pseudo'     => $item['pseudo'],
                    );
                    $tab[$item['id_parent']]['nb_comments']++;
                }
            }
            if($item['id_type'] == self::TYPE_FICHIER) {
                if(array_key_exists($item['id_parent'], $tab)) {
                    $tab[$item['id_parent']]['fichiers'][$item['id']] = array(
                        'id'         => $item['id'],
                        'id_contact' => $item['id_contact'],
                        'date'       => $item['date'],
                        'text'       => $item['text'],
                        'pseudo'     => $item['pseudo'],
                    );
                    $tab[$item['id_parent']]['nb_files']++;
                }
            }
        }
        krsort($tab); // tri anté-chronologique des articles
        return $tab;
    }

    /**
     * ajoute un commentaire à un article
     * @param array ['id_article']
     *              ['id_contact']
     *              ['texte']
     * @return bool
     */
    public function addComment($params)
    {
        return $this->addItem(array(
            'id_parent'  => $params['id_article'],
            'id_type'    => self::TYPE_COMMENTAIRE,
            'id_contact' => $params['id_contact'],
            'title'      => '',
            'text'       => $params['text'],
        ));
    }

    /**
     * gestion de l'upload du fichier
     */
    public function uploadFile($id_file, $file)
    {
        if(is_uploaded_file($_FILES['file']['tmp_name'])) {
            move_uploaded_file($_FILES['file']['tmp_name'], $this->_getPath().'/'.$id_file);
            return true;
        }
        return false;
    }

    /**
     * ajoute un fichier attaché à un article
     * @param array ['id_article']
     *              ['id_contact']
     *              ['title']
     * @return bool
     */
    public function addFile($params)
    {
        return $this->addItem(array(
            'id_parent'  => $params['id_article'],
            'id_type'    => self::TYPE_FICHIER,
            'id_contact' => $params['id_contact'],
            'title'      => $params['title'],
            'text'       => '',
        ));
    }

    /**
     * efface un fichier attaché
     *
     * @param int $id_fichier
     * @return bool
     */
    public function delFile($id)
    {
        return $this->delItem(array(
            'id'      => $id,
            'id_type' => self::TYPE_FICHIER,
        ));
    }

    /**
     * récupère les infos d'un article
     *
     * @param int $id
     *
     * @return array
     */
    public function getArticle($id)
    {
        return $this->getItem(array(
            'id'        => $id,
            'id_parent' => 0,
            'id_type'   => self::TYPE_ARTICLE,
        ));
    }

    /**
     * ajoute un article
     *
     * @param array ['id_contact']
     *              ['title']
     *              ['text']
     * @return bool
     */
    public function addArticle($params)
    {
        return $this->addItem(array(
            'id_parent'  => 0,
            'id_type'    => self::TYPE_ARTICLE,
            'id_contact' => $params['id_contact'],
            'title'      => $params['title'],
            'text'       => $params['text'],
        ));
    }

    /**
     * Edite un article
     *
     * @param array
     * @return bool
     */
    public function editArticle($params)
    {
        return $this->editItem(array(
            'id'         => $params['id'],
            'id_parent'  => 0,
            'id_type'    => self::TYPE_ARTICLE,
            'id_contact' => $params['id_contact'],
            'title'      => $params['title'],
            'text'       => $params['text'],
        ));
    }

    /**
     * Efface un article
     *
     * @param int $id
     * @return bool
     */
    public function delArticle($id)
    {
        return $this->delItem(array(
            'id'      => $id,
            'id_type' => self::TYPE_ARTICLE,
        ));
    }

    /**
     * Récupère un item en base
     *
     * @param array ['id_contact']
     *              ['id_type']
     *              ['id_parent']
     *              ['nom']
     */
    protected function getItem($params)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `b`.`id`, `b`.`id_type`, `b`.`id_parent`, `b`.`id_contact`, "
             . "`m`.`pseudo`, `b`.`title`, `b`.`text`, `b`.`date` "
             . "FROM `".self::$_db_table_blog."` `b`, `".self::$_db_table_membre."` `m` "
             . "WHERE `b`.`id_contact` = `m`.`id_contact` "
             . "AND `b`.`id_groupe` = " . (int) $this->_id_groupe . " "
             . "AND `b`.`id` = " . (int) $params['id'] . " "
             . "AND `b`.`id_parent` = " . (int) $params['id_parent'] . " "
             . "AND `b`.`id_type` = " . (int) $params['id_type'];

        return $db->queryWithFetchFirstRow($sql);
    }

    /**
     * ajoute un item en base
     *
     * @param array ['id_contact']
     *              ['id_type']
     *              ['id_parent']
     *              ['title']
     *              ['text']
     */
    protected function addItem($params)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `".self::$_db_table_blog."` "
             . "(`id_groupe`, `id_type`, `id_parent`, "
             . "`id_contact`, `title`, `text`, `date`) "
             . "VALUES(".(int) $this->_id_groupe.", ".(int) $params['id_type'].", ".(int) $params['id_parent'].", "
             . (int) $params['id_contact'].", '".$db->escape($params['title'])."', '".$db->escape($params['text'])."', NOW())";

        $db->query($sql);

        return $db->insertId();
    }

    /**
     * Edite un item en base
     *
     * @param array ['id']
     *              ['title']
     *              ['text']
     * @return bool
     */
    protected function editItem($params)
    {
        $db = DataBase::getInstance();

        $sql = "UPDATE `".self::$_db_table_blog."` "
             . "SET `title` = '".$db->escape($params['title'])."', `text` = '".$db->escape($params['text'])."' "
             . "WHERE `id` = ".(int) $params['id'];

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * efface un item en base
     *
     * @param array ['id']
     *              ['id_type']
     * @return bool
     */
    protected function delItem($params)
    {
        $db = DataBase::getInstance();

        $sql = "DELETE FROM `".self::$_db_table_blog."` "
             . "WHERE `id` = ".(int) $params['id']." "
             . "AND `id_type` = ".(int) $params['id_type'];

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * retourne si un item est valide
     *
     * @param int $id
     * @return bool
     */
    protected static function isItemOk($id)
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id` "
             . "FROM `".self::$_db_table_blog."` "
             . "WHERE `id` = ".(int) $id;

        $db->query($sql);

        return (bool) $db->numRows();
    }
}