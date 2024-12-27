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

/* map.twig */
class __TwigTemplate_a40a1197ffda8a6cd37e4a875b4c3b1a extends Template
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
        $this->loadTemplate("common/header.twig", "map.twig", 1)->display($context);
        // line 2
        echo "
";
        // line 3
        if (($context["referer"] ?? null)) {
            // line 4
            echo "<div class=\"infobulle error\">
  <p>La page que vous demandez n'existe pas</p>
  <p>Voici le plan du site ainsi que les principaux liens.</p>
</div>
";
        }
        // line 9
        echo "
<div class=\"box\">
  <header>
    <h1>Plan du site</h1>
  </header>
  <div>
    <div class=\"tree_top\"><a href=\"/\">adhocmusic.com</a></div>
    <ul class=\"tree\">
      <li>
        <a href=\"/\">Accueil</a>
        <ul>
          <li><a href=\"/map\">Plan du site</a></li>
          <li><a href=\"/partners\">Partenaires</a></li>
          <li><a href=\"/mentions-legales\">Mentions légales</a></li>
        </ul>
      </li>
      <li>
        <a href=\"/assoce\">L'Assoce</a>
        <ul>
          <li><a href=\"/concerts\">Concerts</a></li>
          <li><a href=\"/afterworks\">Afterworks</a></li>
          <li><a href=\"/festival\">Le Festival</a></li>
          <li><a href=\"/equipe\">Équipe</a></li>
        </ul>
      </li>
      <li>
        <a href=\"/groupes\">Groupes</a>
      </li>
      <li>
        <a href=\"/events\">Agenda</a>
      </li>
      <li>
        <a href=\"/medias\">Média</a>
      </li>
      <li>
        <a href=\"/contact\">Contact</a>
      </li>
      <li>
        <a href=\"/auth/auth\">Se connecter ou créer un compte</a>
      </li>
    </ul>
  </div>
</div>

";
        // line 53
        $this->loadTemplate("common/footer.twig", "map.twig", 53)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "map.twig";
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
        return array (  97 => 53,  51 => 9,  44 => 4,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "map.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/map.twig");
    }
}
