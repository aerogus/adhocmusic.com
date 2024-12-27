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

/* groupes/index.twig */
class __TwigTemplate_1f9d2176c3c367490ff70d6e253fc952 extends Template
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
        $this->loadTemplate("common/header.twig", "groupes/index.twig", 1)->display($context);
        // line 2
        echo "
  <div class=\"box\">
    <header>
      <h1>Groupes</h1>
    </header>

    ";
        // line 8
        if ((twig_get_attribute($this->env, $this->source, ($context["groupes"] ?? null), "length", [], "any", false, false, false, 8) == 0)) {
            // line 9
            echo "    <div>
      <p>Aucun groupe référencé.</p>
    </div>
    ";
        } else {
            // line 13
            echo "    <div class=\"reset grid-7-small-4 has-gutter\">
      ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["groupes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                // line 15
                echo "      <div class=\"grpitem\">
        <a href=\"";
                // line 16
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 16), "html", null, true);
                echo "\">
          <img src=\"";
                // line 17
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "miniPhoto", [], "any", false, false, false, 17), "html", null, true);
                echo "\" alt=\"\" />
          <p>";
                // line 18
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 18), "html", null, true);
                echo "</p>
        </a>
      </div>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['groupe'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 22
            echo "    </div>
    ";
        }
        // line 24
        echo "  </div>

";
        // line 26
        $this->loadTemplate("common/footer.twig", "groupes/index.twig", 26)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "groupes/index.twig";
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
        return array (  91 => 26,  87 => 24,  83 => 22,  73 => 18,  69 => 17,  65 => 16,  62 => 15,  58 => 14,  55 => 13,  49 => 9,  47 => 8,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "groupes/index.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/groupes/index.twig");
    }
}
