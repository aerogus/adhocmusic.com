<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\NotFoundException;
use Adhoc\Utils\ObjectModel;

/**
 * Classe MembreAdhoc
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class MembreAdhoc extends ObjectModel
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_contact';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_membre_adhoc';

    /**
     * @var ?string
     */
    protected ?string $function = null;

    /**
     * @var ?string
     */
    protected ?string $birth_date = null;

    /**
     * @var bool
     */
    protected bool $active = false;

    /**
     * @var int
     */
    protected int $rank = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_contact' => 'int', // pk
        'function' => 'string',
        'birth_date' => 'date',
        'active' => 'bool',
        'rank' => 'int',
    ];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/membre/ca';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/membre/ca';
    }

    /* début getters */

    /**
     * @return ?string
     */
    public function getFunction(): ?string
    {
        return $this->function;
    }

    /**
     * @return ?string
     */
    public function getBirthDate(): ?string
    {
        return $this->birth_date;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /* fin getters */

    /* début setters */

    /**
     * @param string $function function
     *
     * @return static
     */
    public function setFunction(string $function): static
    {
        if ($this->function !== $function) {
            $this->function = $function;
            $this->modified_fields['function'] = true;
        }

        return $this;
    }

    /**
     * @param string $birth_date birth_date
     *
     * @return static
     */
    public function setBirthDate(string $birth_date): static
    {
        if ($this->birth_date !== $birth_date) {
            $this->birth_date = $birth_date;
            $this->modified_fields['function'] = true;
        }

        return $this;
    }

    /**
     * @param bool $active active
     *
     * @return static
     */
    public function setActive(bool $active): static
    {
        if ($this->active !== $active) {
            $this->active = $active;
            $this->modified_fields['active'] = true;
        }

        return $this;
    }

    /**
     * @param int $rank rang
     *
     * @return static
     */
    public function setRank(int $rank): static
    {
        if ($this->rank !== $rank) {
            $this->rank = $rank;
            $this->modified_fields['rank'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Retourne les données des membres internes
     *
     * @param bool $active membre actif ?
     *
     * @return array<string,mixed>
     *
     * @deprecated implémenter une méthode find() + standard
     */
    public static function getStaff(bool $active = true): array
    {
        $db = DataBase::getInstance();

        $sql = "SELECT `m`.`id_contact` AS `id`, "
             . "`m`.`first_name`, `m`.`last_name`, `m`.`text`, "
             . "UNIX_TIMESTAMP(`m`.`modified_at`) AS `modified_at_ts`, "
             . "`ma`.`function`, `ma`.`datdeb`, `ma`.`datfin`, "
             . "(YEAR(CURRENT_DATE) - YEAR(`ma`.`birth_date`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`ma`.`birth_date`, 5)) AS `age` "
             . "FROM `" . Membre::getDbTable() . "` `m`, `" . MembreAdhoc::getDbTable() . "` `ma` "
             . "WHERE `m`.`id_contact` = `ma`.`id_contact` ";
        if ($active) {
             $sql .= "AND `ma`.`active` = TRUE ";
        } else {
             $sql .= "AND `ma`.`active` = FALSE ";
        }
        $sql .= "ORDER BY `ma`.`rank` ASC, `ma`.`datfin` DESC";

        $stm = $db->pdo->query($sql);
        $mbrs = $stm->fetchAll();

        foreach ($mbrs as $idx => $mbr) {
            $mbrs[$idx]['avatar_interne'] = false;
            if (file_exists(self::getBasePath() . '/' . $mbr['id'] . '.jpg')) {
                $mbrs[$idx]['avatar_interne'] = self::getBaseUrl() . '/' . $mbr['id'] . '.jpg?ts=' . $mbr['modified_at_ts'];
            }
            $mbrs[$idx]['url'] = HOME_URL . '/membres/' . $mbr['id'];
        }

        return $mbrs;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new NotFoundException('membre_adhoc inconnu');
        }

        return true;
    }
}
