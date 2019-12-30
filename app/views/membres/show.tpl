{include file="common/header.tpl"}

{if !empty($unknown_member)}

<p class="infobulle error">Ce membre est introuvable</p>

{else}

<div class="box">
  <header>
    <h1>Profil de {$membre->getPseudo()}</h1>
  </header>
  <div class="grid-3">
    <div class="col-1 profile">
      {if $membre->getAvatarUrl()}
      <img src="{$membre->getAvatarUrl()}" alt="{$membre->getPseudo()|escape}">
      {/if}
      <strong>{$membre->getPseudo()|escape}</strong>
      {if $membre->getSite()}
      <a href="{$membre->getSite()}">{$membre->getSite()}</a>
      {/if}
      <a class="button" href="/messagerie/write?pseudo={$membre->getPseudo()|escape}">Lui écrire</a>
    </div>
    <div class="col-2">
      {$membre->getText()}
    </div>
  </div>
</div>

{if $groupes|@count > 0}
<div class="box">
  <header>
    <h2>Ses groupes</h2>
  </header>
  {if !count($groupes)}
  <div>
    <p>{$membre->getPseudo()} ne fait partie d'aucun groupe.</p>
  </div>
  {else}
  <div class="reset grid-8-small-4 has-gutter">
    {foreach from=$groupes item=groupe}
    <div class="grpitem">
      <a href="{$groupe->getUrl()}">
        <img src="{$groupe->getMiniPhoto()}" alt="" />
        <p>{$groupe->getName()}</p>
      </a>
    </div>
    {/foreach}
  </div>
  {/if}
</div>
{/if}

{/if} {* test unknown membre *}

{include file="common/footer.tpl"}
