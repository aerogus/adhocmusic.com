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

/* assoce/equipe.twig */
class __TwigTemplate_23bad6e313f9dc6b339d762a85ad3671 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "assoce/equipe.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"container\">
    <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">L’équipe</h1>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
      <p>Voici les forces actives de l’association pour la saison 2019/2020</p>
      <ul class=\"staff\">
        ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["membres"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["membre"]) {
            // line 9
            yield "        <li>
          <img src=\"";
            // line 10
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["membre"], "avatar_interne", [], "any", false, false, false, 10), "html", null, true);
            yield "\" alt=\"\">
          <strong>";
            // line 11
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["membre"], "firstName", [], "any", false, false, false, 11), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["membre"], "lastName", [], "any", false, false, false, 11), "html", null, true);
            yield "</strong><br>
          <em>";
            // line 12
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["membre"], "function", [], "any", false, false, false, 12), "html", null, true);
            yield "</em>
        </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['membre'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        yield "      </ul>
    </div>
  </div>

  <div class=\"container\">
    <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Les anciens</h1>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
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

";
        // line 68
        yield from $this->loadTemplate("common/footer.twig", "assoce/equipe.twig", 68)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "assoce/equipe.twig";
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
        return array (  133 => 68,  78 => 15,  69 => 12,  63 => 11,  59 => 10,  56 => 9,  52 => 8,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "assoce/equipe.twig", "/var/www/docker.adhocmusic.com/www/views_bs/assoce/equipe.twig");
    }
}
