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
class __TwigTemplate_9cdf9de4ea55bd142e5859e37bfd6b47 extends Template
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
        yield "<header id=\"navbar\" class=\"navbar-container bg-dark\">
  <nav class=\"container-lg navbar navbar-dark navbar-expand-lg\">
    <div class=\"container-fluid\">
      <a class=\"navbar-brand\" id=\"brand\" href=\"/\">AD'HOC</a>
      <ul class=\"navbar-nav ms-auto\">
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
            L'assoce
          </a>
          <ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
            <li><a class=\"dropdown-item\" href=\"/concerts\">Concerts</a></li>
            <li><a class=\"dropdown-item\" href=\"/afterworks\">Afterworks</a></li>
            <li><a class=\"dropdown-item\" href=\"/festival\">Le festival</a></li>
            <li><a class=\"dropdown-item\" href=\"/equipe\">Équipe</a></li>
          </ul>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"/events\">Agenda</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"/medias\">Vidéos</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"/groupes\">Groupes</a>
        </li>
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"/contact\">Contact</a>
        </li>
        <li class=\"nav-item\">
          ";
        // line 30
        if ( !($context["is_auth"] ?? null)) {
            // line 31
            yield "            <a class=\"nav-link\" rel=\"nofollow\" href=\"/auth/auth\" accesskey=\"6\" title=\"Identification\">🔒</a>
          ";
        } else {
            // line 33
            yield "            <a class=\"nav-link\" rel=\"nofollow\" href=\"/membres/tableau-de-bord\" accesskey=\"6\" title=\"Tableau de bord\">🔓</a>
          ";
        }
        // line 35
        yield "        </li>
      </ul>
    </div>
  </nav>
</header>
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
        return array (  83 => 35,  79 => 33,  75 => 31,  73 => 30,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/header-menu.twig", "/var/www/docker.adhocmusic.com/www/views_bs/common/header-menu.twig");
    }
}
