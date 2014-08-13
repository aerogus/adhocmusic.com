<?php

/**
 * @package adhoc
 */

/**
 * Classe Concours
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class Concours
{
    /**
     * @var int
     */
    protected $_id = 0;

    /**
     * @var string
     */
    protected $_title = '';

    /**
     * @var string
     */
    protected $_lots = '';

    /**
     * @var string
     */
    protected $_description = '';

    /**
     * @var string
     */
    protected $_datdeb = '';

    /**
     * @var string
     */
    protected $_datfin = '';

    /**
     * @var string
     */
    protected $_datdeb_ts = 0;

    /**
     * @var string
     */
    protected $_datfin_ts = 0;

    /**
     * @var array
     */
    protected $_qr = array();

    /**
     * @return string
     */
    public function getId()
    {
        return (int) $this->_id;
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
    public function getLots()
    {
        return (string) $this->_lots;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string) $this->_description;
    }

    /**
     * @return string
     */
    public function getDatdeb()
    {
        return (string) $this->_datdeb;
    }

    /**
     * @return string
     */
    public function getDatfin()
    {
        return (string) $this->_datfin;
    }

    /**
     * @return string
     */
    public function getDatdebTs()
    {
        return (string) $this->_datdeb_ts;
    }

    /**
     * @return string
     */
    public function getDatfinTs()
    {
        return (string) $this->_datfin_ts;
    }

    /**
     * retourne le tableau des questions/réponses
     *
     * @return array
     */
    public function getQr()
    {
        return $this->_qr;
    }

    /**
     * retourne le nombre de questions pour le jeu courant
     *
     * @return int
     */
    public function getQrCount()
    {
        return (int) sizeof($this->_qr);
    }

    /**
     * retourne l'url de l'accueil du jeu
     *
     * @return string
     */
    public function getUrl()
    {
        return 'http://www.adhocmusic.com/concours/show/' . $this->getId();
    }

    /**
     * Constructeur
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $this->_id = (int) $id;
        $data = $this->getData();

        if(!$data)
            return;

        $this->_title = $data['title'];
        $this->_lots = $data['lots'];
        $this->_description = $data['description'];
        $this->_datdeb = $data['datdeb'];
        $this->_datfin = $data['datfin'];
        $this->_datdeb_ts = $data['datdeb_ts'];
        $this->_datfin_ts = $data['datfin_ts'];
        $this->_qr = $data['qr'];
    }

    /**
     * retourne les informations du jeu concours
     *
     * @return array
     */
    public function getData()
    {
        $db = DataBase::getInstance();

        // infos générales
        $sql = "SELECT `title`, `lots`, `description`, `datdeb`, `datfin`, "
             . "UNIX_TIMESTAMP(`datdeb`) AS `datdeb_ts`, "
             . "UNIX_TIMESTAMP(`datfin`) AS `datfin_ts` "
             . "FROM `adhoc_jeu` "
             . "WHERE `id_jeu` = " . (int) $this->_id;

        $concours = $db->queryWithFetchFirstRow($sql);

        // questions/réponses
        $sql = "SELECT `rank`, `q`, `image`, `r1`, `r2`, `r3`, `r4`, `r5`, `r` "
             . "FROM `adhoc_jeu_qr` "
             . "WHERE `id_jeu` = " . (int) $this->_id . " "
             . "ORDER BY `rank` ASC";

        $concours['qr'] = array();

        if($rows = $db->queryWithFetch($sql)) {
            foreach($rows as $row) {
                $concours['qr'][$row['rank']] = $row;
                if($row['image']) {
                    $concours['qr'][$row['rank']]['image'] = STATIC_URL . '/img/concours/' . $row['image'];
                }
            }
        }

        return $concours;
    }

    /**
     * ajoute une participation
     *
     * @param int $id_contact
     * @return int
     */
    public function addParticipant($id_contact, $ip, $host)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_jeu_participant` "
             . "(`id_jeu`, `id_contact`, `date`, `ip`, `host`) "
             . "VALUES(" . (int) $this->_id . ", " . (int) $id_contact . ", NOW(), '" . $db->escape($ip). "', '" . $db->escape($host) . "')";

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * Ajoute une réponse pour une participation
     *
     * @param int $id_contact
     * @param int $rank
     * @param int $r
     * @return int
     */
    public function addReponse($id_contact, $rank, $r)
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_jeu_r` "
             . "(`id_jeu`, `id_contact`, `rank`, `r`) "
             . "VALUES(" . (int) $this->_id . ", " . (int) $id_contact . ", " . (int) $rank . ", " . (int) $r . ")";

        $db->query($sql);

        return $db->affectedRows();
    }

    /**
     * retourne si le concours est actuellement actif
     *
     * @return bool
     */
    public function isActif()
    {
        $now = time();

        if(($now > $this->_datdeb_ts) && ($now < $this->_datfin_ts)) {
            return true;
        }
        return false;
    }

    /**
     * Retourne les infos sur les concours actifs
     *
     * @return array ou false
     */
    public static function getActifs()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_jeu` AS `id`, `title`, `lots`, `description`, `datdeb`, `datfin` "
             . "FROM `adhoc_jeu` "
             . "WHERE `datdeb` < NOW() "
             . "AND `datfin` > NOW()";

        return $db->queryWithFetch($sql);
    }

    /**
     * Sort au hasard $nb gagnants parmis les participants ayant toutes les bonnes réponses au jeu
     *
     * @param int $nb
     * @return array
     */
    public function getRandomWinners($nb = 5)
    {
        return false;
    }

    /**
     * retourne la liste des participants, leur score, et trié
     *
     * @return array
     */
    public function getResults()
    {
        $db = DataBase::getInstance();

        // récupération des participants
        $sql = "SELECT `p`.`id_contact`, `p`.`date`, `p`.`ip`, `p`.`host`, "
             . "`m`.`pseudo`, `m`.`first_name`, `m`.`last_name` "
             . "FROM `adhoc_jeu_participant` `p`, `adhoc_membre` `m` "
             . "WHERE `p`.`id_contact` = `m`.`id_contact` "
             . "AND `p`.`id_jeu` = " . (int) $this->_id;
        $p = $db->queryWithFetch($sql);

        $participants = array();
        foreach($p as $_p) {
            $participants[$_p['id_contact']] = $_p;
            $participants[$_p['id_contact']]['score'] = 0;
        }

        // récupération des bonnes réponses au jeu
        $sql = "SELECT `qr`.`rank`, `qr`.`r` "
             . "FROM `adhoc_jeu_qr` `qr` "
             . "WHERE `id_jeu` = " . (int) $this->_id;
        $s = $db->queryWithFetch($sql);

        $reponses = array();
        foreach($s as $_s) {
            $reponses[$_s['rank']] = (int) $_s['r'];
        }

        // récupération des réponses des participants
        $sql = "SELECT `r`.`id_contact`, `r`.`rank`, `r`.`r` "
             . "FROM `adhoc_jeu_r` `r` "
             . "WHERE `id_jeu` = " . (int) $this->_id;
        $r = $db->queryWithFetch($sql);

        foreach($r as $_r) {
            $champ = 'r' . $_r['rank'];
            $participants[$_r['id_contact']][$champ] = $_r['r'];
            if($reponses[$_r['rank']] == $_r['r']) {
                $participants[$_r['id_contact']]['score'] += 1;
            }
        }
        return $participants;
    }
}
