{include file="common/header.tpl" js_jquery_ui=true css_jquery_ui=true}

<script>
$(function() {
    $("#tabs").tabs({
        event: 'click'
    });
});
</script>

<div id="tabs">
  <ul>
    <li><a href="#tab-groupe">Le Groupe</a></li>
    <li><a href="#tab-bio">Biographique</a></li>
    <li><a href="#tab-videos">Vidéos</a></li>
    <li><a href="#tab-audios">Audios</a></li>
    <li><a href="#tab-photos">Photos</a></li>
    <li><a href="#tab-agenda">Agenda</a></li>
    <li><a href="#tab-forum">Forum</a></li>
    {if !empty($show_mot_adhoc)}<li><a href="#tab-mot-adhoc">Le Mot AD'HOC</a>>/li>{/if}
  </ul>
  <div id="tab-groupe">
    <h3>{$groupe->getName()|escape}</h3>
    {if $groupe->getLogo()}<p align="center"><img src="{$groupe->getLogo()}" alt="{$groupe->getName()|escape}" /></p>{/if}
    {if $groupe->getStyle()}<p><strong>Style</strong><br />{$groupe->getStyle()|escape}</p>{/if}
    {if $groupe->getInfluences()}<p><strong>Influences</strong><br />{$groupe->getInfluences()|escape}</p>{/if}
    {if $groupe->getLineUp()}<p><strong>Membres</strong><br />{$groupe->getLineUp()|escape}</p>{/if}
    {if $membres|@count > 0}
    <p><strong>Dont membres AD'HOC</strong></p>
    <ul>
      {foreach from=$membres item=membre}
      <li><a href="/membres/show/{$membre.id}">{$membre.pseudo|escape}</a> ({$membre.nom_type_musicien|escape})</li>
      {/foreach}
    </ul>
    {/if}
    <p><img src="{#STATIC_URL#}/media/structure/1.png" width="16" height="16" alt="" /><a href="{$groupe->getUrl()}" title="Fiche AD'HOC"><strong>{$groupe->getUrl()}</strong></a></p>
    {if $groupe->getSite()}
    <p><img src="{#STATIC_URL#}/img/icones/lien.png" width="16" height="16" alt="" /><a href="{$groupe->getSite()}" title="Site Officiel" class="extlink"><strong>{$groupe->getSite()}</strong></a></p>
    {/if}
    {if $groupe->getMySpace()}
    <p><img src="{#STATIC_URL#}/img/myspace.png" width="16" height="16" alt="" /><a href="{$groupe->getMySpace()}" title="Page MySpace" class="extlink"><strong>{$groupe->getMySpace()}</strong></a></p>
    {/if}
    {if $groupe->getCreatedOn()}
    <p><strong>Fiche créée le</strong><br />{$groupe->getCreatedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
    {/if}
    <iframe src="http://www.facebook.com/plugins/like.php?href={$groupe->getUrl()|escape:"url"}&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font&amp;colorscheme=dark&amp;height=20" scrolling="no" frameborder="0" style="float: right; border: none; overflow: none; width: 80px; height: 20px;" allowTransparency="true"></iframe>
    {if $groupe->getModifiedOn()}
    <p><strong>Mise à jour le</strong><br />{$groupe->getModifiedOn()|date_format:"%d/%m/%Y %H:%M"}</p>
    {/if}
    {if $is_loggued}
    <ul class="tools">
      <li><a href="/audios/create?id_groupe={$groupe->getId()}"><img src="{#STATIC_URL#}/img/icones/audio_add.png" alt="" title="Proposer une chanson pour ce groupe" /></a></li>
      <li><a href="/photos/create?id_groupe={$groupe->getId()}"><img src="{#STATIC_URL#}/img/icones/photo_add.png" alt="" title="Proposer une photo pour ce groupe" /></a></li>
      <li><a href="/videos/create?id_groupe={$groupe->getId()}"><img src="{#STATIC_URL#}/img/icones/video_add.png" alt="" title="Proposer une vidéo pour ce groupe" /></a></li>
      <li><a href="/events/create?id_groupe={$groupe->getId()}"><img src="{#STATIC_URL#}/img/icones/event_add.png" alt="" title="Annoncer une date pour ce groupe" /></a></li>
    </ul>
    {/if}
  </div>
  <div id="tab-bio">
    {if $groupe->getPhoto() || $groupe->getText()}
      {if $groupe->getPhoto()}<p align="center"><img src="{$groupe->getPhoto()}" alt="{$groupe->getName()|escape}" /></p>{/if}
      {if $groupe->getText()}<p align="justify">{$groupe->getText()|nl2br}</p>{/if}
    {/if}
  </div>
  <div id="tab-videos">
    {if $videos|@count > 0}
    <ul class="video">
      {foreach from=$videos item=video}
      <li></li>
      {/foreach}
    </ul>
    {/if}
  </div>
  <div id="tab-audios">
    {if $audios|@count > 0}
    <div style="background: url({#STATIC_URL#}/img/player_adhoc.png); width: 360px; height: 218px; position: relative; margin: 0 auto;">
      <img src="{$groupe->getMiniPhoto()}" alt="" style="position: absolute; top: 28px; left: 14px;" />
      <div style="position: absolute; top: 27px; left: 90px;">{audio_player id=$groupe->getId() type='player_mp3_multi'}</div>
    </div>
    {/if}
  </div>
  <div id="tab-photos">
    {if $photos|@count > 0}
      <div id="allphotos" style="display: block">
      {foreach from=$photos item=photo}
      {/foreach}
       </div>
    {/if}
  </div>
  <div id="tab-agenda">
    {if $events|@count > 0}
    <ul>
      {foreach from=$events item=event}
      {/foreach}
    </ul>
    {/if}
  </div>
  <div id="tab-forum">
    <ul>
      <li>Aucun message ! Allez hop on inaugure ce forum :)</li>
      <li><a href="/forums/add/{$groupe->getId()}"><strong>Ajouter un Message</strong></a></li>
      <li><a href="/forums/forum/{$groupe->getId()}"><strong>Aller dans le forum</strong></a></li>
    </ul>
  </div>
  {if !empty($show_mot_adhoc)}
  <div id="tab-mot-adhoc">
    <p>(*) <em>Cette fenêtre est uniquement visible par les membres internes AD'HOC</em></p>
    <p>{$groupe->getComment()}</p>
    <p><a href="/groupes/edit/{$groupe->getId()}">Editer ce groupe</a></p>
  </div>
  {/if}
</div>

{include file="common/footer.tpl"}

