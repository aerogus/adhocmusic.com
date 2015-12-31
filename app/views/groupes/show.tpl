{include file="common/header.tpl"}

{if !empty($unknown_group)}

<p class="error">Ce groupe est introuvable !</p>

{else}

<div class="grid-2-small-1-tiny-1">

<div>

<div class="box">
  <header>
    <h1>{$groupe->getName()}</h1>
  </header>
  <div>
    {if $groupe->getLogo()}
    <p align="center"><img src="{$groupe->getLogo()}" alt="{$groupe->getName()|escape}"></p>
    {/if}
    {if $groupe->getStyle()}
    <p><strong>Style</strong><br />{$groupe->getStyle()|escape}</p>
    {/if}
    {if $groupe->getInfluences()}
    <p><strong>Influences</strong><br />{$groupe->getInfluences()|escape}</p>
    {/if}
    {if $groupe->getLineup()}
    <p><strong>Membres</strong><br />{$groupe->getLineup()|escape|@nl2br}</p>
    {/if}
    <p><strong>Dont membres AD'HOC</strong></p>
    {if $membres|@count > 0}
    <ul>
    {foreach from=$membres item=membre}
    <li><a href="/membres/show/{$membre.id}">{$membre.pseudo|escape}</a> ({$membre.nom_type_musicien|escape})</li>
    {/foreach}
    </ul>
    {else}
    <p class="warning">Aucun! Vous faites partie de ce groupe ? <a href="/contact">contactez nous</a></p>
    {/if}

    <style>
    #grplinks {
        clear: both;
    }
    #grplinks li {
        float: left;
    }
    #grplinks li {
        margin: 10px 3px;
        padding: 5px;
        background-color: #ececec;
        float: left;
    }
    #grplinks a {
        text-decoration: none !important;
    }
    #grplinks li:hover {
        background-color: #f9f9f9;
    }
    #grplinks img {
        padding-right: 5px;
        width: 16px;
        height: 16px;
    }
    </style>

    <p><strong>Liens</strong></p>
    <ul id="grplinks">
    {if $groupe->getSite()}
    <li><a class="grplink" href="{$groupe->getSite()}" title="Site"><img src="{#STATIC_URL#}/img/icones/lien.png" alt="">Site</a></li>
    {/if}
    {if $groupe->getMySpace()}
    <li><a class="grplink" href="{$groupe->getMySpace()}" title="MySpace"><img src="{#STATIC_URL#}/img/myspace.png" alt="">MySpace</a></li>
    {/if}
    {if $groupe->getFacebookPageId()}
    <li><a class="grplink" href="{$groupe->getFacebookPageUrl()}" title="Facebook"><img src="{#STATIC_URL#}/img/facebook.gif" alt="">Facebook</a></li>
    {/if}
    {if $groupe->getTwitterId()}
    <li><a class="grplink" href="{$groupe->getTwitterUrl()}" title="Twitter"><img src="{#STATIC_URL#}/img/icones/twitter.png" alt="">Twitter</a></li>
    {/if}
    </ul>
    {if $groupe->getCreatedOn()}
    <p><strong>Fiche créée le</strong><br />{$groupe->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
    {/if}
    {if $groupe->getModifiedOn()}
    <p><strong>Mise à jour le</strong><br />{$groupe->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
    {/if}
  </div>
</div>

{if $videos|@count > 0}
{include file="common/boxstart.tpl" boxtitle="Vidéos"}
<div class="clearfix">
{foreach from=$videos item=video}
<div class="thumb-80">
  <a href="{$video.url}" title="{$video.name|escape}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}" />{$video.name|truncate:15:"...":true:true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video.url}" title="{$video.name|escape}"></a>
</div>
{/foreach}
</div>
{if !empty($is_loggued)}
<a href="/videos/create?id_groupe={$groupe->getId()}">Ajouter une vidéo</a>
{/if}
{include file="common/boxend.tpl"}
{/if}

{if $audios|@count > 0}
{include file="common/boxstart.tpl" boxtitle="En Ecoute"}
<div style="background: url({#STATIC_URL#}/img/player_adhoc.png); width: 360px; height: 218px; position: relative; margin: 0 auto;">
  <img src="{$groupe->getMiniPhoto()}" alt="" style="position: absolute; top: 28px; left: 14px;" />
  <div style="position: absolute; top: 27px; left: 90px;">{audio_player id=$groupe->getId() type='player_mp3_multi'}</div>
</div>
{include file="common/boxend.tpl"}
{/if}

</div>
<div>

{include file="common/boxstart.tpl" boxtitle="Présentation"}

{if $groupe->getPhoto()}
<center><img src="{$groupe->getPhoto()}" alt="{$groupe->getName()|escape}" title="{$groupe->getName()|escape}" /></center>
{/if}

<p align="justify">{$groupe->getText()|nl2br}</p>

{include file="comments/share.tpl" title="ce groupe" url=$groupe->getUrl()}

{if !empty($alerting_sub_url)}
<div class="alerting-sub"><a href="{$alerting_sub_url}">S'abonner à ce groupe</a></div>
{elseif !empty($alerting_unsub_url)}
<div class="alerting-unsub"><a href="{$alerting_unsub_url}">Se désabonner de ce groupe</a></div>
{elseif !empty($alerting_auth_url)}
<div class="alerting-auth"><a href="{$alerting_auth_url}">S'abonner à ce groupe</a></div>
{/if}

{include file="common/boxend.tpl"}

{if $photos|@count > 0}
{include file="common/boxstart.tpl" boxtitle="Photos"}
  <div class="clearfix">
  {foreach from=$photos item=photo}
  <div class="thumb-80">
    <a href="{$photo.url}" title="{$photo.name|escape}"><img src="{$photo.thumb_80_80}" alt="{$photo.name|escape}" />{$photo.name|truncate:15:"...":true:true|escape}</a>
    <a class="overlay-80 overlay-photo-80" href="{$photo.url}" title="{$photo.name|escape}"></a>
  </div>
  {/foreach}
  </div>
  {if !empty($is_loggued)}
  <a href="/photos/create?id_groupe={$groupe->getId()}">Ajouter une photo</a>
  {/if}
{include file="common/boxend.tpl"}
{/if}

{if $f_events|@count > 0}
{include file="common/boxstart.tpl" boxtitle="Concerts à venir"}
<ul>
  {foreach from=$f_events item=event}
  <li><a href="/events/show/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'} - {$event.lieu_name|escape}</a></li>
  {/foreach}
</ul>
{include file="common/boxend.tpl"}
{/if}

{include file="common/boxstart.tpl" boxtitle="Concerts passés"}
{if $p_events|@count > 0}
<ul>
  {foreach from=$p_events item=event}
  <li><a href="/events/show/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'} - {$event.lieu_name|escape}</a></li>
  {/foreach}
</ul>
{else}
<p>Aucun concert passé</p>
{/if}
{if !empty($is_loggued)}
  <a href="/events/create?id_groupe={$groupe->getId()}">Saisir une date passée</a>
{/if}
{include file="common/boxend.tpl"}

{if $groupe->getFacebookPageId()}
{include file="common/boxstart.tpl" boxtitle="{$groupe->getName()} sur Facebook"}

{if empty($fb_page_info) && empty($fb_page_feed)}
<p class="warning">Erreur à la récupération du flux Facebook. Vérifiez vos paramètres</p>
{/if}

{if !empty($fb_page_info)}
<p>
{*
  <img src="{$fb_page_info.picture}" alt="" style="float: left" />
*}
  <strong>{$fb_page_info.name|escape}</strong><br /><strong>{$fb_page_info.likes} fans</strong>
</p>
{/if}

{if !empty($fb_page_feed)}
<ul>
  {foreach from=$fb_page_feed item=feed}
  {if $feed.from.id == $groupe->getFacebookPageId()}
  <li style="background-color: #ffffff; margin: 5px; border: 0px solid #000000;">
    <div style="background-color: #ececec; padding: 5px;">{$feed.created_time|date_format:'%d/%m/%Y %H:%M'}</div>
    <div style="padding: 5px;">
    {if $feed.type == 'status'}
      {if !empty($feed.message)}{$feed.message|escape}{/if}
    {/if}
    {if $feed.type == 'link'}
      {if !empty($feed.message)}{$feed.message}<br />{/if}
      {if !empty($feed.link)}<a href="{$feed.link}">{$feed.name|escape}<br />{if !empty($feed.picture)}<img src="{$feed.picture}" alt="" /><br />{/if}{$feed.link|escape}</a>{/if}
    {/if}
    {if $feed.type == 'video'}
      {if !empty($feed.message)}{$feed.message}<br />{/if}
      {if !empty($feed.link)}<a href="{$feed.link}">{$feed.name|escape}<br /><img src="{$feed.picture}" alt="" /></a>{/if}
    {/if}
    </div>
  </li>
  {/if}
  {/foreach}
</ul>
{/if}

{include file="common/boxend.tpl"}
{/if}


{if $groupe->getTwitterId()}

{include file="common/boxstart.tpl" boxtitle="Twitter"}

<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget( {
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 6000,
  width: 400,
  height: 300,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#000000'
    },
    tweets: {
      background: '#ffffff',
      color: '#000000',
      links: '#333333'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: false,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('{$groupe->getTwitterId()}').start();
</script>

{include file="common/boxend.tpl"}

{/if}

</div>

{/if} {* test unknown group *}

{include file="common/footer.tpl"}
