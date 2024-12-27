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

/* assoce/festival.twig */
class __TwigTemplate_8f272c8bffd417300af1f206040e4461 extends Template
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
        yield from $this->loadTemplate("common/header.twig", "assoce/festival.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"container\">
    <div class=\"mb-3\">
      <h1 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Les Pieds dans l’Orge, le festival</h1>
      <div class=\"border rounded-bottom bg-white p-3\">
        <p>Le Festival les Pieds dans l’Orge a vu le jour en 2018 et est l’apogée de la saison de l’association. Sur deux scènes installées au parking du Breuil à Épinay-sur-Orge, plus d’une dizaine de groupes défilent au cours d’une soirée, permettant au public curieux de découvrir les nombreux talents de la région. Un village associatif permet au public de découvrir des artistes de tout genre (peinture, sculpture, photo...) mais aussi de se sustenter (buvette, foodtruck).</p>
        <p>Le mini site dédié: <a class=\"btn btn-primary\" href=\"https://lespiedsdanslorge.org\">https://lespiedsdanslorge.org</a></p>
      </div>
    </div>
    <div class=\"row\">
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2025</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <p>En préparation</p>
        </div>
      </div>
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2024</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <p><a href=\"https://lespiedsdanslorge.org/?year=2024\">https://lespiedsdanslorge.org/?year=2024</a></p>
        </div>
      </div>
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2023</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <p><a href=\"https://lespiedsdanslorge.org/?year=2023\">https://lespiedsdanslorge.org/?year=2023</a></p>
        </div>
      </div>
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2020</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <div class=\"fluid-video-player ratio-16-9 mb-3\">
            <iframe sandbox=\"allow-same-origin allow-scripts\" src=\"https://videos.adhocmusic.com/videos/embed/03376b09-ab14-426e-ace0-b8e8bfa59087?title=0&amp;warningTitle=0\" frameborder=\"0\" allowfullscreen></iframe>
          </div>
          <p>Suite à la crise du covid-19, le festival n'a pas pu avoir lieu en plein air comme prévu. L’équipe AD’HOC a toutefois souhaité proposer une émission en direct avec quelques groupes locaux pour des prestations live et des interviews. Voici donc 4 heures de musique live !</p>
        </div>
      </div>
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2019</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <div class=\"fluid-video-player ratio-16-9 mb-3\">
            <iframe sandbox=\"allow-same-origin allow-scripts\" src=\"https://videos.adhocmusic.com/videos/embed/0c20e037-b7a5-42c7-bf94-4a91755edcd8?title=0&amp;warningTitle=0\" frameborder=\"0\" allowfullscreen></iframe>
          </div>
          <p>Une seconde édition à 11 groupes du 2 scènes, un foodtruck avec des glaces délicieuses, un mur de graf, une bassine à bulles, du soleil et 120L de bière de Marcoussis écoulés</p>
        </div>
      </div>
      <div class=\"col-md-4 mb-3\">
        <h2 class=\"px-2 py-1 mb-0 bg-dark text-white rounded-top\">Édition 2018</h2>
        <div class=\"border rounded-bottom bg-white p-3\">
          <div class=\"fluid-video-player ratio-16-9 mb-3\">
            <iframe sandbox=\"allow-same-origin allow-scripts\" src=\"https://videos.adhocmusic.com/videos/embed/c3c8daa4-2c52-4151-aae0-517263385c65?title=0&amp;warningTitle=0\" frameborder=\"0\" allowfullscreen></iframe>
          </div>
          <p>Après une première annulation en 2016 pour cause d'état d'urgence, AD'HOC a enfin pu organiser la 1ère édition de son festival en plein air.</p>
        </div>
      </div>
    </div>
  </div>

";
        // line 60
        yield from $this->loadTemplate("common/footer.twig", "assoce/festival.twig", 60)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "assoce/festival.twig";
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
        return array (  104 => 60,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "assoce/festival.twig", "/var/www/docker.adhocmusic.com/app/twig_bs/assoce/festival.twig");
    }
}
