{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Hébergement</h1>
  </header>
  <div>
    <p>Créée en 2000, AD'HOC est une association loi 1901 basée à Epinay-sur-Orge (91) ayant pour objet l'organisation de concerts musiques actuelles dans le département de l'Essonne. Présente sur le net dès 2001 avec le site adhocmusic.com, l'association développe depuis 2009 un pôle création, hébergement et maintenance de sites artistiques. Les sites hébergés sur notre serveur créent ainsi le "réseau AD'HOC".</p>
  </div>
</div>

<div class="grid-3-small-2-tiny-1">
  {foreach from=$sites item=site}
  <div class="box thumbs">
    <header>
    <h2><a href="{$site.url}">{$site.title}</a></h2>
    </header>
    <div>
      <p align="center"><a href="{$site.url}"><img src="{$site.image}" alt="{$site.name}"></a></p>
      <p class="description">{$site.description}</p>
    </div>
  </div>
  {/foreach}
</div>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
