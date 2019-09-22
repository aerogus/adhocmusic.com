<?php declare(strict_types=1);

/**
 * Foire aux questions
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class FAQ extends ObjectModel
{
    /**
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
     * @var int
     */
    protected $_id_faq = 0;

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
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= num)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_category' => 'num',
        'question'    => 'str',
        'answer'      => 'str',
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

    /* fin getters */

    /* début setters */

    /**
     * @param int $val val
     *
     * @return object
     */
    function setIdCategory(int $val): object
    {
        if ($this->_id_category !== $val) {
            $this->_id_category = $val;
            $this->_modified_fields['id_category'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setQuestion(string $val): object
    {
        $val = trim($val);
        if ($this->_question !== $val) {
            $this->_question = $val;
            $this->_modified_fields['question'] = true;
        }

        return $this;
    }

    /**
     * @param string $val val
     *
     * @return object
     */
    function setAnswer(string $val): object
    {
        $val = trim($val);
        if ($this->_answer !== $val) {
            $this->_answer = (string) $val;
            $this->_modified_fields['answer'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * @return array
     */
    static function getCategories(): array
    {
        return [
            1 => 'Le site',
            2 => 'Les concerts',
        ];
    }

    /**
     * @return string
     */
    function getCategory(): string
    {
        $categories = self::getCategories();
        return $categories[$this->_id_category];
    }

    /**
     * @param int $id_category id_category
     *
     * @return string
     */
    static function getCategoryById(int $id_category): string
    {
        $categories = self::getCategories();
        return $categories[$id_category];
    }

    /**
     * @return array
     */
    static function getFAQs(): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_faq`, `id_category`, `question`, `answer` "
             . "FROM `adhoc_faq`"
             . "ORDER BY `id_faq` ASC";

        $res = $db->queryWithFetch($sql);

        foreach ($res as $idx => $row) {
            $res[$idx]['category'] = self::getCategoryById($row['id_category']);
        }

        return $res;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_faq`, `id_category`, `question`, `answer` "
             . "FROM `" . self::$_table . "` "
             . "WHERE `id_faq` = " . (int) $this->_id_faq;

        if ($res = $db->queryWithFetchFirstRow($sql)) {
            $this->_dbToObject($res);
            return true;
        }

        throw new Exception('FAQ introuvable');
    }
}
