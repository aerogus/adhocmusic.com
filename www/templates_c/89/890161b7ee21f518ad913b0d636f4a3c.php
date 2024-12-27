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

/* contact.twig */
class __TwigTemplate_6b10944c355fba476b460d9137e59b2a extends Template
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
        $this->loadTemplate("common/header.twig", "contact.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"grid-3-small-1 has-gutter\">

  <div class=\"col-2\">

  <div class=\"box\">
    <header>
      <h1>Contacter l’association AD’HOC</h1>
    </header>
    <div>

      ";
        // line 13
        if (($context["sent_ok"] ?? null)) {
            // line 14
            echo "      <div class=\"infobulle success\">
        <strong>Votre message a bien été envoyé, merci !</strong><br>
        Nous tâcherons d’y répondre dans les plus brefs délais<br>
        Musicalement,<br>
        L’Equipe AD’HOC
      </div>
      ";
        }
        // line 21
        echo "
      ";
        // line 22
        if (($context["sent_ko"] ?? null)) {
            // line 23
            echo "      <div class=\"infobulle error\">Message non envoyé</div>
      ";
        }
        // line 25
        echo "
      ";
        // line 26
        if (($context["show_form"] ?? null)) {
            // line 27
            echo "      <form id=\"form-contact\" name=\"form-contact\" method=\"post\" action=\"/contact\" enctype=\"multipart/form-data\">
        <section class=\"grid-4\">
          <div>
            <label for=\"name\" class=\"col-form-label\">Nom</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_name\"";
            // line 33
            if ( !($context["error_name"] ?? null)) {
                echo " style=\"display: none\"";
            }
            echo ">Vous devez renseigner votre nom</div>
            <input name=\"name\" id=\"name\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre nom\" value=\"";
            // line 34
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\" class=\"w100\">
          </div>
          <div>
            <label for=\"email\" class=\"col-form-label\">E-mail</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_email\"";
            // line 40
            if ( !($context["error_email"] ?? null)) {
                echo " style=\"display: none\"";
            }
            echo ">Votre email semble incorrect</div>
            <input name=\"email\" id=\"email\" type=\"email\" maxlength=\"80\" required=\"required\" placeholder=\"Votre e-mail\" value=\"";
            // line 41
            echo twig_escape_filter($this->env, ($context["email"] ?? null), "html", null, true);
            echo "\" class=\"w100\">
          </div>
          <div>
            <label for=\"subject\" class=\"col-form-label\">Sujet</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_subject\"";
            // line 47
            if ( !($context["error_subject"] ?? null)) {
                echo " style=\"display: none\"";
            }
            echo ">Vous devez saisir un sujet</div>
            <input name=\"subject\" id=\"subject\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre sujet\" value=\"";
            // line 48
            echo twig_escape_filter($this->env, ($context["subject"] ?? null), "html", null, true);
            echo "\" class=\"w100\">
          </div>
          <div>
            <label for=\"text\" class=\"col-form-label\">Message</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_text\"";
            // line 54
            if ( !($context["error_text"] ?? null)) {
                echo " style=\"display: none\"";
            }
            echo ">Vous devez écrire quelque chose !</div>
            <textarea name=\"text\" id=\"text\" placeholder=\"Votre message\" required=\"required\" class=\"w100\" rows=\"6\">";
            // line 55
            echo twig_escape_filter($this->env, ($context["text"] ?? null), "html", null, true);
            echo "</textarea>
          </div>
          <div>
            <label for=\"mailing\" class=\"col-form-label visually-hidden\">Newsletter</label>
          </div>
          <div class=\"col-3 mbs\">
            <input type=\"checkbox\" class=\"checkbox\" id=\"mailing\" name=\"mailing\"";
            // line 61
            if (($context["mailing"] ?? null)) {
                echo " checked=\"checked\"";
            }
            echo ">
            Je souhaite recevoir la newsletter
          </div>
          <div></div>
          <div class=\"col-3\">
            <div class=\"infobulle error\" id=\"error_check\"";
            // line 66
            if ( !($context["error_check"] ?? null)) {
                echo " style=\"display: none\"";
            }
            echo ">Erreur à la vérification du code de sécurité</div>
            <input id=\"form-contact-submit\" data-check=\"";
            // line 67
            echo twig_escape_filter($this->env, ($context["check"] ?? null), "html", null, true);
            echo "\" name=\"form-contact-submit\" type=\"submit\" value=\"Envoyer le message\" class=\"btn btn--primary w100\"/>
          </div>
        </section>
        <input name=\"check\" id=\"check\" type=\"hidden\" value=\"\">
      </form>

      ";
        }
        // line 74
        echo "
    </div>
  </div>";
        // line 77
        echo "
  </div>";
        // line 79
        echo "
  <div class=\"col-1\">

    <div class=\"box\">
      <header>
        <h2>Adresse Postale</h2>
      </header>
      <div>
        <strong>Association AD’HOC</strong><br>
        <address>9 impasse des tilleuls<br>
        91360 Épinay-sur-Orge</address>
      </div>
    </div>

    <div class=\"box\">
      <header>
        <h2>Questions fréquentes</h2>
      </header>
      ";
        // line 97
        if (($context["faq"] ?? null)) {
            // line 98
            echo "      <div class=\"reset\">
        ";
            // line 99
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["faq"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 100
                echo "        <div class=\"faq\">
          <h3 class=\"flex-row-reverse\">";
                // line 101
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "question", [], "any", false, false, false, 101), "html", null, true);
                echo " <i class=\"icon-arrow--right\"></i></h3>
          <p>";
                // line 102
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["f"], "answer", [], "any", false, false, false, 102), "html", null, true);
                echo "</p>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            echo "      </div>
      ";
        } else {
            // line 107
            echo "      <div>
        <p>Aucune questions fréquentes</p>
      </div>
      ";
        }
        // line 111
        echo "    </div>

  </div>";
        // line 114
        echo "
</div>";
        // line 116
        echo "
";
        // line 117
        $this->loadTemplate("common/footer.twig", "contact.twig", 117)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "contact.twig";
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
        return array (  243 => 117,  240 => 116,  237 => 114,  233 => 111,  227 => 107,  223 => 105,  214 => 102,  210 => 101,  207 => 100,  203 => 99,  200 => 98,  198 => 97,  178 => 79,  175 => 77,  171 => 74,  161 => 67,  155 => 66,  145 => 61,  136 => 55,  130 => 54,  121 => 48,  115 => 47,  106 => 41,  100 => 40,  91 => 34,  85 => 33,  77 => 27,  75 => 26,  72 => 25,  68 => 23,  66 => 22,  63 => 21,  54 => 14,  52 => 13,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "contact.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/contact.twig");
    }
}
