{include file="common/header.tpl"}

<div class="box">
  <header>
    <h2>{$thread.subject}</h2>
  </header>
  <div>

<script>
$(function() {

  $(".toggle").hover(function () {
      var toggle_id = $(this).attr('id').replace('toggle_', '');
      $("#msg_" + toggle_id).toggle();
  });

  $(".thread-avatar").hover(function () {
      $(this).addClass('thread-avatar-full');
  }, function() {
      $(this).removeClass('thread-avatar-full');
  });

  $('textarea.tinymce').tinymce({
      // Location of TinyMCE script
      script_url: '//www.adhocmusic.com/tinymce/tiny_mce.js',

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
      template_replace_values : {
          username: "Some User",
          staffid: "991234"
      }
  });

  $("#form-forum-write").submit(function () {
      var valid = true;
      if($("#text").val() === "") {
          $("#text").prev(".error").fadeIn();
          valid = false;
      } else {
          $("#text").prev(".error").fadeOut();
      }
      return valid;
  });

});
</script>

<div class="subscribers round-corners-all">
{foreach $subs as $sub}
<a href="/adm/membres/{$sub.id_contact}" title="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}"><img src="/media/membre/ca/{$sub.id_contact}.jpg" class="thread-avatar" alt="{$sub.pseudo|escape} - {$sub.port|escape} - {$sub.email|escape}" /></a>
{/foreach}
<br style="clear: both">
</div>

<a class="button" href="/adm/forums/forum/{$id_forum|escape}">Retour forum</a>

{foreach $messages as $message}
<div class="clearfix message">
  <div class="message-meta">
    <img src="/media/membre/ca/{$message.created_by}.jpg" alt="">
    <a href="/membres/{$message.created_by}">{$message.created_by|pseudo_by_id}</a><br>
    {$message.created_on|date_format:'%a %d %b %Y<br>%H:%M'}
  </div>
  <div class="message-body">
    {$message.parsed_text|@nl2br}
  </div>
</div>
{/foreach}

{pagination nb_items=$nb_items nb_items_per_page=$nb_items_per_page page=$page}

  </div>
</div>

{include file="common/boxstart.tpl" boxtitle="Répondre"}

<form id="form-forum-write" name="form-forum-write" method="post" action="/adm/forums/write">
  <ul>
    <li>
      <label for="text">Message</label>
      <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
      <textarea class="tinymce" name="text" id="text" rows="10" cols="80" style="width: 100%;">{$text|escape}</textarea>
    </li>
    <li>
      <input id="form-forum-write-submit" name="form-forum-write-submit" type="submit" value="Envoyer" class="button" style="padding: 5px 0;">
    </li>
  </ul>
  <input name="check" id="check" type="hidden" value="{$check|escape}">
  <input name="id_forum" id="id_forum" type="hidden" value="{$id_forum|escape}">
  <input name="id_thread" id="id_thread" type="hidden" value="{$id_thread|escape}">
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
