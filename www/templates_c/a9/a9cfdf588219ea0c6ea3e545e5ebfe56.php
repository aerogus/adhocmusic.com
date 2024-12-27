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

/* membres/create.twig */
class __TwigTemplate_03a124a780a9f710e02164c91d2885c5 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "membres/create.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h3 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Créer un compte</h3>
  <div class=\"border rounded-bottom bg-white p-3\">

";
        // line 7
        if (($context["create"] ?? null)) {
            // line 8
            yield "
<div class=\"alert alert-info\">Bienvenue ! Votre compte AD’HOC a bien été créé. Consultez votre boite aux lettres électronique, elle vous confirme votre inscription et un mot de passe vous a été communiqué.<br>
Cliquez alors sur le cadenas en haut à droite pour vous identifier.</div>

";
        } elseif (        // line 12
($context["error_generic"] ?? null)) {
            // line 13
            yield "
<div class=\"alert alert-danger\">Erreur à l’inscription. Votre email est déjà présente, vous avez
déjà un compte. Si vous ne vous souvenez plus de votre mot de passe, <a href=\"/auth/lost-password\">cliquez ici</a> pour le récupérer.</div>

";
        } else {
            // line 18
            yield "
<form id=\"form-member-create\" name=\"form-member-create\" method=\"post\" action=\"/membres/create\">
  <div class=\"mb-3\">
    <label for=\"pseudo\" class=\"form-label\">Pseudo</label>
    <div id=\"error_pseudo_unavailable\" class=\"alert alert-danger\"";
            // line 22
            if ( !($context["error_pseudo_unavailable"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Ce pseudo est pris, veuillez en choisir un autre</div>
    <div class=\"alert alert-danger\" id=\"error_pseudo\"";
            // line 23
            if ( !($context["error_pseudo"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez saisir un pseudo entre 1 à 50 caractères</div>
    <input id=\"pseudo\" class=\"form-control\" name=\"pseudo\" type=\"text\" maxlength=\"50\" value=\"";
            // line 24
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 24), "html", null, true);
            yield "\" placeholder=\"Pseudo\" required>
  </div>
  <div class=\"mb-3\">
    <label for=\"email\" class=\"form-label\">E-mail</label>
    <div id=\"error_email\"";
            // line 28
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield " class=\"alert alert-danger\">Vous devez saisir votre e-mail</div>
    <div id=\"error_invalid_email\" class=\"alert alert-danger\"";
            // line 29
            if ( !($context["error_invalid_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Cet e-mail semble invalide</div>
    <div id=\"error_already_member\" class=\"alert alert-danger\"";
            // line 30
            if ( !($context["error_already_member"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href=\"/auth/lost-password\">oublié votre mot de passe ?</a></div>
    <input id=\"email\" class=\"form-control\" name=\"email\" type=\"email\" maxlength=\"50\" value=\"";
            // line 31
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 31), "html", null, true);
            yield "\" placeholder=\"E-mail\" required>
  </div>
  <div class=\"mb-3 form-check\">
    <input id=\"mailing\" class=\"form-check-input\" name=\"mailing\" type=\"checkbox\"";
            // line 34
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "mailing", [], "any", false, false, false, 34)) {
                yield " checked=\"checked\"";
            }
            yield ">
    <label for=\"mailing\" class=\"form-check-label\">Je souhaite recevoir la newsletter</label>
  </div>
  <div>
    <input type=\"hidden\" name=\"csrf\" value=\"";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 38), "html", null, true);
            yield "\">
    <input type=\"hidden\" name=\"text\" value=\"";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 39), "html", null, true);
            yield "\">
    <input id=\"form-membrer-create-submit\" name=\"form-member-create-submit\" class=\"btn btn-primary\" type=\"submit\" value=\"Je crée mon compte\">
  </div>
</form>

";
        }
        // line 45
        yield "
</div>
</div>";
        // line 48
        yield "
";
        // line 49
        yield from $this->loadTemplate("common/footer.twig", "membres/create.twig", 49)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "membres/create.twig";
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
        return array (  146 => 49,  143 => 48,  139 => 45,  130 => 39,  126 => 38,  117 => 34,  111 => 31,  105 => 30,  99 => 29,  93 => 28,  86 => 24,  80 => 23,  74 => 22,  68 => 18,  61 => 13,  59 => 12,  53 => 8,  51 => 7,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "membres/create.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/membres/create.twig");
    }
}
