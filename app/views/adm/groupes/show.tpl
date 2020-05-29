{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>{$groupe->getName()}</h1>
  </header>
  <div>

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
    <td>{$groupe->getCreatedAt()}</td>
  </tr>
  <tr>
    <th>Modification</th>
    <td>{$groupe->getModifiedAt()}</td>
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
  <tr><td>{$style->getName()}</td></tr>
  {/foreach}
</table>

<table>
  <caption>Membres</caption>
  {foreach from=$groupe->getMembers() item=member}
  <tr>
    <td>{$member->getFirstName()|escape} {$member->getLastName()|escape} (<a href="/adm/membres/{$member->getIdContact()}">{$member->getPseudo()|escape}</a>)</td>
    <td><a class="btn btn--secondary" href="/adm/appartient-a?from=groupe&amp;action=delete&amp;groupe={$groupe->getId()}&amp;membre={$member->getIdContact()}">Supprimer</a></td>
  </tr>
  {/foreach}
</table>
<a class="btn btn--primary" href="/adm/appartient-a?from=groupe&amp;action=create&amp;groupe={$groupe->getId()}">Ajout Membre</a>

  </div>
</div>

{include file="common/footer.tpl"}
