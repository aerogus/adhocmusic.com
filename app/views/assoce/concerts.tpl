{include file="common/header.tpl"}

  <div class="box">
    <header>
      <h1>Les concerts</h1>
    </header>
    <div class="reset">

      {foreach from=$events key=season item=events_of_the_year}
      <div class="saison">
        <h3>Saison {$season}</h3>
        <div class="gallery" id="saison-{$season|truncate:4:''}">
          {foreach from=$events_of_the_year item=event}
          <div class="photo">
            <a href="{$event->getUrl()}" title="{$event->getName()|escape}">
              <img src="{$event->getThumbUrl(320)}" alt="Flyer {$event->getName()|escape}">
            </a>
          </div>
          {/foreach}
        </div>
      </div>
      {/foreach}
      <div class="saison">
        <h3>Saisons 1994 à 1997</h3>
        <p>C’est très flou, il y a eu quelques concerts à cette époque, sous le nom de l’association Casimir (ou dépendant directement du comité des fêtes d’Épinay-sur-Orge), mais nous n’avons plus de traces de flyers, au mieux une mention d’un concert "avec des jeunes" dans le canard local. Si vous avez des infos contactez nous pour nos archives :)</p>
      </div>
    </div>
  </div>{* .box *}

{include file="common/footer.tpl"}
