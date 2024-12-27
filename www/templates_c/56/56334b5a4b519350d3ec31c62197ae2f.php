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

/* common/header.twig */
class __TwigTemplate_19b91daeb4a00022354d01bbc39e45f1 extends Template
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
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
<meta charset=\"utf-8\">
<title>";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "</title>
<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">

";
        // line 9
        if (($context["og_type"] ?? null)) {
            // line 10
            yield "<meta property=\"og:type\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["og_type"] ?? null), "html", null, true);
            yield "\">
";
            // line 11
            if (((($context["og_type"] ?? null) != "video.movie") && (($context["og_type"] ?? null) != "website"))) {
                // line 12
                yield "<meta property=\"og:language\" content=\"fr\">
<meta property=\"og:author\" content=\"adhocmusic\">
";
            }
        } else {
            // line 16
            yield "<meta property=\"og:type\" content=\"article\">
";
        }
        // line 18
        yield "
<meta property=\"og:locale\" content=\"fr_FR\">
<meta property=\"og:site_name\" content=\"adhocmusic.com\">
<meta property=\"og:title\" content=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "\">
<meta property=\"og:url\" content=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["url"] ?? null), "html", null, true);
        yield "\">
<meta property=\"og:description\" content=\"";
        // line 23
        if ( !($context["description"] ?? null)) {
            yield "Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...";
        } else {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        }
        yield "\">

";
        // line 25
        if (($context["og_audio"] ?? null)) {
            // line 26
            yield "<meta property=\"og:audio\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_audio"] ?? null), "url", [], "any", false, false, false, 26), "html", null, true);
            yield "\">
<meta property=\"og:audio:secure_url\" content=\"";
            // line 27
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_audio"] ?? null), "url", [], "any", false, false, false, 27), "html", null, true);
            yield "\">
<meta property=\"og:audio:title\" content=\"";
            // line 28
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_audio"] ?? null), "title", [], "any", false, false, false, 28), "html", null, true);
            yield "\">
<meta property=\"og:audio:artist\" content=\"";
            // line 29
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_audio"] ?? null), "artist", [], "any", false, false, false, 29), "html", null, true);
            yield "\">
<meta property=\"og:audio:type\" content=\"";
            // line 30
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_audio"] ?? null), "type", [], "any", false, false, false, 30), "html", null, true);
            yield "\">
";
        }
        // line 32
        yield "
";
        // line 33
        if (($context["og_video"] ?? null)) {
            // line 34
            yield "<meta property=\"og:video:url\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_video"] ?? null), "url", [], "any", false, false, false, 34), "html", null, true);
            yield "\">
<meta property=\"og:video:secure_url\" content=\"";
            // line 35
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_video"] ?? null), "secure_url", [], "any", false, false, false, 35), "html", null, true);
            yield "\">
<meta property=\"og:video:height\" content=\"";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_video"] ?? null), "height", [], "any", false, false, false, 36), "html", null, true);
            yield "\">
<meta property=\"og:video:width\" content=\"";
            // line 37
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_video"] ?? null), "width", [], "any", false, false, false, 37), "html", null, true);
            yield "\">
<meta property=\"og:video:type\" content=\"";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["og_video"] ?? null), "type", [], "any", false, false, false, 38), "html", null, true);
            yield "\">
";
        }
        // line 40
        yield "
";
        // line 41
        if (($context["og_image"] ?? null)) {
            // line 42
            yield "<meta property=\"og:image\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["og_image"] ?? null), "html", null, true);
            yield "\">
";
        }
        // line 44
        yield "
";
        // line 46
        yield "
<link rel=\"author\" href=\"";
        // line 47
        yield "/humans.txt\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"/apple-touch-icon.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"/favicon-32x32.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"/favicon-16x16.png\">
<link rel=\"manifest\" href=\"/site.webmanifest\">
<link rel=\"mask-icon\" href=\"/safari-pinned-tab.svg\" color=\"#5bbad5\">
<meta name=\"msapplication-TileColor\" content=\"#292933\">
<meta name=\"theme-color\" content=\"#ffffff\">

<meta name=\"robots\" content=\"";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["robots"] ?? null), "html", null, true);
        yield "\">
<meta name=\"description\" content=\"";
        // line 57
        if ( !($context["description"] ?? null)) {
            yield "Soutien des musiques actuelles en Essonne, agenda culturel, vidéos de concerts...";
        } else {
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null), "html", null, true);
        }
        yield "\">

";
        // line 59
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["stylesheets"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["style_url"]) {
            // line 60
            yield "<link rel=\"stylesheet\" href=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["style_url"], "html", null, true);
            yield "\">
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['style_url'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        yield "
";
        // line 63
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["header_scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script_url"]) {
            // line 64
            yield "<script src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["script_url"], "html", null, true);
            yield "\"></script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['script_url'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 66
        yield "
</head>

<body>

";
        // line 71
        yield from $this->loadTemplate("common/header-menu.twig", "common/header.twig", 71)->unwrap()->yield($context);
        // line 72
        yield "
";
        // line 73
        yield from $this->loadTemplate("common/breadcrumb.twig", "common/header.twig", 73)->unwrap()->yield($context);
        // line 74
        yield "
<div class=\"\">
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "common/header.twig";
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
        return array (  230 => 74,  228 => 73,  225 => 72,  223 => 71,  216 => 66,  207 => 64,  203 => 63,  200 => 62,  191 => 60,  187 => 59,  178 => 57,  174 => 56,  163 => 47,  160 => 46,  157 => 44,  151 => 42,  149 => 41,  146 => 40,  141 => 38,  137 => 37,  133 => 36,  129 => 35,  124 => 34,  122 => 33,  119 => 32,  114 => 30,  110 => 29,  106 => 28,  102 => 27,  97 => 26,  95 => 25,  86 => 23,  82 => 22,  78 => 21,  73 => 18,  69 => 16,  63 => 12,  61 => 11,  56 => 10,  54 => 9,  48 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "common/header.twig", "/var/www/docker.adhocmusic.com/www/views_bs/common/header.twig");
    }
}
