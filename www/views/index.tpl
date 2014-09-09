{include file="common/header.tpl"}

<div id="left-center">

<script>
$(function() {
  $.featureList(
    $("#tabs li a"),
    $("#output li"), {
      start_item: 0,
      transition_interval: 3000
    }
  );
});
</script>

<div id="feature_list">
  <ul id="tabs">
    {foreach from=$featured item=f}
    <li>
      <a href="{$f.link|escape}">
        <h3>{$f.title|escape}</h3>
        <span>{$f.description|escape}</span>
      </a>
    </li>
    {/foreach}
  </ul>
  <ul id="output">
    {foreach from=$featured item=f}
    <li>
      <a href="{$f.link|escape}">
        <img src="{$f.image|escape}" alt="" />
      </a>
    </li>
    {/foreach}
  </ul>
</div>

{include file="common/boxstart.tpl" boxtitle="Vidéos Live" width="300px; float: left"}

{foreach from=$videos item=video}
<div class="thumb-80">
  <a href="{$video.url}"><img src="{$video.thumb_80_80}" alt="{$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}" />{$video.name|truncate:15:"...":true|escape}</a>
  <a class="overlay-80 overlay-video-80" href="{$video.url}" title="Regarder {$video.name|escape}{if !empty($video.groupe_name)} ({$video.groupe_name|escape}){/if}"></a>
</div>
{/foreach}

{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Activité récente" width="320px; float: left; margin-left: 20px"}
<fb:activity app_id="50959607741" site="http://www.adhocmusic.com" action="Comma separated list of action of action types" width="300" height="230" header="false"></fb:activity>
{include file="common/boxend.tpl"}

</div>

<div id="right">

{include file="common/boxstart.tpl" boxtitle="Agenda" width="300px; margin-bottom: 20px;"}

<ul>
{foreach from=$evts key=month item=mevts}
  <li><strong>{$month|date_format:"%B %Y"|capitalize}</strong>
  <ul>
  {foreach from=$mevts key=month item=evt}
    <li><span style="font-weight: bold; color: #cc0000;" title="{$evt.date|date_format:"%A %e %B à %H:%M"}">{$evt.date|date_format:"%d"}</span>{if !empty($evt.structure_id)} <img src="{$evt.structure_picto}" alt="" title="organisé par {$evt.structure_name|escape}" />{/if} <a href="/events/show/{$evt.id}" title="{$evt.name|escape}">{$evt.name|truncate:'40'|escape}</a></li>
  {/foreach}
  </ul>
  </li>
{/foreach}
</ul>

{include file="common/boxend.tpl"}

{if !empty($comments)}
{include file="common/boxstart.tpl" boxtitle="Derniers commentaires" width="300px"}
<ul>
{foreach from=$comments item=comment}
<li style="margin-bottom: 5px">
  <strong>{$comment.pseudo}</strong> le {$comment.created_on|date_format:'%d/%m/%Y'}<br />
  <a href="/{$comment.type_full}/show/{$comment.id_content}">{$comment.text|truncate:'50'}</a></li>
{/foreach}
</ul>
{include file="common/boxend.tpl"}
{/if}

</div>

{include file="common/footer.tpl"}
