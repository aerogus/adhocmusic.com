{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Membre</h1>
  </header>
  <div>
  <table>
    <caption>Infos générales</caption>
    <tr>
      <th>Id</th>
      <td>{$membre->getId()}</td>
    </tr>
    <tr>
      <th>Email</th>
      <td>{$membre->getEmail()}</td>
    </tr>
    <tr>
      <th>Date Ouverture Newsletter</th>
      <td>{$membre->getLastnl()}</td>
    </tr>
    <tr>
      <th>Abonnement Newsletter</th>
      <td>{$membre->getMailing()}</td>
    </tr>
    <tr>
      <th>Pseudo</th>
      <td>{$membre->getPseudo()}</td>
    </tr>
    <tr>
      <th>Nom</th>
      <td>{$membre->getLastName()}</td>
    </tr>
    <tr>
      <th>Prénom</th>
      <td>{$membre->getFirstName()}</td>
    </tr>
    <tr>
      <th>Date Inscription</th>
      <td>{$membre->getCreatedAt()}</td>
    </tr>
    <tr>
      <th>Date Modification</th>
      <td>{$membre->getModifiedAt()}</td>
    </tr>
    <tr>
      <th>Date Visite</th>
      <td>{$membre->getVisitedAt()}</td>
    </tr>
    <tr>
      <th>Adresse</th>
      <td>{$membre->getAddress()}</td>
    </tr>
    <tr>
      <th>Code Postal</th>
      <td>{if $membre->getCity()}{$membre->getCity()->getCp()}{/if}</td>
    </tr>
    <tr>
      <th>Ville</th>
      <td>{if $membre->getCity()}{$membre->getCity()->getName()}{/if}</td>
    </tr>
    <tr>
      <th>Pays</th>
      <td>{if $membre->getCountry()}{$membre->getCountry()->getName()}{/if}</td>
    </tr>
    <tr>
      <th>Téléphone</th>
      <td>{$membre->getTel()}</td>
    </tr>
    <tr>
      <th>Portable</th>
      <td>{$membre->getPort()}</td>
    </tr>
    <tr>
      <th>Site</th>
      <td>{$membre->getSite()}</td>
    </tr>
    <tr>
      <th>Niveau</th>
      <td>{$membre->getLevel()}</td>
    </tr>
    <tr>
      <th>Texte</th>
      <td>{$membre->getText()}</td>
    </tr>
  </table>
  <table>
    <caption>Ses Groupes</caption>
    <tr>
      <th>Nom</th>
      <th>Supprimer</th>
    </tr>
    {foreach from=$membre->getGroupes() item=groupe}
    <tr>
      <td><a href="/adm/groupes/{$groupe->getIdGroupe()}">{$groupe->getName()|escape}</a></td>
      <td><a class="btn btn--secondary" href="/adm/appartient-a?from=membre&action=delete&membre={$membre->getIdContact()}&groupe={$groupe->getIdGroupe()}">Supprimer</a></td>
    </tr>
    {/foreach}
  </table>
  <a class="btn btn--primary" href="/adm/appartient-a?from=membre&action=create&membre={$membre->getIdContact()}">Ajout Groupe</a>
  </div>
</div>

{include file="common/footer.tpl"}
