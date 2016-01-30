{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Foire aux questions"}

<form id="form-faq-edit" name="form-faq-edit" action="/adm/faq/edit" method="post">
  <ul>
    <li>
      <label for="id_category">Catégorie</label>
      <select name="id_category">
      {foreach from=$categories key=cat_id item=cat_name}
        <option value="{$cat_id}"{if $faq->getIdCategory() == $cat_id} selected="selected"{/if}>{$cat_name}</option>
      {/foreach}
      </select>
    </li>
    <li>
      <label for="question">Question</label>
      <textarea id="question" name="question">{$faq->getQuestion()|escape}</textarea>
    </li>
    <li>
      <label for="answer">Réponse</label>
      <textarea id="answer" name="answer">{$faq->getAnswer()|escape}</textarea>
    </li>
  </ul>
  <input type="hidden" name="id_faq" value="{$faq->getId()}">
  <input id="form-faq-edit-submit" name="form-faq-edit-submit" type="submit">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
