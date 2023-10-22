<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Reference\FAQCategory;

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
    protected static $instance = null;

    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_faq';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_faq';

    /**
     * @var ?int
     */
    protected ?int $id_faq = null;

    /**
     * @var int
     */
    protected int $id_category = 0;

    /**
     * @var string
     */
    protected string $question = '';

    /**
     * @var string
     */
    protected string $answer = '';

    /**
     * @var bool
     */
    protected bool $online = false;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
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
    public function getIdFAQ(): int
    {
        return $this->faq;
    }

    /**
     * @return int
     */
    public function getIdCategory(): int
    {
        return $this->category;
    }

    /**
     * @return object
     */
    public function getCategory(): object
    {
        return FAQCategory::getInstance($this->getIdCategory());
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @return bool
     */
    public function getOnline(): bool
    {
        return $this->online;
    }

    /**
     * Retourne la date de création format YYYY-MM-DD HH:II:SS
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return $this->created_at;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return ?int
     */
    public function getCreatedAtTs(): ?string
    {
        if (!is_null($this->created_at) && Date::isDateTimeOk($this->created_at)) {
            return (int) strtotime($this->created_at);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return ?string
     */
    public function getModifiedAt(): ?string
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return $this->modified_at;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return ?int
     */
    public function getModifiedAtTs(): ?int
    {
        if (!is_null($this->modified_at) && Date::isDateTimeOk($this->modified_at)) {
            return strtotime($this->modified_at);
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
    public function setIdCategory(int $id_category): object
    {
        if ($this->category !== $id_category) {
            $this->category = $id_category;
            $this->modified_fields['id_category'] = true;
        }

        return $this;
    }

    /**
     * @param string $question question
     *
     * @return object
     */
    public function setQuestion(string $question): object
    {
        $question = trim($question);
        if ($this->question !== $question) {
            $this->question = $question;
            $this->modified_fields['question'] = true;
        }

        return $this;
    }

    /**
     * @param string $answer réponse
     *
     * @return object
     */
    public function setAnswer(string $answer): object
    {
        $answer = trim($answer);
        if ($this->answer !== $answer) {
            $this->answer = $answer;
            $this->modified_fields['answer'] = true;
        }

        return $this;
    }

    /**
     * @param bool $online online
     *
     * @return object
     */
    public function setOnline(bool $online): object
    {
        if ($this->online !== $online) {
            $this->online = $online;
            $this->modified_fields['online'] = true;
        }

        return $this;
    }

    /**
     * @param string $created_at date de création format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    public function setCreatedAt(string $created_at): object
    {
        if ($this->created_at !== $created_at) {
            $this->created_at = $created_at;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->created_at !== $now) {
            $this->created_at = $now;
            $this->modified_fields['created_at'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_at date de modification format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    public function setModifiedAt(string $modified_at): object
    {
        if ($this->modified_at !== $modified_at) {
            $this->modified_at = $modified_at;
            $this->modified_fields['modified_at'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    public function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->modified_at !== $now) {
            $this->modified_at = $now;
            $this->modified_fields['modified_at'] = true;
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
    public static function find(array $params): array
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

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields))))) {
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

        if (isset($params['limit'])) {
            $sql .= "LIMIT " . (int) $params['start'] . ", " . (int) $params['limit'];
        }

        $ids = $db->queryWithFetchFirstFields($sql);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
