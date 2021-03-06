{include file="common/header.tpl"}

{if !empty($unknown_structure)}

<p class="infobulle error">Cette structure est introuvable !</p>

{else}

<div class="box">
  <header>
    <h1>{$structure->getName()}</h1>
  </header>
  <div>

<table>
  <tr>
    <th>Id</th>
    <td>{$structure->getIdStructure()}</td>
  </tr>
  <tr>
    <th>Nom</th>
    <td>{$structure->getName()}</td>
  </tr>
  <tr>
    <th>Imagette</th>
    <td><img src="{$structure->getPicto()}" alt=""></td>
  </tr>
  <tr>
    <th>Evénements</th>
    <td>
      <ul>
      {foreach $events as $event}
        <li><a href="{$event->getUrl()|escape}">{$event->getDate()|escape} : {$event->getName()|escape}</a></li>
      {/foreach}
      </ul>
    </td>
  </tr>
</table>

  </div>
</div>

{/if} {* test unknown structure *}

{include file="common/footer.tpl"}
