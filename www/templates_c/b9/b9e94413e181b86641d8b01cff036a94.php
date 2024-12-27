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

/* newsletters/subscriptions.twig */
class __TwigTemplate_5bfca2799076d1b3f4241587b64632c9 extends Template
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
        $this->loadTemplate("common/header.twig", "newsletters/subscriptions.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"box\" style=\"width: 320px; margin: 0 auto 20px\">
  <header>
    <h2>Newsletter</h2>
  </header>
  <div>
";
        // line 8
        if (($context["form"] ?? null)) {
            // line 9
            echo "<form id=\"form-newsletter\" name=\"form-newsletter\" action=\"/newsletters/subscriptions\" method=\"post\">
  <div class=\"mbs\">
    <label for=\"email\">E-mail</label>
    <input type=\"email\" id=\"email\" name=\"email\" placeholder=\"E-mail\" class=\"w100\" value=\"";
            // line 12
            echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
            echo "\" required=\"required\">
  </div>
  <div class=\"mbs\">
    <input type=\"radio\" class=\"radio\" name=\"action\" value=\"sub\" ";
            // line 15
            if ((($context["action"] ?? null) == "sub")) {
                echo " checked=\"checked\"";
            }
            echo ">
    <label for=\"sub\">Inscription</label>
  </div>
  <div class=\"mbs\">
    <input type=\"radio\" class=\"radio\" name=\"action\" value=\"unsub\" ";
            // line 19
            if ((($context["action"] ?? null) == "unsub")) {
                echo " checked=\"checked\"";
            }
            echo ">
    <label for=\"unsub\">Désinscription</label>
  </div>
  <div>
    <input class=\"btn btn--primary w100\" type=\"submit\" id=\"form-newsletter-submit\" name=\"form-newsletter-submit\" value=\"Valider\">
  </div>
</form>
";
        }
        // line 27
        echo "
";
        // line 28
        if (($context["error_email"] ?? null)) {
            // line 29
            echo "<div class=\"infobulle error\">Adresse email invalide</div>
";
        }
        // line 31
        echo "
";
        // line 32
        if (($context["ret"] ?? null)) {
            // line 33
            echo "  ";
            if ((($context["ret"] ?? null) == "SUB-OK")) {
                // line 34
                echo "  <div class=\"infobulle success\">L'email <strong>";
                echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
                echo "</strong> a bien été inscrite à la liste des abonnés de la newsletter AD'HOC. Merci et bienvenue ! :)</div>
  ";
            } elseif ((            // line 35
($context["ret"] ?? null) == "SUB-KO")) {
                // line 36
                echo "  <div class=\"infobulle error\">L'email <strong>";
                echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
                echo "</strong> est déjà inscrite à la liste des abonnés de la newsletter AD'HOC.</div>
  ";
            } elseif ((            // line 37
($context["ret"] ?? null) == "UNSUB-OK")) {
                // line 38
                echo "  <div class=\"infobulle success\">L'email <strong>";
                echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
                echo "</strong> a bien été désinscrite de la liste des abonnés de la newsletter AD'HOC. Au revoir :(</div>
  ";
            } elseif ((            // line 39
($context["ret"] ?? null) == "UNSUB-KO")) {
                // line 40
                echo "  <div class=\"infobulle error\">L'email <strong>";
                echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
                echo "</strong> n'est pas inscrite à la newsletter AD'HOC.</div>
  ";
            }
        }
        // line 43
        echo "
  </div>
</div>

";
        // line 47
        $this->loadTemplate("common/footer.twig", "newsletters/subscriptions.twig", 47)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "newsletters/subscriptions.twig";
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
        return array (  133 => 47,  127 => 43,  120 => 40,  118 => 39,  113 => 38,  111 => 37,  106 => 36,  104 => 35,  99 => 34,  96 => 33,  94 => 32,  91 => 31,  87 => 29,  85 => 28,  82 => 27,  69 => 19,  60 => 15,  54 => 12,  49 => 9,  47 => 8,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "newsletters/subscriptions.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/newsletters/subscriptions.twig");
    }
}
