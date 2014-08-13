{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Stats d'ouverture Newsletter"}

<p>Nombre d'abonné actifs instantanés : <strong>{$nb_subscribers}</strong></p>
<p>Nombre d'ouvertures : <strong>{$nbo}</strong></p>
<p>Nombre d'ouvertures uniques : <strong>{$nbou}</strong></p>

<p>Techniquement, ce tableau indique la liste des personnes qui ont affiché l'image du bandeau supérieur de la newsletter. Les gens qui n'affichent pas les images dans leur client de messagerie ne sont donc pas comptabilisés.</p>

<table>
  <tr>
    <th>Date</th>
    <th>Nl</th>
    <th>Contact</th>
    <th>Lien</th>
  </tr>
  {foreach from=$hits item=hit}
  <tr>
    <td>{$hit.date|date_format:"%d/%m/%Y %H:%M:%S"}</td>
    <td>{$hit.id_newsletter|escape}</td>
    <td><strong>{$hit.email}</strong><br />(<a href="/membres/show/{$hit.id_contact}"><strong>{$hit.pseudo|escape}</strong></a>)</td>
    <td><a href="{$hit.url}">{$hit.url}</a></td>
  </tr>
  {/foreach}
</table>

<br />

<table>
  <tr>
    <th>Date</th>
    <th>Nl</th>
    <th>Contact</th>
    {if !empty($full)}
    <th>Host</th>
    <th>Useragent</th>
    {/if}
  </tr>
  {foreach from=$nls item=nl}
  <tr>
    <td>{$nl.date|date_format:"%d/%m/%Y %H:%M:%S"}</td>
    <td>{$nl.id_newsletter|escape}</td>
    <td><strong>{$nl.email}</strong><br />(<a href="/membres/show/{$nl.id_contact}"><strong>{$nl.pseudo|escape}</strong></a>)</td>
    {if !empty($full)}
    <td>{$nl.host}<br />({$nb.ip})</td>
    <td>{$nl.useragent}</td>
    {/if}
  </tr>
  {/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
