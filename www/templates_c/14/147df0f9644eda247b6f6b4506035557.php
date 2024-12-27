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

/* medias/index.twig */
class __TwigTemplate_1f7f303f69b4829568feb4ccd0a622b2 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "medias/index.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
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
        $context['_seq'] = CoreExtension::ensureTraversable(($context["groupes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
            // line 17
            yield "            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "id", [], "any", false, false, false, 17), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 17), "html", null, true);
            yield "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['groupe'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        yield "          </select>
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
        $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 28
            yield "            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 28), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "date", [], "any", false, false, false, 28), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "name", [], "any", false, false, false, 28), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "lieu", [], "any", false, false, false, 28), "name", [], "any", false, false, false, 28), "html", null, true);
            yield "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        yield "          </select>
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
        $context['_seq'] = CoreExtension::ensureTraversable(($context["lieux"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lieu"]) {
            // line 39
            yield "            <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["lieu"], "id", [], "any", false, false, false, 39), "html", null, true);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["lieu"], "city", [], "any", false, false, false, 39), "cp", [], "any", false, false, false, 39), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["lieu"], "city", [], "any", false, false, false, 39), "name", [], "any", false, false, false, 39), "html", null, true);
            yield " - ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["lieu"], "name", [], "any", false, false, false, 39), "html", null, true);
            yield "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['lieu'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield "          </select>
        </div>
      </section>
    </form>
    <div class=\"mtm\" id=\"search-results\"></div>
  </div>
</div>";
        // line 48
        yield "
<div class=\"box\">
  <header>
    <h2>Dernières vidéos ajoutées</h2>
  </header>
  ";
        // line 53
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["last_videos"] ?? null)) > 0)) {
            // line 54
            yield "  <div class=\"reset grid-3-small-2 has-gutter\">
    ";
            // line 55
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["last_videos"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["video"]) {
                // line 56
                yield "    <div class=\"video\">
      <div class=\"thumb\" style=\"background-image: url(";
                // line 57
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "thumbUrl", [], "any", false, false, false, 57), "html", null, true);
                yield ")\">
        <a class=\"playbtn\" href=\"";
                // line 58
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 58), "html", null, true);
                yield "\" title=\"Regarder la vidéo ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 58), "html", null, true);
                yield "\">▶</a>
      </div>
      <p class=\"title\"><a href=\"";
                // line 60
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "url", [], "any", false, false, false, 60), "html", null, true);
                yield "\" title=\"Regarder la vidéo ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 60), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["video"], "name", [], "any", false, false, false, 60), "html", null, true);
                yield "</a></p>
      <p class=\"subtitle\">";
                // line 61
                if (CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61)) {
                    yield "<a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "url", [], "any", false, false, false, 61), "html", null, true);
                    yield "\" title=\"Aller à la page du groupe ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "name", [], "any", false, false, false, 61), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["video"], "groupe", [], "any", false, false, false, 61), "name", [], "any", false, false, false, 61), "html", null, true);
                    yield "</a>";
                }
                yield "</p>
    </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['video'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            yield "  </div>
  ";
        } else {
            // line 66
            yield "  <div>
    <p>Aucune vidéo ajoutée</p>
  </div>
  ";
        }
        // line 70
        yield "</div>

";
        // line 72
        yield from $this->loadTemplate("common/footer.twig", "medias/index.twig", 72)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "medias/index.twig";
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
        return array (  210 => 72,  206 => 70,  200 => 66,  196 => 64,  179 => 61,  171 => 60,  164 => 58,  160 => 57,  157 => 56,  153 => 55,  150 => 54,  148 => 53,  141 => 48,  133 => 41,  118 => 39,  114 => 38,  104 => 30,  89 => 28,  85 => 27,  75 => 19,  64 => 17,  60 => 16,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "medias/index.twig", "/var/www/docker.adhocmusic.com/www/views/medias/index.twig");
    }
}
