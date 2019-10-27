{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>Newsletters</h2>
  </header>
  <div class="reset">
    <table class="table table--zebra">
      <thead>
        <tr>
<!--          <th>Date</th>-->
          <th>Sujet</th>
        </tr>
      </thead>
      <tbody>
      {foreach $newsletters as $newsletter}
        <tr>
<!--          <td>{$newsletter.created_on}</td>-->
          <td><a href="/newsletters/{$newsletter.id}">{$newsletter.title|escape}</a></td>
        </tr>
      {/foreach}
      </tbody>
    </table>
  </div>
</div>

{include file="common/footer.tpl"}
