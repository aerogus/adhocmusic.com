<?php

declare(strict_types=1);

namespace Adhoc\Utils;

use Adhoc\Utils\Image;
use Adhoc\Utils\Tools;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

/**
 *
 */
class EmailTwig
{
    /**
     * @var array<string,mixed>
     */
    public array $vars = [
    ];

    /**
     *
     */
    protected ?FilesystemLoader $loader = null;

    /**
     *
     */
    protected ?Environment $env = null;

    /**
     *
     */
    public function __construct()
    {
        $this->loader = new FilesystemLoader(TWIG_TEMPLATES_PATH);
        $this->env = new Environment($this->loader, [
            'cache' => TWIG_TEMPLATES_C_PATH,
            'auto_reload' => true, // true pour dev uniquement
        ]);

        $this->env->addExtension(new IntlExtension());

        //$this->registerPlugin('modifier', 'link', ['Adhoc\Utils\EmailTwig', 'modifierLink']);
        //$this->registerPlugin('function', 'image', ['Adhoc\Utils\EmailTwig', 'functionImage']);
    }

    /**
     * @param string $key
     * @param mixed  $val
     *
     * @return void
     */
    public function assign($key, $val): void
    {
        $this->vars[$key] = $val;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function modifierLink(string $url): string
    {
        // oui je sais pour les global ...
        // @see Controller::email::newsletter
        global $newsletter_id_newsletter;
        global $newsletter_id_contact;
        $orig = $newsletter_id_newsletter . '|' . $newsletter_id_contact;
        //return $url; // en attendant que ça remarche
        return 'https://www.adhocmusic.com/r/' . Tools::base64UrlEncode($url) . '||' . Tools::base64UrlEncode($orig);
    }

    /**
     * Récupère l'url d'une image cachée (la cache si nécessaire)
     *
     * @param array<string,mixed> $params [
     *                                'type'
     *                                'id'
     *                                'width'
     *                                'height'
     *                                'bgcolor'
     *                                'border'
     *                                'zoom'
     *                            ]
     *
     * @return string
     */
    public static function functionImage($params): string
    {
        $type    = (string) $params['type'];
        $id      = (int) $params['id'];
        $width   = (int) $params['width'];
        $height  = (int) $params['height'];
        $bgcolor = (string) $params['bgcolor'];
        $border  = (int) $params['border'];
        $zoom    = (int) $params['zoom'];

        $uid = $type . '/' . $id . '/' . $width . '/' . $height . '/' . $bgcolor . '/' . $border . '/' . $zoom . '.jpg';

        switch ($type) {
            case 'photo':
                $source = ADHOC_ROOT_PATH . '/media/photo/' . $id . '.jpg';
                break;
            case 'event':
                $source = ADHOC_ROOT_PATH . '/media/event/' . $id . '.jpg';
                break;
            case 'video':
                $source = ADHOC_ROOT_PATH . '/media/video/' . $id . '.jpg';
                break;
            default:
                $source = '';
                break;
        }

        $cache_local = Image::getCachePath($uid);
        $cache_url = Image::getCacheUrl($uid);

        if (file_exists($cache_local)) {
            return $cache_url;
        }

        if (file_exists($source)) {
            $img = (new Image($source))
                ->setType(IMAGETYPE_JPEG)
                ->setMaxWidth($width)
                ->setMaxHeight($height)
                ->setBorder($border)
                ->setKeepRatio(true)
                ->setZoom($zoom)
                ->setHexColor($bgcolor);
            Image::writeCache($uid, $img->get());
            return $cache_url;
        }

        return '---';
    }

    /**
     * @param string $tpl_file
     *
     * @return string
     */
    public function render(string $tpl_file): string
    {
        return $this->env->render($tpl_file, $this->vars);
    }
}
