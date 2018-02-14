{include file="common/header.tpl"}

{if !empty($unknown_structure)}

<p class="error">Cette structure est introuvable !</p>

{else}

{include file="common/boxstart.tpl" boxtitle=$structure->getName()}

<table>
  <tr>
    <th>Id</th>
    <td>{$structure->getId()}</td>
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
        <li><a href="{$event.url|escape}">{$event.date|escape} : {$event.name|escape}</a></li>
      {/foreach}
      </ul>
    </td>
  </tr>
</table>

{include file="common/boxend.tpl"}

{/if} {* test unknown structure *}

{include file="common/footer.tpl"}
