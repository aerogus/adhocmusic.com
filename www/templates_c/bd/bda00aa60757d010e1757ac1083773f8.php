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
class __TwigTemplate_29e45f9dd607b34fff1f72989edceadc extends Template
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
<div class=\"box\" style=\"width: 320px; margin: 0 auto 20px\">
  <header>
    <h2>Newsletter</h2>
  </header>
  <div>
";
        // line 8
        if (($context["form"] ?? null)) {
            // line 9
            yield "<form id=\"form-newsletter\" name=\"form-newsletter\" action=\"/newsletters/subscriptions\" method=\"post\">
  <div class=\"mbs\">
    <label for=\"email\">E-mail</label>
    <input type=\"email\" id=\"email\" name=\"email\" placeholder=\"E-mail\" class=\"w100\" value=\"";
            // line 12
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
            yield "\" required=\"required\">
  </div>
  <div class=\"mbs\">
    <input type=\"radio\" class=\"radio\" name=\"action\" value=\"sub\" ";
            // line 15
            if ((($context["action"] ?? null) == "sub")) {
                yield " checked=\"checked\"";
            }
            yield ">
    <label for=\"sub\">Inscription</label>
  </div>
  <div class=\"mbs\">
    <input type=\"radio\" class=\"radio\" name=\"action\" value=\"unsub\" ";
            // line 19
            if ((($context["action"] ?? null) == "unsub")) {
                yield " checked=\"checked\"";
            }
            yield ">
    <label for=\"unsub\">Désinscription</label>
  </div>
  <div>
    <input class=\"btn btn--primary w100\" type=\"submit\" id=\"form-newsletter-submit\" name=\"form-newsletter-submit\" value=\"Valider\">
  </div>
</form>
";
        }
        // line 27
        yield "
";
        // line 28
        if (($context["error_email"] ?? null)) {
            // line 29
            yield "<div class=\"infobulle error\">Adresse email invalide</div>
";
        }
        // line 31
        yield "
";
        // line 32
        if (($context["ret"] ?? null)) {
            // line 33
            yield "  ";
            if ((($context["ret"] ?? null) == "SUB-OK")) {
                // line 34
                yield "  <div class=\"infobulle success\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> a bien été inscrite à la liste des abonnés de la newsletter AD'HOC. Merci et bienvenue ! :)</div>
  ";
            } elseif ((            // line 35
($context["ret"] ?? null) == "SUB-KO")) {
                // line 36
                yield "  <div class=\"infobulle error\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> est déjà inscrite à la liste des abonnés de la newsletter AD'HOC.</div>
  ";
            } elseif ((            // line 37
($context["ret"] ?? null) == "UNSUB-OK")) {
                // line 38
                yield "  <div class=\"infobulle success\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> a bien été désinscrite de la liste des abonnés de la newsletter AD'HOC. Au revoir :(</div>
  ";
            } elseif ((            // line 39
($context["ret"] ?? null) == "UNSUB-KO")) {
                // line 40
                yield "  <div class=\"infobulle error\">L'email <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
                yield "</strong> n'est pas inscrite à la newsletter AD'HOC.</div>
  ";
            }
        }
        // line 43
        yield "
  </div>
</div>

";
        // line 47
        yield from $this->loadTemplate("common/footer.twig", "newsletters/subscriptions.twig", 47)->unwrap()->yield($context);
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
        return array (  138 => 47,  132 => 43,  125 => 40,  123 => 39,  118 => 38,  116 => 37,  111 => 36,  109 => 35,  104 => 34,  101 => 33,  99 => 32,  96 => 31,  92 => 29,  90 => 28,  87 => 27,  74 => 19,  65 => 15,  59 => 12,  54 => 9,  52 => 8,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "newsletters/subscriptions.twig", "/var/www/docker.adhocmusic.com/app/twig/newsletters/subscriptions.twig");
    }
}
