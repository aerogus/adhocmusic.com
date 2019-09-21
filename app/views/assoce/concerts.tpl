{include file="common/header.tpl"}

  <div class="box">
    <header>
      <h3>Les Concerts</h3>
    </header>
    <div>
      {foreach from=$events key=season item=events_of_the_year}
      <div class="saison">
        <h3>Saison {$season}</h3>
        <ul>
          {foreach from=$events_of_the_year item=event}
          <li>
            <a href="/events/{$event.id}"><img alt="" src="{$event.flyer_100_url}"><br>{$event.date|date_format:"%e %b"}</a>
          </li>
          {/foreach}
        </ul>
      </div>
      {/foreach}
      <div class="concerts">
        <h3>Saisons 1994 à 1997</h3>
        <p>C’est très flou, il y a eu quelques concerts à cette époque, sous le nom de l’association Casimir (ou dépendant directement du comité des fêtes d’Épinay sur Orge), mais je n’ai plus de traces des flyers. Si vous avez des infos contactez nous pour nos archives :)</p>
      </div>
    </div>
  </div>{* .box *}

{include file="common/footer.tpl"}
