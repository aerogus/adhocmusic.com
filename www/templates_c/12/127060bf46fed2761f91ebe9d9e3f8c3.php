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

/* auth/login.twig */
class __TwigTemplate_f7a240bc7fb9493469483b31419765f4 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "auth/login.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
";
        // line 3
        if (($context["auth_failed"] ?? null)) {
            // line 4
            yield "<div class=\"infobulle error\">Authentification échouée</div>
";
        }
        // line 6
        yield "
";
        // line 7
        if (($context["auth_required"] ?? null)) {
            // line 8
            yield "<div class=\"infobulle warning\">Vous devez posséder un compte AD'HOC pour accéder à cette page ou vous n'avez pas les droits suffisants</div>
";
        }
        // line 10
        yield "
<div class=\"box\" style=\"width: 320px; margin: 0 auto 20px\">
  <header>
    <h1>Se connecter</h1>
  </header>
  <div>
    <form id=\"form-login\" name=\"form-login\" method=\"post\" action=\"/auth/login\">
      <div class=\"mbs\">
        <label for=\"login-pseudo\">Pseudo</label>
        <div class=\"infobulle error\" id=\"error_login-pseudo\"";
        // line 19
        if ( !($context["error_login_pseudo"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Pseudo vide !</div>
        <input type=\"text\" id=\"login-pseudo\" name=\"pseudo\" placeholder=\"Pseudo\" class=\"w100\">
      </div>
      <div class=\"mbm\">
        <label for=\"login-password\">Mot de passe</label>
        <div class=\"infobulle error\" id=\"error_login-password\"";
        // line 24
        if ( !($context["error_login_password"] ?? null)) {
            yield " style=\"display: none\"";
        }
        yield ">Mot de passe vide !</div>
        <input type=\"password\" id=\"login-password\" name=\"password\" placeholder=\"Mot de passe\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <input id=\"form-login-submit\" name=\"form-login-submit\" class=\"btn btn--primary w100\" type=\"submit\" value=\"Je me connecte\">
      </div>
      ";
        // line 30
        if (($context["referer"] ?? null)) {
            yield "<input type=\"hidden\" id=\"login-referer\" name=\"referer\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode(($context["referer"] ?? null)), "html", null, true);
            yield "\">";
        }
        // line 31
        yield "      <div class=\"txtcenter\">
        <ul>
          <li class=\"mbs\"><a href=\"/auth/lost-password\">mot de passe oublié</a></li>
          <li><a href=\"/membres/create\">créer un compte</a></li>
        </ul>
      </div>
    </form>
  </div>
</div>

";
        // line 41
        yield from $this->loadTemplate("common/footer.twig", "auth/login.twig", 41)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "auth/login.twig";
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
        return array (  112 => 41,  100 => 31,  94 => 30,  83 => 24,  73 => 19,  62 => 10,  58 => 8,  56 => 7,  53 => 6,  49 => 4,  47 => 3,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/login.twig", "/var/www/docker.adhocmusic.com/app/twig/auth/login.twig");
    }
}
