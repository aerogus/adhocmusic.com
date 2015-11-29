{include file="common/header.tpl" title=$title}

{if !empty($unknown_photo)}

<p class="error">Cette photo est introuvable !</p>

{else}

<div id="left">

<style>
.metatop {
  color: #fff;
  margin-top: 5px;
  padding: 3px 5px;
  font-weight: bold;
  background-color: #999999;
}
.metacontent {
  padding: 5px 0px 5px 5px;
}
</style>

{include file="common/boxstart.tpl" width="200px"}
{if !empty($groupe)}
<div class="metatop">Groupe</div>
<div class="metacontent">
  <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt="" /><strong>{$groupe->getName()|escape}</strong></a>
</div>
<br style="clear: both;">
{/if}
{if !empty($event)}
<div class="metatop">Evénement</div>
<div class="metacontent">
  <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt="" /><strong>{$event->getName()|escape}</strong></a><br />{$event->getDate()|date_format:'%d/%m/%Y'}
</div>
<br style="clear: both;">
{/if}
{if !empty($lieu)}
<div class="metatop">Lieu</div>
<div class="metacontent">
  <a href="{$lieu->getUrl()}"><img style="float: right;" src="{$lieu->getMapUrl('64x64')}" alt="" /><strong>{$lieu->getName()|escape}</strong></a><br />{$lieu->getAddress()}<br />{$lieu->getCp()} {$lieu->getCity()|escape}
</div>
<br style="clear: both;" />
{/if}
{if !empty($next) && !empty($prev)}
<div class="metatop">Album</div>
<div class="metacontent">
  <p align="center"><a href="{$prev}#p">←</a> photo {$idx_photo}/{$nb_photos} <a href="{$next}#p">→</a></p>
</div>
{/if}
{if !empty($who)}
<div class="metatop">Sur cette photo</div>
<div class="metacontent">
  {$who}
</div>
{/if}
{include file="common/boxend.tpl"}

</div>

<div id="centerright" style="float: right;">

<a name="p"></a>

{include file="common/boxstart.tpl" boxtitle2=$photo->getName()|escape width="700px"}

<script>
$(function() {

  $("#photofull").noContext();

  {if !empty($prev) && !empty($next) && true}
  $(document).keydown(function(e) {
    if (e.keyCode == 37) {
       window.location = '{$prev}#p';
       e.preventDefault();
    }
    if (e.keyCode == 39) {
       window.location = '{$next}#p';
       e.preventDefault();
    }
  });
  {/if}

  {if empty($live_edit)}
  var self = $("#pname");
  self.value = self.text();
  self.bind('click', function() {
    self
      .html('<input style="width: 300px; font-size: 9px;" type="text" value="' + self.value + '" />')
      .find('input')
      .bind('blur', function(event) {
        self.value = $(this).val();
        self.text(self.value);
        $.post('/photos/ajax_update', {
          id: {$photo->getId()},
          name: self.value
        }, function(data) {
          //alert(data);
        });
      })
      .focus();
  });
  {/if}

});
</script>

<p align="center" id="photofull" class="photofull">
{if !empty($next)}<a href="{$next}">{/if}
<img src="{$photo->getThumb680Url()}" alt="{$photo->getName()|escape}" />
{if !empty($next)}</a>{/if}
</p>

<p align="center" style="margin: 10px 0px;">
<span id="pname">{$photo->getName()|escape}</span>
<span id="pcredits">{if !empty($has_credits)}(<i>crédits: {$photo->getCredits()|escape}</i>){/if}</span>
</p>

{include file="comments/share.tpl" title="cette photo" url=$photo->getUrl()}

{include file="comments/box.tpl" type="p" id_content=$photo->getId()}

{include file="common/boxend.tpl"}

</div>

{/if} {* test unknown photo *}

{include file="common/footer.tpl"}
