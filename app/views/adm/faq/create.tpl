{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Foire aux questions"}

<form id="form-faq-create" name="form-faq-create" action="/adm/faq/create" method="post">
  <ul>
    <li>
      <label for="id_category">Catégorie</label>
      <select name="id_category">
      {foreach from=$categories key=cat_id item=cat_name}
        <option value="{$cat_id}">{$cat_name}</option>
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
  </ul>
  <input id="form-faq-create-submit" name="form-faq-create-submit" type="submit">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
