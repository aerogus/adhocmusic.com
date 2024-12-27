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

/* common/footer-menu.twig */
class __TwigTemplate_c356130e08aade33c33533d09560608c extends Template
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
        yield "<footer class=\"bg-dark\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-3\">
        <ul class=\"list-unstyled\">
          <li><h4>Qui sommes-nous ?</h4></li>
          <li><a href=\"/assoce\">L’association</a></li>
          <li><a href=\"/equipe\">L’équipe</a></li>
          <li><a href=\"/mentions-legales\">Mentions légales</a></li>
          <li><a href=\"/credits\">Crédits</a></li>
        </ul>
      </div>
      <div class=\"col-3\">
        <ul class=\"list-unstyled\">
          <li><h4>Nos évènements</h4></li>
          <li><a href=\"/concerts\">Concerts</a></li>
          <li><a href=\"/afterworks\">Afterworks</a></li>
          <li><a href=\"/festival\">Le Festival</a></li>
        </ul>
      </div>
      <div class=\"col-3\">
        <ul class=\"list-unstyled\">
          <li><h4>Suivez nous</h4></li>
          <li class=\"email\"><a href=\"/newsletters/subscriptions\" title=\"Abonnement à la newsletter\">Newsletter</a></li>
          <li class=\"peertube\"><a href=\"https://videos.adhocmusic.com\" title=\"Instance PeerTube AD'HOC Tube\">PeerTube</a></li>
          <li class=\"facebook\"><a href=\"https://facebook.com/adhocmusic\" title=\"@adhocmusic sur Facebook\">@adhocmusic</a></li>
          <li class=\"instagram\"><a href=\"https://instagram.com/adhoc.music\" title=\"@adhoc.music sur Instagram\">@adhoc.music</a></li>          
          <li class=\"x\"><a href=\"https://x.com/adhocmusic\" title=\"@adhocmusic sur X\">@adhocmusic</a></li>
        </ul>
      </div>
      <div class=\"col-3\">
        <ul class=\"list-unstyled\">
          <li><h4>Contact</h4></li>
          <li><a href=\"/contact\">Contactez-nous</a></li>
          <li><a href=\"/partners\">Partenaires</a></li>
          <li><a href=\"/map\">Plan du site</a></li>
          <li><a href=\"https://github.com/aerogus/adhocmusic.com\">Code source</a></li>
        </ul>
      </div>
    </div>
    <p class=\"text-center fst-italic\">Association loi 1901 à but non lucratif œuvrant pour le développement des musiques actuelles à <a href=\"https://www.ville-epinay-sur-orge.fr\">Épinay-sur-Orge</a> depuis 1996</p>
  </div>
</footer>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "common/footer-menu.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/footer-menu.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/common/footer-menu.twig");
    }
}
