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

/* common/header-menu.twig */
class __TwigTemplate_c364fb640b6467b18c8d5f46036a786c extends Template
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
        yield "<div class=\"top-bar\">
  <div class=\"top-bar-inner\">
    <div class=\"top-bar-title\">
      <a href=\"/\" accesskey=\"1\" title=\"Retour à l'accueil\"><strong>AD’HOC</strong></a>
    </div>
    <div class=\"top-bar-right\">
      <button id=\"btn-burger\" class=\"top-bar-burger\">≡</button>
      <nav class=\"top-menu\">
        <ul>
          <li>
            <a href=\"/assoce\" accesskey=\"2\" title=\"Présentation de l’Association AD’HOC, l’équipe, nos concerts\">L’Assoce</a>
            <ul>
              <li><a href=\"/concerts\">Concerts</a></li>
              <li><a href=\"/afterworks\">Afterworks</a></li>
              <li><a href=\"/festival\">Le festival</a></li>
              <li><a href=\"/equipe\">Équipe</a></li>
            </ul>
          </li>
          <li>
            <a href=\"/events\" accesskey=\"2\" title=\"Agenda\">Agenda</a>
          </li>
          <li>
            <a href=\"/medias\" accesskey=\"3\" title=\"Vidéos\">Vidéos</a>
          </li>
          <li>
            <a href=\"/groupes\" accesskey=\"4\" title=\"Groupes\">Groupes</a>
          </li>
          <li>
            <a href=\"/contact\" accesskey=\"5\" title=\"Contact\">Contact</a>
          </li>
          <li>
          ";
        // line 32
        if ( !($context["is_auth"] ?? null)) {
            // line 33
            yield "            <a class=\"avatar\" rel=\"nofollow\" href=\"/auth/auth\" accesskey=\"6\" title=\"Identification\">🔒</a>
          ";
        } else {
            // line 35
            yield "            <a class=\"avatar\" rel=\"nofollow\" href=\"/membres/tableau-de-bord\" accesskey=\"6\" title=\"Tableau de bord\">🔓</a>
          ";
        }
        // line 37
        yield "          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "common/header-menu.twig";
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
        return array (  85 => 37,  81 => 35,  77 => 33,  75 => 32,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/header-menu.twig", "/var/www/docker.adhocmusic.com/www/views/common/header-menu.twig");
    }
}
