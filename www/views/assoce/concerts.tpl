{include file="common/header.tpl" swfobject=true}

<div id="right">

{include file="assoce/sidebar.inc.tpl"}

</div>

<div id="left-center">

{include file="common/boxstart.tpl" boxtitle="Les Concerts"}

{foreach from=$events key=season item=events_of_the_year}
<div class="concerts">
  <h3>Saison {$season}</h3>
  <ul>
    {foreach from=$events_of_the_year item=event}
    <li>
      <a href="/events/show/{$event.id}" style="color: #000; text-decoration: none;"><img alt="" src="{$event.flyer_100_url}" /><br />{$event.date|date_format:"%e %b"}.</a>
      {if $event.nb_photos > 0}<img src="{#STATIC_URL#}/img/icones/photo.png" alt="{$event.nb_photos} photo(s)" title="{$event.nb_photos} photo(s)" />{/if}
      {if $event.nb_videos > 0}<img src="{#STATIC_URL#}/img/icones/video.png" alt="{$event.nb_videos} vidéo(s)" title="{$event.nb_videos} vidéo(s)" />{/if}
      {if $event.nb_audios > 0}<img src="{#STATIC_URL#}/img/icones/audio.png" alt="{$event.nb_audios} audio(s)" title="{$event.nb_audios} audio(s)" />{/if}
    </li>
    {/foreach}
  </ul>
  <div style="clear: both"></div>
</div>
{/foreach}
<div class="concerts">
  <h3>Saisons 1994 à 1997</h3>
  <p>C'est très flou, il y a eu quelques concerts à cette époque, sous le nom de l'association Casimir (ou dépendant directement du comité des fêtes d'Epinay sur Orge), mais je n'ai plus de traces des flyers. Si vous avez des infos contactez nous pour nos archives :)</p>
</div>

{include file="common/boxend.tpl"}

</div>

{include file="common/footer.tpl"}
