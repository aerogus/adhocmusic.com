<?php declare(strict_types=1);

/**
 * Classe Photo
 *
 * Classe de gestion des photos du site
 * Upload, Appel conversion etc ...
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Photo extends Media
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
    protected static $_pk = 'id_photo';

    /**
     * @var string
     */
    protected static $_table = 'adhoc_photo';

    /**
     * @var int
     */
    protected $_id_photo = 0;

    /**
     * @var string
     */
    protected $_pseudo = '';

    /**
     * @var string
     */
    protected $_credits = '';

    /**
     * Liste des attributs de l'objet
     *
     * @var array
     */
    protected static $_all_fields = [
        'id_photo'     => 'int', // pk
        'id_contact'   => 'int',
        'id_groupe'    => 'int',
        'id_lieu'      => 'int',
        'id_event'     => 'int',
        'id_structure' => 'int',
        'name'         => 'string',
        'created_on'   => 'date',
        'modified_on'  => 'date',
        'online'       => 'bool',
        'credits'      => 'string',
    ];

    /* debut getters */

    /**
     * @return string
     */
    static function getBaseUrl(): string
    {
        return MEDIA_URL . '/photo';
    }

    /**
     * @return string
     */
    static function getBasePath(): string
    {
        return MEDIA_PATH . '/photo';
    }

    /**
     * @return string
     */
    function getPseudo(): string
    {
        return $this->_pseudo;
    }

    /**
     * @return string
     */
    function getCredits(): string
    {
        return $this->_credits;
    }

    /**
     * @return string
     */
    function getUrl(): string
    {
        return HOME_URL . '/photos/' . $this->getIdPhoto();
    }

    /* fin getters */

    /* debut setters */

    /**
     * @param string $credits credits
     *
     * @return object
     */
    function setCredits(string $credits): object
    {
        if ($this->_credits !== $credits) {
            $this->_credits = $credits;
            $this->_modified_fields['credits'] = true;
        }

        return $this;
    }

    /* fin setters */

    /**
     * Efface une photo de la table photo + le fichier .jpg
     *
     * @return bool
     */
    function delete(): bool
    {
        if (parent::delete()) {
            self::invalidatePhotoInCache($this->getId(),  80,  80, '000000', false,  true);
            self::invalidatePhotoInCache($this->getId(), 130, 130, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 400, 300, '000000', false, false);
            self::invalidatePhotoInCache($this->getId(), 680, 600, '000000', false, false);

            $file = self::getBasePath() . '/' . $this->getId() . '.jpg';
            if (file_exists($file)) {
                unlink($file);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _loadFromDb(): bool
    {
        if (!parent::_loadFromDb()) {
            throw new Exception('Photo introuvable');
        }
        return true;
    }

    /**
     * @return string
     */
    function getThumb80Url(): string
    {
        return self::getPhotoUrl($this->getId(), 80, 80, '000000', false, true);
    }

    /**
     * @return string
     */
    function getThumb320Url(): string
    {
        return self::getPhotoUrl($this->getId(), 320, 0, '000000', false, false);
    }

    /**
     * @return string
     */
    function getThumb680Url(): string
    {
        return self::getPhotoUrl($this->getId(), 680, 600, '000000', false, false);
    }

    /**
     * @return bool
     */
    static function invalidatePhotoInCache(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = false): bool
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Retourne l'url de la photo
     * gestion de la mise en cache
     *
     * @return string
     */
    static function getPhotoUrl(int $id, int $width = 80, int $height = 80, string $bgcolor = '000000', bool $border = false, bool $zoom = false): string
    {
        $uid = 'photo/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';
        $cache = Image::getLocalCachePath($uid);

        if (!file_exists($cache)) {
            $source = self::getBasePath() . '/' . $id . '.jpg';
            if (file_exists($source)) {
                $img = new Image($source);
                $img->setType(IMAGETYPE_JPEG);
                $img->setMaxWidth($width);
                $img->setMaxHeight($height);
                $img->setBorder($border);
                $img->setKeepRatio(true);
                if ($zoom) {
                    $img->setZoom();
                }
                $img->setHexColor($bgcolor);
                Image::writeCache($uid, $img->get());
            } else {
                $img = (new Image())
                    ->init(16, 16, '000000');
                Image::writeCache($uid, $img->get());
                Log::write('photo', 'photo ' . $id . ' introuvable | uid : ' . $uid);
            }
        }

        return Image::getHttpCachePath($uid);
    }
}
