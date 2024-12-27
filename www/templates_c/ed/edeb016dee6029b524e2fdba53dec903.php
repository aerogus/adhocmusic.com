<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* credits.twig */
class __TwigTemplate_31b1df7ec6c5aa9eb24e5744711eb159 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield from $this->loadTemplate("common/header.twig", "credits.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h1>Crédits</h1>
  <p>Le site <strong>adhocmusic.com</strong> a été développé bénévolement <strike>💰</strike> par <a class=\"ext\" href=\"https://guillaume.seznec.fr\">Guillaume Seznec</a> 🦸 pour l’<a href=\"/\">association AD’HOC</a> 🎶 depuis 2001. Son code source est sous licence <a class=\"ext\" href=\"https://github.com/aerogus/adhocmusic.com/blob/main/LICENSE\">GNU Affero General Public License</a>, consultable 🗒 et bifurquable ⑂ sur <a class=\"ext\" href=\"https://github.com/aerogus/adhocmusic.com\">GitHub</a>.</p>
  <p>Le site est hébergé sur un VPS chez <a class=\"ext\" href=\"https://www.ovhcloud.com\">OVHcloud</a> hébergé en France 🇫🇷🐓🥖. Le serveur tourne sous <a class=\"ext\" href=\"https://www.debian.org\">Debian GNU/Linux</a> 🍥, les principaux composants logiciels ⚙ sont <a class=\"ext\" href=\"https://www.nginx.com\">NGINX</a>, <a class=\"ext\" href=\"https://www.php.net\">PHP</a>, <a class=\"ext\" href=\"https://mariadb.org\">MariaDB</a>, <a class=\"ext\" href=\"https://memcached.org/\">memcached</a>.</p>
  <p>Les vidéos 📽 produites (captées + mixées + montées) par l’association sont hébergées sur notre <a class=\"ext\" href=\"https://videos.adhocmusic.com\">instance PeerTube</a>. Les autres vidéos 📽 sont issues des plateformes <a class=\"ext\" href=\"https://www.youtube.com\">YouTube</a>,  <a class=\"ext\" href=\"https://www.dailymotion.com\">Dailymotion</a>, <a class=\"ext\" href=\"https://www.facebook.com\">Facebook</a> ou <a class=\"ext\" href=\"https://vimeo.com\">Vimeo</a>.</p>
  <p>Les cartes topographiques 🗺 proviennent de <a class=\"ext\" href=\"https://www.openstreetmap.org\">OpenStreetMap</a> via l'API 🍃 <a class=\"ext\" href=\"https://www.leafletjs.com\">Leaflet</a>.</p>
  <p>Pour toute question ❓ sur le site ou l’association vous pouvez utiliser notre <a href=\"/contact\">formulaire de contact</a> 🖋.</p>
</div>

";
        // line 12
        yield from $this->loadTemplate("common/footer.twig", "credits.twig", 12)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "credits.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  56 => 12,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "credits.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/credits.twig");
    }
}
