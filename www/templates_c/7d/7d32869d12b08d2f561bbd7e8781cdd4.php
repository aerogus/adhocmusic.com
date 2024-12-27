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

/* assoce/afterworks.twig */
class __TwigTemplate_0b51b1c44efcc8e348ccef26e1cfcbdd extends Template
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
        yield from         $this->loadTemplate("common/header.twig", "assoce/afterworks.twig", 1)->unwrap()->yield($context);
        // line 2
        yield "
  <div class=\"box\">
    <header>
      <h1>Les afterworks</h1>
    </header>
    <div>
      <div class=\"edito\">
        <p>Depuis 2015, AD’HOC propose un rendez-vous musical à Épinay-sur-Orge: les <em>Afterworks</em>. Ils se déroulent un vendredi soir par mois dans les salles annexes du parc de la mairie d’Épinay-sur-Orge de 19h30 à 22h30. Des artistes sont invités à se produire pour un set acoustique.</p>
       <p>Si le cœur vous en dit, apportez vos instruments et venez jouer avec eux avant ou après leur set pour une jam session. Non musiciens,     vous êtes aussi les bienvenus, ces afterworks sont avant tout un prétexte pour se retrouver régulièrement dans une ambiance cosy et conviviale.     Apportez votre paquet de chips, votre bouteille de jus de fruits préféré et vous êtes avec nous pour une soirée détente après une dure semaine     de boulot.</p>
      </div>
      <div class=\"fluid-video-player ratio-16-9\">
        <iframe sandbox=\"allow-same-origin allow-scripts\" src=\"https://videos.adhocmusic.com/videos/embed/480852e4-78ba-4ec0-935b-cd55cf069216?title=0&amp;warningTitle=0\" frameborder=\"0\" allowfullscreen></iframe>
      </div>

      <h2>Saison #5 (2019/2020)</h2>

      <ol class=\"episodes\">
        <li><a href=\"/events/6871\">S5E1 - 27 septembre 2019</a></li>
        <li><a href=\"/events/6872\">S5E2 - 18 octobre 2019</a></li>
        <li><a href=\"/events/6873\">S5E3 - 29 novembre 2019</a></li>
        <li><a href=\"/events/6874\">S5E4 - 20 décembre 2019</a></li>
        <li><a href=\"/events/6875\">S5E5 - 28 février 2020</a></li>
        <li><a href=\"/events/6876\">S5E6 - 1er mai 2020 - version confinée En ligne</a></li>
      </ol>

      <div class=\"fluid-video-player ratio-16-9 mbm\">
        <iframe sandbox=\"allow-same-origin allow-scripts\" src=\"https://videos.adhocmusic.com/videos/embed/f3ed5408-c590-4a4f-8d40-186e176b4db3?title=0&amp;warningTitle=0\" frameborder=\"0\" allowfullscreen></iframe>
      </div>

      <h2>Saison #4 (2018/2019)</h2>
      <ol class=\"episodes\">
        <li><a href=\"\">19 octobre 2018</a></li>
        <li><a href=\"\">30 novembre 2018</a></li>
        <li><a href=\"\">21 décembre 2018</a></li>
        <li><a href=\"\">22 février 2019</a></li>
        <li><a href=\"\">22 mars 2019</a></li>
        <li><a href=\"\">19 avril 2019</a></li>
      </ol>

      <h2>Saison #3 (2017/2018)</h2>
      <ol class=\"episodes\">
        <li><a href=\"\">20 octobre 2017</a></li>
        <li><a href=\"\">24 novembre 2017</a></li>
        <li><a href=\"\">22 décembre 2017</a></li>
        <li><a href=\"\">26 janvier 2017</a></li>
        <li><a href=\"\">16 février 2018</a></li>
        <li><a href=\"\">16 mars 2018</a></li>
        <li><a href=\"\">13 avril 2018</a></li>
      </ol>

      <h2>Saison #2 (2016/2017)</h2>
      <ol class=\"episodes\">
        <li><a href=\"\">25 novembre 2016</a> avec Wilky Way Attitude + Nikki Lore <br>https://www.facebook.com/events/1658090021148953/</li>
        <li><a href=\"\">16 décembre 2016</a> avec SO’N<br>https://www.facebook.com/events/1057931160993773/</li>
        <li><a href=\"\">24 février 2017</a> avec Joolsy + Trep1<br>https://www.facebook.com/events/1653787128267635/</li>
        <li><a href=\"\">24 mars 2017</a> avec Special Guest<br>https://www.facebook.com/events/330054137362210/</li>
        <li><a href=\"\">23 juin 2017</a></li>
      </ol>

      <h2>Saison #1 (2015/2016)</h2>
      <ol class=\"episodes\">
        <li><a href=\"\">16 octobre 2015</a> avec Plug-in<br>https://www.facebook.com/events/1477030929271884/</li>
        <li><a href=\"\">27 novembre 2015</a> avec Nikki Lore<br>https://www.facebook.com/events/1509764076016034/</li>
        <li><a href=\"\">18 décembre 2015</a> avec Former Life + Mess Factory<br>https://www.facebook.com/events/1072938009417195/</li>
        <li><a href=\"\">29 janvier 2016</a> avec Doctor Fruit<br>https://www.facebook.com/events/1677331702549980/</li>
        <li><a href=\"\">19 février 2016</a> avec la Troupe des Zicos<br>https://www.facebook.com/events/118856268476132/</li>
        <li><a href=\"\">15 avril 2016</a> avec les groupes du Fet’Estival<br>https://www.facebook.com/events/1658795981065217/</li>
        <li><a href=\"\">17 juin 2016</a> avec Special Guest<br>https://www.facebook.com/events/839700286143378/</li>
      </ol>

    </div>

  </div>

";
        // line 76
        yield from         $this->loadTemplate("common/footer.twig", "assoce/afterworks.twig", 76)->unwrap()->yield($context);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "assoce/afterworks.twig";
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
        return array (  120 => 76,  44 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "assoce/afterworks.twig", "/var/www/docker.adhocmusic.com/app/twig/assoce/afterworks.twig");
    }
}
