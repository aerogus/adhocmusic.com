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

/* onair.twig */
class __TwigTemplate_a465deb7e12e7cb55f97cbdde01ef4c1 extends Template
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
        $this->loadTemplate("common/header.twig", "onair.twig", 1)->display($context);
        // line 2
        echo "
<div class=\"box\">
  <header>
    <h1>ON AIR</h1>
  </header>
  <div>
    <p>ici les live des émissions AD'HOC. prochaine émission : <strong>aucune émission prévue</strong></p>
    <div style=\"max-width:960px;margin:0 auto\">
      <div class=\"fluid-video-player ratio-16-9\">
        <video id=\"video\" style=\"background:url(/img/mire-tv.webp) no-repeat center center / cover\" controls></video>
      </div>
    </div>
    <p>Si le player ci-dessus ne marche pas, essayez  les urls suivantes :</p>
    <ul>
      <li><a href=\"https://live.adhocmusic.com/hls/onair.m3u8\">https://live.adhocmusic.com/hls/onair.m3u8</a></li>
      <li><a href=\"rtmp://live.adhocmusic.com/push/onair\">rtmp://live.adhocmusic.com/push/onair</a></li>
      <li><a href=\"https://www.facebook.com/adhocmusic/live\">https://www.facebook.com/adhocmusic/live</a></li>
    </ul>
  </div>
</div>

";
        // line 23
        $this->loadTemplate("common/footer.twig", "onair.twig", 23)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "onair.twig";
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
        return array (  62 => 23,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "onair.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/onair.twig");
    }
}
