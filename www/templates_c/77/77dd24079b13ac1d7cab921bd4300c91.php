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

/* events/index.twig */
class __TwigTemplate_582179c38c9442c8daa030db837493b3 extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "events/index.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
";
        // line 3
        if (($context["create"] ?? null)) {
            yield "<p class=\"infobulle success\">Evénement ajouté</p>";
        }
        // line 4
        if (($context["edit"] ?? null)) {
            yield "<p class=\"infobulle success\">Evénement modifié</p>";
        }
        // line 5
        if (($context["delete"] ?? null)) {
            yield "<p class=\"infobulle success\">Evénement supprimé</p>";
        }
        // line 6
        yield "
<div class=\"grid-3-small-1 has-gutter\">

  <div class=\"box col-2-small-1\">
    <header>
      <h1>Agenda</h1>
    </header>

    ";
        // line 14
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["events"] ?? null)) == 0)) {
            // line 15
            yield "    <div>
      <p>Aucune date annoncée pour cette période. <a href=\"/events/create\">Inscrire un évènement</a></p>
    </div>
    ";
        } else {
            // line 19
            yield "    <div>

";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
            foreach ($context['_seq'] as $context["day"] => $context["events_of_the_day"]) {
                // line 22
                yield "<div id=\"day-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["day"], "html", null, true);
                yield "\" class=\"events_of_the_day\">
<h3>";
                // line 23
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, $context["day"], "medium", "medium", "dd LLLL yyyy"), "html", null, true);
                yield "</h3>
";
                // line 24
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["events_of_the_day"]);
                foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                    // line 25
                    yield "<div class=\"event grid-3-small-1\">
  <div class=\"event_header col-1\">
    <div class=\"event_date\">";
                    // line 27
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 27), "medium", "medium", "dd LLLL yyyy"), "html", null, true);
                    yield "</div>
    <div class=\"event_lieu\"><a href=\"/lieux/";
                    // line 28
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "id", [], "any", false, false, false, 28), "html", null, true);
                    yield "\" title=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    yield "\"><strong>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    yield "</strong></a><br>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "idDepartement", [], "any", false, false, false, 28), "html", null, true);
                    yield " ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "city", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
                    yield "</div>
  </div>
  <div class=\"event_content col-2\">
    <span class=\"event_title\">
      <a href=\"";
                    // line 32
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 32), "html", null, true);
                    yield "\"><strong>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 32), "html", null, true);
                    yield "</strong></a>
    </span>
    <div class=\"event_body\">
      ";
                    // line 35
                    if (CoreExtension::getAttribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 35)) {
                        // line 36
                        yield "      <a href=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 36), "html", null, true);
                        yield "\"><img src=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "thumbUrl", [], "any", false, false, false, 36), "html", null, true);
                        yield "\" style=\"float: right; margin: 0 0 5px 5px\" alt=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 36), "html", null, true);
                        yield "\"></a>
      ";
                    }
                    // line 38
                    yield "      ";
                    yield Twig\Extension\CoreExtension::nl2br($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "text", [], "any", false, false, false, 38), "html", null, true));
                    yield "
      <ul>
      ";
                    // line 40
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "groupes", [], "any", false, false, false, 40));
                    foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                        // line 41
                        yield "        <li><a href=\"";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 41), "html", null, true);
                        yield "\"><strong>";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 41), "html", null, true);
                        yield "</strong></a> (";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "style", [], "any", false, false, false, 41), "html", null, true);
                        yield ")</li>
      ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['groupe'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 43
                    yield "      </ul>
      <p class=\"event_price\">";
                    // line 44
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "price", [], "any", false, false, false, 44), "html", null, true);
                    yield "</p>
      <a style=\"margin: 10px 0; padding: 5px; border: 1px solid #999\" href=\"/events/ical/";
                    // line 45
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 45), "html", null, true);
                    yield ".ics\"><img src=\"/img/icones/cal.svg\" width=\"16\" height=\"16\">Ajout au calendrier</a>
      <br class=\"clear\" style=\"clear:both\">
    </div>
  </div>
</div>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 51
                yield "</div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['day'], $context['events_of_the_day'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 53
            yield "
  </div>
";
        }
        // line 56
        yield "</div>";
        // line 57
        yield "
<div class=\"col-1\">
{calendar year=\$year month=\$month day=\$day}
</div>

</div>";
        // line 63
        yield "
";
        // line 64
        yield from         $this->loadTemplate("common/footer.twig", "events/index.twig", 64)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "events/index.twig";
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
        return array (  205 => 64,  202 => 63,  195 => 57,  193 => 56,  188 => 53,  182 => 51,  171 => 45,  167 => 44,  164 => 43,  151 => 41,  147 => 40,  141 => 38,  131 => 36,  129 => 35,  121 => 32,  106 => 28,  102 => 27,  98 => 25,  94 => 24,  90 => 23,  85 => 22,  81 => 21,  77 => 19,  71 => 15,  69 => 14,  59 => 6,  55 => 5,  51 => 4,  47 => 3,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "events/index.twig", "/var/www/docker.adhocmusic.com/app/twig/events/index.twig");
    }
}
