{include file="common/header.tpl" js_jquery_tinymce=true}

{if !empty($error_article)}

<p class="error">Cet article est introuvable ou vous n'avez pas les droits pour l'éditer !</p>

{else}

{include file="common/boxstart.tpl" boxtitle="Modifier un Article"}

<script>
$(function() {

  $('textarea.tinymce').tinymce({
    // Location of TinyMCE script
    script_url : 'http://static.adhocmusic.com/tinymce/tiny_mce.js',

    // General options
    theme : "advanced",
    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

    // Theme options
    theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,forecolor,backcolor,media,fullscreen",
    theme_advanced_buttons3 : "",
    theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    // Example content CSS (should be your site CSS)
    content_css : "css/content.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",

    // Replace values for the template plugin
    template_replace_values : {
      username : "Some User",
      staffid : "991234"
    }
  });

  $("#form-article-edit").submit(function() {
    var valid = true;
    if($("#id_rubrique").val() == 0) {
      $("#error_id_rubrique").fadeIn();
      valid = false;
    } else {
      $("#error_id_rubrique").fadeOut();
    }
    if($("#title").val() == "") {
      $("#error_title").fadeIn();
      valid = false;
    } else {
      $("#error_title").fadeOut();
    }
    if($("#intro").val() == "") {
      $("#error_intro").fadeIn();
      valid = false;
    } else {
      $("#error_intro").fadeOut();
    }
    if($("#text").val() == "") {
      $("#error_text").fadeIn();
      valid = false;
    } else {
      $("#error_text").fadeOut();
    }
    return valid;
  });

});
</script>

<form id="form-article-edit" name="form-article-edit" action="/articles/edit" method="post" enctype="multipart/form-data">
    <ol>
      <li>
        <label for="url">URL</label>
        <a href="{$article->getUrl()|escape}">{$article->getUrl()|escape}</a>
      </li>
      <li>
        <label for="online">En Ligne</label>
        <input type="checkbox" id="online" name="online" {if $article->getOnline()} checked="checked"{/if} /></span>
      </li>
      <li>
        <div id="error_id_rubrique" class="error"{if empty($error_id_rubrique)} style="display: none"{/if}>Vous devez selectionner une rubrique</div>
        <label for="id_rubrique">Rubrique</label>
        <select id="id_rubrique" name="id_rubrique">
          <option value="0">-- Choix Rubrique --</option>
          {foreach from=$rubriques item=rubrique}
          <option value="{$rubrique.id|escape}"{if $rubrique.id == $article->getIdRubrique()} selected="selected"{/if}>{$rubrique.title|escape}</option>
          {/foreach}
        </select>
      </li>
      <li>
        <label for="image">Image 100x100</label>
        <input type="file" id="image" name="image" />
        <img src="{$article->getImage()}" alt="" />
      </li>
      <li>
        <div id="error_title" class="error"{if empty($error_title)} style="display: none"{/if}>Vous devez préciser un titre</div>
        <label for="title">Titre</label>
        <input id="title" type="text" name="title" size="50" value="{$article->getTitle()|escape}" />
      </li>
      <li>
        <div id="error_intro" class="error"{if empty($error_intro)} style="display: none"{/if}>Vous devez écrire une introduction</div>
        <label for="intro">Intro (texte brut)</label>
        <textarea style="width: 650px; height: 100px;" id="intro" name="intro">{$article->getIntro()|escape}</textarea>
      </li>
      <li>
        <div id="error_text" class="error"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire un texte</div>
        <label for="text">Contenu (xhtml)</label>
        <textarea class="tinymce" style="width: 100%; height: 500px;" id="text" id="text" name="text">{$article->getText()|escape}</textarea>
      </li>
    </ol>
  <input type="hidden" name="id" value="{$article->getId()|escape}" />
  <input type="hidden" name="id_contact" value="{$article->getIdContact()|escape}" />
  <input id="form-article-edit-submit" name="form-article-edit-submit" type="submit" value="Enregistrer" />
</form>

{include file="common/boxend.tpl"}

{/if} {* error_article *}

{include file="common/footer.tpl"}
