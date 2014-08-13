{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Editer un article"}

<form id="blog-edit" name="blog-edit" method="post" action="/blog/edit" enctype="multipart/form-data">
  <fieldset>
    <ol>
      <li>
        <label for="title">Titre</label>
        <input id="title" type="text" name="title" value="{$article.title|escape}" />
      </li>
      <li>
        <label for="text">Texte</label>
        <textarea id="text" name="text" rows="10" cols="40">{$article.text|escape}</textarea>
      </li>
      <li>
        <label for="file">Pièce jointe</label>
        <input type="file" id="file" name="file" />
      </li>
    </ol>
  </fieldset>
  <input type="hidden" name="groupe" value="{$groupe}" />
  <input type="hidden" name="id" value="{$article.id}" />
  <input id="blog-edit-submit" name="blog-edit-submit" class="button" type="submit" value="Ok" />
</form>
<a href="/blog/del?groupe={$groupe}&amp;id={$id}">Supprimer l'article et tous ses contenus</a>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
