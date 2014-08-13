{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="A l'Affiche"}

<p class="info">
Cet outil sert à modifier le bloc à l'affiche de la page d'accueil<br />
Il y a 4 emplacements ("slots") ayant chacun une fonction éditoriale :<br />
 - Slot 1 : Live AD'HOC<br />
 - Slot 2 : Evénement<br />
 - Slot 3 : Groupe AD'HOC<br />
 - Slot 4 : Article/Reportage<br />
S'il y a plusieurs contenus pour un slot à un instant t, le contenu sera choisi au hasard<br />
Veillez à ce que tous les slots soient renseignés pour un instant t<br />
L'image doit être au format .jpg 427x240 obligatoirement (rapport 16/9)
</p>

<a href="/adm/featured/create" class="button">Ajouter</a>

<table>
  <thead>
    <tr>
      <th>Slot</th>
      <th>Début</th>
      <th>Fin</th>
      <th>En ligne</th>
      <th>Titre</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$featured item=f}
    <tr class="{$f.class}">
      <td>{$f.slot_name|escape}</td>
      <td>{$f.datdeb|date_format:'%d/%m/%Y'}</td>
      <td>{$f.datfin|date_format:'%d/%m/%Y'}</td>
      <td>{$f.online|display_on_off_icon}</td>
      <td><a href="/adm/featured/edit/{$f.id}"><img src="{$f.image}" width="54" height="30" alt="" style="float: right;" /><a href="/adm/featured/edit/{$f.id}">{$f.title}<br />{$f.description}</a></td>
    </tr>
  {/foreach}
  </tbody>
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
