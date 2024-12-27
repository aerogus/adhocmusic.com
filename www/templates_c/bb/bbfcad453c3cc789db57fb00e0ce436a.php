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

/* common/breadcrumb.twig */
class __TwigTemplate_dcd8b765ba9de4090e0c5d789d854beb extends Template
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
        // line 2
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["trail"] ?? null)) > 1)) {
            // line 3
            yield "<div class=\"breadcrumb\">
  <ul>
    ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["trail"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 6
                yield "    <li>
    ";
                // line 7
                if (CoreExtension::getAttribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 7)) {
                    // line 8
                    yield "      <a ";
                    if (($context["key"] == 0)) {
                        yield " class=\"home\"";
                    }
                    yield " href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, false, 8), "html", null, true);
                    yield "\" title=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, false, 8), "html", null, true);
                    yield "\">
        ";
                    // line 9
                    if (($context["key"] == 0)) {
                        yield "<span class=\"mobile\">🏠</span>";
                    }
                    // line 10
                    yield "        <span>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 10), "html", null, true);
                    yield "</span>
      </a>
    ";
                } else {
                    // line 13
                    yield "    <span>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, false, 13), "html", null, true);
                    yield "</span>
    ";
                }
                // line 15
                yield "    </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            yield "  </ul>
</div>
";
        }
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "common/breadcrumb.twig";
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
        return array (  92 => 17,  85 => 15,  79 => 13,  72 => 10,  68 => 9,  57 => 8,  55 => 7,  52 => 6,  48 => 5,  44 => 3,  42 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/breadcrumb.twig", "/var/www/docker.adhocmusic.com/app/twig/common/breadcrumb.twig");
    }
}
