{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Newsletters</h1>
  </header>
  <div>
    <p>nombre d'abonnés : {$nb_sub}</p>
    <p><a href="/adm/newsletter/create" class="btn btn--primary">Écrire une lettre</a></p>
    <table class="table table--zebra">
      <thead>
        <tr>
          <th scope="col" class="w10">#</th>
          <th scope="col" class="w10">Voir</th>
          <th scope="col">Sujet</th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$newsletters item=newsletter}
        <tr>
          <td>{$newsletter->getIdNewsletter()}</td>
          <td><a href="/newsletters/{$newsletter->getIdNewsletter()}" target="_blank">[voir]</a></td>
          <td><a href="/adm/newsletter/edit/{$newsletter->getIdNewsletter()|escape}">{$newsletter->getTitle()|escape}</a></td>
        </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
