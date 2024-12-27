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
class __TwigTemplate_d11bfbe35be3315b365fcfd86bfb078c extends Template
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
    <h1>Les concerts</h1>
    <p>Activité historique de l'association AD'HOC, les concerts à la salle G. Pompidou d'Épinay-sur-Orge se sont tenus de 1996 à 2020 et voici le mur des flyers. Nous privilégions désormais les partenariats avec les autres structures, MJCs et salles du département.</p>

    ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
        foreach ($context['_seq'] as $context["season"] => $context["events_of_the_year"]) {
            // line 8
            yield "    <div class=\"saison\">
      <h3>Saison ";
            // line 9
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["season"], "html", null, true);
            yield "</h3>
      <div class=\"gallery\" id=\"saison-";
            // line 10
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["season"], "html", null, true);
            yield "\">
        ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["events_of_the_year"]);
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 12
                yield "        <div class=\"photo\">
          <a href=\"";
                // line 13
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 13), "html", null, true);
                yield "\" title=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 13), "html", null, true);
                yield "\">
            <img src=\"";
                // line 14
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 14), "html", null, true);
                yield "\" alt=\"Flyer ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 14), "html", null, true);
                yield "\">
          </a>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 18
            yield "      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['season'], $context['events_of_the_year'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        yield "
    <div class=\"saison\">
      <h3>Saisons 1994 à 1997</h3>
      <p>C’est très flou, il y a eu quelques concerts à cette époque, sous le nom de l’association Casimir (ou dépendant directement du comité des fêtes d’Épinay-sur-Orge), mais nous n’avons plus de traces de flyers, au mieux une mention d’un concert \"avec des jeunes\" dans le canard local. Si vous avez des infos contactez nous pour nos archives :)</p>
    </div>

  </div>

";
        // line 28
        yield from $this->loadTemplate("common/footer.twig", "assoce/concerts.twig", 28)->unwrap()->yield($context);
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
        return array (  108 => 28,  98 => 20,  91 => 18,  79 => 14,  73 => 13,  70 => 12,  66 => 11,  62 => 10,  58 => 9,  55 => 8,  51 => 7,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "assoce/concerts.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/assoce/concerts.twig");
    }
}
