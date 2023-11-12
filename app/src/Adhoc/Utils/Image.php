<?php

declare(strict_types=1);

namespace Adhoc\Utils;

/**
 * Classe de création et de conversion d'images
 *
 * Format d'import/export : GIF/JPEG/PNG
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Image
{
    /**
     * @var string
     */
    protected string $file_sou = '';

    /**
     * @var string
     */
    protected string $file_res = '';

    /**
     * handle source
     *
     * @var \GdImage|false
     */
    protected $handle = null;

    /**
     * handle resizé
     *
     * @var \GdImage|false
     */
    protected $handle2 = null;

    /**
     * handle final + palette
     *
     * @var \GdImage|false
     */
    protected $handle3 = null;

    /**
     * Largeur de l'image
     *
     * @var int
     */
    protected int $width = 0;

    /**
     * Hauteur de l'image
     *
     * @var int
     */
    protected int $height = 0;

    /**
     * @var mixed
     */
    protected $type = IMAGETYPE_JPEG;

    /**
     * @var mixed
     */
    protected $ratio = null;

    /**
     * couleur courante en Hexa
     *
     * @var mixed
     */
    protected $color = null;

    /**
     * Zone de sélection (nouveau cadrage)
     */

    /**
     * @var int
     */
    protected int $x1 = 0;   // point supérieur gauche

    /**
     * @var int
     */
    protected int $x2 = 0;   //

    /**
     * @var int
     */
    protected int $y1 = 0;   // point inférieur droit

    /**
     * @var int
     */
    protected int $y2 = 0;   //

    /**
     * @var int
     */
    protected int $wSel = 0; // largeur et hauteur selectionnées

    /**
     * @var int
     */
    protected int $hSel = 0; //

    /**
     * dimensions de la nouvelle image
     */

    /**
     * @var int
     */
    protected int $new_l = 0;

    /**
     * @var int
     */
    protected int $new_h = 0;

    /**
     * décalage à l'origine, pour les images générées avec bordure
     */

    /**
     * @var int
     */
    protected int $deltax = 0;

    /**
     * @var int
     */
    protected int $deltay = 0;

    /**
     * contraintes de conversion
     */

    /**
     * @var int
     */
    protected int $max_width  = 0; // px

    /**
     * @var int
     */
    protected int $max_height = 0; // px

    /**
     * Qualité / Taux de compression
     */

    /**
     * @var int
     */
    protected int $jpeg_quality; // pas d'unité (0:dégradé/léger -> 100:beau/lourd)

    /**
     * @var int
     */
    protected int $png_quality;  // quantisation de la palette en bits : 24/16/8/4/2/1

    /**
     * @var int
     */
    protected int $gif_quality;  // nbre de couleurs de la palette : 1 à 256

    /**
     * Ajout d'une bordure en cas de resize
     *
     * @var bool
     */
    protected bool $border = true;

    /**
     * Garde les proportions en cas de resize
     *
     * @var bool
     */
    protected bool $keep_ratio = true;

    /**
     * Constructeur
     * charge le handle d'un fichier si passé en paramètre
     * sinon crée une nouvelle image aux dimensions données
     *
     * @param string $file file
     */
    public function __construct(string $file = null)
    {
        if (!is_null($file)) {
            $this->file_sou = $file;
            $this->read();
        }

        // valeurs par défaut
        $this->border       = false;
        $this->keep_ratio   = true;
        $this->jpeg_quality = 90;
        $this->gif_quality  = 256;
        $this->png_quality  = 16777216;
        $this->color        = ['r' => 0, 'g' => 0, 'b' => 0]; // indépendant du handle
        $this->deltax       = 0;
        $this->deltay       = 0;

        $this->file_res     = '/tmp/adhocmusic-img-' . md5(time() . rand());
    }

    /**
     * Créé une image à partir de ... rien
     *
     * @param int    $width  > 1
     * @param int    $height > 1
     * @param string $color  (ex: #ffffff)
     *
     * @return object
     */
    public function init(int $width = 16, int $height = 16, string $color = null): object
    {
        $this->handle = imagecreatetruecolor($width, $height);

        if ($color) {
            $color = str_replace('#', '', $color);
            $red   = hexdec(substr($color, 0, 2));
            $green = hexdec(substr($color, 2, 2));
            $blue  = hexdec(substr($color, 4, 2));
            $color = imagecolorallocate($this->handle, $red, $green, $blue);
            imagefill($this->handle, 0, 0, $color);
        }

        $this->width  = (int) $width;
        $this->height = (int) $height;
        $this->ratio  = $this->width / $this->height;

        $this->selectAll();

        return $this;
    }

    /**
     * Charge un fichier dans l'attribut $this->handle
     * retourn false en cas d'erreur
     *
     * @return bool
     * @throws \Exception
     */
    public function read(): bool
    {
        if ($this->file_sou && file_exists($this->file_sou) && is_readable($this->file_sou)) {
            $this->type = exif_imagetype($this->file_sou);

            switch ($this->type) {
                case IMAGETYPE_GIF:
                    $this->handle = imagecreatefromgif($this->file_sou);
                    break;

                case IMAGETYPE_JPEG:
                    $this->handle = imagecreatefromjpeg($this->file_sou);
                    break;

                case IMAGETYPE_PNG:
                    $this->handle = imagecreatefrompng($this->file_sou);
                    break;

                default:
                    return false;
            }

            $this->width  = imagesx($this->handle);
            $this->height = imagesy($this->handle);
            $this->ratio  = $this->width / $this->height;

            // on select tout par défaut
            $this->selectAll();

            return true;
        } else {
            throw new \Exception('file_sou introuvable');
        }
    }

    /**
     * Méthodes de selection d'une zone
     */

    /**
     * Défini une zone valide dans l'image source
     * règle :
     * 0 <= x1 < x2 < $this->width
     * 0 <= y1 < y2 < $this->height
     *
     * @param int $x1 x1
     * @param int $y1 y1
     * @param int $x2 x2
     * @param int $y2 y2
     *
     * @return object
     */
    public function setZone(int $x1, int $y1, int $x2, int $y2): object
    {
        if (
            ($x1 >= 0) && ($x2 > $x1) && ($this->width > $x2) &&
            ($y1 >= 0) && ($y2 > $y1) && ($this->height > $y2)
        ) {
            $this->x1   = $x1;
            $this->y1   = $y1;
            $this->x2   = $x2;
            $this->y2   = $y2;
            $this->wSel = $this->x2 - $this->x1 + 1;
            $this->hSel = $this->y2 - $this->y1 + 1;
        }

        return $this;
    }

    /**
     * On sélectionne la zone centrale de l'image
     *
     * @param bool $zoom bool
     *
     * @return object
     */
    public function setZoom(bool $zoom = true): object
    {
        if ($zoom) {
            // ratio de l'image destination
            $ratio = $this->max_width / $this->max_height;

            // coordonnées de la sélection avant calcul
            $x1 = 0;
            $y1 = 0;
            $x2 = 0;
            $y2 = 0;

            // cadrage
            while (($x2 < $this->width) && ($y2 < $this->height)) {
                $x2 += $ratio;
                $y2 += $ratio;
            }

            // arrondi
            $x2 = intval($x2);
            $y2 = intval($y2);

            // centrage de la sélection
            $offsetx = intval(($this->width - $x2) / 2);
            $offsety = intval(($this->height - $y2) / 2);

            $x1 += $offsetx;
            $y1 += $offsety;
            $x2 += $offsetx - 1;
            $y2 += $offsety - 1;

            $this->setZone($x1, $y1, $x2, $y2);
        }

        return $this;
    }

    /**
     * Sélection de toute l'image
     *
     * @return void
     */
    public function selectAll(): void
    {
        $this->setZone(0, 0, $this->width - 1, $this->height - 1);
    }

    /**
     * Defini le nom du fichier destination
     *
     * @param string $file file
     *
     * @return self
     */
    public function setDestFile(string $file): self
    {
        $this->file_res = $file;

        return $this;
    }

    /**
     * Fixe la couleur courante
     *
     * 3 paramàtres de 0 à 255 chacun
     *
     * @param int $red   rouge
     * @param int $green vert
     * @param int $blue  bleu
     *
     * @return object
     */
    public function setColor(int $red = 0, int $green = 0, int $blue = 0): object
    {
        $this->color = [
            'r' => $red,
            'g' => $green,
            'b' => $blue,
        ];

        return $this;
    }

    /**
     * Fixe la couleur courante
     * parametre en hexa (ex: FB41CE)
     *
     * @param string $hexCode hexCode
     *
     * @return object
     */
    public function setHexColor(string $hexCode): object
    {
        $red   = hexdec(substr($hexCode, 0, 2));
        $green = hexdec(substr($hexCode, 2, 2));
        $blue  = hexdec(substr($hexCode, 4, 2));
        $this->setColor($red, $green, $blue);

        return $this;
    }

    /**
     * Type du fichier de sortie
     * les constantes exif sont supportées :
     * - IMAGETYPE_GIF
     * - IMAGETYPE_JPEG
     * - IMAGETYPE_PNG
     *
     * @param int $type type
     *
     * @return object
     */
    public function setType(int $type): object
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Fixe une contrainte de largeur maxi
     *
     * @param int $maxWidth largeur maxi
     *
     * @return object
     */
    public function setMaxWidth(int $maxWidth): object
    {
        $this->max_width = $maxWidth;

        return $this;
    }

    /**
     * Fixe une contrainte de hauteur maxi
     *
     * @param int $maxHeight hauteur maxi
     *
     * @return self
     */
    public function setMaxHeight(int $maxHeight): self
    {
        $this->max_height = $maxHeight;

        return $this;
    }

    /**
     * Redimensionnement de l'image
     * handle -> handle2
     *
     * @return void
     */
    public function resize(): void
    {
        if ($this->max_height && $this->max_width && $this->border) {
            $width = $this->max_width;
            $height = $this->max_height;
        } else {
            $width = $this->new_l;
            $height = $this->new_h;
        }

        $this->handle2 = imagecreatetruecolor((int) $width, (int) $height);

        // rempli le fond avec la couleur courante
        $bgcolor = imagecolorallocate($this->handle2, $this->color['r'], $this->color['g'], $this->color['b']);
        imagefill($this->handle2, 0, 0, $bgcolor);

        imagecopyresampled(
            $this->handle2,
            $this->handle,
            $this->deltax,
            $this->deltay,
            $this->x1,
            $this->y1,
            $this->new_l,
            $this->new_h,
            $this->wSel,
            $this->hSel
        );
    }

    /**
     * Calcul des nouvelles hauteurs et largeurs à partir de la zone
     * sélectionnée de l'image source et des contraintes
     * (max_width, max_height et keep_ratio)
     * calcul aussi l'offset si bordure
     * charge new_l et new_h
     *
     * @return void
     */
    public function calculTaille(): void
    {
        /**
         * Calcul de la nouvelle taille de l'image
         */
        if ($this->keep_ratio) {
            if ($this->max_height) {
                $tmp_h = min($this->hSel, $this->max_height);
                $rh1   = $tmp_h / $this->hSel;
                $tmp_l = round($this->wSel * $rh1);
                if ($this->max_width && $tmp_l) { // a debugguer
                    $this->new_l = (int) min($this->max_width, $tmp_l);
                    $rh2          = $this->new_l / ($this->wSel * $rh1);
                    $this->new_h = (int) round($this->hSel * $rh1 * $rh2);
                } else {
                    $this->new_l = (int) $tmp_l;
                    $this->new_h = (int) $tmp_h;
                }
            } else {
                if ($this->max_width) {
                    $this->new_l = (int) min($this->wSel, $this->max_width);
                    $rh           = $this->new_l / $this->wSel;
                    $this->new_h = (int) round($this->hSel * $rh);
                } else {
                    $this->new_l = (int) $this->wSel;
                    $this->new_h = (int) $this->hSel;
                }
            }
        } else {
            if ($this->max_height) {
                if ($this->max_width) {
                    $this->new_l = (int) min($this->wSel, $this->max_width);
                    $this->new_h = (int) min($this->hSel, $this->max_height);
                } else {
                    $this->new_l = $this->wSel;
                    $this->new_h = (int) min($this->hSel, $this->max_height);
                }
            } else {
                if ($this->max_width) {
                    $this->new_l = (int) min($this->wSel, $this->max_width);
                    $this->new_h = (int) $this->hSel;
                } else {
                    $this->new_l = (int) $this->wSel;
                    $this->new_h = (int) $this->hSel;
                }
            }
        }

        /**
         * Calcul de l'offset en cas de bordure
         */
        if ($this->max_height && $this->max_width && $this->border) {
            $this->deltax = (int) round(($this->max_width - $this->new_l) / 2);
            $this->deltay = (int) round(($this->max_height - $this->new_h) / 2);
        } else {
            $this->deltax = 0;
            $this->deltay = 0;
        }
    }

    /**
     * Indique si on doit garder les proportions
     *
     * @param bool $bool bool
     *
     * @return object
     */
    public function setKeepRatio(bool $bool): object
    {
        $this->keep_ratio = $bool;

        return $this;
    }

    /**
     * Indique si on doit ajouter des bordures
     *
     * @param bool $bool bool
     *
     * @return object
     */
    public function setBorder(bool $bool): object
    {
        $this->border = $bool;

        return $this;
    }

    /**
     * Méthodes de sortie du flux
     */

    /**
     * Affiche l'image à l'écran
     *
     * @return void
     */
    public function display(): void
    {
        $this->calculTaille();
        $this->resize();

        switch ($this->type) {
            case IMAGETYPE_GIF:
                header("Content-Type: image/gif");
                imagetruecolortopalette($this->handle2, true, $this->gif_quality);
                imagegif($this->handle2);
                break;

            case IMAGETYPE_JPEG:
                header("Content-Type: image/jpeg");
                imagejpeg($this->handle2, null, $this->jpeg_quality);
                break;

            case IMAGETYPE_PNG:
                header("Content-Type: image/png");
                imagetruecolortopalette($this->handle2, true, $this->png_quality);
                imagepng($this->handle2);
                break;
        }
    }

    /**
     * Écrit la nouvelle image sur disque
     *
     * @return void
     */
    public function write(): void
    {
        $this->calculTaille();
        $this->resize();
        $this->doWrite(false);
    }

    /**
     * Retourne l'image sous forme de chaine binaire
     *
     * @return string
     */
    public function get(): string
    {
        $this->calculTaille();
        $this->resize();
        return $this->doWrite(true);
    }

    /**
     * écriture des images générées
     *
     * @param bool $get_contents
     *
     * @return mixed
     */
    private function doWrite(bool $get_contents = false): mixed
    {
        $res = false;

        switch ($this->type) {
            case IMAGETYPE_GIF:
                $this->handle3 = imagecreatetruecolor($this->new_l, $this->new_h);
                imagecopy($this->handle3, $this->handle2, 0, 0, 0, 0, $this->new_l, $this->new_h);
                imagetruecolortopalette($this->handle3, true, $this->gif_quality);
                $res = imagegif($this->handle3, $this->file_res);
                break;

            case IMAGETYPE_JPEG:
                $this->handle3 = imagecreatetruecolor($this->new_l, $this->new_h);
                imagecopy($this->handle3, $this->handle2, 0, 0, 0, 0, $this->new_l, $this->new_h);
                $res = imagejpeg($this->handle3, $this->file_res, $this->jpeg_quality);
                break;

            case IMAGETYPE_PNG:
                $this->handle3 = imagecreatetruecolor($this->new_l, $this->new_h);
                imagecopy($this->handle3, $this->handle2, 0, 0, 0, 0, $this->new_l, $this->new_h);
                imagetruecolortopalette($this->handle3, true, $this->png_quality);
                $res = imagepng($this->handle3, $this->file_res);
                break;
        }

        if ($get_contents) {
            if (file_exists($this->file_res)) {
                $img = file_get_contents($this->file_res);
                unlink($this->file_res);
                return $img;
            }
            return false;
        } else {
            return $res;
        }
    }

    /**
     * Retourne le chemin local de l'image cachée
     *
     * @param string $uid uid
     *
     * @return string
     */
    public static function getCachePath(string $uid): string
    {
        $hash = md5(trim($uid));

        $d0 = IMG_CACHE_PATH;
        $d1 = substr($hash, 0, 1);
        $d2 = substr($hash, 1, 1);
        $d3 = substr($hash, 2, 1);

        return $d0 . '/' . $d1 . '/' . $d2 . '/' . $d3 . '/' . $hash . '.jpg';
    }

    /**
     * Retourne l'url de l'image cachée
     *
     * @param string $uid uid
     *
     * @return string
     */
    public static function getCacheUrl(string $uid): string
    {
        $hash = md5(trim($uid));

        $d0 = IMG_CACHE_URL;
        $d1 = substr($hash, 0, 1);
        $d2 = substr($hash, 1, 1);
        $d3 = substr($hash, 2, 1);

        return $d0 . '/' . $d1 . '/' . $d2 . '/' . $d3 . '/' . $hash . '.jpg';
    }

    /**
     * Écrit le cache
     *
     * @param string $uid     UID
     * @param string $content (bin)
     *
     * @return bool
     */
    public static function writeCache(string $uid, string $content): bool
    {
        $hash = md5(trim($uid));

        $d0 = IMG_CACHE_PATH;
        $d1 = substr($hash, 0, 1);
        $d2 = substr($hash, 1, 1);
        $d3 = substr($hash, 2, 1);

        $dir = $d0 . '/' . $d1 . '/' . $d2 . '/' . $d3;
        // création du répertoire de stockage si inexistant
        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        $dest = $dir . '/' . $hash . '.jpg';

        return (bool) file_put_contents($dest, $content);
    }
}
