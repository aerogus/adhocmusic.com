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
        'created_at'   => 'date',
        'modified_at'  => 'date',
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
     * @return int
     */
    function getIdPhoto(): int
    {
        return $this->_id_photo;
    }

    /**
     * @return string
     */
    function getPseudo(): string
    {
        return Membre::getInstance($this->getIdContact())->getPseudo();
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
            foreach ([80, 320, 680, 100] as $maxWidth) {
                $this->clearThumb($maxWidth);
            }

            $file = self::getBasePath() . '/' . $this->getIdPhoto() . '.jpg';
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
     * @return string|null
     */
    function getThumbUrl(int $maxWidth = 0): ?string
    {
        $sourcePath = self::getBasePath() . '/' . $this->getIdPhoto() . '.jpg';

        if (!$maxWidth) {
            return self::getBaseUrl() . '/' . $this->getIdPhoto() . '.jpg';
        } else {
            $uid = 'photo/' . $this->getIdPhoto() . '/' . $maxWidth;
            $cachePath = Image::getCachePath($uid);
            if (!file_exists($cachePath)) {
                // @TODO ajouter à une file de calcul
            }
            return Image::getCacheUrl($uid);
        }
    }

    /**
     * @return bool
     */
    function clearThumb(int $maxWidth = 0): bool
    {
        $uid = 'photo/' . $this->getIdPhoto() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
            return true;
        }

        return false;
    }

    /**
     * Génère la miniature d'une photo
     *
     * @param int $maxWidth maxWidth
     *
     * @return bool
     */
    function genThumb(int $maxWidth = 0): bool
    {
        if (!$maxWidth) {
            return false;
        }

        $uid = 'photo/' . $this->getIdPhoto() . '/' . $maxWidth;
        $cache = Image::getCachePath($uid);

        if (file_exists($cache)) {
            unlink($cache);
        }

        $source = self::getBasePath() . '/' . $this->getIdPhoto() . '.jpg';
        if (!file_exists($source)) {
            return false;
        }

        $img = (new Image($source))
            ->setType(IMAGETYPE_JPEG)
            ->setMaxWidth($maxWidth);

        Image::writeCache($uid, $img->get());

        return true;
    }

    /**
     * Répare l'orientation d'un jpeg
     *
     * @param string $filename
     */
    static function fixOrientation(string $filename): bool
    {
        $quality = 90;
        $info = getimagesize($filename);
        if ($info['mime'] === 'image/jpeg') {
            $exif = exif_read_data($filename);
            if (!empty($exif['Orientation']) && in_array($exif['Orientation'], [2, 3, 4, 5, 6, 7, 8])) {
                $image = imagecreatefromjpeg($filename);
                if (in_array($exif['Orientation'], [3, 4])) {
                    $image = imagerotate($image, 180, 0);
                }
                if (in_array($exif['Orientation'], [5, 6])) {
                    $image = imagerotate($image, -90, 0);
                }
                if (in_array($exif['Orientation'], [7, 8])) {
                    $image = imagerotate($image, 90, 0);
                }
                if (in_array($exif['Orientation'], [2, 5, 7, 4])) {
                    imageflip($image, IMG_FLIP_HORIZONTAL);
                }
            }
            imagejpeg($image, $filename, $quality);
            return true;
        }
        return false;
    }
}
