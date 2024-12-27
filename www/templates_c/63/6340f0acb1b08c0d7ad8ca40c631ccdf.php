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
class __TwigTemplate_e95cda5023f4527ece88e9a1dc3c9ebe extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "auth/auth.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"grid-2 has-gutter\">

<div class=\"box\">
  <header>
    <h1>Se connecter</h1>
  </header>
  <div>
    <form id=\"form-login\" name=\"form-login\" method=\"post\" action=\"/auth/login\">
      <div class=\"mbs\">
        <label for=\"login-pseudo\">Pseudo</label>
        <div class=\"infobulle error\" id=\"error_login-pseudo\"";
        // line 13
        if ( !($context["error_login_pseudo"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Pseudo vide !</div>
        <input type=\"text\" id=\"login-pseudo\" name=\"pseudo\" required=\"required\" placeholder=\"Pseudo\" class=\"w100\">
      </div>
      <div class=\"mbm\">
        <label for=\"login-password\">Mot de passe</label>
        <div class=\"infobulle error\" id=\"error_login-password\"";
        // line 18
        if ( !($context["error_login_password"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Mot de passe vide !</div>
        <input type=\"password\" id=\"login-password\" name=\"password\" required=\"required\" placeholder=\"Mot de passe\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <input id=\"form-login-submit\" name=\"form-login-submit\" type=\"submit\" value=\"Je me connecte\" class=\"btn btn--primary w100\">
        ";
        // line 23
        if (($context["referer"] ?? null)) {
            yield "<input type=\"hidden\" id=\"login-referer\" name=\"referer\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(($context["referer"] ?? null)), "html", null, true);
            yield "\">";
        }
        // line 24
        yield "      </div>
      <div class=\"txtcenter\">
        <ul>
          <li><a href=\"/auth/lost-password\">mot de passe oublié</a></li>
        </ul>
      </div>
    </form>
  </div>
</div>

<div class=\"box\">
  <header>
    <h1>Créer un compte</h1>
  </header>
  <div>
    <form id=\"form-member-create\" name=\"form-member-create\" method=\"post\" action=\"/membres/create\">
      <div class=\"mbs\">
        <label for=\"pseudo\">Pseudo</label>
        <div id=\"error_pseudo_unavailable\" class=\"infobulle error\"";
        // line 42
        if ( !($context["error_pseudo_unavailable"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Ce pseudo est pris, veuillez en choisir un autre</div>
        <div class=\"infobulle error\" id=\"error_pseudo\"";
        // line 43
        if ( !($context["error_pseudo"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Vous devez saisir un pseudo entre 2 à 16 caractères</div>
        <input id=\"pseudo\" name=\"pseudo\" type=\"text\" value=\"";
        // line 44
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 44)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 44), "html", null, true);
        }
        yield "\" required=\"required\" placeholder=\"Pseudo\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <label for=\"email\">E-mail</label>
        <div id=\"error_email\"";
        // line 48
        if ( !($context["error_email"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield " class=\"infobulle error\">Vous devez saisir votre e-mail</div>
        <div id=\"error_invalid_email\" class=\"infobulle error\"";
        // line 49
        if ( !($context["error_invalid_email"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Cet e-mail semble invalide</div>
        <div id=\"error_already_member\" class=\"infobulle error\"";
        // line 50
        if ( !($context["error_already_member"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href=\"/auth/lost-password\">oublié votre mot de passe ?</a></div>
        <input id=\"email\" name=\"email\" type=\"email\" value=\"";
        // line 51
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 51)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 51), "html", null, true);
        }
        yield "\" required=\"required\" placeholder=\"E-mail\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <label for=\"mailing\" class=\"visually-hidden\">Newsletter</label>
        <input id=\"mailing\" class=\"checkbox\" name=\"mailing\" type=\"checkbox\"";
        // line 55
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "mailing", [], "any", false, false, false, 55)) {
            yield " checked=\"checked\"";
        }
        yield "> Je souhaite recevoir la newsletter
      </div>
      <div>
        <input type=\"hidden\" name=\"csrf\" value=\"";
        // line 58
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 58)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 58), "html", null, true);
        }
        yield "\">
        <input type=\"hidden\" name=\"text\" value=\"";
        // line 59
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 59)) {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 59), "html", null, true);
        }
        yield "\">
        <input id=\"form-membrer-create-submit\" name=\"form-member-create-submit\" class=\"btn btn--primary w100\" type=\"submit\" value=\"Je crée mon compte\">
      </div>
    </form>
  </div>
</div>

</div>

";
        // line 68
        yield from         $this->loadTemplate("common/footer.twig", "auth/auth.twig", 68)->unwrap()->yield($context);
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
        return array (  179 => 68,  165 => 59,  159 => 58,  151 => 55,  142 => 51,  136 => 50,  130 => 49,  124 => 48,  115 => 44,  109 => 43,  103 => 42,  83 => 24,  77 => 23,  67 => 18,  57 => 13,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/auth.twig", "/var/www/docker.adhocmusic.com/app/twig/auth/auth.twig");
    }
}
