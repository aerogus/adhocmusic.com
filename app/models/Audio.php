<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Classe Audio
 *
 * Classe de gestion des audios du site
 * Appel des conversions etc ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Audio extends Media
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
    protected static string $_pk = 'id_audio';

    /**
     * @var string
     */
    protected static string $_table = 'adhoc_audio';

    /**
     * @var int
     */
    protected int $_id_audio = 0;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static $_all_fields = [
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
     * @return int
     */
    public function getIdAudio(): int
    {
        return $this->_id_audio;
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
     * @return string|null
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
     * @throws Exception
     */
    protected function loadFromDb(): bool
    {
        if (!parent::loadFromDb()) {
            throw new Exception('Audio introuvable');
        }

        return true;
    }
}
