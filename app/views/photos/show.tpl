{include file="common/header.tpl" title=$title}

{if !empty($unknown_photo)}

<p class="infobulle error">Cette photo est introuvable</p>

{else}

<div class="grid-3-small-1 has-gutter">

  <div class="col-1">

    {if !empty($groupe)}
    <div class="box">
      <header>
        <h2>Groupe</h2>
      </header>
      <div>
        <a href="{$groupe->getUrl()}"><img style="float: right;" src="{$groupe->getMiniPhoto()}" alt=""><strong>{$groupe->getName()|escape}</strong></a>
      </div>
    </div>
    {/if}

    {if !empty($event)}
    <div class="box">
      <header>
        <h2>Événement</h2>
      </header>
      <div>
        <a href="{$event->getUrl()}"><img style="float: right;" src="{$event->getThumbUrl(100)}" alt=""><strong>{$event->getName()|escape}</strong></a><br>{$event->getDate()|date_format:'%d/%m/%Y'}
      </div>
    </div>
    {/if}

    {if !empty($lieu)}
    <div class="box">
      <header>
        <h2>Lieu</h2>
      </header>
      <div>
        <a href="{$lieu->getUrl()}"><strong>{$lieu->getName()|escape}</strong></a><br>{$lieu->getAddress()}<br>{$lieu->getCity()->getCp()} {$lieu->getCity()->getName()|escape}
      </div>
    </div>
    {/if}

    {if !empty($next) && !empty($prev)}
    <div class="box">
      <header>
        <h2>Album</h2>
      </header>
      <div>
        <p align="center"><a href="{$prev}#p">←</a> photo {$idx_photo}/{$nb_photos} <a href="{$next}#p">→</a></p>
      </div>
    </div>
    {/if}

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
    <img src="{$photo->getThumbUrl(680)}" alt="{$photo->getName()|escape}">
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
