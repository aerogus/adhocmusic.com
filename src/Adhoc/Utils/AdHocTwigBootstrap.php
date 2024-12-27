<?php

declare(strict_types=1);

namespace Adhoc\Utils;

use Adhoc\Utils\Trail;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

/**
 * Fonctions et modifiers custom pour Twig
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */
class AdHocTwigBootstrap
{
    /**
     * @var array<string,mixed>
     */
    public array $vars = [
        'stylesheets' => [], // css
        'header_scripts' => [], // js du header
        'script_vars' => [], // variables js utilisables dans les scripts du footer
        'inline_scripts' => [], // scripts js inline
        'footer_scripts' => [], // js du footer
        'title' => '',
        'body_class' => '',
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

        // assignations générales
        $this->assign('title', "♫ AD'HOC : les Musiques Actuelles en Essonne");
        $this->assign('description', "Portail sur les musiques actuelles, vidéos de concerts, promotion d'artistes...");
        $this->assign('og_type', 'website');
        $this->assign('og_image', HOME_URL . '/img/screenshot-homepage.jpg');
        $this->assign('sessid', session_id());
        $this->assign('HOME_URL', HOME_URL);
        $this->assign('uri', $_SERVER['REQUEST_URI']);
        $this->assign('url', HOME_URL . $_SERVER['REQUEST_URI']);
        $this->assign('fb_page_id', FB_PAGE_ID);
        $this->assign('robots', 'index,follow');

        if (array_key_exists('membre', $_SESSION)) {
            $this->assign('me', $_SESSION['membre']);
            $this->assign('is_auth', true);
        } else {
            $this->assign('is_auth', false);
        }

        $this->enqueueStyle('/static/library/bootstrap@5.3.3/bootstrap.min.css');
        $this->enqueueStyle('/css/adhoc-bs.css');

        $this->enqueueScript('/static/library/bootstrap@5.3.3/bootstrap.bundle.min.js');
        $this->enqueueScript('/static/library/jquery@3.7.1/jquery.min.js');
        $this->enqueueScript('/js/adhoc-bs.js');
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
     * Ajoute d'une feuille de style
     *
     * @param string $style_name url de la feuille de style
     *
     * @return void
     */
    public function enqueueStyle(string $style_name): void
    {
        $this->vars['stylesheets'][] = $style_name;
    }

    /**
     * Ajoute un javascript externe dans le footer
     *
     * @param string $script_name url du script
     * @param bool $in_footer
     *
     * @return void
     */
    public function enqueueScript(string $script_name, bool $in_footer = true): void
    {
        if ($in_footer) {
            $this->vars['footer_scripts'][] = $script_name;
        } else {
            $this->vars['header_scripts'][] = $script_name;
        }
    }

    /**
     * Ajoute une variable js utilisable dans les scripts du footer
     *
     * @param string $key   key
     * @param mixed  $value value
     *
     * @return void
     */
    public function enqueueScriptVar(string $key, $value): void
    {
        $this->vars['script_vars'][$key] = $value;
    }

    /**
     * Ajoute plusieurs variables js utilisables dans les scripts du footer
     *
     * @param array<string,mixed> $vars ['key1' => value1, 'key2' => value2]
     *
     * @return void
     */
    public function enqueueScriptVars(array $vars): void
    {
        foreach ($vars as $key => $value) {
            $this->enqueueScriptVar($key, $value);
        }
    }

    /**
     * Imprime un javascript en ligne dans le footer
     *
     * @param string $script script
     *
     * @return void
     */
    public function printInlineScript(string $script): void
    {
        $this->vars['inline_scripts'][] = $script;
    }

    /**
     * @param string $tpl_file
     *
     * @return string
     */
    public function render(string $tpl_file): string
    {
        // fil d'ariane
        $this->assign('trail', Trail::getInstance()->getPath());

        return $this->env->render($tpl_file, $this->vars);
    }
}
