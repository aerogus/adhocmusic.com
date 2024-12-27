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

/* map.twig */
class __TwigTemplate_1151f9ca59dd8b9600d5c69034cae876 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "map.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h1>Plan du site</h1>

  ";
        // line 6
        if (($context["referer"] ?? null)) {
            // line 7
            yield "  <div class=\"alert alert-danger\">La page que vous demandez n'existe pas, voici le plan du site ainsi que les principaux liens:</div>
  ";
        }
        // line 9
        yield "
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
        // line 49
        yield from $this->loadTemplate("common/footer.twig", "map.twig", 49)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "map.twig";
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
        return array (  98 => 49,  56 => 9,  52 => 7,  50 => 6,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "map.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/map.twig");
    }
}
