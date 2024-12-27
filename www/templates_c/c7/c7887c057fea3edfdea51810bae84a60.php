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

/* contact.twig */
class __TwigTemplate_36cd7c11bee24a2a28bb3cd773e54ba4 extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "contact.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
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
            yield "      <div class=\"infobulle success\">
        <strong>Votre message a bien été envoyé, merci !</strong><br>
        Nous tâcherons d’y répondre dans les plus brefs délais<br>
        Musicalement,<br>
        L’Equipe AD’HOC
      </div>
      ";
        }
        // line 21
        yield "
      ";
        // line 22
        if (($context["sent_ko"] ?? null)) {
            // line 23
            yield "      <div class=\"infobulle error\">Message non envoyé</div>
      ";
        }
        // line 25
        yield "
      ";
        // line 26
        if (($context["show_form"] ?? null)) {
            // line 27
            yield "      <form id=\"form-contact\" name=\"form-contact\" method=\"post\" action=\"/contact\" enctype=\"multipart/form-data\">
        <section class=\"grid-4\">
          <div>
            <label for=\"name\" class=\"col-form-label\">Nom</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_name\"";
            // line 33
            if ( !($context["error_name"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez renseigner votre nom</div>
            <input name=\"name\" id=\"name\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre nom\" value=\"";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["name"] ?? null), "html", null, true);
            yield "\" class=\"w100\">
          </div>
          <div>
            <label for=\"email\" class=\"col-form-label\">E-mail</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_email\"";
            // line 40
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Votre email semble incorrect</div>
            <input name=\"email\" id=\"email\" type=\"email\" maxlength=\"80\" required=\"required\" placeholder=\"Votre e-mail\" value=\"";
            // line 41
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
            yield "\" class=\"w100\">
          </div>
          <div>
            <label for=\"subject\" class=\"col-form-label\">Sujet</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_subject\"";
            // line 47
            if ( !($context["error_subject"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez saisir un sujet</div>
            <input name=\"subject\" id=\"subject\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre sujet\" value=\"";
            // line 48
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["subject"] ?? null), "html", null, true);
            yield "\" class=\"w100\">
          </div>
          <div>
            <label for=\"text\" class=\"col-form-label\">Message</label>
          </div>
          <div class=\"col-3 mbs\">
            <div class=\"infobulle error\" id=\"error_text\"";
            // line 54
            if ( !($context["error_text"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez écrire quelque chose !</div>
            <textarea name=\"text\" id=\"text\" placeholder=\"Votre message\" required=\"required\" class=\"w100\" rows=\"6\">";
            // line 55
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text"] ?? null), "html", null, true);
            yield "</textarea>
          </div>
          <div>
            <label for=\"mailing\" class=\"col-form-label visually-hidden\">Newsletter</label>
          </div>
          <div class=\"col-3 mbs\">
            <input type=\"checkbox\" class=\"checkbox\" id=\"mailing\" name=\"mailing\"";
            // line 61
            if (($context["mailing"] ?? null)) {
                yield " checked=\"checked\"";
            }
            yield ">
            Je souhaite recevoir la newsletter
          </div>
          <div></div>
          <div class=\"col-3\">
            <div class=\"infobulle error\" id=\"error_check\"";
            // line 66
            if ( !($context["error_check"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Erreur à la vérification du code de sécurité</div>
            <input id=\"form-contact-submit\" data-check=\"";
            // line 67
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["check"] ?? null), "html", null, true);
            yield "\" name=\"form-contact-submit\" type=\"submit\" value=\"Envoyer le message\" class=\"btn btn--primary w100\"/>
          </div>
        </section>
        <input name=\"check\" id=\"check\" type=\"hidden\" value=\"\">
      </form>

      ";
        }
        // line 74
        yield "
    </div>
  </div>";
        // line 77
        yield "
  </div>";
        // line 79
        yield "
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
            yield "      <div class=\"reset\">
        ";
            // line 99
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["faq"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 100
                yield "        <div class=\"faq\">
          <h3 class=\"flex-row-reverse\">";
                // line 101
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "question", [], "any", false, false, false, 101), "html", null, true);
                yield " <i class=\"icon-arrow--right\"></i></h3>
          <p>";
                // line 102
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "answer", [], "any", false, false, false, 102), "html", null, true);
                yield "</p>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['f'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            yield "      </div>
      ";
        } else {
            // line 107
            yield "      <div>
        <p>Aucune questions fréquentes</p>
      </div>
      ";
        }
        // line 111
        yield "    </div>

  </div>";
        // line 114
        yield "
</div>";
        // line 116
        yield "
";
        // line 117
        yield from         $this->loadTemplate("common/footer.twig", "contact.twig", 117)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "contact.twig";
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
        return array (  248 => 117,  245 => 116,  242 => 114,  238 => 111,  232 => 107,  228 => 105,  219 => 102,  215 => 101,  212 => 100,  208 => 99,  205 => 98,  203 => 97,  183 => 79,  180 => 77,  176 => 74,  166 => 67,  160 => 66,  150 => 61,  141 => 55,  135 => 54,  126 => 48,  120 => 47,  111 => 41,  105 => 40,  96 => 34,  90 => 33,  82 => 27,  80 => 26,  77 => 25,  73 => 23,  71 => 22,  68 => 21,  59 => 14,  57 => 13,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "contact.twig", "/var/www/docker.adhocmusic.com/app/twig/contact.twig");
    }
}
