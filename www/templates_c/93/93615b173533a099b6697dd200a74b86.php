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
class __TwigTemplate_da58e96d12356b6ab73539f4fd8746a5 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "auth/lost-password.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <div class=\"col-6 border rounded bg-white p-3 mx-auto\">
  <h1>Mot de passe oublié</h1>

";
        // line 7
        if (($context["sent_ok"] ?? null)) {
            // line 8
            yield "<div class=\"alert alert-success\">Un nouveau mot de passe vous a été attribué. Veuillez consulter votre boite aux lettres.</div>
";
        }
        // line 10
        yield "
";
        // line 11
        if (($context["sent_ko"] ?? null)) {
            // line 12
            yield "<div class=\"alert alert-danger\">Un nouveau mot de passe vous a été attribué mais l'envoi de l'email a échoué (c'est plutôt con !). Veuillez <a href=\"/contact\">nous contacter</a>.</div>
  ";
            // line 13
            if (($context["new_password"] ?? null)) {
                // line 14
                yield "  <div class=\"alert alert-success\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["new_password"] ?? null), "html", null, true);
                yield "</div>
  ";
            }
        }
        // line 17
        yield "
";
        // line 18
        if (($context["err_email_unknown"] ?? null)) {
            // line 19
            yield "<div class=\"alert alert-danger\">Compte introuvable</div>
";
        }
        // line 21
        yield "
";
        // line 22
        if (($context["err_email_invalid"] ?? null)) {
            // line 23
            yield "<div class=\"alert alert-danger\">Erreur e-mail synatiquement incorrect.</div>
";
        }
        // line 25
        yield "
";
        // line 26
        if (($context["form"] ?? null)) {
            // line 27
            yield "<form id=\"form-lost-password\" name=\"form-lost-password\" method=\"post\" action=\"/auth/lost-password\">
  <p>Veuillez entrer l'e-mail que vous avez utilisé pour l'inscription, un nouveau mot de passe vous sera envoyé par e-mail.</p>
  <div class=\"mb-3\">
    <label for=\"email\" class=\"form-label\">E-mail</label>
    <div class=\"alert alert-danger\" id=\"error_email\"";
            // line 31
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez renseigner votre e-mail ou e-mail invalide</div>
    <input name=\"email\" id=\"email\" type=\"email\" placeholder=\"E-mail\" required class=\"form-control\">
  </div>
  <input id=\"form-lost-password-submit\" name=\"form-lost-password-submit\" class=\"btn btn-primary\" type=\"submit\" value=\"Ok\">
</form>
";
        }
        // line 37
        yield "
</div>
</div>

";
        // line 41
        yield from $this->loadTemplate("common/footer.twig", "auth/lost-password.twig", 41)->unwrap()->yield($context);
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
        return array (  120 => 41,  114 => 37,  103 => 31,  97 => 27,  95 => 26,  92 => 25,  88 => 23,  86 => 22,  83 => 21,  79 => 19,  77 => 18,  74 => 17,  67 => 14,  65 => 13,  62 => 12,  60 => 11,  57 => 10,  53 => 8,  51 => 7,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/lost-password.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/auth/lost-password.twig");
    }
}
