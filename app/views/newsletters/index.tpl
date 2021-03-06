{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Newsletters</h1>
  </header>
  <div class="reset">
    <table class="table table--zebra">
      <thead>
        <tr>
          <th>Sujet</th>
        </tr>
      </thead>
      <tbody>
      {foreach $newsletters as $newsletter}
        <tr>
          <td><a href="/newsletters/{$newsletter->getIdNewsletter()}">{$newsletter->getTitle()|escape}</a></td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
