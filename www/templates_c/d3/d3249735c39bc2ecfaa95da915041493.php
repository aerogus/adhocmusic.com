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

/* common/breadcrumb.twig */
class __TwigTemplate_9ef4db9dba13881f2731b8469f513da0 extends Template
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
        // line 2
        if ((twig_length_filter($this->env, ($context["trail"] ?? null)) > 1)) {
            // line 3
            echo "<div class=\"breadcrumb\">
  <ul>
    ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["trail"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 6
                echo "    <li>
    ";
                // line 7
                if (twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 7)) {
                    // line 8
                    echo "      <a ";
                    if (($context["key"] == 0)) {
                        echo " class=\"home\"";
                    }
                    echo " href=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 8), "html", null, true);
                    echo "\" title=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, false, 8), "html", null, true);
                    echo "\">
        ";
                    // line 9
                    if (($context["key"] == 0)) {
                        echo "<span class=\"mobile\">🏠</span>";
                    }
                    // line 10
                    echo "        <span>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 10), "html", null, true);
                    echo "</span>
      </a>
    ";
                } else {
                    // line 13
                    echo "    <span>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 13), "html", null, true);
                    echo "</span>
    ";
                }
                // line 15
                echo "    </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "  </ul>
</div>
";
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "common/breadcrumb.twig";
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
        return array (  87 => 17,  80 => 15,  74 => 13,  67 => 10,  63 => 9,  52 => 8,  50 => 7,  47 => 6,  43 => 5,  39 => 3,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/breadcrumb.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/common/breadcrumb.twig");
    }
}
