<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Utils\DataBase;
use Adhoc\Utils\NotFoundException;
use Adhoc\Utils\ObjectModel;

/**
 * Classe Contact
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Contact extends ObjectModel
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_contact',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_contact';

    /**
     * @var ?int
     */
    protected ?int $id_contact = null;

    /**
     * @var ?string
     */
    protected ?string $email = null;

    /**
     * @var ?Membre
     */
    protected ?Membre $membre = null;

    /**
     * @var ?bool
     */
    protected ?bool $is_membre = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_contact' => 'int', // pk
        'email' => 'string',
    ];

    /**
     * @return ?int
     */
    public function getIdContact(): ?int
    {
        return $this->id_contact;
    }

    /**
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return ?Membre
     */
    public function getMembre(): ?Membre
    {
        if (is_null($this->is_membre)) {
            try {
                $this->membre = Membre::getInstance($this->getIdContact());
                $this->is_membre = true;
                return $this->membre;
            } catch (NotFoundException $e) {
                $this->is_membre = false;
                return null;
            }
        } elseif ($this->is_membre === false) {
            return null;
        } else {
            return $this->membre;
        }
    }

    /**
     * @return ?bool
     */
    public function isMembre(): ?bool
    {
        return $this->is_membre;
    }

    /**
     * @param int $id_contact id_contact
     *
     * @return static
     */
    public function setIdContact(int $id_contact): static
    {
        if ($this->id_contact !== $id_contact) {
            $this->id_contact = $id_contact;
            $this->modified_fields['id_contact'] = true;
        }

        return $this;
    }

    /**
     * @param string $email email
     *
     * @return static
     */
    public function setEmail(string $email): static
    {
        if ($this->email !== $email) {
            $this->email = $email;
            $this->modified_fields['email'] = true;
        }

        return $this;
    }

    /**
     * @param string $email
     *
     * @return int|false
     */
    public static function getIdByEmail(string $email): int|false
    {
        $cs = Contact::find([
            'email' => $email,
        ]);
        if (count($cs) === 0) {
            return false; // contact introuvable
        }

        return $cs[0]->getIdContact();
    }

    /**
     * Retourne une collection d'objets "Contact" répondant au(x) critère(s) donné(s)
     *
     * @param array<string,mixed> $params [
     *                                'email' => string,
     *                                'order_by' => string,
     *                                'sort' => string,
     *                                'start' => int,
     *                                'limit' => int,
     *                            ]
     *
     * @return array<static>
     */
    public static function find(array $params): array
    {
        $db = DataBase::getInstance();
        $objs = [];

        $sql  = "SELECT ";

        $pks = array_map(
            function ($item) {
                return '`' . $item . '`';
            },
            static::getDbPk()
        );
        $sql .= implode(', ', $pks) . ' ';

        $sql .= "FROM `" . static::getDbTable() . "` ";
        $sql .= "WHERE 1 ";

        if (isset($params['email'])) {
            $sql .= "AND `email` = '" . $params['email'] . "' ";
        }

        if ((isset($params['order_by']) && (in_array($params['order_by'], array_keys(static::$all_fields), true)))) {
            $sql .= "ORDER BY `" . $params['order_by'] . "` ";
        } else {
            $pks = array_map(function ($item) {
                return '`' . $item . '`';
            }, static::getDbPk());
            $sql .= 'ORDER BY ' . implode(', ', $pks) . ' ';
        }

        if ((isset($params['sort']) && (in_array($params['sort'], ['ASC', 'DESC'], true)))) {
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

        $ids = $db->pdo->query($sql)->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($ids as $id) {
            $objs[] = static::getInstance((int) $id);
        }

        return $objs;
    }
}
