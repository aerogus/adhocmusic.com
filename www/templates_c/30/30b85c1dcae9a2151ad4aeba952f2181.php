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

/* common/header.twig */
class __TwigTemplate_008dffa72c3f7f0121d2e47c443c79e2 extends Template
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
        echo "<!DOCTYPE html>
<html lang=\"fr\">
<head>
<meta charset=\"utf-8\">
<title>";
        // line 5
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">

";
        // line 9
        if (($context["og_type"] ?? null)) {
            // line 10
            echo "<meta property=\"og:type\" content=\"";
            echo twig_escape_filter($this->env, ($context["og_type"] ?? null), "html", null, true);
            echo "\">
";
            // line 11
            if (((($context["og_type"] ?? null) != "video.movie") && (($context["og_type"] ?? null) != "website"))) {
                // line 12
                echo "<meta property=\"og:language\" content=\"fr\">
<meta property=\"og:author\" content=\"adhocmusic\">
";
            }
        } else {
            // line 16
            echo "<meta property=\"og:type\" content=\"article\">
";
        }
        // line 18
        echo "
<meta property=\"og:locale\" content=\"fr_FR\">
<meta property=\"og:site_name\" content=\"adhocmusic.com\">
<meta property=\"og:title\" content=\"";
        // line 21
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "\">
<meta property=\"og:url\" content=\"";
        // line 22
        echo twig_escape_filter($this->env, ($context["url"] ?? null), "html", null, true);
        echo "\">
<meta property=\"og:description\" content=\"";
        // line 23
        if ( !($context["description"] ?? null)) {
            echo "Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...";
        } else {
            echo twig_escape_filter($this->env, ($context["description"] ?? null), "html", null, true);
        }
        echo "\">

";
        // line 25
        if (($context["og_audio"] ?? null)) {
            // line 26
            echo "<meta property=\"og:audio\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_audio"] ?? null), "url", [], "any", false, false, false, 26), "html", null, true);
            echo "\">
<meta property=\"og:audio:secure_url\" content=\"";
            // line 27
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_audio"] ?? null), "url", [], "any", false, false, false, 27), "html", null, true);
            echo "\">
<meta property=\"og:audio:title\" content=\"";
            // line 28
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_audio"] ?? null), "title", [], "any", false, false, false, 28), "html", null, true);
            echo "\">
<meta property=\"og:audio:artist\" content=\"";
            // line 29
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_audio"] ?? null), "artist", [], "any", false, false, false, 29), "html", null, true);
            echo "\">
<meta property=\"og:audio:type\" content=\"";
            // line 30
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_audio"] ?? null), "type", [], "any", false, false, false, 30), "html", null, true);
            echo "\">
";
        }
        // line 32
        echo "
";
        // line 33
        if (($context["og_video"] ?? null)) {
            // line 34
            echo "<meta property=\"og:video:url\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_video"] ?? null), "url", [], "any", false, false, false, 34), "html", null, true);
            echo "\">
<meta property=\"og:video:secure_url\" content=\"";
            // line 35
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_video"] ?? null), "secure_url", [], "any", false, false, false, 35), "html", null, true);
            echo "\">
<meta property=\"og:video:height\" content=\"";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_video"] ?? null), "height ", [], "any", false, false, false, 36), "html", null, true);
            echo "\">
<meta property=\"og:video:width\" content=\"";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_video"] ?? null), "width", [], "any", false, false, false, 37), "html", null, true);
            echo "\">
<meta property=\"og:video:type\" content=\"";
            // line 38
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["og_video"] ?? null), "type", [], "any", false, false, false, 38), "html", null, true);
            echo "\">
";
        }
        // line 40
        echo "
";
        // line 41
        if (($context["og_image"] ?? null)) {
            // line 42
            echo "<meta property=\"og:image\" content=\"";
            echo twig_escape_filter($this->env, ($context["og_image"] ?? null), "html", null, true);
            echo "\">
";
        }
        // line 44
        echo "
";
        // line 46
        echo "
<link rel=\"author\" href=\"";
        // line 47
        echo "/humans.txt\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"/apple-touch-icon.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"/favicon-32x32.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"/favicon-16x16.png\">
<link rel=\"manifest\" href=\"/site.webmanifest\">
<link rel=\"mask-icon\" href=\"/safari-pinned-tab.svg\" color=\"#5bbad5\">
<meta name=\"msapplication-TileColor\" content=\"#292933\">
<meta name=\"theme-color\" content=\"#ffffff\">

<meta name=\"robots\" content=\"";
        // line 56
        echo twig_escape_filter($this->env, ($context["robots"] ?? null), "html", null, true);
        echo "\">
<meta name=\"description\" content=\"";
        // line 57
        if ( !($context["description"] ?? null)) {
            echo "Soutien des musiques actuelles en Essonne, agenda culturel, vidéos de concerts...";
        } else {
            echo twig_escape_filter($this->env, ($context["description"] ?? null), "html", null, true);
        }
        echo "\">

";
        // line 59
        if (($context["stylesheets"] ?? null)) {
            // line 60
            echo "  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["stylesheets"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["style_url"]) {
                // line 61
                echo "  <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $context["style_url"], "html", null, true);
                echo "\">
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['style_url'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 64
        echo "
";
        // line 65
        if (($context["header_scripts"] ?? null)) {
            // line 66
            echo "  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["header_scripts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["script_url"]) {
                // line 67
                echo "  <script src=\"";
                echo twig_escape_filter($this->env, $context["script_url"], "html", null, true);
                echo "\"></script>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script_url'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 70
        echo "
</head>

<body>

";
        // line 75
        $this->loadTemplate("common/header-menu.twig", "common/header.twig", 75)->display($context);
        // line 76
        echo "
<div class=\"site_content clearfix\">

<!--
<div class=\"alert alert--danger txtcenter\"><a href=\"/onair\">Suivez le direct du festival Les Pieds dans l'Orge #3 samedi 23 mai à 17h</a></div>
-->

";
        // line 83
        $this->loadTemplate("common/breadcrumb.twig", "common/header.twig", 83)->display($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "common/header.twig";
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
        return array (  237 => 83,  228 => 76,  226 => 75,  219 => 70,  209 => 67,  204 => 66,  202 => 65,  199 => 64,  189 => 61,  184 => 60,  182 => 59,  173 => 57,  169 => 56,  158 => 47,  155 => 46,  152 => 44,  146 => 42,  144 => 41,  141 => 40,  136 => 38,  132 => 37,  128 => 36,  124 => 35,  119 => 34,  117 => 33,  114 => 32,  109 => 30,  105 => 29,  101 => 28,  97 => 27,  92 => 26,  90 => 25,  81 => 23,  77 => 22,  73 => 21,  68 => 18,  64 => 16,  58 => 12,  56 => 11,  51 => 10,  49 => 9,  43 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/header.twig", "/Users/gus/workspace-perso/adhocmusic.com/app/twig/common/header.twig");
    }
}
