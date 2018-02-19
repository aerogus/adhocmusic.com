{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle=$groupe->getName()}

<table>
  <caption>Infos générales</caption>
  <tr>
    <th>Id</th>
    <td>{$groupe->getId()}</td>
  </tr>
  <tr>
    <th>Etat</th>
    <td>{$groupe->getEtat()}</td>
  </tr>
  <tr>
    <th>Nom</th>
    <td>{$groupe->getName()}</td>
  </tr>
  <tr>
    <th>Alias</th>
    <td>{$groupe->getAlias()}</td>
  </tr>
  <tr>
    <th>Style</th>
    <td>{$groupe->getStyle()}</td>
  </tr>
  <tr>
    <th>Influences</th>
    <td>{$groupe->getInfluences()}</td>
  </tr>
  <tr>
    <th>Line-up</th>
    <td>{$groupe->getLineup()}</td>
  </tr>
  <tr>
    <th>Mini-texte</th>
    <td>{$groupe->getMiniText()|@nl2br}</td>
  </tr>
  <tr>
    <th>Texte</th>
    <td>{$groupe->getText()}</td>
  </tr>
  <tr>
    <th>Site</th>
    <td>{$groupe->getSite()}</td>
  </tr>
  <tr>
    <th>Facebook Page Id</th>
    <td><a href="{$groupe->getFacebookPageUrl()}">{$groupe->getFacebookPageId()}</a></td>
  </tr>
  <tr>
    <th>Création</th>
    <td>{$groupe->getCreatedOn()}</td>
  </tr>
  <tr>
    <th>Modification</th>
    <td>{$groupe->getModifiedOn()}</td>
  </tr>
  <tr>
    <th>Template</th>
    <td>{$groupe->getTemplate()}</td>
  </tr>
  <tr>
    <th>Photo</th>
    <td>{if $groupe->getPhoto()}<img src="{$groupe->getPhoto()}" alt="">{/if}</td>
  </tr>
  <tr>
    <th>Logo</th>
    <td>{if $groupe->getLogo()}<img src="{$groupe->getLogo()}" alt="">{/if}</td>
  </tr>
  <tr>
    <th>Mini Photo</th>
    <td><img src="{$groupe->getMiniPhoto()}" alt=""></td>
  </tr>
  <tr>
    <th>Le Mot AD'HOC</th>
    <td>{$groupe->getComment()}</td>
  </tr>
</table>

<table>
  <caption>Styles</caption>
  {foreach from=$groupe->getStyles() item=style}
  <tr><td>{$style.id}</td></tr>
  {/foreach}
</table>

<table>
  <caption>Membres</caption>
  {foreach from=$groupe->getMembers() item=member}
  <tr>
    <th>{$member.nom_type_musicien|escape}</th>
    <td>{$member.first_name|escape} {$member.last_name|escape} (<a href="/adm/membres/{$member.id}">{$member.pseudo|escape}</a>)</td>
    <td><a class="button" href="/adm/appartient-a?from=groupe&amp;action=delete&amp;groupe={$groupe->getId()}&amp;membre={$member.id}">Supprimer</a></td>
  </tr>
  {/foreach}
</table>
<a class="button" href="/adm/appartient-a?from=groupe&amp;action=create&amp;groupe={$groupe->getId()}">Ajout Membre</a>
{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
