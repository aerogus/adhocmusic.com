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

/* common/footer.twig */
class __TwigTemplate_c74e257326b6162588688ca0df430bc8 extends Template
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
        yield "
</div>";
        // line 3
        yield "
";
        // line 4
        yield from         $this->loadTemplate("common/footer-menu.twig", "common/footer.twig", 4)->unwrap()->yield($context);
        // line 5
        yield "
<button type=\"button\" id=\"up\" name=\"retour en haut de la page\">↑</button>

";
        // line 8
        if (($context["script_vars"] ?? null)) {
            // line 9
            yield "<script>
var asv = ";
            // line 10
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["script_vars"] ?? null), "html", null, true);
            yield "
</script>
";
        }
        // line 13
        yield "
";
        // line 14
        if (($context["footer_scripts"] ?? null)) {
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["footer_scripts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["script_url"]) {
                // line 16
                yield "<script src=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["script_url"], "html", null, true);
                yield "\"></script>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['script_url'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 19
        yield "
";
        // line 20
        if (($context["inline_scripts"] ?? null)) {
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["inline_scripts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["inline_script"]) {
                // line 22
                yield "<script>
";
                // line 23
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["inline_script"], "html", null, true);
                yield "
</script>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['inline_script'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 27
        yield "
</body>
</html>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "common/footer.twig";
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
        return array (  107 => 27,  97 => 23,  94 => 22,  90 => 21,  88 => 20,  85 => 19,  75 => 16,  71 => 15,  69 => 14,  66 => 13,  60 => 10,  57 => 9,  55 => 8,  50 => 5,  48 => 4,  45 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/footer.twig", "/var/www/docker.adhocmusic.com/app/twig/common/footer.twig");
    }
}
