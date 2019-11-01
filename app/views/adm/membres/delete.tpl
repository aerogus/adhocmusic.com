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
</table>

<p>Confirmer la suppression ?</p>

  </div>
</div>

{include file="common/footer.tpl"}
