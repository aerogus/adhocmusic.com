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

/* events/index.twig */
class __TwigTemplate_a9cbd7033ce9b78503dc54db82fff68e extends Template
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
        $this->loadTemplate("common/header.twig", "events/index.twig", 1)->display($context);
        // line 2
        echo "
";
        // line 3
        if (($context["create"] ?? null)) {
            echo "<p class=\"infobulle success\">Evénement ajouté</p>";
        }
        // line 4
        if (($context["edit"] ?? null)) {
            echo "<p class=\"infobulle success\">Evénement modifié</p>";
        }
        // line 5
        if (($context["delete"] ?? null)) {
            echo "<p class=\"infobulle success\">Evénement supprimé</p>";
        }
        // line 6
        echo "
<div class=\"grid-3-small-1 has-gutter\">

  <div class=\"box col-2-small-1\">
    <header>
      <h1>Agenda</h1>
    </header>

    ";
        // line 14
        if ((twig_get_attribute($this->env, $this->source, ($context["events"] ?? null), "length", [], "any", false, false, false, 14) == 0)) {
            // line 15
            echo "    <div>
      <p>Aucune date annoncée pour cette période. <a href=\"/events/create\">Inscrire un évènement</a></p>
    </div>
    ";
        } else {
            // line 19
            echo "    <div>

";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["events"] ?? null));
            foreach ($context['_seq'] as $context["day"] => $context["events_of_the_day"]) {
                // line 22
                echo "<div id=\"day-";
                echo twig_escape_filter($this->env, $context["day"], "html", null, true);
                echo "\" class=\"events_of_the_day\">
<h3>";
                // line 23
                echo twig_escape_filter($this->env, $context["day"], "html", null, true);
                echo "</h3>
";
                // line 24
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["events_of_the_day"]);
                foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                    // line 25
                    echo "<div class=\"event grid-3-small-1\">
  <div class=\"event_header col-1\">
    <div class=\"event_date\">";
                    // line 27
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "date ", [], "any", false, false, false, 27), "html", null, true);
                    echo "</div>
    <div class=\"event_lieu\"><a href=\"/lieux/";
                    // line 28
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "id", [], "any", false, false, false, 28), "html", null, true);
                    echo "\" title=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    echo "\"><strong>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    echo "</strong></a><br>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "idDepartement", [], "any", false, false, false, 28), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "city", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    echo "</div>
  </div>
  <div class=\"event_content col-2\">
    <span class=\"event_title\">
      <a href=\"";
                    // line 32
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 32), "html", null, true);
                    echo "\"><strong>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 32), "html", null, true);
                    echo "</strong></a>
    </span>
    <div class=\"event_body\">
      ";
                    // line 35
                    if (twig_get_attribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 35)) {
                        // line 36
                        echo "      <a href=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 36), "html", null, true);
                        echo "\"><img src=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 36), "html", null, true);
                        echo "\" style=\"float: right; margin: 0 0 5px 5px\" alt=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 36), "html", null, true);
                        echo "\"></a>
      ";
                    }
                    // line 38
                    echo "      ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "text", [], "any", false, false, false, 38), "html", null, true);
                    echo "
      <ul>
      ";
                    // line 40
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["event"], "groupes", [], "any", false, false, false, 40));
                    foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                        // line 41
                        echo "        <li><a href=\"";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 41), "html", null, true);
                        echo "\"><strong>";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 41), "html", null, true);
                        echo "</strong></a> ({ groupe.style }})</li>
      ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['groupe'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 43
                    echo "      </ul>
      <p class=\"event_price\">";
                    // line 44
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "price", [], "any", false, false, false, 44), "html", null, true);
                    echo "</p>
      <a style=\"margin: 10px 0; padding: 5px; border: 1px solid #999\" href=\"/events/ical/";
                    // line 45
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 45), "html", null, true);
                    echo ".ics\"><img src=\"/img/icones/cal.svg\" width=\"16\" height=\"16\">Ajout au calendrier</a>
      <br class=\"clear\" style=\"clear:both\">
    </div>
  </div>
</div>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 51
                echo "</div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['day'], $context['events_of_the_day'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 53
            echo "
  </div>
";
        }
        // line 56
        echo "</div>";
        // line 57
        echo "
<div class=\"col-1\">
{calendar year=\$year month=\$month day=\$day}
</div>

</div>";
        // line 63
        echo "
";
        // line 64
        $this->loadTemplate("common/footer.twig", "events/index.twig", 64)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "events/index.twig";
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
        return array (  198 => 64,  195 => 63,  188 => 57,  186 => 56,  181 => 53,  175 => 51,  164 => 45,  160 => 44,  157 => 43,  146 => 41,  142 => 40,  136 => 38,  126 => 36,  124 => 35,  116 => 32,  101 => 28,  97 => 27,  93 => 25,  89 => 24,  85 => 23,  80 => 22,  76 => 21,  72 => 19,  66 => 15,  64 => 14,  54 => 6,  50 => 5,  46 => 4,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "events/index.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/events/index.twig");
    }
}
