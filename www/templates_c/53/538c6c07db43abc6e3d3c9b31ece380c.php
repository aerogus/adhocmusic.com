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

/* auth/auth.twig */
class __TwigTemplate_d01249e015a6f3e23ef47e77454a974b extends Template
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
        $this->loadTemplate("common/header.twig", "auth/auth.twig", 1)->display($context);
        // line 2
        echo "
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
            echo " style=\"display: none\"";
        }
        echo ">Pseudo vide !</div>
        <input type=\"text\" id=\"login-pseudo\" name=\"pseudo\" required=\"required\" placeholder=\"Pseudo\" class=\"w100\">
      </div>
      <div class=\"mbm\">
        <label for=\"login-password\">Mot de passe</label>
        <div class=\"infobulle error\" id=\"error_login-password\"";
        // line 18
        if ( !($context["error_login_password"] ?? null)) {
            echo " style=\"display: none\"";
        }
        echo ">Mot de passe vide !</div>
        <input type=\"password\" id=\"login-password\" name=\"password\" required=\"required\" placeholder=\"Mot de passe\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <input id=\"form-login-submit\" name=\"form-login-submit\" type=\"submit\" value=\"Je me connecte\" class=\"btn btn--primary w100\">
        ";
        // line 23
        if (($context["referer"] ?? null)) {
            echo "<input type=\"hidden\" id=\"login-referer\" name=\"referer\" value=\"";
            echo twig_escape_filter($this->env, twig_urlencode_filter(($context["referer"] ?? null)), "html", null, true);
            echo "\">";
        }
        // line 24
        echo "      </div>
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
            echo " style=\"display: none\"";
        }
        echo ">Ce pseudo est pris, veuillez en choisir un autre</div>
        <div class=\"infobulle error\" id=\"error_pseudo\"";
        // line 43
        if ( !($context["error_pseudo"] ?? null)) {
            echo " style=\"display: none\"";
        }
        echo ">Vous devez saisir un pseudo entre 2 à 16 caractères</div>
        <input id=\"pseudo\" name=\"pseudo\" type=\"text\" value=\"";
        // line 44
        if (twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 44)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "pseudo", [], "any", false, false, false, 44), "html", null, true);
        }
        echo "\" required=\"required\" placeholder=\"Pseudo\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <label for=\"email\">E-mail</label>
        <div id=\"error_email\"";
        // line 48
        if ( !($context["error_email"] ?? null)) {
            echo " style=\"display: none\"";
        }
        echo " class=\"infobulle error\">Vous devez saisir votre e-mail</div>
        <div id=\"error_invalid_email\" class=\"infobulle error\"";
        // line 49
        if ( !($context["error_invalid_email"] ?? null)) {
            echo " style=\"display: none\"";
        }
        echo ">Cet e-mail semble invalide</div>
        <div id=\"error_already_member\" class=\"infobulle error\"";
        // line 50
        if ( !($context["error_already_member"] ?? null)) {
            echo " style=\"display: none\"";
        }
        echo ">Inscription impossible car un compte avec cet e-mail existe déjà. Vous avez <a href=\"/auth/lost-password\">oublié votre mot de passe ?</a></div>
        <input id=\"email\" name=\"email\" type=\"email\" value=\"";
        // line 51
        if (twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 51)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "email", [], "any", false, false, false, 51), "html", null, true);
        }
        echo "\" required=\"required\" placeholder=\"E-mail\" class=\"w100\">
      </div>
      <div class=\"mbs\">
        <label for=\"mailing\" class=\"visually-hidden\">Newsletter</label>
        <input id=\"mailing\" class=\"checkbox\" name=\"mailing\" type=\"checkbox\"";
        // line 55
        if (twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "mailing", [], "any", false, false, false, 55)) {
            echo " checked=\"checked\"";
        }
        echo "> Je souhaite recevoir la newsletter
      </div>
      <div>
        <input type=\"hidden\" name=\"csrf\" value=\"";
        // line 58
        if (twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 58)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "csrf", [], "any", false, false, false, 58), "html", null, true);
        }
        echo "\">
        <input type=\"hidden\" name=\"text\" value=\"";
        // line 59
        if (twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 59)) {
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "text", [], "any", false, false, false, 59), "html", null, true);
        }
        echo "\">
        <input id=\"form-membrer-create-submit\" name=\"form-member-create-submit\" class=\"btn btn--primary w100\" type=\"submit\" value=\"Je crée mon compte\">
      </div>
    </form>
  </div>
</div>

</div>

";
        // line 68
        $this->loadTemplate("common/footer.twig", "auth/auth.twig", 68)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "auth/auth.twig";
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
        return array (  174 => 68,  160 => 59,  154 => 58,  146 => 55,  137 => 51,  131 => 50,  125 => 49,  119 => 48,  110 => 44,  104 => 43,  98 => 42,  78 => 24,  72 => 23,  62 => 18,  52 => 13,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "auth/auth.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/auth/auth.twig");
    }
}
