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

/* auth/auth.twig */
class __TwigTemplate_1c0b9dd1e52f77e71aa9382af1f00b96 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "auth/auth.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
<div class=\"row\">

<div class=\"col-md-6\">
  <h3 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Se connecter</h3>
  <div class=\"border rounded-bottom bg-white p-3\">
    <form id=\"form-login\" name=\"form-login\" method=\"post\" action=\"/auth/login\">
      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"login-pseudo\">Pseudo</label>
        <div class=\"alert alert-danger\" id=\"error_login-pseudo\"";
        // line 12
        if ( !($context["error_login_pseudo"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Pseudo vide !</div>
        <input type=\"text\" id=\"login-pseudo\" name=\"pseudo\" required=\"required\" placeholder=\"Pseudo\" class=\"form-control\">
      </div>
      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"login-password\">Mot de passe</label>
        <div class=\"alert alert-danger\" id=\"error_login-password\"";
        // line 17
        if ( !($context["error_login_password"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Mot de passe vide !</div>
        <input type=\"password\" id=\"login-password\" name=\"password\" required=\"required\" placeholder=\"Mot de passe\" class=\"form-control\">
      </div>
      <div class=\"mb-3\">
        <input id=\"form-login-submit\" name=\"form-login-submit\" type=\"submit\" value=\"Je me connecte\" class=\"btn btn-primary\">
        ";
        // line 22
        if (($context["referer"] ?? null)) {
            yield "<input type=\"hidden\" id=\"login-referer\" name=\"referer\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(($context["referer"] ?? null)), "html", null, true);
            yield "\">";
        }
        // line 23
        yield "      </div>
      <a href=\"/auth/lost-password\">mot de passe oublié</a>
    </form>
  </div>
</div>

<div class=\"col-md-6\">
  <h3 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Créer un compte</h3>
  <div class=\"border rounded-bottom bg-white p-3\">
    <form id=\"form-member-create\" name=\"form-member-create\" method=\"post\" action=\"/membres/create\">
      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"pseudo\">Pseudo</label>
        <div id=\"error_pseudo_unavailable\" class=\"alert alert-danger\"";
        // line 35
        if ( !($context["error_pseudo_unavailable"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Ce pseudo est pris, veuillez en choisir un autre</div>
        <div class=\"alert alert-danger\" id=\"error_pseudo\"";
        // line 36
        if ( !($context["error_pseudo"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Vous devez saisir un pseudo entre 2 à 16 caractères</div>
        <input id=\"pseudo\" name=\"pseudo\" type=\"text\" value=\"";
        // line 37
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 37)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 37), "html", null, true);
        }
        yield "\" required=\"required\" placeholder=\"Pseudo\" class=\"form-control\">
      </div>
      <div class=\"mb-3\">
        <label class=\"form-label\" for=\"email\">E-mail</label>
        <div id=\"error_email\"";
        // line 41
        if ( !($context["error_email"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield " class=\"alert alert-danger\">Vous devez saisir votre e-mail</div>
        <div id=\"error_invalid_email\" class=\"alert alert-danger\"";
        // line 42
        if ( !($context["error_invalid_email"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Cet e-mail semble invalide</div>
        <div id=\"error_already_member\" class=\"alert alert-danger\"";
        // line 43
        if ( !($context["error_already_member"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href=\"/auth/lost-password\">oublié votre mot de passe ?</a></div>
        <input id=\"email\" name=\"email\" type=\"email\" value=\"";
        // line 44
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 44)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 44), "html", null, true);
        }
        yield "\" required=\"required\" placeholder=\"E-mail\" class=\"form-control\">
      </div>
      <div class=\"mb-3\">
        <label for=\"mailing\" class=\"visually-hidden\">Newsletter</label>
        <input id=\"mailing\" class=\"checkbox\" name=\"mailing\" type=\"checkbox\"";
        // line 48
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "mailing", [], "any", false, false, false, 48)) {
            yield " checked=\"checked\"";
        }
        yield "> Je souhaite recevoir la newsletter
      </div>
      <div>
        <input type=\"hidden\" name=\"csrf\" value=\"";
        // line 51
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 51)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 51), "html", null, true);
        }
        yield "\">
        <input type=\"hidden\" name=\"text\" value=\"";
        // line 52
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 52)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 52), "html", null, true);
        }
        yield "\">
        <input id=\"form-membrer-create-submit\" name=\"form-member-create-submit\" class=\"btn btn-primary\" type=\"submit\" value=\"Je crée mon compte\">
      </div>
    </form>
  </div>
</div>

</div>
</div>

";
        // line 62
        yield from $this->loadTemplate("common/footer.twig", "auth/auth.twig", 62)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "auth/auth.twig";
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
        return array (  173 => 62,  158 => 52,  152 => 51,  144 => 48,  135 => 44,  129 => 43,  123 => 42,  117 => 41,  108 => 37,  102 => 36,  96 => 35,  82 => 23,  76 => 22,  66 => 17,  56 => 12,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/auth.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/auth/auth.twig");
    }
}
