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

/* assoce/concerts.twig */
class __TwigTemplate_97aa65e4c3b6f3f0c7b1ea1e194bd73c extends Template
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
        $this->loadTemplate("common/header.twig", "assoce/concerts.twig", 1)->display($context);
        // line 2
        echo "
  <div class=\"box\">
    <header>
      <h1>Les concerts</h1>
    </header>
    <div>
      <div class=\"edito\">
      Activité historique de l'association AD'HOC, les concerts à la salle G. Pompidou d'Épinay-sur-Orge se sont tenus de 1996 à 2020 et voici le mur des flyers. Nous prévoyons pour les saisons à venir de privilégier les partenariats avec les autres structures, MJCs et salles du département.</div>
    </div>
    <div class=\"reset\">

      ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["events"] ?? null));
        foreach ($context['_seq'] as $context["season"] => $context["events_of_the_year"]) {
            // line 14
            echo "      <div class=\"saison\">
        <h3>Saison ";
            // line 15
            echo twig_escape_filter($this->env, $context["season"], "html", null, true);
            echo "</h3>
        <div class=\"gallery\" id=\"saison-";
            // line 16
            echo twig_escape_filter($this->env, $context["season"], "html", null, true);
            echo "\">
          ";
            // line 17
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["events_of_the_year"]);
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 18
                echo "          <div class=\"photo\">
            <a href=\"";
                // line 19
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 19), "html", null, true);
                echo "\" title=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 19), "html", null, true);
                echo "\">
              <img src=\"";
                // line 20
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 20), "html", null, true);
                echo "\" alt=\"Flyer ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 20), "html", null, true);
                echo "\">
            </a>
          </div>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 24
            echo "        </div>
      </div>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['season'], $context['events_of_the_year'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "      <div class=\"saison\">
        <h3>Saisons 1994 à 1997</h3>
        <div class=\"edito\">
        <p>C’est très flou, il y a eu quelques concerts à cette époque, sous le nom de l’association Casimir (ou dépendant directement du comité des fêtes d’Épinay-sur-Orge), mais nous n’avons plus de traces de flyers, au mieux une mention d’un concert \"avec des jeunes\" dans le canard local. Si vous avez des infos contactez nous pour nos archives :)</p>
        </div>
      </div>
    </div>
  </div>";
        // line 35
        echo "
";
        // line 36
        $this->loadTemplate("common/footer.twig", "assoce/concerts.twig", 36)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "assoce/concerts.twig";
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
        return array (  112 => 36,  109 => 35,  100 => 27,  92 => 24,  80 => 20,  74 => 19,  71 => 18,  67 => 17,  63 => 16,  59 => 15,  56 => 14,  52 => 13,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "assoce/concerts.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/assoce/concerts.twig");
    }
}
