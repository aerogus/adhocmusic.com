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

/* newsletters/index.twig */
class __TwigTemplate_8ae8c364d2810fdc1f2ae7aa8c766dc0 extends Template
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
        $this->loadTemplate("common/header.twig", "newsletters/index.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"box\">
  <header>
    <h1>Newsletters</h1>
  </header>
  <div class=\"reset\">
    <table class=\"table table--zebra\">
      <thead>
        <tr>
          <th>Sujet</th>
        </tr>
      </thead>
      <tbody>
      ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["newsletters"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["newsletter"]) {
            // line 16
            echo "        <tr>
          <td><a href=\"/newsletters/";
            // line 17
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["newsletter"], "id", [], "any", false, false, false, 17), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["newsletter"], "title", [], "any", false, false, false, 17), "html", null, true);
            echo "</a></td>
        </tr>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['newsletter'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "      </tbody>
    </table>
  </div>
</div>

";
        // line 25
        $this->loadTemplate("common/footer.twig", "newsletters/index.twig", 25)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "newsletters/index.twig";
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
        return array (  79 => 25,  72 => 20,  61 => 17,  58 => 16,  54 => 15,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "newsletters/index.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/newsletters/index.twig");
    }
}
