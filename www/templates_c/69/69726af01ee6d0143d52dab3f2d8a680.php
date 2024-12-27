<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* common/footer.twig */
class __TwigTemplate_24b480b0340f0220fcba87c2af9348fb extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "
</div>";
        // line 3
        echo "
";
        // line 4
        $this->loadTemplate("common/footer-menu.twig", "common/footer.twig", 4)->display($context);
        // line 5
        echo "
<button type=\"button\" id=\"up\" name=\"retour en haut de la page\">↑</button>

";
        // line 8
        if (($context["script_vars"] ?? null)) {
            // line 9
            echo "<script>
var asv = ";
            // line 10
            echo twig_escape_filter($this->env, ($context["script_vars"] ?? null), "html", null, true);
            echo "
</script>
";
        }
        // line 13
        echo "
";
        // line 14
        if (($context["footer_scripts"] ?? null)) {
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["footer_scripts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["script_url"]) {
                // line 16
                echo "<script src=\"";
                echo twig_escape_filter($this->env, $context["script_url"], "html", null, true);
                echo "\"></script>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script_url'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 19
        echo "
";
        // line 20
        if (($context["inline_scripts"] ?? null)) {
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["inline_scripts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["inline_script"]) {
                // line 22
                echo "<script>
";
                // line 23
                echo twig_escape_filter($this->env, $context["inline_script"], "html", null, true);
                echo "
</script>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['inline_script'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 27
        echo "
</body>
</html>
";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "common/footer.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  102 => 27,  92 => 23,  89 => 22,  85 => 21,  83 => 20,  80 => 19,  70 => 16,  66 => 15,  64 => 14,  61 => 13,  55 => 10,  52 => 9,  50 => 8,  45 => 5,  43 => 4,  40 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/footer.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/common/footer.twig");
    }
}
