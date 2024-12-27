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

/* index.twig */
class __TwigTemplate_258063e0eb536d23a1996e6f101ab03c extends Template
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
        $this->loadTemplate("common/header.twig", "index.twig", 1)->display($context);
        // line 2
        echo "
<div id=\"swipe\" class=\"swipe clearfix mts mbs\">
  <ul class=\"swipe-wrap\">
    ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["featured"] ?? null));
        foreach ($context['_seq'] as $context["idx"] => $context["f"]) {
            // line 6
            echo "    <li data-index=\"";
            echo twig_escape_filter($this->env, $context["idx"], "html", null, true);
            echo "\">
      <a href=\"";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "url", [], "any", false, false, false, 7), "html", null, true);
            echo "\">
        <h2>";
            // line 8
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "title", [], "any", false, false, false, 8), "html", null, true);
            echo "<br><span>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "description", [], "any", false, false, false, 8), "html", null, true);
            echo "</span></h2>
        <img src=\"";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "image", [], "any", false, false, false, 9), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "description", [], "any", false, false, false, 9), "html", null, true);
            echo "\" alt=\"\">
      </a>
    </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['idx'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "  </ul>
  <div class=\"swipe-pagination-wrapper\">
    <ul class=\"swipe-pagination\">
      ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["featured"] ?? null));
        foreach ($context['_seq'] as $context["idx"] => $context["f"]) {
            // line 17
            echo "      <li data-index=\"";
            echo twig_escape_filter($this->env, $context["idx"], "html", null, true);
            echo "\">
        <a href=\"";
            // line 18
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "url", [], "any", false, false, false, 18), "html", null, true);
            echo "\"></a>
      </li>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['idx'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </ul>
  </div>
</div>

<div class=\"grid-3-small-1 has-gutter\">

  <div class=\"col-2\">

    <div class=\"box\">
      <header>
        <h2>Ils sont passés par AD'HOC</h2>
      </header>
      <div class=\"reset grid-3-small-2 has-gutter\">
        ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["videos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
            // line 35
            echo "        <div class=\"video\">
          <div class=\"thumb\" style=\"background-image: url(";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "thumbUrl", [], "any", false, false, false, 36), "html", null, true);
            echo ")\">
            <a class=\"playbtn\" href=\"";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 37), "html", null, true);
            echo "\" title=\"Regarder la vidéo ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 37), "html", null, true);
            echo "\">▶</a>
          </div>
          <p class=\"title\"><a href=\"";
            // line 39
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "url", [], "any", false, false, false, 39), "html", null, true);
            echo "\" title=\"Aller à la page du groupe ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            echo "</a></p>
          <p class=\"subtitle\">
            <a href=\"";
            // line 41
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 41), "html", null, true);
            echo "\" title=\"Regarder la vidéo ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 41), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 41), "html", null, true);
            echo "</a>
            <br/>
            <a href=\"";
            // line 43
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "url", [], "any", false, false, false, 43), "html", null, true);
            echo "\" title=\"Aller à la page de l'événement ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "name", [], "any", false, false, false, 43), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "date", [], "any", false, false, false, 43), "html", null, true);
            echo "</a>
          </p>
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['video'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "      </div>
    </div>

  </div>

  <div class=\"col-1\">

  <div class=\"box\">
    <header>
      <h2><a href=\"/events\" title=\"Agenda\">Agenda</a></h2>
    </header>
    <div>
      ";
        // line 59
        if (($context["events"] ?? null)) {
            // line 60
            echo "      <ul>
      ";
            // line 61
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["events"] ?? null));
            foreach ($context['_seq'] as $context["month"] => $context["month_events"]) {
                // line 62
                echo "        <li class=\"mbs\">
          <strong>";
                // line 63
                echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, $this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, $context["month"], "medium", "medium", "LLLL yyyy")), "html", null, true);
                echo "</strong>
          <ul>
          ";
                // line 65
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["month_events"]);
                foreach ($context['_seq'] as $context["month"] => $context["event"]) {
                    // line 66
                    echo "            <li><span style=\"font-weight: bold; color: #cc0000;\" title=\"";
                    echo twig_escape_filter($this->env, $this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 66), "full"), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 66), "medium", "medium", "dd"), "html", null, true);
                    echo "</span> <a href=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 66), "html", null, true);
                    echo "\" title=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 66), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_slice($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 66), 0, 40), "html", null, true);
                    echo "</a></li>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['month'], $context['event'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 68
                echo "          </ul>
        </li>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['month'], $context['month_events'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            echo "      </ul>
      ";
        } else {
            // line 73
            echo "      aucun événement annoncé
      ";
        }
        // line 75
        echo "    </div>
  </div>

  </div>

</div>

";
        // line 82
        $this->loadTemplate("common/footer.twig", "index.twig", 82)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "index.twig";
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
        return array (  240 => 82,  231 => 75,  227 => 73,  223 => 71,  215 => 68,  198 => 66,  194 => 65,  189 => 63,  186 => 62,  182 => 61,  179 => 60,  177 => 59,  163 => 47,  149 => 43,  140 => 41,  131 => 39,  124 => 37,  120 => 36,  117 => 35,  113 => 34,  98 => 21,  89 => 18,  84 => 17,  80 => 16,  75 => 13,  63 => 9,  57 => 8,  53 => 7,  48 => 6,  44 => 5,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "index.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/index.twig");
    }
}
