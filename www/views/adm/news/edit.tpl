{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Edition News"}

<form id="form-news-edit" name="form-news-edit" action="/adm/news/edit" method="post">
  <fieldset>
    <ol>
      <li>
        <span style="float: right">{$news->getCreatedOn()|date_format:'%d/%m/%Y %H:%M:%S'}</span>
        <label for="created_on">Crée le :</label>
      </li>
      <li>
        <span style="float: right">{$news->getModifiedOn()|date_format:'%d/%m/%Y %H:%M:%S'}</span>
        <label for="modified_on">Modifié le :</label>
      </li>
      <li>
        <span style="float: right"><input type="checkbox" id="online" name="online" {if !empty($news->getOnline())} checked="checked"{/if} /></span>
        <label for="online">En ligne :</label>
      </li>
      <li>
        <input type="text" name="title" id="title" value="{$news->getTitle()|escape}" style="width: 200px; float: right" />
        <label for="title">Titre</label>
      </li>
      <li>
        <textarea id="intro" name="intro" style="width: 100%; height: 200px; float: right;">{$news->getIntro()|escape}</textarea>
        <label for="intro">Intro</label>
      </li>
      <li>
        <textarea id="text" name="text" style="width: 100%; height: 400px; float: right;">{$news->getText()|escape}</textarea>
        <label for="text">Texte</label>
      </li>
    </ol>
  </fieldset>
  <input id="form-news-edit-submit" name="form-news-edit-submit" class="button" type="submit" value="Enregistrer" />
  <input type="hidden" id="id_news" name="id_news" value="{$news->getId()|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
