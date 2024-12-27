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
class __TwigTemplate_1a7e941126488bceea73f978a9874bb4 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "contact.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <div class=\"row\">
    <div class=\"col-md-8\">

    <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Contacter l’association AD’HOC</h1>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">

      ";
        // line 10
        if (($context["sent_ok"] ?? null)) {
            // line 11
            yield "      <div class=\"alert alert-success\">
        <strong>Votre message a bien été envoyé, merci !</strong><br>
        Nous tâcherons d’y répondre dans les plus brefs délais<br>
        Musicalement,<br>
        L’Equipe AD’HOC
      </div>
      ";
        }
        // line 18
        yield "
      ";
        // line 19
        if (($context["sent_ko"] ?? null)) {
            // line 20
            yield "      <div class=\"alert alert-danger\">Message non envoyé</div>
      ";
        }
        // line 22
        yield "
      ";
        // line 23
        if (($context["show_form"] ?? null)) {
            // line 24
            yield "      <form id=\"form-contact\" name=\"form-contact\" method=\"post\" action=\"/contact\" enctype=\"multipart/form-data\">
        <div class=\"row mb-3\">
          <label for=\"name\" class=\"form-label col-2\">Nom</label>
          <div class=\"col-8\">
            <div class=\"alert alert-danger\" id=\"error_name\"";
            // line 28
            if ( !($context["error_name"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez renseigner votre nom</div>
            <input name=\"name\" id=\"name\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre nom\" value=\"";
            // line 29
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["name"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
          </div>
        </div>
        <div class=\"row mb-3\">
          <label for=\"email\" class=\"form-label col-2\">E-mail</label>
          <div class=\"col-8\">
            <div class=\"alert alert-danger\" id=\"error_email\"";
            // line 35
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Votre email semble incorrect</div>
            <input name=\"email\" id=\"email\" type=\"email\" maxlength=\"80\" required=\"required\" placeholder=\"Votre e-mail\" value=\"";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
          </div>
        </div>
        <div class=\"row mb-3\">
          <label for=\"subject\" class=\"form-label col-2\">Sujet</label>
          <div class=\"col-8\">
            <div class=\"alert alert-danger\" id=\"error_subject\"";
            // line 42
            if ( !($context["error_subject"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez saisir un sujet</div>
            <input name=\"subject\" id=\"subject\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre sujet\" value=\"";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["subject"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
          </div>
        </div>
        <div class=\"row mb-3\">
          <label for=\"text\" class=\"form-label col-2\">Message</label>
          <div class=\"col-8\">
            <div class=\"alert alert-danger\" id=\"error_text\"";
            // line 49
            if ( !($context["error_text"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez écrire quelque chose !</div>
            <textarea name=\"text\" id=\"text\" placeholder=\"Votre message\" required=\"required\" class=\"form-control\" rows=\"6\">";
            // line 50
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text"] ?? null), "html", null, true);
            yield "</textarea>
          </div>
        </div>
        <div class=\"row mb-3\">
          <div class=\"offset-2\">
            <input type=\"checkbox\" class=\"form-check-input\" id=\"mailing\" name=\"mailing\"";
            // line 55
            if (($context["mailing"] ?? null)) {
                yield " checked=\"checked\"";
            }
            yield ">
            <label for=\"mailing\" class=\"form-check-label\">Je souhaite recevoir la newsletter</label>
          </div>
        </div>
        <div class=\"row mb-3\">
          <div class=\"offset-2\">
            <div class=\"alert alert-danger\" id=\"error_check\"";
            // line 61
            if ( !($context["error_check"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Erreur à la vérification du code de sécurité</div>
            <input id=\"form-contact-submit\" data-check=\"";
            // line 62
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["check"] ?? null), "html", null, true);
            yield "\" name=\"form-contact-submit\" type=\"submit\" value=\"Envoyer le message\" class=\"btn btn-primary\"/>
          </div>
        </div>
        <input name=\"check\" id=\"check\" type=\"hidden\" value=\"\">
      </form>
      ";
        }
        // line 68
        yield "
    </div>
  </div>";
        // line 71
        yield "
  <div class=\"col-md-4\">

    <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Adresse Postale</h2>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
      <strong>Association AD’HOC</strong><br>
      <address>9 impasse des tilleuls<br>
      91360 Épinay-sur-Orge</address>
    </div>

    <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Questions fréquentes</h2>
    <div class=\"border rounded-bottom bg-white p-3 mb-3\">
      ";
        // line 83
        if (($context["faq"] ?? null)) {
            // line 84
            yield "      <div class=\"reset\">
        ";
            // line 85
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["faq"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 86
                yield "        <div class=\"faq\">
          <h3 class=\"flex-row-reverse\">";
                // line 87
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "question", [], "any", false, false, false, 87), "html", null, true);
                yield " <i class=\"icon-arrow--right\"></i></h3>
          <p>";
                // line 88
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "answer", [], "any", false, false, false, 88), "html", null, true);
                yield "</p>
        </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['f'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 91
            yield "      </div>
      ";
        } else {
            // line 93
            yield "      <div>
        <p>Aucune questions fréquentes</p>
      </div>
      ";
        }
        // line 97
        yield "    </div>

    </div>";
        // line 100
        yield "  </div>";
        // line 101
        yield "</div>";
        // line 102
        yield "
";
        // line 103
        yield from $this->loadTemplate("common/footer.twig", "contact.twig", 103)->unwrap()->yield($context);
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
        return array (  234 => 103,  231 => 102,  229 => 101,  227 => 100,  223 => 97,  217 => 93,  213 => 91,  204 => 88,  200 => 87,  197 => 86,  193 => 85,  190 => 84,  188 => 83,  174 => 71,  170 => 68,  161 => 62,  155 => 61,  144 => 55,  136 => 50,  130 => 49,  121 => 43,  115 => 42,  106 => 36,  100 => 35,  91 => 29,  85 => 28,  79 => 24,  77 => 23,  74 => 22,  70 => 20,  68 => 19,  65 => 18,  56 => 11,  54 => 10,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "contact.twig", "/var/www/docker.adhocmusic.com/www/views_bs/contact.twig");
    }
}
