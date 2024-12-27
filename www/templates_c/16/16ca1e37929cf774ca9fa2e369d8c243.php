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

/* auth/lost-password.twig */
class __TwigTemplate_4ea759dadaee0ca371033367b82e545d extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "auth/lost-password.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"box\" style=\"width: 320px; margin: 0 auto 20px\">
  <header>
    <h1>Mot de passe oublié</h1>
  </header>
  <div>

";
        // line 9
        if (($context["sent_ok"] ?? null)) {
            // line 10
            yield "<div class=\"infobulle success\">Un nouveau mot de passe vous a été attribué. Veuillez consulter votre boite aux lettres.</div>
";
        }
        // line 12
        yield "
";
        // line 13
        if (($context["sent_ko"] ?? null)) {
            // line 14
            yield "<div class=\"infobulle error\">Un nouveau mot de passe vous a été attribué mais l'envoi de l'email a échoué (c'est plutôt con !). Veuillez <a href=\"/contact\">nous contacter</a>.</div>
  ";
            // line 15
            if (($context["new_password"] ?? null)) {
                // line 16
                yield "  <div class=\"infobulle success\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["new_password"] ?? null), "html", null, true);
                yield "</div>
  ";
            }
        }
        // line 19
        yield "
";
        // line 20
        if (($context["err_email_unknown"] ?? null)) {
            // line 21
            yield "<div class=\"infobulle error\">Compte introuvable</div>
";
        }
        // line 23
        yield "
";
        // line 24
        if (($context["err_email_invalid"] ?? null)) {
            // line 25
            yield "<div class=\"infobulle error\">Erreur e-mail synatiquement incorrect.</div>
";
        }
        // line 27
        yield "
";
        // line 28
        if (($context["form"] ?? null)) {
            // line 29
            yield "<form id=\"form-lost-password\" name=\"form-lost-password\" method=\"post\" action=\"/auth/lost-password\">
  <p>Veuillez entrer l'e-mail que vous avez utilisé pour l'inscription, un nouveau mot de passe vous sera envoyé par e-mail.</p>
  <div class=\"mbs\">
    <label for=\"email\">E-mail</label>
    <div class=\"infobulle error\" id=\"error_email\"";
            // line 33
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez renseigner votre e-mail ou e-mail invalide</div>
    <input name=\"email\" id=\"email\" type=\"email\" placeholder=\"E-mail\" required=\"required\" class=\"w100\">
  </div>
  <div>
    <input id=\"form-lost-password-submit\" name=\"form-lost-password-submit\" class=\"btn btn--primary w100\" type=\"submit\" value=\"Ok\">
  </div>
</form>
";
        }
        // line 41
        yield "
  </div>
</div>

";
        // line 45
        yield from         $this->loadTemplate("common/footer.twig", "auth/lost-password.twig", 45)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "auth/lost-password.twig";
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
        return array (  124 => 45,  118 => 41,  105 => 33,  99 => 29,  97 => 28,  94 => 27,  90 => 25,  88 => 24,  85 => 23,  81 => 21,  79 => 20,  76 => 19,  69 => 16,  67 => 15,  64 => 14,  62 => 13,  59 => 12,  55 => 10,  53 => 9,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/lost-password.twig", "/var/www/docker.adhocmusic.com/app/twig/auth/lost-password.twig");
    }
}
