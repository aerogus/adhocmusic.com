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

/* assoce/concerts.twig */
class __TwigTemplate_6fa23770c865e2c3f2b239445a43543c extends Template
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
        yield from $this->loadTemplate("common/header.twig", "assoce/concerts.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"container\">
    
    <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Les concerts</h1>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
      <p>Activité historique de l'association AD'HOC, les concerts à la salle G. Pompidou d'Épinay-sur-Orge se sont tenus de 1996 à 2020 et voici le mur des flyers. Nous privilégions désormais les partenariats avec les autres structures, MJCs et salles du département.</p>
    </div>

    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
        foreach ($context['_seq'] as $context["season"] => $context["events_of_the_year"]) {
            // line 11
            yield "    <h3 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Saison ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["season"], "html", null, true);
            yield "</h3>
    <div class=\"border rounded-bottom bg-white p-3 row\">
      ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["events_of_the_year"]);
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 14
                yield "        <div class=\"col-4 mb-3\">
          <a href=\"";
                // line 15
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 15), "html", null, true);
                yield "\" title=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 15), "html", null, true);
                yield "\">
            <img style=\"max-width:100%\" src=\"";
                // line 16
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 16), "html", null, true);
                yield "\" alt=\"Flyer ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 16), "html", null, true);
                yield "\">
          </a>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 20
            yield "    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['season'], $context['events_of_the_year'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        yield "
    <h3 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Saisons 1994 à 1997</h3>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
      <p>C’est très flou, il y a eu quelques concerts à cette époque, sous le nom de l’association Casimir (ou dépendant directement du comité des fêtes d’Épinay-sur-Orge), mais nous n’avons plus de traces de flyers, au mieux une mention d’un concert \"avec des jeunes\" dans le canard local. Si vous avez des infos contactez nous pour nos archives :)</p>
    </div>

  </div>

";
        // line 30
        yield from $this->loadTemplate("common/footer.twig", "assoce/concerts.twig", 30)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "assoce/concerts.twig";
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
        return array (  106 => 30,  96 => 22,  89 => 20,  77 => 16,  71 => 15,  68 => 14,  64 => 13,  58 => 11,  54 => 10,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "assoce/concerts.twig", "/var/www/docker.adhocmusic.com/www/views_bs/assoce/concerts.twig");
    }
}
