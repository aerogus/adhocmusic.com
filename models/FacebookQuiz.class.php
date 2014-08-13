<?php

/**
 * @package adhoc
 */

/**
 * Classe Quiz (application Facebook)
 *
 * L'idée est de faire un quiz de type:
 * "Les 5 plus grands groupes AD'HOC de tous les temps"
 *
 * A choisir parmi les groupes, actifs/inactifs qui ont au moins
 * fait une scène en Spinolie, à travers le temps
 *
 * @package adhoc
 * @author Guillaume Seznec <guillaume.seznec@gmail.com>
 */
class FacebookQuiz
{
    /**
     * récupérer le nom, l'url fiche groupe, le style, la mini image
     *
     * @return array
     */
    public static function getGroupes()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT DISTINCT `g`.`id_groupe` AS `id`, `g`.`name`, `g`.`alias` "
             . "FROM `adhoc_event` `e`, `adhoc_participe_a` `p`, `adhoc_groupe` `g`, `adhoc_organise_par` `o` "
             . "WHERE `e`.`id_event` = `o`.`id_event` "
             . "AND `p`.`id_event` = `e`.`id_event` "
             . "AND `p`.`id_groupe` = `g`.`id_groupe` "
             . "AND `o`.`id_structure` = 1 "
             . "AND `e`.`id_lieu` IN(1, 383, 404, 507) "
             . "ORDER BY RAND()";

        $tmp = $db->queryWithFetch($sql);

        $grps = array();

        foreach($tmp as $cpt => $grp) {
            $grps[$cpt] = $grp;
            if(file_exists(ADHOC_ROOT_PATH . '/media/groupe/m' . $grp['id'] . '.jpg')) {
                $pic = 'http://static.adhocmusic.com/media/groupe/m' . $grp['id'] . '.jpg';
            } else {
                $pic = 'http://static.adhocmusic.com/img/note_adhoc_64.png';
            }
            $grps[$cpt]['pic'] = $pic;
            $grps[$cpt]['url'] = 'http://www.adhocmusic.com/' . $grp['alias'];
        }

        unset($tmp);

        return $grps;
    }

    /**
     * ajoute un Vote
     *
     * @param array ['facebook_uid']
     *              ['id_groupe_1']
     *              ['id_groupe_2']
     *              ['id_groupe_3']
     *              ['id_groupe_4']
     *              ['id_groupe_5']
     *
     * @return int
     */
    public static function addVote($params = array())
    {
        $db = DataBase::getInstance();

        $sql = "INSERT INTO `adhoc_fb_quiz` "
             . "(`facebook_uid`, "
             . "`id_groupe_1`, "
             . "`id_groupe_2`, "
             . "`id_groupe_3`, "
             . "`id_groupe_4`, "
             . "`id_groupe_5`, "
             . "`date`) "
             . "VALUES (" . (int) $params['facebook_uid'] . ", "
             . (int) $params['id_groupe_1'] . ", "
             . (int) $params['id_groupe_2'] . ", "
             . (int) $params['id_groupe_3'] . ", "
             . (int) $params['id_groupe_4'] . ", "
             . (int) $params['id_groupe_5'] . ", "
             . "NOW())";

        $db->query($sql);

        return $db->insertId();
    }

    /**
     * retourne la liste des participants
     *
     * @return array
     */
    public static function getVotes()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `q`.`facebook_uid`, `m`.`first_name`, `m`.`last_name`, "
             . "`id_groupe_1`, `id_groupe_2`, `id_groupe_3`, "
             . "`id_groupe_4`, `id_groupe_5`, `date` "
             . "FROM (`adhoc_fb_quiz` `q`) "
             . "LEFT JOIN `adhoc_membre` `m` ON (`m`.`facebook_uid` = `q`.`facebook_uid`) "
             . "ORDER BY `id` DESC";

        return $db->queryWithFetch($sql);
    }

    /**
     * retourne le classement des groupes
     *
     * @return array
     */
    public static function getResults()
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `id_groupe_1`, `id_groupe_2`, "
             . "`id_groupe_3`, `id_groupe_4`, `id_groupe_5` "
             . "FROM `adhoc_fb_quiz` "
             . "ORDER BY `id` ASC";

        $res = $db->queryWithFetch($sql);

        $tab = array();
        // init tableau
        foreach($res as $_res) {
            $tab[$_res['id_groupe_1']] = 0;
            $tab[$_res['id_groupe_2']] = 0;
            $tab[$_res['id_groupe_3']] = 0;
            $tab[$_res['id_groupe_4']] = 0;
            $tab[$_res['id_groupe_5']] = 0;
        }
        // calcul des points
        foreach($res as $_res) {
            $tab[$_res['id_groupe_1']] += 5;
            $tab[$_res['id_groupe_2']] += 4;
            $tab[$_res['id_groupe_3']] += 3;
            $tab[$_res['id_groupe_4']] += 2;
            $tab[$_res['id_groupe_5']] += 1;
        }
        $tmp = array();
        $grp = array();
        $pts = array();
        foreach($tab as $id_groupe => $points) {
            $tmp[$id_groupe] = array(
                'points' => $points,
                'id_groupe' => $id_groupe
            );
            $grp[$id_groupe] = $id_groupe;
            $pts[$id_groupe] = $points;
        }
        array_multisort($pts, SORT_DESC, $grp, SORT_ASC, $tmp);

        return $tmp;
    }
}
