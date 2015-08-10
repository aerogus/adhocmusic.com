{include file="fb/adhocmusic/tab/common/header.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" title=$groupe->getName()|escape}

{if $groupe->getLogo()}
<p align="center"><img src="{$groupe->getLogo()}" alt="{$groupe->getName()}" /></p>
{/if}

{if $groupe->getStyle()}
<p><strong>Style</strong><br />{$groupe->getStyle()|escape}</p>
{/if}

{if $groupe->getInfluences()}
<p><strong>Influences</strong><br />{$groupe->getInfluences()|escape}</p>
{/if}

{if $groupe->getLineup()}
<p><strong>Membres</strong><br />{$groupe->getLineup()|escape}</p>
{/if}

<p><strong>Dont membres Facebook</strong>
<ul>
{foreach from=$groupe->getMembers() item=membre}
  {if $membre.facebook_uid > 0}
  <li><a href="http://www.facebook.com/profile.php?id={$membre.facebook_uid}">{$membre.pseudo|escape}</a> ({$membre.nom_type_musicien|escape})</li>
  {/if}
{/foreach}
</ul>
</p>

<p>
<img src="{#STATIC_URL#}/media/structure/1.png" width="16" height="16" alt="" />
<a href="{$groupe->getUrl()}" title="Fiche AD'HOC"><strong>{$groupe->getUrl()}</strong></a>
</p>

{if $groupe->getSite()}
<p>
<img src="{#STATIC_URL#}/img/icones/lien.png" width="16" height="16" alt="" />
<a href="{$groupe->getSite()}" title="Site Officiel" class="extlink"><strong>{$groupe->getSite()|escape}</strong></a>
</p>
{/if}

{if $groupe->getMySpace()}
<p>
<img src="{#STATIC_URL#}/img/myspace.png" width="16" height="16" alt="" />
<a href="{$groupe->getMySpace()}" title="Page MySpace" class="extlink"><strong>{$groupe->getMySpace()}</strong></a>
</p>
{/if}

{if $groupe->getCreatedOn()}
<p><strong>Fiche créée le</strong> : {$groupe->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
{/if}

{if $groupe->getModifiedOn()}
<p><strong>Mise à jour le</strong> : {$groupe->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
{/if}

{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" title="Concerts à venir"}
<ul>
  {foreach from=$f_events item=event}
  <li><a href="/fb/adhocmusic/tab/event/{$event.id|escape}">{$event.date|date_format:'%d/%m/%Y %H:%M'}</a> - <a href="/lieu/{$event.lieu_id|escape}">{$event.lieu_name|escape}</a></li>
  {/foreach}
</ul>
{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{*
{include file="fb/adhocmusic/tab/common/boxstart.tpl" title="Photos"}
{include file="fb/adhocmusic/tab/common/boxend.tpl"}
*}

{*
{include file="fb/adhocmusic/tab/common/boxstart.tpl" title="Vidéos"}
{include file="fb/adhocmusic/tab/common/boxend.tpl"}
*}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
