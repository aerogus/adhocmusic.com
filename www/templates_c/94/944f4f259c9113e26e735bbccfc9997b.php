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

/* membres/show.twig */
class __TwigTemplate_034302867e800b318093980c551d7f02 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "membres/show.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
";
        // line 3
        if (($context["unknown_member"] ?? null)) {
            // line 4
            yield "
<p class=\"infobulle error\">Ce membre est introuvable</p>

";
        } else {
            // line 8
            yield "
<div class=\"box\">
  <header>
    <h1>Profil de ";
            // line 11
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "pseudo", [], "any", false, false, false, 11), "html", null, true);
            yield "</h1>
  </header>
  <div class=\"grid-3\">
    <div class=\"col-1 profile\">
      ";
            // line 15
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "avatarUrl", [], "any", false, false, false, 15)) {
                // line 16
                yield "      <img src=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "avatarUrl", [], "any", false, false, false, 16), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "pseudo", [], "any", false, false, false, 16), "html", null, true);
                yield "\">
      ";
            }
            // line 18
            yield "      <strong>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "pseudo", [], "any", false, false, false, 18), "html", null, true);
            yield "</strong>
      ";
            // line 19
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "site", [], "any", false, false, false, 19)) {
                // line 20
                yield "      <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "site", [], "any", false, false, false, 20), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "site", [], "any", false, false, false, 20), "html", null, true);
                yield "</a>
      ";
            }
            // line 22
            yield "      <a class=\"btn btn--primary\" href=\"/messagerie/write?pseudo=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "pseudo", [], "any", false, false, false, 22), "html", null, true);
            yield "\">Lui écrire</a>
    </div>
    <div class=\"col-2\">
      ";
            // line 25
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["membre"] ?? null), "text", [], "any", false, false, false, 25), "html", null, true);
            yield "
    </div>
  </div>
</div>

";
            // line 30
            if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["groupes"] ?? null)) > 0)) {
                // line 31
                yield "<div class=\"box\">
  <header>
    <h2>Ses groupes</h2>
  </header>
  <div class=\"reset grid-8-small-4 has-gutter\">
    ";
                // line 36
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["groupes"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                    // line 37
                    yield "    <div class=\"grpitem\">
      <a href=\"";
                    // line 38
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 38), "html", null, true);
                    yield "\">
        <img src=\"";
                    // line 39
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "miniPhoto", [], "any", false, false, false, 39), "html", null, true);
                    yield "\" alt=\"\" />
        <p>";
                    // line 40
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 40), "html", null, true);
                    yield "</p>
      </a>
    </div>
    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['groupe'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 44
                yield "  </div>
</div>
";
            }
            // line 47
            yield "
";
        }
        // line 48
        yield " ";
        // line 49
        yield "
";
        // line 50
        yield from $this->loadTemplate("common/footer.twig", "membres/show.twig", 50)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "membres/show.twig";
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
        return array (  155 => 50,  152 => 49,  150 => 48,  146 => 47,  141 => 44,  131 => 40,  127 => 39,  123 => 38,  120 => 37,  116 => 36,  109 => 31,  107 => 30,  99 => 25,  92 => 22,  84 => 20,  82 => 19,  77 => 18,  69 => 16,  67 => 15,  60 => 11,  55 => 8,  49 => 4,  47 => 3,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "membres/show.twig", "/var/www/docker.adhocmusic.com/app/twig/membres/show.twig");
    }
}
