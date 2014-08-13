{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Supprimer un article"}

<form id="blog-del" name="blog-del" method="post" action="/blog/del">
  <fieldset>
    <ol>
      <li>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="{$article.title|escape}" />
      </li>
      <li>
        <label for="text">Texte</label>
        <textarea id="text" name="text" rows="10" cols="40">{$article.text|escape}</textarea>
      </li>
    </ol>
  </fieldset>
  <input type="hidden" id="id" name="id" value="{$id|escape}" />
  <input type="hidden" id="groupe" name="groupe" value="{$groupe}" />
  <input id="blog-del-submit" name="blog-del-submit" class="button" type="submit" value="Confirmer Suppression" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
