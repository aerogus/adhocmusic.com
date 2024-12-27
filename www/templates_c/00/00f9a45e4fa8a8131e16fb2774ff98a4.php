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

/* newsletters/subscriptions.twig */
class __TwigTemplate_7725127937e29291ec790badf8bbc4a1 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "newsletters/subscriptions.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Newsletter</h1>

";
        // line 6
        if (($context["form"] ?? null)) {
            // line 7
            yield "<div class=\"border rounded-bottom bg-white p-3\">
<form id=\"form-newsletter\" name=\"form-newsletter\" action=\"/newsletters/subscriptions\" method=\"post\">
  <div class=\"row mb-3\">
    <label class=\"col-2 form-label\" for=\"email\">E-mail</label>
    <div class=\"col-10\">
      <input type=\"email\" id=\"email\" name=\"email\" placeholder=\"E-mail\" class=\"form-control\" value=\"";
            // line 12
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
            yield "\" required=\"required\">
    </div>
  </div>
  <div class=\"row mb-3\">
    <div class=\"offset-2\">
    <div class=\"form-check form-check-inline\">
      <input type=\"radio\" class=\"form-check-input\" name=\"action\" value=\"sub\" ";
            // line 18
            if ((($context["action"] ?? null) == "sub")) {
                yield " checked=\"checked\"";
            }
            yield ">
      <label class=\"form-check-label\"  for=\"sub\">Inscription</label>
    </div>
    <div class=\"form-check form-check-inline\">
      <input type=\"radio\" class=\"form-check-input\" name=\"action\" value=\"unsub\" ";
            // line 22
            if ((($context["action"] ?? null) == "unsub")) {
                yield " checked=\"checked\"";
            }
            yield ">
      <label class=\"form-check-label\" for=\"unsub\">Désinscription</label>
    </div>
    </div>
  </div>
  <div class=\"row mb-3\">
    <div class=\"offset-2\">
      <input class=\"btn btn-primary\" type=\"submit\" id=\"form-newsletter-submit\" name=\"form-newsletter-submit\" value=\"Valider\">
    </div>
  </div>
</form>
</div>
";
        }
        // line 35
        yield "
";
        // line 36
        if (($context["error_email"] ?? null)) {
            // line 37
            yield "<div class=\"alert alert-danger\">Adresse email invalide</div>
";
        }
        // line 39
        yield "
";
        // line 40
        if (($context["ret"] ?? null)) {
            // line 41
            yield "  ";
            if ((($context["ret"] ?? null) == "SUB-OK")) {
                // line 42
                yield "  <div class=\"alert alert-success\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> a bien été inscrite à la liste des abonnés de la newsletter AD'HOC. Merci et bienvenue ! :)</div>
  ";
            } elseif ((            // line 43
($context["ret"] ?? null) == "SUB-KO")) {
                // line 44
                yield "  <div class=\"alert alert-danger\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> est déjà inscrite à la liste des abonnés de la newsletter AD'HOC.</div>
  ";
            } elseif ((            // line 45
($context["ret"] ?? null) == "UNSUB-OK")) {
                // line 46
                yield "  <div class=\"alert alert-success\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> a bien été désinscrite de la liste des abonnés de la newsletter AD'HOC. Au revoir :(</div>
  ";
            } elseif ((            // line 47
($context["ret"] ?? null) == "UNSUB-KO")) {
                // line 48
                yield "  <div class=\"alert alert-danger\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> n'est pas inscrite à la newsletter AD'HOC.</div>
  ";
            }
        }
        // line 51
        yield "
</div>

";
        // line 54
        yield from $this->loadTemplate("common/footer.twig", "newsletters/subscriptions.twig", 54)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "newsletters/subscriptions.twig";
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
        return array (  145 => 54,  140 => 51,  133 => 48,  131 => 47,  126 => 46,  124 => 45,  119 => 44,  117 => 43,  112 => 42,  109 => 41,  107 => 40,  104 => 39,  100 => 37,  98 => 36,  95 => 35,  77 => 22,  68 => 18,  59 => 12,  52 => 7,  50 => 6,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "newsletters/subscriptions.twig", "/var/www/docker.adhocmusic.com/www/views_bs/newsletters/subscriptions.twig");
    }
}
