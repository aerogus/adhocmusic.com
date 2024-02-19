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
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_contact';

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
     * @var ?string
     */
    protected ?string $lastnl = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_contact' => 'int', // pk
        'email'      => 'string',
        'lastnl'     => 'date',
    ];

    /* début getters */

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
     * Retourne la date de la dernière consultation d'une newsletter
     * (si tracker activé)
     *
     * @return ?string
     */
    public function getLastnl(): ?string
    {
        return $this->lastnl;
    }

    /* fin getters */

    /* début setters*/

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
     * @param string $lastnl lastnl
     *
     * @return static
     */
    public function setLastnl(string $lastnl): static
    {
        if ($this->lastnl !== $lastnl) {
            $this->lastnl = $lastnl;
            $this->modified_fields['lastnl'] = true;
        }

        return $this;
    }

    /**
     * @return static
     */
    public function setLastnlNow(): static
    {
        $now = date('Y-m-d H:i:s');

        return $this->setLastnl($now);
    }

    /* fin setters */

    /**
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new NotFoundException('contact inconnu');
        }

        return true;
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
}
