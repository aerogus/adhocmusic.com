<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* common/header-menu.twig */
class __TwigTemplate_3cb7cf3a35814c81b12dde9764cec4e1 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"top-bar\">
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
            echo "            <a class=\"avatar\" rel=\"nofollow\" href=\"/auth/auth\" accesskey=\"6\" title=\"Identification\">🔒</a>
          ";
        } else {
            // line 35
            echo "            <a class=\"avatar\" rel=\"nofollow\" href=\"/membres/tableau-de-bord\" accesskey=\"6\" title=\"Tableau de bord\">🔓</a>
          ";
        }
        // line 37
        echo "          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>
";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "common/header-menu.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  80 => 37,  76 => 35,  72 => 33,  70 => 32,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/header-menu.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/common/header-menu.twig");
    }
}
