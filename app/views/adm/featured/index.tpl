{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>À l'Affiche</h1>
  </header>
  <div>
    <p class="info">
    Cet outil sert à modifier le slider de la home<br>
    L'image doit être au format .jpg 1000x375
    </p>
    <a href="/adm/featured/create" class="button">Ajouter</a>

    <div id="swipe" class="swipe clearfix">
      <ul class="swipe-wrap">
        {foreach from=$featured_front key=idx item=f}
        <li data-index="{$idx}">
          <a href="{$f.url}">
            <h2>{$f.title}</h2>
            <h2>{$f.description}</h2>
            <img src="{$f.image}" title="{$f.description}" alt="">
          </a>
        </li>
        {/foreach}
      </ul>
      <div class="swipe-pagination-wrapper">
        <ul class="swipe-pagination">
          {foreach from=$featured_front key=idx item=f}
          <li data-index="{$idx}">
            <a href="{$f.link}"></a>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Début</th>
          <th>Fin</th>
          <th>En ligne</th>
          <th>Titre</th>
        </tr>
      </thead>
      <tbody>
      {foreach from=$featured_admin item=f}
        <tr class="{$f.class}">
          <td>{$f.datdeb|date_format:'%d/%m/%Y'}</td>
          <td>{$f.datfin|date_format:'%d/%m/%Y'}</td>
          <td>{$f.online|display_on_off_icon}</td>
          <td><a href="/adm/featured/edit/{$f.id}"><img src="{$f.image}" width="54" height="30" alt="" style="float: right;" /><br>{$f.description}</a></td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
