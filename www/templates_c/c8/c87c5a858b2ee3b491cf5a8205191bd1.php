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

/* groupes/index.twig */
class __TwigTemplate_781b3e7ba0401a1edbf10355740e3d83 extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "groupes/index.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"box\">
    <header>
      <h1>Groupes</h1>
    </header>

    ";
        // line 8
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["groupes"] ?? null)) == 0)) {
            // line 9
            yield "    <div>
      <p>Aucun groupe référencé.</p>
    </div>
    ";
        } else {
            // line 13
            yield "    <div class=\"reset grid-7-small-4 has-gutter\">
      ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["groupes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                // line 15
                yield "      <div class=\"grpitem\">
        <a href=\"";
                // line 16
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 16), "html", null, true);
                yield "\">
          <img src=\"";
                // line 17
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "miniPhoto", [], "any", false, false, false, 17), "html", null, true);
                yield "\" alt=\"\" />
          <p>";
                // line 18
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 18), "html", null, true);
                yield "</p>
        </a>
      </div>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['groupe'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 22
            yield "    </div>
    ";
        }
        // line 24
        yield "  </div>

";
        // line 26
        yield from         $this->loadTemplate("common/footer.twig", "groupes/index.twig", 26)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "groupes/index.twig";
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
        return array (  96 => 26,  92 => 24,  88 => 22,  78 => 18,  74 => 17,  70 => 16,  67 => 15,  63 => 14,  60 => 13,  54 => 9,  52 => 8,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "groupes/index.twig", "/var/www/docker.adhocmusic.com/app/twig/groupes/index.twig");
    }
}
