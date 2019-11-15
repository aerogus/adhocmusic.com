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
        'created_on'  => 'date',
        'modified_on' => 'date',
    ];

    /* début getters */

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
        return FAQCategory::getInstance($this->_id_category);
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
    function getCreatedOn(): ?string
    {
        if (!is_null($this->_created_on) && Date::isDateTimeOk($this->_created_on)) {
            return $this->_created_on;
        }
        return null;
    }

    /**
     * Retourne la date de création sous forme d'un timestamp
     *
     * @return int|null
     */
    function getCreatedOnTs(): ?string
    {
        if (!is_null($this->created_on) && Date::isDateTimeOk($this->_created_on)) {
            return (int) strtotime($this->_created_on);
        }
        return null;
    }

    /**
     * Retourne la date de modification
     *
     * @return string|null
     */
    function getModifiedOn(): ?string
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return $this->_modified_on;
        }
        return null;
    }

    /**
     * Retourne la date de modification sous forme d'un timestamp
     *
     * @return int|null
     */
    function getModifiedOnTs(): ?int
    {
        if (!is_null($this->_modified_on) && Date::isDateTimeOk($this->_modified_on)) {
            return strtotime($this->_modified_on);
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
     * @param string $created_on date de création format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setCreatedOn(string $created_on): object
    {
        if ($this->_created_on !== $created_on) {
            $this->_created_on = $created_on;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setCreatedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_created_on !== $now) {
            $this->_created_on = $now;
            $this->_modified_fields['created_on'] = true;
        }

        return $this;
    }

    /**
     * @param string $modified_on date de modification format "YYYY-MM-DD HH:II:SS"
     *
     * @return object
     */
    function setModifiedOn(string $modified_on): object
    {
        if ($this->_modified_on !== $modified_on) {
            $this->_modified_on = $modified_on;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /**
     * @return object
     */
    function setModifiedNow(): object
    {
        $now = date('Y-m-d H:i:s');

        if ($this->_modified_on !== $now) {
            $this->_modified_on = $now;
            $this->_modified_fields['modified_on'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne une collection d'objets "FAQ" répondant au(x) critère(s)
     *
     * @param array $params param
     *
     * @return array
     */
    static function find(array $params): array
    {
        // @TODO à implémenter
        return [];
    }
}
