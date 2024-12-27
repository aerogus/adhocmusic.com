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

/* partners.twig */
class __TwigTemplate_6de5a436abcf24423c0d5a65dec12af9 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "partners.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h1>Partenaires</h1>
    ";
        // line 5
        if (($context["partners"] ?? null)) {
            // line 6
            yield "    <ul class=\"partners\">
    ";
            // line 7
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["partners"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["partner"]) {
                // line 8
                yield "      <li>
        <a href=\"";
                // line 9
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["partner"], "url", [], "any", false, false, false, 9), "html", null, true);
                yield "\">
          <img src=\"";
                // line 10
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["partner"], "iconUrl", [], "any", false, false, false, 10), "html", null, true);
                yield "\" alt=\"\">
          <strong>";
                // line 11
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["partner"], "title", [], "any", false, false, false, 11), "html", null, true);
                yield "</strong><br>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["partner"], "description", [], "any", false, false, false, 11), "html", null, true);
                yield "
        </a>
      </li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['partner'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            yield "    </ul>
    ";
        } else {
            // line 17
            yield "    Pas de partenaires référencés
    ";
        }
        // line 19
        yield "</div>

";
        // line 21
        yield from $this->loadTemplate("common/footer.twig", "partners.twig", 21)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partners.twig";
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
        return array (  93 => 21,  89 => 19,  85 => 17,  81 => 15,  69 => 11,  65 => 10,  61 => 9,  58 => 8,  54 => 7,  51 => 6,  49 => 5,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "partners.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/partners.twig");
    }
}
