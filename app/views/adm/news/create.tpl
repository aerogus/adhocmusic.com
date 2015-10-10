{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Ajout News"}

<form id="form-news-create" name="form-news-create" action="/adm/news/create" method="post">
  <fieldset>
    <ol>
      <li>
        <input type="text" id="title" name="title" style="width: 200px; float: right;" />
        <label for="title">Titre</label>
      </li>
      <li>
        <textarea id="intro" name="intro" style="width: 100%; height: 400px; float: right;"></textarea>
        <label for="intro">Intro</label>
      </li>
      <li>
        <textarea id="text" name="text" style="width: 100%; height: 400px; float: right;"></textarea>
        <label for="text">Texte</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-news-create-submit" name="form-news-create-submit" class="button" type="submit" value="Enregistrer" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
