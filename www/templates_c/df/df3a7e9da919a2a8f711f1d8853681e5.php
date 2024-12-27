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

/* medias/index.twig */
class __TwigTemplate_de59ce12adec68d55643606c9ad1f974 extends Template
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
        $this->loadTemplate("common/header.twig", "medias/index.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"box\">
  <header>
    <h1>Rechercher une vidéo</h1>
  </header>
  <div>
    <form id=\"form-media-search\" name=\"form-media-search\" method=\"get\" action=\"/medias\" style=\"margin-bottom:2rem\">
      <section class=\"grid-4\">
        <div>
          <label for=\"groupe\">Groupe</label>
        </div>
        <div class=\"col-3 mbs\">
          <select id=\"groupe\" name=\"groupe\" class=\"w100\">
            <option value=\"\">---</option>
            ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["groupes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
            // line 17
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "id", [], "any", false, false, false, 17), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 17), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['groupe'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "          </select>
        </div>
        <div>
          <label for=\"event\">Événement</label>
        </div>
        <div class=\"col-3 mbs\">
          <select id=\"event\" name=\"event\" class=\"w100\">
            <option value=\"\">---</option>
            ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["events"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 28
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 28), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 28), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 28), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        echo "          </select>
        </div>
        <div>
          <label for=\"lieu\">Lieu</label>
        </div>
        <div class=\"col-3\">
          <select id=\"lieu\" name=\"lieu\" class=\"w100\">
            <option value=\"\">---</option>
            ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["lieux"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lieu"]) {
            // line 39
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["lieu"], "id", [], "any", false, false, false, 39), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["lieu"], "city", [], "any", false, false, false, 39), "cp", [], "any", false, false, false, 39), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["lieu"], "city", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["lieu"], "name", [], "any", false, false, false, 39), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['lieu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "          </select>
        </div>
      </section>
    </form>
    <div class=\"mtm\" id=\"search-results\"></div>
  </div>
</div>";
        // line 48
        echo "
<div class=\"box\">
  <header>
    <h2>Dernières vidéos ajoutées</h2>
  </header>
  ";
        // line 53
        if ((twig_get_attribute($this->env, $this->source, ($context["last_videos"] ?? null), "length", [], "any", false, false, false, 53) > 0)) {
            // line 54
            echo "  <div class=\"reset grid-3-small-2 has-gutter\">
    ";
            // line 55
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["last_videos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
                // line 56
                echo "    <div class=\"video\">
      <div class=\"thumb\" style=\"background-image: url(";
                // line 57
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "thumbUrl", [], "any", false, false, false, 57), "html", null, true);
                echo ")\">
        <a class=\"playbtn\" href=\"";
                // line 58
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 58), "html", null, true);
                echo "\" title=\"Regarder la vidéo ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 58), "html", null, true);
                echo "\">▶</a>
      </div>
      <p class=\"title\"><a href=\"";
                // line 60
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 60), "html", null, true);
                echo "\" title=\"Regarder la vidéo ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 60), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 60), "html", null, true);
                echo "</a></p>
      <p class=\"subtitle\">";
                // line 61
                if (twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61)) {
                    echo "<a href=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "url", [], "any", false, false, false, 61), "html", null, true);
                    echo "\" title=\"Aller à la page du groupe ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "name", [], "any", false, false, false, 61), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "name", [], "any", false, false, false, 61), "html", null, true);
                    echo "</a>";
                }
                echo "</p>
    </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['video'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            echo "  </div>
  ";
        } else {
            // line 66
            echo "  <div>
    <p>Aucune vidéo ajoutée</p>
  </div>
  ";
        }
        // line 70
        echo "</div>

";
        // line 72
        $this->loadTemplate("common/footer.twig", "medias/index.twig", 72)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "medias/index.twig";
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
        return array (  205 => 72,  201 => 70,  195 => 66,  191 => 64,  174 => 61,  166 => 60,  159 => 58,  155 => 57,  152 => 56,  148 => 55,  145 => 54,  143 => 53,  136 => 48,  128 => 41,  113 => 39,  109 => 38,  99 => 30,  84 => 28,  80 => 27,  70 => 19,  59 => 17,  55 => 16,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "medias/index.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/medias/index.twig");
    }
}
