{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Liaisons groupe / styles</h1>
  </header>
  <div>

<div class="infobulle info">Un groupe est lié à un style en texte libre, et à 1 à 3 styles prédéfinis d'une liste déroulante. C'est de ce dernier choix que dépend l'affichage et le classement du groupe. Un groupe doit obligatoirement avoir un style sélectionné sinon il n'apparaitra pas dans la liste des groupes. Merci donc de veiller à ce que tous les groupes aient un style (= vert). Si groupe est en rouge, sélectionnez 1 à 3 styles pour le définir. Merci !</div>
<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Style libre</th>
      <th>Styles (1 à 3)</th>
      <th>Modifier</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$groupes key=id_grp item=groupe}
    <tr>
      <td style="background-color: {$groupe.bgcolor|escape}">{$groupe.name|escape}</td>
      <td style="background-color: {$groupe.bgcolor|escape}">{$groupe.style|escape}</td>
      <td style="background-color: {$groupe.bgcolor|escape}">
      {if !empty($groupe.styles)}
      <ol>
      {foreach from=$groupe.styles key=ordre item=style}
      <li>{$ordre|escape} - {$style|escape}</li>
      {/foreach}
      </ol>
      {/if}
      </td>
      <td style="background-color: {$groupe.bgcolor|escape}"><a href="/adm/groupe-de-style/{$groupe.id|escape}">Modifier</a></td>
    </tr>
    {/foreach}
  </tbody>
</table>

  </div>
</div>

{include file="common/footer.tpl"}
