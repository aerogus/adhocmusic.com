{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Partenaires</h1>
  </header>
  <div>
    <ul class="partners">
    {foreach from=$partners item=partner}
      <li>
        <a href="{$partner->url}">
          <img src="/img/partners/{$partner->id}.png" alt="">
          <strong>{$partner->title}</strong><br>{$partner->description}
        </a>
      </li>
    {/foreach}
    </ul>
  </div>
</div>

<div class="box">
  <header>
    <h2>Devenir partenaire ?</h2>
  </header>
  <div>
    <p><strong>AD'HOC</strong> est ouvert à différentes propositions de partenariat, en particulier avec des sites musicaux, webzines et autres agendas culturels.</p>
    <p>N'hésitez pas à faire un lien vers notre site. Toutes les bannières et logos sont disponibles sur la page "<a href="/visuels">visuels</a>"</p>
    <p>Pour tout renseignement complémentaire, vous pouvez <a href="/contact"><strong>nous contacter</strong></a>.</p>
  </div>
</div>

{include file="common/footer.tpl"}
