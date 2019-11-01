{include file="common/header.tpl" title=$title}

{if !empty($unknown_photo)}

<p class="infobulle error">Cette photo est introuvable</p>

{else}

<div class="grid-3-small-1 has-gutter-l">

  <div class="col-1">

    <div class="box">
      <header>
        <h1></h1>
      </header>
      <div>
    {if !empty($groupe)}
    <div class="metatop">Groupe</div>
    <div class="metacontent">
      <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
    </div>
    <br style="clear: both;">
    {/if}
    {if !empty($event)}
    <div class="metatop">Evénement</div>
    <div class="metacontent">
      <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getFlyer100Url()}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
    </div>
    <br style="clear: both;">
    {/if}
    {if !empty($lieu)}
    <div class="metatop">Lieu</div>
    <div class="metacontent">
      <a href="{$lieu->getUrl()}"><img style="float: right;" src="{$lieu->getMapUrl('64x64')}" alt=""><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCp()} {$lieu->getCity()|escape}
    </div>
    <br style="clear: both;">
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
    </div>
    </div>

  </div>{* .col-1 *}

  <div class="col-2-small-1">

    <a name="p"></a>

    <div class="box">
      <header>
        <h1>{$photo->getName()}</h1>
      </header>
      <div>

    <p align="center" id="photofull" class="photofull">
    {if !empty($next)}<a href="{$next}">{/if}
    <img src="{$photo->getThumb680Url()}" alt="{$photo->getName()|escape}">
    {if !empty($next)}</a>{/if}
    </p>

    <p align="center" style="margin: 10px 0px;">
      <span id="pname">{$photo->getName()|escape}</span>
      <span id="pcredits">{if !empty($has_credits)}(<i>crédits: {$photo->getCredits()|escape}</i>){/if}</span>
    </p>

      </div>
    </div>

  </div>{* .col-2-small-1 *}

</div>{* .grid-3-small-1 *}

{/if} {* test unknown photo *}

{include file="common/footer.tpl"}
