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
class __TwigTemplate_b96dac015b261826080eaa0c9dba7acd extends Template
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
<div class=\"box\" style=\"width: 320px; margin: 0 auto 20px\">
  <header>
    <h1>Créer un compte</h1>
  </header>
  <div>

";
        // line 9
        if (($context["create"] ?? null)) {
            // line 10
            yield "
<div class=\"infobulle success\">Bienvenue ! Votre compte AD’HOC a bien été créé. Consultez votre boite aux lettres électronique, elle vous confirme votre inscription et un mot de passe vous a été communiqué.<br>
Cliquez alors sur le cadenas en haut à droite pour vous identifier.</div>

";
        } elseif (        // line 14
($context["error_generic"] ?? null)) {
            // line 15
            yield "
<div class=\"infobulle error\">Erreur à l’inscription. Votre email est déjà présente, vous avez
déjà un compte. Si vous ne vous souvenez plus de votre mot de passe, <a href=\"/auth/lost-password\">cliquez ici</a> pour le récupérer.</div>

";
        } else {
            // line 20
            yield "
<form id=\"form-member-create\" name=\"form-member-create\" method=\"post\" action=\"/membres/create\">
  <div class=\"mbs\">
    <label for=\"pseudo\">Pseudo</label>
    <div id=\"error_pseudo_unavailable\" class=\"infobulle error\"";
            // line 24
            if ( !($context["error_pseudo_unavailable"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Ce pseudo est pris, veuillez en choisir un autre</div>
    <div class=\"infobulle error\" id=\"error_pseudo\"";
            // line 25
            if ( !($context["error_pseudo"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez saisir un pseudo entre 1 à 50 caractères</div>
    <input id=\"pseudo\" name=\"pseudo\" type=\"text\" maxlength=\"50\" value=\"";
            // line 26
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 26), "html", null, true);
            yield "\" placeholder=\"Pseudo\">
  </div>
  <div class=\"mbs\">
    <label for=\"email\">E-mail</label>
    <div id=\"error_email\"";
            // line 30
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield " class=\"infobulle error\">Vous devez saisir votre e-mail</div>
    <div id=\"error_invalid_email\" class=\"infobulle error\"";
            // line 31
            if ( !($context["error_invalid_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Cet e-mail semble invalide</div>
    <div id=\"error_already_member\" class=\"infobulle error\"";
            // line 32
            if ( !($context["error_already_member"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href=\"/auth/lost-password\">oublié votre mot de passe ?</a></div>
    <input id=\"email\" name=\"email\" type=\"email\" maxlength=\"50\" value=\"";
            // line 33
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 33), "html", null, true);
            yield "\" placeholder=\"E-mail\">
  </div>
  <div class=\"mbs\">
    <label for=\"mailing\" class=\"visually-hidden\">Newsletter</label>
    <span><input id=\"mailing\" class=\"checkbox\" name=\"mailing\" type=\"checkbox\"";
            // line 37
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "mailing", [], "any", false, false, false, 37)) {
                yield " checked=\"checked\"";
            }
            yield "> Je souhaite recevoir la newsletter</span>
  </div>
  <div>
    <input type=\"hidden\" name=\"csrf\" value=\"";
            // line 40
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 40), "html", null, true);
            yield "\">
    <input type=\"hidden\" name=\"text\" value=\"";
            // line 41
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 41), "html", null, true);
            yield "\">
    <input id=\"form-membrer-create-submit\" name=\"form-member-create-submit\" class=\"btn btn--primary\" style=\"width:100%\" type=\"submit\" value=\"Je crée mon compte\">
  </div>
</form>

";
        }
        // line 47
        yield "
  </div>
</div>

";
        // line 51
        yield from $this->loadTemplate("common/footer.twig", "membres/create.twig", 51)->unwrap()->yield($context);
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
        return array (  147 => 51,  141 => 47,  132 => 41,  128 => 40,  120 => 37,  113 => 33,  107 => 32,  101 => 31,  95 => 30,  88 => 26,  82 => 25,  76 => 24,  70 => 20,  63 => 15,  61 => 14,  55 => 10,  53 => 9,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "membres/create.twig", "/var/www/docker.adhocmusic.com/app/twig/membres/create.twig");
    }
}
