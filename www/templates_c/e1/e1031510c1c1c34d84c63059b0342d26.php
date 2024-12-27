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
class __TwigTemplate_d19f060900e3d2458ed75bb12f47d0fd extends Template
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
        yield from $this->loadTemplate("common/footer-menu.twig", "common/footer.twig", 4)->unwrap()->yield($context);
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
            yield json_encode(($context["script_vars"] ?? null));
            yield "
</script>
";
        }
        // line 13
        yield "
";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["footer_scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script_url"]) {
            // line 15
            yield "<script src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["script_url"], "html", null, true);
            yield "\"></script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['script_url'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        yield "
";
        // line 18
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["inline_scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["inline_script"]) {
            // line 19
            yield "<script>
";
            // line 20
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["inline_script"], "html", null, true);
            yield "
</script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['inline_script'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
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
        return array (  101 => 23,  92 => 20,  89 => 19,  85 => 18,  82 => 17,  73 => 15,  69 => 14,  66 => 13,  60 => 10,  57 => 9,  55 => 8,  50 => 5,  48 => 4,  45 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/footer.twig", "/var/www/docker.adhocmusic.com/www/views_bs/common/footer.twig");
    }
}
