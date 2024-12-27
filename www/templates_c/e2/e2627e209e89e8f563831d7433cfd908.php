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

/* partners.twig */
class __TwigTemplate_c0f96f722a16177741e1f59a9597cacc extends Template
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
        $this->loadTemplate("common/header.twig", "partners.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"box\">
  <header>
    <h1>Partenaires</h1>
  </header>
  <div>
    ";
        // line 8
        if (($context["partners"] ?? null)) {
            // line 9
            echo "    <ul class=\"partners\">
    ";
            // line 10
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["partners"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["partner"]) {
                // line 11
                echo "      <li>
        <a href=\"";
                // line 12
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["partner"], "url", [], "any", false, false, false, 12), "html", null, true);
                echo "\">
          <img src=\"";
                // line 13
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["partner"], "iconUrl", [], "any", false, false, false, 13), "html", null, true);
                echo "\" alt=\"\">
          <strong>";
                // line 14
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["partner"], "title", [], "any", false, false, false, 14), "html", null, true);
                echo "</strong><br>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["partner"], "description", [], "any", false, false, false, 14), "html", null, true);
                echo "
        </a>
      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['partner'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 18
            echo "    </ul>
    ";
        } else {
            // line 20
            echo "    Pas de partenaires référencés
    ";
        }
        // line 22
        echo "  </div>
</div>

";
        // line 25
        $this->loadTemplate("common/footer.twig", "partners.twig", 25)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "partners.twig";
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
        return array (  92 => 25,  87 => 22,  83 => 20,  79 => 18,  67 => 14,  63 => 13,  59 => 12,  56 => 11,  52 => 10,  49 => 9,  47 => 8,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "partners.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/partners.twig");
    }
}
