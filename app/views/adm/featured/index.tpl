{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>À l'Affiche</h1>
  </header>
  <div>
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

    <a href="/adm/featured/create" class="button">Nouveau</a>

    <table>
      <thead>
        <tr>
          <th>Titre / Description</th>
          <th>Visuel</th>
          <th>Début</th>
          <th>Fin</th>
          <th>En ligne</th>
        </tr>
      </thead>
      <tbody>
      {foreach $featured_admin as $f}
        <tr class="{$f.class}">
          <td><a href="/adm/featured/edit/{$f.id}">{$f.title}<br>{$f.description}</a></td>
          <td><img src="{$f.image}" width="108" height="60" alt="" style="display: block" /></td>
          <td>{$f.datdeb|date_format:'%d/%m/%Y'}</td>
          <td>{$f.datfin|date_format:'%d/%m/%Y'}</td>
          <td>{$f.online|display_on_off_icon}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
