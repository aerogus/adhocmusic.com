{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajouter un article"}

<form id="blog-add" name="blog-add" method="post" action="/blog/add" enctype="multipart/form-data">
  <fieldset>
    <ol>
      <li>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" />
      </li>
      <li>
        <label for="text">Texte</label>
        <textarea id="text" name="text" rows="10" cols="40"></textarea>
      </li>
      <li>
        <label for="file">Pièce jointe</label>
        <input type="file" id="file" name="file" />
      </li>
    </ol>
  </fieldset>
  <input type="hidden" name="groupe" value="{$groupe}" />
  <input id="blog-add-submit" name="blog-add-submit" class="button" type="submit" value="Ok" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}