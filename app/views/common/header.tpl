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
{if $og_type !== 'video.movie' && $og_type !== 'website'}
<meta property="fb:page_id" content="{$fb_page_id}">
<meta property="og:language" content="fr">
<meta property="og:author" content="adhocmusic">
{/if}
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="adhocmusic.com">
<meta property="og:title" content="{$title|escape}">
<meta property="og:url" content="{$url}">
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

<link rel="author" href="{#HOME_URL#}/humans.txt">
<link rel="shortcut icon" href="{#HOME_URL#}/favicon.ico">
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

</head>

<body>

{include file="common/menu-top.tpl"}

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
