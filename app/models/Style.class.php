<?php declare(strict_types=1);

/**
 * Classe de gestion des styles musicaux
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Style extends ObjectModel
{
    /**
     * @var object
     */
    protected static $_instance = null;

    /**
     * @var string
     */
    protected static $_pk = 'id_style';
    /**
     * @var string
     */
    protected static $_table = 'adhoc_style';

    /**
     * @var int
     */
    protected $_id_style = 0;

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * Liste des attributs de l'objet
     * on précise si en base c'est de type :
     * - numérique/integer/float/bool (= int)
     * - datetime/text (= str)
     * ceci est utile pour la formation de la requête
     *
     * @var array
     */
    protected static $_all_fields = [
        'name' => 'str',
    ];

    /**
     * Tableau des attributs modifiés depuis la dernière sauvegarde.
     *
     * Pour chaque attribut modifié, on a un élément de la forme 'attribut => true'.
     *
     * @var array
     */
    protected $_modified_fields = [];

    /* début getters */

    /**
     * @return string
     */
    static function getName(): string
    {
        return $this->_name;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $val val
     *
     * @return object
     */
    function setName(string $val): object
    {
        if ($this->_name !== $val) {
            $this->_name = $val;
            $this->_modified_fields['name'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne les infos sur un style
     *
     * @return bool
     * @throws Exception
     */
    function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Style introuvable');
        }

        return true;
    }

    /**
     * Codes style
     */
    const ROC =  1;
    const REG =  2;
    const TEC =  3;
    const MET =  4;
    const WOR =  5;
    const CHA =  6;
    const HIP =  7;
    const RNB =  8;
    const JAZ =  9;
    const FUN = 10;
    const DIS = 11;
    const CLA = 12;
    const POP = 13;
    const PRO = 14;
    const PUN = 15;
    const SKA = 16;
    const TRI = 17;
    const FUS = 18;
    const DUB = 19;
    const HEA = 20;
    const DRU = 21;
    const CEL = 22;
    const HOU = 23;
    const ELE = 24;
    const SOU = 25;
    const BLU = 26;
    const FES = 27;
    const RAI = 28;
    const FOL = 29;
    const LAT = 30;
    const COU = 31;

    /**
     * Tableau des Styles
     *
     * @var array
     */
    protected static $_liste = [
        self::ROC => "Rock",
        self::REG => "Reggae",
        self::TEC => "Techno",
        self::MET => "Métal",
        self::WOR => "World",
        self::CHA => "Chanson",
        self::HIP => "Hip Hop",
        self::RNB => "R'n'B",
        self::JAZ => "Jazz",
        self::FUN => "Funk",
        self::DIS => "Disco",
        self::CLA => "Classique",
        self::POP => "Pop",
        self::PRO => "Progressif",
        self::PUN => "Punk",
        self::SKA => "Ska",
        self::TRI => "Trip Hop",
        self::FUS => "Fusion",
        self::DUB => "Dub",
        self::HEA => "Heavy",
        self::DRU => "Drum 'n Bass",
        self::CEL => "Celtique",
        self::HOU => "House",
        self::ELE => "Electro",
        self::SOU => "Soul",
        self::BLU => "Blues",
        self::FES => "Festif",
        self::RAI => "Raï",
        self::FOL => "Folk",
        self::LAT => "Latino",
        self::COU => "Country",
    ];

    /**
     * Retourne le tableau de la liste
     *
     * @return array
     */
    static function getHashTable(): array
    {
        asort(self::$_liste);
        return self::$_liste;
    }

    /**
     *
     */
    static function isStyleOk(int $id_style): bool
    {
        if (array_key_exists($id_style, self::$_liste)) {
            return true;
        }
        return false;
    }
}
