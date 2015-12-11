<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>{$title|escape}</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
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
<link rel="stylesheet" href="/css/adhoc.css?v=20150909">
{if !empty($css_jquery_ui)}
<link rel="stylesheet" href="{#STATIC_URL#}/css/adhoc/jquery-ui-1.8.2.custom.css">
{/if}

{foreach from=$header_scripts item=script_url}
<script src="{$script_url}"></script>
{/foreach}

{if !empty($js_jquery_tools)}
<script src="{#STATIC_URL#}/js/jquery.tools.min.js"></script>
{/if}
{if !empty($swfobject)}
<script src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
{/if}
{if !empty($js_jquery_ui)}
<script src="{#STATIC_URL#}/js/jquery-ui-1.8.16.custom.min.js"></script>
{/if}
{if !empty($js_jquery_ui_datepicker)}
<script src="{#STATIC_URL#}/js/jquery-ui-datepicker-fr.js"></script>
{/if}
{if !empty($js_jquery_ui_timepicker)}
<script src="{#STATIC_URL#}/js/jquery-ui-timepicker-addon-0.5.min.js"></script>
{/if}
{if !empty($js_jquery_tablesorter)}
<script src="{#STATIC_URL#}/js/jquery.tablesorter.min.js"></script>
{/if}
{if !empty($js_gmap)}
<script src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&region=FR"></script>
{/if}

<script>
(function(i,s,o,g,r,a,m) { i['GoogleAnalyticsObject']=r;i[r]=i[r]||function() {
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-1420343-1', 'auto');
ga('send', 'pageview');
</script>

</head>

<body>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>
$(function () {

  window.fbAsyncInit = function() {

    FB.init({
      appId : '50959607741',
      xfbml : false,
      version : 'v2.5'
    });

    FB.getLoginStatus(function(response) {
      if (response.authResponse) {
        $('#fb-access-token').val(response.authResponse.accessToken);
      } else {
        // do something...maybe show a login prompt
      }
    });

    $('#ask_permissions').click(function () {
      FB.login(function(response) {
      },{
        perms: 'manage_pages'
      });
    });

  };

  window.___gcfg = { lang: 'fr' };

  (function() {
    var po = document.createElement('script'); po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();

});
</script>

<div id="conteneur" class="clearfix">

<div id="header" class="clearfix">
  <a id="logo" href="/" title="Cliquez pour revenir à l'accueil"><span>AD'HOC</span></a>
  <div id="megabanner">
  </div>
</div>

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

{if !empty($trail)}
<div class="breadCrumbHolder module">
  <div id="breadCrumb" class="breadCrumb module">
  {if ($trail|@count) > 1}
    <ul>
    {foreach from=$trail item=item name=breadcrumb}
      <li><a href="{$item.link|escape}">{$item.title|escape}</a></li>
    {/foreach}
    </ul>
  {/if}
  </div>
</div>
{/if}

</div>

<div id="main">
