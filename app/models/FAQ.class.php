<?php declare(strict_types=1);

use \Reference\FAQCategory;

/**
 * Foire aux questions
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class FAQ extends ObjectModel
{
    /**
     * Instance de l'objet
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_faq';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_faq';

    /**
     * @var int|null
     */
    protected $_id_faq = null;

    /**
     * @var int
     */
    protected $_id_category = 0;

    /**
     * @var string
     */
    protected $_question = '';

    /**
     * @var string
     */
    protected $_answer = '';

    /**
     * @var bool
     */
    protected $_online = false;

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_faq'      => 'int', // pk
        'id_category' => 'int',
        'question'    => 'string',
        'answer'      => 'string',
        'online'      => 'bool',
        'created_at'  => 'date',
        'modified_at' => 'date',
    ];

    /* début getters */

    /**
     * @return int
     */
    function getIdFAQ(): int
    {
        return $this->_id_faq;
    }

    /**
     * @return int
     */
    function getIdCategory(): int
    {
        return $this->_id_category;
    }

    /**
     * @return object
     */
    function getCategory(): object
    {
        return FAQCategory::getInstance($this->getIdCategory());
    }

    /**
     * @return string
     */
    function getQuestion(): string
    {
        return $this->_question;
    }

    /**
     * @return string
     */
    function getAnswer(): string
    {
        return $this->_answer;
    }

    /**
     * @return bool
     */
    function getOnline(): bool
    {
        return $this->_online;
    }

    /**
     * Retourne la date de création format YYYY-MM-DD HH:II:SS
     *
     * @return string|null
     */
    function getCreatedAt(): ?string
    {
        if (!is_null($this->_created_at) && Date::isDateTimeOk($this->_created_at)) {
            return $this->_created_at;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return int|null
     */
    function getCreatedAtTs(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->_created_at)) {
            return (int) strtotime($this->_created_at);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return string|null
     */
    function getModifiedAt(): ?string
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return $this->_modified_at;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return int|null
     */
    function getModifiedAtTs(): ?int
    {
        if (!is_null($this->_modified_at) && Date::isDateTimeOk($this->_modified_at)) {
            return strtotime($this->_modified_at);
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param int $id_category id_category
     *
     * @return object
     */
    function setIdCategory(int $id_category): object
    {
        if ($this->_id_category !== $id_category) {
            $this->_id_category = $id_category;
            $this->_modified_fields['id_category'] = true;
        }

        return $this;
    }

    /**
     * @param string $question question
     *
     * @return object
     */
    function setQuestion(string $question): object
    {
        $question = trim($question);
        if ($this->_question !== $question) {
            $this->_question = $question;
            $this->_modified_fields['question'] = true;
        }

        return $this;
    }

    /**
     * @param string $answer réponse
     *
     * @return object
     */
    function setAnswer(string $answer): object
    {
        $answer = trim($answer);
        if ($this->_answer !== $answer) {
            $this->_answer = $answer;
            $this->_modified_fields['answer'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return object
     */
    function setOnline(bool $online): object
    {
        if ($this->_online !== $online) {
            $this->_online = $online;
            $this->_modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at date de création format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setCreatedAt(string $created_at): object
    {
        if ($this->_created_at !== $created_at) {
            $this->_created_at = $created_at;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_at !== $now) {
            $this->_created_at = $now;
            $this->_modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_at date de modification format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setModifiedAt(string $modified_at): object
    {
        if ($this->_modified_at !== $modified_at) {
            $this->_modified_at = $modified_at;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_at !== $now) {
            $this->_modified_at = $now;
            $this->_modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne une collection d'objets "FAQ" répondant au(x) critère(s) donné(s)
     *
     * @param array $params [
     *                      'id_category' => int,
     *                      'online' => bool,
     *                      'order_by' => string,
     *                      'sort' => string,
     *                      'start' => int,
     *                      'limit' => int,
     *                      ]
     *
     * @return array
     */
    static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql = "SELECT `" . static::getDbPk() . "` FROM `" . static::getDbTable() . "` WHERE 1 ";

        if (isset($params['id_category'])) {
            $sql .= "AND `id_category` = " . (int) $params['id_category'] . " ";
        }

        if (isset($params['online'])) {
            $sql .= "AND `online` = ";
            $sql .= $params['online'] ? "TRUE" : "FALSE";
            $sql .= " ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$_all_fields))))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $sql .= "ORDER BY `" . static::getDbPk() . "` ";
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'])))) {
            $sql .= $params['sort'] . " ";
        } else {
            $sql .= "ASC ";
        }

        if (!isset($params['start'])) {
            $params['start'] = 0;
        }

        if (isset($params['start']) && isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
