{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Édition d'une question fréquente</h1>
  </header>
  <div>
  <form id="form-faq-edit" name="form-faq-edit" action="/adm/faq/edit" method="post">
  <ul>
    <li>
      <label for="id_category">Catégorie</label>
      <select name="id_category">
      {foreach from=$categories item=cat}
        <option value="{$cat->getId()}"{if $faq->getIdCategory() === $cat->getId()} selected="selected"{/if}>{$cat->getName()}</option>
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
    <li>
      <label for="online">Afficher</label>
      <input class="switch" type="checkbox" id="online" name="online"{if $faq->getOnline()} checked="checked"{/if}>
    </li>
  </ul>
  <input type="hidden" name="id_faq" value="{$faq->getId()}">
  <input class="button" id="form-faq-edit-submit" name="form-faq-edit-submit" type="submit">
  </form>
  </div>
</div>

{include file="common/footer.tpl"}
