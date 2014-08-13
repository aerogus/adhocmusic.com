{include file="common/header.tpl"}

<script>
$(function() {

  updateBuddies();
  updateMessages();

  $('#chat-input').focus(function() {
    if($(this).val() == 'Ecrivez un message ici') {
        $(this).val('');
    }
  });

  $('#chat-input').keypress(function(e) {
    code = e.keyCode ? e.keyCode : e.which;
    if(code.toString() == 13) { // press enter
      if($(this).val() != '') {
        $.post(
          "/live/chat-send-message",
          { message: $(this).val() },
          function(data) {
          }
        );
        $(this).val(''); // reset input field
      }
    }
    updateMessages(false);
  });

});

var upd_buddies = setInterval("updateBuddies();", 30000);
var upd_messages = setInterval("updateMessages(true);", 10000);

function updateBuddies()
{
  $.get(
    "/live/chat-get-online",
    function(data) {
      $('#chat-online').html(data); // update online users list
    }
  );
}

function updateMessages(alerting)
{
  alerting = typeof(alerting) != 'undefined' ? alerting : true;

  var old_data = $('#chat-content').val();
  $.get(
    "/live/chat-get-last-messages",
    function(data) {
      if(old_data != '' && data != old_data) {
      }
      $('#chat-content').html(data); // update messages list
    }
  );
}

</script>

<style>
#chat-box {
    margin-right: 10px;
    border: 1px solid #999;
    width: 920px;
    height: 300px;
    float: right;
    background: #666;
    position: relative;
}
#chat-content {
    position: absolute;
    left: 5px;
    top: 5px;
    padding: 5px;
    width: 770px;
    height: 245px;
    background: #fff;
    color: #000;
    border: 1px solid #000;
    overflow: hidden;
    font-family: courier;
    font-size: 13px;
}
#chat-content td {
    padding: 0 3px;
}
#chat-online {
    position: absolute;
    right: 5px;
    top: 5px;
    padding: 5px;
    width: 110px;
    height: 245px;
    background: #fff;
    color: #000;
    border: 1px solid #000;
    overflow: hidden;
}
#chat-input {
    position: absolute;
    left: 5px;
    bottom: 5px;
    width: 775px;
    height: 25px;
    background: #fff;
    border: 1px solid #000;
    padding-left: 5px;
    color: #000;
}
</style>

<div>

<div>
  <p>Pour suivre le concert :</p>
  <ul>
    <li>Si vous utilisez Firefox, la vidéo s'affiche directement sur la gauche</li>
    <li>Si vous utilisez un autre navigateur, il faut que java soit installé, et la vidéo s'affichera dans une applet</li>
    <li>Vous pouvez également suivre le flux (ogg/theora) avec un lecteur vidéo comme <a href="http://www.videolan.org">VLC</a> (recommandé) en saisissant l'une des adresses suivantes :<br />
        <ul>
          <li><a href="http://www.adhocmusic.com:8000/live.ogg">http://www.adhocmusic.com:8000/live.ogg</a></li>
          <li><a href="http://www.adhocmusic.com:8000/live.ogg.m3u">http://www.adhocmusic.com:8000/live.ogg.m3u</a></li>
          <li><a href="http://www.adhocmusic.com:8000/live.ogg.xspf">http://www.adhocmusic.com:8000/live.ogg.xspf</a></li>
        </ul>
    </li>
  </ul>

  <p>Actuellement : <strong>OFFLINE</strong> (diffusions d'anciens concerts AD'HOC)</p>
  {*
  <p>Actuellement : <strong>ONLINE</strong> (en direct de la salle G. Pompidou)</p>
  *}


<ul class="share-box">
  <li style="float: left; padding: 5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="adhocmusic" data-lang="fr">Tweeter</a><script src="http://platform.twitter.com/widgets.js"></script></li>
  <li style="float: left; padding: 5px;"><fb:like href="http://www.adhocmusic.com/live" send="false" layout="box_count" width="65" show_faces="false" font="arial"></fb:like></li>
  <li style="float: left; padding: 5px;"><g:plusone size="tall"></g:plusone></li>
</ul>
<br clear="all" />
</div>

<p align="center">

{if !empty($html5)}

<video autoplay controls width="{$width}" height="{$height}">
  <source src="http://www.adhocmusic.com:8000/live.ogg" type="video/ogg" />
</video>

{else}

<applet code="com.fluendo.player.Cortado.class" archive="http://static.adhocmusic.com/java/cortado.jar" width="{$width}" height="{$height}">
  <param name="url" value="http://www.adhocmusic.com:8000/live.ogg" />
  <param name="local" value="false" />
  <param name="video" value="true" />
  <param name="audio" value="true" />
  <param name="bufferSize" value="100" />
  <param name="live" value="true" />
</applet>

{/if}

</p>

</div>

{*
{include file="comments/share.tpl" title="cette retransmission Live AD'HOC" url='http://www.adhocmusic.com/live'}
*}

<div id="chat-box">
{if !empty($chat_enabled)}
  <div id="chat-content"></div>
  <div id="chat-online"></div>
  <input type="text" name="chat-input" id="chat-input" value="Ecrivez un message ici" maxlength="80" />
{else}
  <div class="warning"><a href="/auth/login" style="color: #000; font-weight: bold;">Identifiez vous</a> ou <a href="/membres/create" style="color: #000; font-weight: bold;">créez un compte</a> pour accéder au chat et parler avec les membres connectés</div>
{/if}
</div>

{include file="common/footer.tpl"}
