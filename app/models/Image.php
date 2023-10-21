<?php

declare(strict_types=1);

namespace Adhoc\Model;

/**
 * Classe de création et de conversion d'images
 *
 * Format d'import/export : GIF/JPEG/PNG
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 *
 * @see http://classes.scriptsphp.net:81/doc.image
 */
class Image
{
    /**
     * @var string
     */
    protected string $_file_sou = '';
    protected string $_file_res = '';

    /**
     * @var mixed
     */
    protected $_handle  = null; // handle source
    protected $_handle2 = null; // handle resizé
    protected $_handle3 = null; // handle final + palette

    /**
     * @var int
     */
    protected $_width  = 0;
    protected $_height = 0;

    /**
     * @var mixed
     */
    protected $_type  = IMAGETYPE_JPEG; //
    protected $_ratio = null;           //
    protected $_color = null;           // couleur courante en Hexa

    /**
     * Zone de sélection (nouveau cadrage)
     */
    protected $_x1 = 0;   // point supérieur gauche
    protected $_x2 = 0;   //
    protected $_y1 = 0;   // point inférieur droit
    protected $_y2 = 0;   //
    protected $_wSel = 0; // largeur et hauteur selectionnées
    protected $_hSel = 0; //

    /**
     * dimensions de la nouvelle image
     */
    protected $_new_l = 0;
    protected $_new_h = 0;

    /**
     * décalage à l'origine, pour les images générées avec bordure
     */
    protected $_deltax = 0;
    protected $_deltay = 0;

    /**
     * contraintes de conversion
     */
    protected $_max_width  = 0; // px
    protected $_max_height = 0; // px

    /**
     * @var int Qualité / Taux de compression
     */
    protected $_jpeg_quality; // pas d'unité (0:dégradé/léger -> 100:beau/lourd)
    protected $_png_quality;  // quantisation de la palette en bits : 24/16/8/4/2/1
    protected $_gif_quality;  // nbre de couleurs de la palette : 1 à 256

    /**
     * @var bool Ajout d'une bordure en cas de resize
     */
    protected $_border = true;

    /**
     * @var bool Garde les proportions en cas de resize
     */
    protected $_keep_ratio = true;

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
            $this->_file_sou = $file;
            $this->read();
        }

        // valeurs par défaut
        $this->_border       = false;
        $this->_keep_ratio   = true;
        $this->_jpeg_quality = 90;
        $this->_gif_quality  = 256;
        $this->_png_quality  = 16777216;
        $this->_color        = ['r' => 0, 'g' => 0, 'b' => 0]; // indépendant du handle
        $this->_deltax       = 0;
        $this->_deltay       = 0;

        $this->_file_res     = '/tmp/adhocmusic-img-' . md5(time() . rand());
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
        $this->_handle = imagecreatetruecolor($width, $height);

        if ($color) {
            $color = str_replace('#', '', $color);
            $red   = hexdec(substr($color, 0, 2));
            $green = hexdec(substr($color, 2, 2));
            $blue  = hexdec(substr($color, 4, 2));
            $color = imagecolorallocate($this->_handle, $red, $green, $blue);
            imagefill($this->_handle, 0, 0, $color);
        }

        $this->_width  = (int) $width;
        $this->_height = (int) $height;
        $this->_ratio  = $this->_width / $this->_height;

        $this->selectAll();

        return $this;
    }

    /**
     * Charge un fichier dans l'attribut $this->_handle
     * retourn false en cas d'erreur
     *
     * @return bool
     * @throws Exception
     */
    public function read(): bool
    {
        if ($this->_file_sou && file_exists($this->_file_sou) && is_readable($this->_file_sou)) {
            $this->_type = exif_imagetype($this->_file_sou);

            switch ($this->_type) {
                case IMAGETYPE_GIF:
                    $this->_handle = imagecreatefromgif($this->_file_sou);
                    break;

                case IMAGETYPE_JPEG:
                    $this->_handle = imagecreatefromjpeg($this->_file_sou);
                    break;

                case IMAGETYPE_PNG:
                    $this->_handle = imagecreatefrompng($this->_file_sou);
                    break;

                default:
                    return false;
            }

            $this->_width  = imagesx($this->_handle);
            $this->_height = imagesy($this->_handle);
            $this->_ratio  = $this->_width / $this->_height;

            // on select tout par défaut
            $this->selectAll();

            return true;
        } else {
            throw new Exception('file_sou introuvable');
        }
    }

    /**
     * Méthodes de selection d'une zone
     */

    /**
     * Défini une zone valide dans l'image source
     * règle :
     * 0 <= x1 < x2 < $this->_width
     * 0 <= y1 < y2 < $this->_height
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
            ($x1 >= 0) && ($x2 > $x1) && ($this->_width > $x2) &&
            ($y1 >= 0) && ($y2 > $y1) && ($this->_height > $y2)
        ) {
            $this->_x1   = $x1;
            $this->_y1   = $y1;
            $this->_x2   = $x2;
            $this->_y2   = $y2;
            $this->_wSel = $this->_x2 - $this->_x1 + 1;
            $this->_hSel = $this->_y2 - $this->_y1 + 1;
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
            $ratio = $this->_max_width / $this->_max_height;

            // coordonnées de la sélection avant calcul
            $x1 = 0;
            $y1 = 0;
            $x2 = 0;
            $y2 = 0;

            // cadrage
            while (($x2 < $this->_width) && ($y2 < $this->_height)) {
                $x2 += $ratio;
                $y2 += $ratio;
            }

            // arrondi
            $x2 = intval($x2);
            $y2 = intval($y2);

            // centrage de la sélection
            $offsetx = intval(($this->_width - $x2) / 2);
            $offsety = intval(($this->_height - $y2) / 2);

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
     */
    public function selectAll()
    {
        $this->setZone(0, 0, $this->_width - 1, $this->_height - 1);
    }

    /**
     * Defini le nom du fichier destination
     *
     * @param string $file file
     *
     * @return object
     */
    public function setDestFile(string $file): object
    {
        $this->_file_res = $file;

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
        $this->_color = [
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
        $this->_type = $type;

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
        $this->_max_width = $maxWidth;

        return $this;
    }

    /**
     * Fixe une contrainte de hauteur maxi
     *
     * @param int $maxHeight hauteur maxi
     *
     * @return object
     */
    public function setMaxHeight(int $maxHeight): object
    {
        $this->_max_height = $maxHeight;

        return $this;
    }

    /**
     * Redimensionnement de l'image
     * handle -> handle2
     */
    public function resize()
    {
        if ($this->_max_height && $this->_max_width && $this->_border) {
            $width = $this->_max_width;
            $height = $this->_max_height;
        } else {
            $width = $this->_new_l;
            $height = $this->_new_h;
        }

        $this->_handle2 = imagecreatetruecolor((int) $width, (int) $height);

        // rempli le fond avec la couleur courante
        $bgcolor = imagecolorallocate($this->_handle2, $this->_color['r'], $this->_color['g'], $this->_color['b']);
        imagefill($this->_handle2, 0, 0, $bgcolor);

        imagecopyresampled(
            $this->_handle2,
            $this->_handle,
            $this->_deltax,
            $this->_deltay,
            $this->_x1,
            $this->_y1,
            $this->_new_l,
            $this->_new_h,
            $this->_wSel,
            $this->_hSel
        );
    }

    /**
     * Calcul des nouvelles hauteurs et largeurs à partir de la zone
     * sélectionnée de l'image source et des contraintes
     * (max_width, max_height et keep_ratio)
     * calcul aussi l'offset si bordure
     * charge new_l et new_h
     */
    public function calculTaille()
    {
        /**
         * Calcul de la nouvelle taille de l'image
         */
        if ($this->_keep_ratio) {
            if ($this->_max_height) {
                $tmp_h = min($this->_hSel, $this->_max_height);
                $rh1   = $tmp_h / $this->_hSel;
                $tmp_l = round($this->_wSel * $rh1);
                if ($this->_max_width && $tmp_l) { // a debugguer
                    $this->_new_l = (int) min($this->_max_width, $tmp_l);
                    $rh2          = $this->_new_l / ($this->_wSel * $rh1);
                    $this->_new_h = (int) round($this->_hSel * $rh1 * $rh2);
                } else {
                    $this->_new_l = (int) $tmp_l;
                    $this->_new_h = (int) $tmp_h;
                }
            } else {
                if ($this->_max_width) {
                    $this->_new_l = (int) min($this->_wSel, $this->_max_width);
                    $rh           = $this->_new_l / $this->_wSel;
                    $this->_new_h = (int) round($this->_hSel * $rh);
                } else {
                    $this->_new_l = (int) $this->_wSel;
                    $this->_new_h = (int) $this->_hSel;
                }
            }
        } else {
            if ($this->_max_height) {
                if ($this->_max_width) {
                    $this->_new_l = (int) min($this->_wSel, $this->_max_width);
                    $this->_new_h = (int) min($this->_hSel, $this->_max_height);
                } else {
                    $this->_new_l = $this->_wSel;
                    $this->_new_h = (int) min($this->_hSel, $this->_max_height);
                }
            } else {
                if ($this->_max_width) {
                    $this->_new_l = (int) min($this->_wSel, $this->_max_width);
                    $this->_new_h = (int) $this->_hSel;
                } else {
                    $this->_new_l = (int) $this->_wSel;
                    $this->_new_h = (int) $this->_hSel;
                }
            }
        }

        /**
         * Calcul de l'offset en cas de bordure
         */
        if ($this->_max_height && $this->_max_width && $this->_border) {
            $this->_deltax = round(($this->_max_width - $this->_new_l) / 2);
            $this->_deltay = round(($this->_max_height - $this->_new_h) / 2);
        } else {
            $this->_deltax = 0;
            $this->_deltay = 0;
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
        $this->_keep_ratio = $bool;

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
        $this->_border = $bool;

        return $this;
    }

    /**
     * Méthodes de sortie du flux
     */

    /**
     * Affiche l'image à l'écran
     */
    public function display()
    {
        $this->calculTaille();
        $this->resize();
        $this->display();
    }

    /**
     * Affichage de l'image à l'écran
     */
    private function display()
    {
        switch ($this->_type) {
            case IMAGETYPE_GIF:
                header("Content-Type: image/gif");
                imagetruecolortopalette($this->_handle2, true, $this->_gif_quality);
                imagegif($this->_handle2);
                break;

            case IMAGETYPE_JPEG:
                header("Content-Type: image/jpeg");
                imagejpeg($this->_handle2, null, $this->_jpeg_quality);
                break;

            case IMAGETYPE_PNG:
                header("Content-Type: image/png");
                imagetruecolortopalette($this->_handle2, true, $this->_png_quality);
                imagepng($this->_handle2);
                break;
        }
    }

    /**
     * Écrit la nouvelle image sur disque
     */
    public function write()
    {
        $this->calculTaille();
        $this->resize();
        $this->write(false);
    }

    /**
     * Retourne l'image sous forme de chaine binaire
     *
     * @return string
     */
    public function get()
    {
        $this->calculTaille();
        $this->resize();
        return $this->write(true);
    }

    /**
     * écriture des images générées
     */
    private function write(bool $get_contents = false)
    {
        switch ($this->_type) {
            case IMAGETYPE_GIF:
                $this->_handle3 = imagecreatetruecolor($this->_new_l, $this->_new_h);
                imagecopy($this->_handle3, $this->_handle2, 0, 0, 0, 0, $this->_new_l, $this->_new_h);
                imagetruecolortopalette($this->_handle3, true, $this->_gif_quality);
                imagegif($this->_handle3, $this->_file_res);
                break;

            case IMAGETYPE_JPEG:
                $this->_handle3 = imagecreatetruecolor($this->_new_l, $this->_new_h);
                imagecopy($this->_handle3, $this->_handle2, 0, 0, 0, 0, $this->_new_l, $this->_new_h);
                imagejpeg($this->_handle3, $this->_file_res, $this->_jpeg_quality);
                break;

            case IMAGETYPE_PNG:
                $this->_handle3 = imagecreatetruecolor($this->_new_l, $this->_new_h);
                imagecopy($this->_handle3, $this->_handle2, 0, 0, 0, 0, $this->_new_l, $this->_new_h);
                imagetruecolortopalette($this->_handle3, true, $this->_png_quality);
                imagepng($this->_handle3, $this->_file_res);
                break;
        }

        if ($get_contents) {
            if (file_exists($this->_file_res)) {
                $img = file_get_contents($this->_file_res);
                unlink($this->_file_res);
                return $img;
            }
            return false;
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
