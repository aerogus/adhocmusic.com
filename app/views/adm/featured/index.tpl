{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>À l'Affiche</h1>
  </header>
  <div>

    <div id="swipe" class="swipe clearfix mbs">
      <ul class="swipe-wrap">
        {foreach from=$featured_front key=idx item=f}
        <li data-index="{$idx}">
          <a href="{$f->getUrl()}">
            <h2>{$f->getTitle()}<br><span>{$f->getDescription()}</span></h2>
            <img src="{$f->getImage()}" title="{$f->getDescription()}" alt="">
          </a>
        </li>
        {/foreach}
      </ul>
      <div class="swipe-pagination-wrapper">
        <ul class="swipe-pagination">
          {foreach from=$featured_front key=idx item=f}
          <li data-index="{$idx}">
            <a href="{$f->getUrl()}"></a>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>

    <a href="/adm/featured/create" class="btn btn--primary">Nouveau</a>

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
        <tr>
          <td><a href="/adm/featured/edit/{$f->getId()}">{$f->getTitle()}<br>{$f->getDescription()}</a></td>
          <td><img src="{$f->getImage()}" width="108" height="60" alt="" style="display: block" /></td>
          <td>{$f->getDatDeb()|date_format:'%d/%m/%Y'}</td>
          <td>{$f->getDatFin()|date_format:'%d/%m/%Y'}</td>
          <td>{$f->getOnline()|display_on_off_icon}</td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
