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
class __TwigTemplate_5220a627fa9959879d088f97d4209102 extends Template
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

    <h1>Contacter l’association AD’HOC</h1>

    ";
        // line 9
        if (($context["sent_ok"] ?? null)) {
            // line 10
            yield "    <div class=\"alert alert-success\">
      <strong>Votre message a bien été envoyé, merci !</strong><br>
      Nous tâcherons d’y répondre dans les plus brefs délais<br>
      Musicalement,<br>
      L’Equipe AD’HOC
    </div>
    ";
        }
        // line 17
        yield "
    ";
        // line 18
        if (($context["sent_ko"] ?? null)) {
            // line 19
            yield "    <div class=\"alert alert-danger\">Message non envoyé</div>
    ";
        }
        // line 21
        yield "
    ";
        // line 22
        if (($context["show_form"] ?? null)) {
            // line 23
            yield "    <form id=\"form-contact\" name=\"form-contact\" method=\"post\" action=\"/contact\" enctype=\"multipart/form-data\">
      <div class=\"row mb-3\">
        <label for=\"name\" class=\"form-label col-2\">Nom</label>
        <div class=\"col-8\">
          <div class=\"alert alert-danger\" id=\"error_name\"";
            // line 27
            if ( !($context["error_name"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez renseigner votre nom</div>
          <input name=\"name\" id=\"name\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre nom\" value=\"";
            // line 28
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["name"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
        </div>
      </div>
      <div class=\"row mb-3\">
        <label for=\"email\" class=\"form-label col-2\">E-mail</label>
        <div class=\"col-8\">
          <div class=\"alert alert-danger\" id=\"error_email\"";
            // line 34
            if ( !($context["error_email"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Votre email semble incorrect</div>
          <input name=\"email\" id=\"email\" type=\"email\" maxlength=\"80\" required=\"required\" placeholder=\"Votre e-mail\" value=\"";
            // line 35
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["email"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
        </div>
      </div>
      <div class=\"row mb-3\">
        <label for=\"subject\" class=\"form-label col-2\">Sujet</label>
        <div class=\"col-8\">
          <div class=\"alert alert-danger\" id=\"error_subject\"";
            // line 41
            if ( !($context["error_subject"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez saisir un sujet</div>
          <input name=\"subject\" id=\"subject\" type=\"text\" maxlength=\"80\" required=\"required\" placeholder=\"Votre sujet\" value=\"";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["subject"] ?? null), "html", null, true);
            yield "\" class=\"form-control\">
        </div>
      </div>
      <div class=\"row mb-3\">
        <label for=\"text\" class=\"form-label col-2\">Message</label>
        <div class=\"col-8\">
          <div class=\"alert alert-danger\" id=\"error_text\"";
            // line 48
            if ( !($context["error_text"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Vous devez écrire quelque chose !</div>
          <textarea name=\"text\" id=\"text\" placeholder=\"Votre message\" required=\"required\" class=\"form-control\" rows=\"6\">";
            // line 49
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text"] ?? null), "html", null, true);
            yield "</textarea>
        </div>
      </div>
      <div class=\"row mb-3\">
        <div class=\"offset-2\">
          <input type=\"checkbox\" class=\"form-check-input\" id=\"mailing\" name=\"mailing\"";
            // line 54
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
            // line 60
            if ( !($context["error_check"] ?? null)) {
                yield " style=\"display: none\"";
            }
            yield ">Erreur à la vérification du code de sécurité</div>
          <input id=\"form-contact-submit\" data-check=\"";
            // line 61
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
  </div>";
        // line 70
        yield "
  <div class=\"col-md-4\">

    <h2>Adresse Postale</h2>
    <div>
      <strong>Association AD’HOC</strong><br>
      <address>9 impasse des tilleuls<br>
      91360 Épinay-sur-Orge</address>
    </div>

    <h2>Questions fréquentes</h2>
    ";
        // line 81
        if (($context["faq"] ?? null)) {
            // line 82
            yield "    <div class=\"reset\">
      ";
            // line 83
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["faq"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 84
                yield "      <div class=\"faq\">
        <h3 class=\"flex-row-reverse\">";
                // line 85
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "question", [], "any", false, false, false, 85), "html", null, true);
                yield " <i class=\"icon-arrow--right\"></i></h3>
        <p>";
                // line 86
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["f"], "answer", [], "any", false, false, false, 86), "html", null, true);
                yield "</p>
      </div>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['f'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 89
            yield "    </div>
    ";
        } else {
            // line 91
            yield "    <div>
      <p>Aucune questions fréquentes</p>
    </div>
    ";
        }
        // line 95
        yield "
    </div>";
        // line 97
        yield "  </div>";
        // line 98
        yield "</div>";
        // line 99
        yield "
";
        // line 100
        yield from $this->loadTemplate("common/footer.twig", "contact.twig", 100)->unwrap()->yield($context);
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
        return array (  231 => 100,  228 => 99,  226 => 98,  224 => 97,  221 => 95,  215 => 91,  211 => 89,  202 => 86,  198 => 85,  195 => 84,  191 => 83,  188 => 82,  186 => 81,  173 => 70,  170 => 68,  160 => 61,  154 => 60,  143 => 54,  135 => 49,  129 => 48,  120 => 42,  114 => 41,  105 => 35,  99 => 34,  90 => 28,  84 => 27,  78 => 23,  76 => 22,  73 => 21,  69 => 19,  67 => 18,  64 => 17,  55 => 10,  53 => 9,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "contact.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/contact.twig");
    }
}
