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

/* assoce/equipe.twig */
class __TwigTemplate_5a87b1f51634ee21c239478a13d288f4 extends Template
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
        $this->loadTemplate("common/header.twig", "assoce/equipe.twig", 1)->display($context);
        // line 2
        echo "
    <div class=\"box\">
      <header>
        <h1>L’équipe</h1>
      </header>
      <div>
        <p>Voici les forces actives de l’association pour la saison 2019/2020</p>
        <ul class=\"staff\">
          ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["membres"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["membre"]) {
            // line 11
            echo "          <li>
            <img src=\"";
            // line 12
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["membre"], "avatar_interne", [], "any", false, false, false, 12), "html", null, true);
            echo "\" alt=\"\">
            <strong>";
            // line 13
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["membre"], "firstName", [], "any", false, false, false, 13), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["membre"], "lastName", [], "any", false, false, false, 13), "html", null, true);
            echo "</strong><br>
            <em>";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["membre"], "function", [], "any", false, false, false, 14), "html", null, true);
            echo "</em>
          </li>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['membre'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "        </ul>
      </div>
    </div>

    <div class=\"box\">
      <header>
        <h1>Les anciens</h1>
      </header>
      <div>
        <p>De 1996 à aujourd’hui, nombre de bénévoles ont participé à l’aventure AD’HOC de près ou de loin. Qu’ils en soient remerciés:</p>
        <p>
          <strong>Pablo Ruamps Simon</strong> (2007 à 2010),
          <strong>Myriam Fiévé</strong> (2008 à 2010),
          <strong>Mika Apamian</strong> (2008 à 2010),
          <strong>Franck Chassot</strong> (2006 à 2010),
          <strong>Marie-Cécile Preux</strong> (2007 à 2010),
          <strong>Grégory Chassot</strong> (1996 à 2009),
          <strong>Guillaume Drivierre</strong> (1996 à 2009),
          <strong>Sylvain Pendino</strong> (2000 à 2009),
          <strong>Aïssa Guigon</strong> (2004 à 2008),
          <strong>Mathias Gorenflot</strong> (2002 à 2007),
          <strong>Julien Perronnet</strong> (1996 à 2006),
          <strong>Julie Busnel</strong> (2005 à 2006),
          <strong>Christophe Boutin</strong> (1996 à 2002),
          <strong>Patrice Popineau</strong> (1996 à 2019),
          <strong>Vincent Pendino</strong> (2019 à 2019),
          <strong>Milena Leclere</strong> (2011 à 2015),
          <strong>Frederic Decaen</strong> (2006 à 2014),
          <strong>Noémie Luxain</strong> (2016 à 2019),
          <strong>Eugénie Cottel</strong> (2007 à 2009),
          <strong>Cédric Pereira</strong> (1996 à 2014),
          <strong>Léa Vroome</strong> (2016 à 2019),
          <strong>Candice Vergès</strong> (2013 à 2014),
          <strong>Michel Dechenaud</strong> (1996 à 2012),
          <strong>William Bonin</strong> (2013 à 2019),
          <strong>Oriane Rondou</strong> (2014 à 2016),
          <strong>Julie Madeira</strong> (2004 à 2014),
          <strong>Aurélie Turmine</strong> (2008 à 2014),
          <strong>Eric Redon</strong> (2002 à 2012),
          <strong>Guilhem Dubernet</strong> (2010 à 2013),
          <strong>Juliette Bigey</strong> (2008 à 2016),
          <strong>Pierre Gerard</strong> (2002 à 2012),
          <strong>Juan Ramon Alvarez</strong> (1996 à 2006),
          <strong>Quentin Goffic</strong> (2009 à 2012),
          <strong>Hugues Delacroix</strong> (1996 à 2000),
          <strong>Guillaume Dessay</strong> (1996 à 2010),
          <strong>Louis Cabrera</strong> (2010 à 2013),
          <strong>Alexandre Bellepeau</strong> (2010 à 2012),
          <strong>Christina Ribeiro</strong> (2011 à 2012),
          <strong>Emilie Lacombe</strong> (2000 à 2012),
          et <strong>Francisque Vigouroux</strong> (1996 à 2002).
        </p>
      </div>
    </div>

  </div>

";
        // line 74
        $this->loadTemplate("common/footer.twig", "assoce/equipe.twig", 74)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "assoce/equipe.twig";
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
        return array (  134 => 74,  75 => 17,  66 => 14,  60 => 13,  56 => 12,  53 => 11,  49 => 10,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "assoce/equipe.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/assoce/equipe.twig");
    }
}
