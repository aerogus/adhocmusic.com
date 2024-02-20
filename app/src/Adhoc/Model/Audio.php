<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Media;

/**
 * Classe Audio
 *
 * Classe de gestion des audios du site
 * Appel des conversions etc ...
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Audio extends Media
{
    /**
     * @var string|array<string>
     */
    protected static string|array $pk = 'id_audio';

    /**
     * @var string
     */
    protected static string $table = 'adhoc_audio';

    /**
     * @var ?int
     */
    protected ?int $id_audio = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_audio'     => 'int', // pk
        'id_contact'   => 'int',
        'id_groupe'    => 'int',
        'id_lieu'      => 'int',
        'id_event'     => 'int',
        'name'         => 'string',
        'created_at'   => 'date',
        'modified_at'  => 'date',
        'online'       => 'bool',
    ];

    /* début getters */

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/audio';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/audio';
    }

    /**
     * @return ?int
     */
    public function getIdAudio(): ?int
    {
        return $this->id_audio;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/audios/' . $this->getIdAudio();
    }

    /**
     * @return string
     */
    public function getDirectMp3Url(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.mp3')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.mp3';
        }
        return null;
    }

    /**
     * @return ?string
     */
    public function getDirectAacUrl(): ?string
    {
        if (file_exists(self::getBasePath() . '/' . $this->getId() . '.m4a')) {
            return self::getBaseUrl() . '/' . $this->getId() . '.m4a';
        }
        return null;
    }

    /* fin getters */

    /* début setters */

    /* fin setters */

    /**
     * Efface un enregistrement de la table audio
     * + gestion de l'effacement du/des fichier(s)
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (parent::delete()) {
            $mp3File = self::getBasePath() . '/' . $this->getId() . '.mp3';
            if (file_exists($mp3File)) {
                unlink($mp3File);
            }
            $aacFile = self::getBasePath() . '/' . $this->getId() . '.m4a';
            if (file_exists($aacFile)) {
                unlink($aacFile);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new \Exception('Audio introuvable');
        }

        return true;
    }
}
