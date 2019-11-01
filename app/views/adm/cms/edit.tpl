{include file="common/header.tpl" js_jquery_tinymce=true}

<script>
$(function() {

    $('textarea.tinymce').tinymce({
        // Location of TinyMCE script
        script_url: 'https://www.adhocmusic.com/tinymce/tiny_mce.js',

        // General options
        theme: "advanced",
        plugins: "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect",
        theme_advanced_buttons2: "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,forecolor,backcolor,media,fullscreen",
        theme_advanced_buttons3: "",
        theme_advanced_buttons4: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,

        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",

        // Replace values for the template plugin
        template_replace_values: {
            username: "Some User",
            staffid: "991234"
        }
    });

});
</script>

<div class="box">
  <header>
    <h1>Pages Statiques</h1>
  </header>
  <div>

<form id="form-cms-edit" name="form-cms-edit" action="/adm/cms/edit" method="post">
  <ul>
    <li>
      <label for="alias">URI</label>
      <span></span>
      <input id="alias" name="alias" value="{$cms->getAlias()|escape}">
    </li>
    <li>
      <label for="menuselected">Menu</label>
      <span>Quel est le menu de 1er niveau qui est sélectionné ?</span>
      <span>home, assoce, groupes, agenda, medias, lieux, articles, forums, chat, contact</span>
      <input type="text" id="menuselected" name="menuselected" value="">
    </li>
    <li>
      <label for="breadcrumb">Fil d'ariane</label>
      <span></span>
      <input type="text" id="breadcrumb" name="breadcrumb" value="">
    </li>
    <li>
      <label for="content">Contenu</label>
      <span></span>
      <textarea class="tinymce" id="content" name="content">{$cms->getContent()|escape}</textarea>
    </li>
    <li>
      <label for="online">En Ligne</label>
      <input type="checkbox"{if $cms->getOnline()} checked="checked"{/if} id="online" name="online">
    </li>
    <li>
      <label for="auth">Droits d'identification</label>
      <select id="auth" name="auth">
      <option value="0">Non</option>
      {foreach from=$auth key=auth_id item=auth_name}
      <option value="{$auth_id}"{if ($cms->getAuth() == $auth_id)} selected="selected"{/if}>{$auth_name|escape}</select>
      {/foreach}
    </li>
  </ul>
  <input type="hidden" name="id_cms" value="{$cms->getId()|escape}">
  <input id="form-cms-edit-submit" name="form-cms-edit-submit" type="submit" value="OK" class="button">
</form>

<a href="/adm/cms/delete/{$cms->getId()|escape}">Effacer la page</a>

  </div>
</div>

{include file="common/footer.tpl"}
