<?php

declare(strict_types=1);

namespace Adhoc\Model;

use Adhoc\Model\Media;
use Adhoc\Utils\Conf;
use Adhoc\Utils\Image;

/**
 * Classe Photo
 *
 * Classe de gestion des photos du site
 * Upload, Appel conversion etc ...
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class Photo extends Media
{
    /**
     * @var array<string>
     */
    protected static array $pk = [
        'id_photo',
    ];

    /**
     * @var string
     */
    protected static string $table = 'adhoc_photo';

    /**
     * @var ?int
     */
    protected ?int $id_photo = null;

    /**
     * @var ?string
     */
    protected ?string $credits = null;

    /**
     * Liste des attributs de l'objet
     *
     * @var array<string,string>
     */
    protected static array $all_fields = [
        'id_photo' => 'int', // pk
        'id_contact' => 'int',
        'id_groupe' => 'int',
        'id_lieu' => 'int',
        'id_event' => 'int',
        'name' => 'string',
        'created_at' => 'date',
        'modified_at' => 'date',
        'online' => 'bool',
        'credits' => 'string',
    ];

    /**
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return MEDIA_URL . '/photo';
    }

    /**
     * @return string
     */
    public static function getBasePath(): string
    {
        return MEDIA_PATH . '/photo';
    }

    /**
     * @return ?int
     */
    public function getIdPhoto(): ?int
    {
        return $this->id_photo;
    }

    /**
     * @return int
     */
    public function getIdMedia(): int
    {
        return $this->getIdPhoto();
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return Membre::getInstance($this->getIdContact())->getPseudo();
    }

    /**
     * @return string
     */
    public function getCredits(): string
    {
        return $this->credits;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return HOME_URL . '/photos/' . $this->getIdPhoto();
    }

    /**
     * @param int $id_photo
     *
     * @return static
     */
    public function setIdPhoto(int $id_photo): static
    {
        if ($this->id_photo !== $id_photo) {
            $this->id_photo = $id_photo;
            $this->modified_fields['id_photo'] = true;
        }

        return $this;
    }

    /**
     * @param ?string $credits credits
     *
     * @return static
     */
    public function setCredits(?string $credits): static
    {
        if ($this->credits !== $credits) {
            $this->credits = $credits;
            $this->modified_fields['credits'] = true;
        }

        return $this;
    }

    /**
     * Efface une photo de la table photo + le fichier .jpg
     *
     * @return bool
     */
    public function delete(): bool
    {
        if (parent::delete()) {
            $thumbWidths = Conf::getInstance()->get('photo')['thumb_width'];
            foreach ($thumbWidths as $maxWidth) {
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
     * Retourne l'url d'une miniature de photo (sans vérifier l'existence du fichier)
     *
     * @param int  $maxWidth     largeur maxi
     * @param bool $genIfMissing force la génération de la miniature si manquante
     *
     * @return ?string
     */
    public function getThumbUrl(int $maxWidth = 0, bool $genIfMissing = false): ?string
    {
        $sourcePath = self::getBasePath() . '/' . $this->getIdPhoto() . '.jpg';
        if (!file_exists($sourcePath)) {
            return null;
        }

        if ($maxWidth === 0) {
            return self::getBaseUrl() . '/' . $this->getIdPhoto() . '.jpg';
        } else {
            $uid = 'photo/' . $this->getIdPhoto() . '/' . $maxWidth;
            $cachePath = Image::getCachePath($uid);
            if (!file_exists($cachePath)) {
                if ($genIfMissing) {
                    $this->genThumb($maxWidth);
                } else {
                    // @TODO ajouter à une file de calcul
                }
            }
            return Image::getCacheUrl($uid);
        }
    }

    /**
     * @return bool
     */
    public function clearThumb(int $maxWidth = 0): bool
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
    public function genThumb(int $maxWidth = 0): bool
    {
        if ($maxWidth === 0) {
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
     * Répare l'orientation d'un jpeg en se basant sur les données EXIF
     *
     * @param string $filename image source + destination
     *
     * @return bool
     */
    public static function fixOrientation(string $filename): bool
    {
        if (getimagesize($filename)['mime'] !== 'image/jpeg') {
            return false;
        }
        $exif = exif_read_data($filename);
        if (isset($exif['Orientation']) && in_array($exif['Orientation'], [2, 3, 4, 5, 6, 7, 8], true)) {
            $image = imagecreatefromjpeg($filename);
            if (in_array($exif['Orientation'], [3, 4], true)) {
                $image = imagerotate($image, 180, 0);
            }
            if (in_array($exif['Orientation'], [5, 6], true)) {
                $image = imagerotate($image, -90, 0);
            }
            if (in_array($exif['Orientation'], [7, 8], true)) {
                $image = imagerotate($image, 90, 0);
            }
            if (in_array($exif['Orientation'], [2, 5, 7, 4], true)) {
                imageflip($image, IMG_FLIP_HORIZONTAL);
            }
            imagejpeg($image, $filename, 100);
            return true;
        }
        return false;
    }

    /**
     * Applique une rotation à un .jpeg
     *
     * @param string $filename image source + destination
     * @param int $angle angle
     *
     * @return bool
     */
    public static function rotate(string $filename, int $angle): bool
    {
        if (!in_array($angle, [-90, 90, 180], true)) {
            return false;
        }
        if (getimagesize($filename)['mime'] !== 'image/jpeg') {
            return false;
        }
        $image = imagecreatefromjpeg($filename);
        $image = imagerotate($image, $angle, 0);
        imagejpeg($image, $filename, 100);
        return true;
    }
}
