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

/* index.twig */
class __TwigTemplate_903c2593a320345c13c8efb0ffa69226 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "index.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div id=\"swipe\" class=\"swipe clearfix mts mbs\">
  <ul class=\"swipe-wrap\">
    ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["featured"] ?? null));
        foreach ($context['_seq'] as $context["idx"] => $context["f"]) {
            // line 6
            yield "    <li data-index=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["idx"], "html", null, true);
            yield "\">
      <a href=\"";
            // line 7
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "url", [], "any", false, false, false, 7), "html", null, true);
            yield "\">
        <h2>";
            // line 8
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "title", [], "any", false, false, false, 8), "html", null, true);
            yield "<br><span>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "description", [], "any", false, false, false, 8), "html", null, true);
            yield "</span></h2>
        <img src=\"";
            // line 9
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "image", [], "any", false, false, false, 9), "html", null, true);
            yield "\" title=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "description", [], "any", false, false, false, 9), "html", null, true);
            yield "\" alt=\"\">
      </a>
    </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['idx'], $context['f'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        yield "  </ul>
  <div class=\"swipe-pagination-wrapper\">
    <ul class=\"swipe-pagination\">
      ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["featured"] ?? null));
        foreach ($context['_seq'] as $context["idx"] => $context["f"]) {
            // line 17
            yield "      <li data-index=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["idx"], "html", null, true);
            yield "\">
        <a href=\"";
            // line 18
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "url", [], "any", false, false, false, 18), "html", null, true);
            yield "\"></a>
      </li>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['idx'], $context['f'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        yield "    </ul>
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
        $context['_seq'] = CoreExtension::ensureTraversable(($context["videos"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
            // line 35
            yield "        <div class=\"video\">
          <div class=\"thumb\" style=\"background-image: url(";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "thumbUrl", [], "any", false, false, false, 36), "html", null, true);
            yield ")\">
            <a class=\"playbtn\" href=\"";
            // line 37
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 37), "html", null, true);
            yield "\" title=\"Regarder la vidéo ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 37), "html", null, true);
            yield "\">▶</a>
          </div>
          <p class=\"title\"><a href=\"";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "url", [], "any", false, false, false, 39), "html", null, true);
            yield "\" title=\"Aller à la page du groupe ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            yield "</a></p>
          <p class=\"subtitle\">
            <a href=\"";
            // line 41
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 41), "html", null, true);
            yield "\" title=\"Regarder la vidéo ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 41), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 41), "html", null, true);
            yield "</a>
            <br/>
            <a href=\"";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "url", [], "any", false, false, false, 43), "html", null, true);
            yield "\" title=\"Aller à la page de l'événement ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "name", [], "any", false, false, false, 43), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "event", [], "any", false, false, false, 43), "date", [], "any", false, false, false, 43), "medium", "medium", "dd LLLL yyyy"), "html", null, true);
            yield "</a>
          </p>
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['video'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        yield "      </div>
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
            yield "      <ul>
      ";
            // line 61
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
            foreach ($context['_seq'] as $context["month"] => $context["month_events"]) {
                // line 62
                yield "        <li class=\"mbs\">
          <strong>";
                // line 63
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), $this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, $context["month"], "medium", "medium", "LLLL yyyy")), "html", null, true);
                yield "</strong>
          <ul>
          ";
                // line 65
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["month_events"]);
                foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                    // line 66
                    yield "            <li><span style=\"font-weight: bold; color: #cc0000;\" title=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 66), "full"), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extra\Intl\IntlExtension']->formatDateTime($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 66), "medium", "medium", "dd"), "html", null, true);
                    yield "</span> <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "url", [], "any", false, false, false, 66), "html", null, true);
                    yield "\" title=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 66), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 66), 0, 40), "html", null, true);
                    yield "</a></li>
          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 68
                yield "          </ul>
        </li>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['month'], $context['month_events'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            yield "      </ul>
      ";
        } else {
            // line 73
            yield "      aucun événement annoncé
      ";
        }
        // line 75
        yield "    </div>
  </div>

  </div>

</div>

";
        // line 82
        yield from $this->loadTemplate("common/footer.twig", "index.twig", 82)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "index.twig";
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
        return array (  245 => 82,  236 => 75,  232 => 73,  228 => 71,  220 => 68,  203 => 66,  199 => 65,  194 => 63,  191 => 62,  187 => 61,  184 => 60,  182 => 59,  168 => 47,  154 => 43,  145 => 41,  136 => 39,  129 => 37,  125 => 36,  122 => 35,  118 => 34,  103 => 21,  94 => 18,  89 => 17,  85 => 16,  80 => 13,  68 => 9,  62 => 8,  58 => 7,  53 => 6,  49 => 5,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "index.twig", "/var/www/docker.adhocmusic.com/www/views/index.twig");
    }
}
