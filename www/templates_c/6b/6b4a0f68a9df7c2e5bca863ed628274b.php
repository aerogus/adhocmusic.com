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

/* mentions-legales.twig */
class __TwigTemplate_8d7cdff5ded9b16f2859d764cf4a765a extends Template
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
        yield from $this->loadTemplate("common/header.twig", "mentions-legales.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
<div class=\"container\">
  <h1>Mentions Légales</h1>
  <h2>L'Association</h3>
  <p>
  Le site <strong>adhocmusic.com</strong> est édité par <strong>AD'HOC</strong>,
  Association loi 1901 à but non lucratif basée à Épinay-sur-Orge. Le directeur de la publication est Martin Pham Van en sa qualité de président.
  </p>
  <h2>Hébergement</h2>
  <p>
  Le site adhocmusic.com est hébergé par la société <strong>OVH</strong>,<br>
  SAS au capital de 5 000 000 € RCS Roubaix – Tourcoing 424 761 419 00045<br>
  Code APE 6202A - N° TVA : FR 22 424 761 419<br>
  Siège social : 2 rue Kellermann 59100 Roubaix - France.
  </p>
  <h2>Respect de la législation \"Informatiques et libertés\"</h2>
  <p>
  Le site <strong>adhocmusic.com</strong> est déclaré à la C.N.I.L. sous le n° 838403.<br>
  Loi informatique et libertés du 6 janvier 1978.<br>
  Pour toute rectification et accès aux données personnelles, utilisez notre <a href=\"/contact\">formulaire de contact</a>.
  </p>
  <h2>Droit à l'image</h2>
  <p>
  Le site héberge des photos de manifestations publiques musicales, vous pouvez <a href=\"/contact\">nous contacter</a> pour toute demande de mise hors ligne.
  </p>
  <h2>Propriété intellectuelle</h2>
  <p>
  Le site héberge des musiques d'artistes qui ont fait une démarche active de diffusion de leurs oeuvres
  et propose un système de streaming. Le téléchargement des oeuvres n'est pas autorisé.
  </p>
</div>

";
        // line 34
        yield from $this->loadTemplate("common/footer.twig", "mentions-legales.twig", 34)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "mentions-legales.twig";
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
        return array (  78 => 34,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "mentions-legales.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/mentions-legales.twig");
    }
}
