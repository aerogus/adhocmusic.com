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
class __TwigTemplate_5d009615bcc186566f4bcab13f8970d8 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "groupes/index.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"container\">
    <h1>Groupes</h1>

    ";
        // line 6
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["groupes"] ?? null)) == 0)) {
            // line 7
            yield "    <p>Aucun groupe référencé.</p>
    ";
        } else {
            // line 9
            yield "      <div class=\"row row-cols-8 row-cols-md-8\">
      ";
            // line 10
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["groupes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["groupe"]) {
                // line 11
                yield "      <div class=\"col mb-4\">
        <div class=\"card text-center\">
          <img src=\"";
                // line 13
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "miniPhoto", [], "any", false, false, false, 13), "html", null, true);
                yield "\" class=\"card-img-top\" alt=\"\" />
          <div class=\"card-body\">
            <h5 class=\"card-title\" title=\"";
                // line 15
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 15), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "name", [], "any", false, false, false, 15), "html", null, true);
                yield "</h5>
            <a class=\"btn btn-secondary\" href=\"";
                // line 16
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["groupe"], "url", [], "any", false, false, false, 16), "html", null, true);
                yield "\">Voir</a>
          </div>
        </div>
      </div>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['groupe'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 21
            yield "      </div>
    ";
        }
        // line 23
        yield "
  </div>

";
        // line 26
        yield from $this->loadTemplate("common/footer.twig", "groupes/index.twig", 26)->unwrap()->yield($context);
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
        return array (  98 => 26,  93 => 23,  89 => 21,  78 => 16,  72 => 15,  67 => 13,  63 => 11,  59 => 10,  56 => 9,  52 => 7,  50 => 6,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "groupes/index.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/groupes/index.twig");
    }
}
