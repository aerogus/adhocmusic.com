{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajout d'une question fréquente</h1>
  </header>
  <div>
  <form id="form-faq-create" name="form-faq-create" action="/adm/faq/create" method="post">
  <ul>
    <li>
      <label for="id_category">Catégorie</label>
      <select name="id_category">
      {foreach from=$categories item=cat}
        <option value="{$cat->getId()}">{$cat->getName()}</option>
      {/foreach}
      </select>
    </li>
    <li>
      <label for="question">Question</label>
      <textarea id="question" name="question"></textarea>
    </li>
    <li>
      <label for="answer">Réponse</label>
      <textarea id="answer" name="answer"></textarea>
    </li>
    <li>
      <label for="online">Afficher</label>
      <input class="switch" type="checkbox" id="online" name="online">
    </li>
  </ul>
  <input class="button" id="form-faq-create-submit" name="form-faq-create-submit" type="submit">
  </form>
  </div>
</div>

{include file="common/footer.tpl"}
