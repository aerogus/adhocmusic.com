<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>{$title|escape}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="fb:app_id" content="{$fb_app_id|escape}">
{* début open graph *}
{if !empty($og_type)}
<meta property="og:type" content="{$og_type|escape}">
{else}
<meta property="og:type" content="article">
{/if}
{if $og_type != 'video.movie' && $og_type != 'website'}
<meta property="fb:page_id" content="{$fb_page_id}">
<meta property="og:language" content="fr">
<meta property="og:author" content="adhocmusic">
{/if}
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="adhocmusic.com">
<meta property="og:title" content="{$title|escape}">
<meta property="og:url" content="http://www.adhocmusic.com{$uri}">
<meta property="og:description" content="{if empty($description)}Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...{else}{$description|escape}{/if}">

{if !empty($og_audio)}
<meta property="og:audio" content="{$og_audio.url}">
<meta property="og:audio:secure_url" content="{$og_audio.url}">
<meta property="og:audio:title" content="{$og_audio.title|escape}">
<meta property="og:audio:artist" content="{$og_audio.artist|escape}">
<meta property="og:audio:type" content="{$og_audio.type}">
{/if}

{if !empty($og_video)}
<meta property="og:video" content="{$og_video.url}">
<meta property="og:video:height" content="{$og_video.height}">
<meta property="og:video:width" content="{$og_video.width}">
<meta property="og:video:type" content="{$og_video.type}">
{/if}

{if !empty($og_image)}
<meta property="og:image" content="{$og_image}">
{/if}

{* fin open graph *}

<link rel="author" href="http://www.adhocmusic.com/humans.txt">
<link rel="shortcut icon" href="http://www.adhocmusic.com/favicon.ico">
<meta name="robots" content="index,follow">
<meta name="description" content="{if empty($description)}Portail de référence sur les musiques actuelles en Essonne, Agenda culturel géolocalisé, Vidéos de concerts, promotion d'artistes ...{else}{$description|escape}{/if}">

{foreach from=$stylesheets item=style_url}
<link rel="stylesheet" href="{$style_url}">
{/foreach}

{if !empty($css_jquery_ui)}
<link rel="stylesheet" href="/css/adhoc/jquery-ui-1.8.2.custom.css">
{/if}

{foreach from=$header_scripts item=script_url}
<script src="{$script_url}"></script>
{/foreach}

{if !empty($js_jquery_tools)}
<script src="/js/jquery.tools.min.js"></script>
{/if}
{if !empty($swfobject)}
<script src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
{/if}
{if !empty($js_jquery_ui)}
<script src="/js/jquery-ui-1.8.16.custom.min.js"></script>
{/if}
{if !empty($js_jquery_ui_datepicker)}
<script src="/js/jquery-ui-datepicker-fr.js"></script>
{/if}
{if !empty($js_jquery_ui_timepicker)}
<script src="/js/jquery-ui-timepicker-addon-0.5.min.js"></script>
{/if}
{if !empty($js_jquery_tablesorter)}
<script src="/js/jquery.tablesorter.min.js"></script>
{/if}
{if !empty($js_gmap)}
<script src="https://maps.google.com/maps/api/js?libraries=geometry&region=FR"></script>
{/if}

</head>

<body>

<header class="clearfix">
  <a id="logo" href="/" title="Cliquez pour revenir à l'accueil"><span>AD'HOC</span></a>
</header>

<div id="menu-wrapper">

{include file="common/menu.tpl" menuselected=$menuselected}

<div id="boxlogin-outter">
  {if empty($is_auth)}
  <span><a href="/auth/login">Connexion</a></span>
  {else}
  <span><a href="/membres/tableau-de-bord">Tableau de bord</a></span>
  {/if}
  <div id="boxlogin-inner" style="display: none;">
  {include file="common/boxlogin.tpl"}
  </div>
</div>

</div>{* #menu-wrapper *}

{* file d'ariane *}
{if !empty($trail) && ($trail|@count) > 1}
<div class="breadcrumb">
  <ul>
    {foreach from=$trail item=item name=breadcrumb}
      {if !empty($item.link)}
      <li><a href="{$item.link|escape}">{$item.title|escape}</a></li>
      {else}
      <li><span>{$item.title|escape}</span></li>
      {/if}
    {/foreach}
  </ul>
</div>
{/if}

<div class="site_content clearfix">
