<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>{$title|escape}</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
{* début open graph *}
{if !empty($og_type)}
<meta property="og:type" content="{$og_type|escape}">
{else}
<meta property="og:type" content="article">
{/if}
{if $og_type !== 'video.movie' && $og_type !== 'website'}
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
<meta property="og:video:url" content="{$og_video.url}">
<meta property="og:video:secure_url" content="{$og_video.secure_url}">
<meta property="og:video:height" content="{$og_video.height}">
<meta property="og:video:width" content="{$og_video.width}">
<meta property="og:video:type" content="{$og_video.type}">
{/if}

{if !empty($og_image)}
<meta property="og:image" content="{$og_image}">
{/if}

{* fin open graph *}

<link rel="author" href="{#HOME_URL#}/humans.txt">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#292933">
<meta name="theme-color" content="#ffffff">

<meta name="robots" content="index,follow">
<meta name="description" content="{if empty($description)}Soutien des musiques actuelles en Essonne, agenda culturel, vidéos de concerts...{else}{$description|escape}{/if}">

{foreach $stylesheets as $style_url}
<link rel="stylesheet" href="{$style_url}">
{/foreach}

{foreach $header_scripts as $script_url}
<script src="{$script_url}"></script>
{/foreach}

</head>

<body>

{include file="common/header-menu.tpl"}

<div class="site_content clearfix">

<!--
<div class="alert alert--danger txtcenter"><a href="/onair">Suivez le direct du festival Les Pieds dans l'Orge #3 samedi 23 mai à 17h</a></div>
-->

{include file="common/breadcrumb.tpl"}
