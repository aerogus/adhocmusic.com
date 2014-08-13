{include file="common/header.tpl"}

<script>
$(function() {
  $.get(
    "/live/chat-get-online",
    function(data2) {
      $('#chat-online').html(data2); // update online users list
    }
  );
  $.get(
    "/live/chat-get-last-messages",
    function(data) {
      $('#chat-content').html(data); // update messages list
    }
  );
  $('#chat-input').keypress(function(e) {
    code = e.keyCode ? e.keyCode : e.which;
    if(code.toString() == 13) { // press enter
      $.post(
        "/live/chat-send-message",
        { message: $(this).val() },
        function(data) {
          //alert("Envoi message: " +  data);
        }
      );
      $(this).val(''); // reset input field
    }
    $.get(
      "/live/chat-get-last-messages",
      function(data) {
        $('#chat-content').html(data); // update messages list
      }
    );
  });
});
</script>

<style>
#chat-box {
    margin-right: 10px;
    border: 1px solid #fff;
    width: 500px;
    height: 320px;
    float: right;
    background: #666;
    position: relative;
}
#chat-content {
    position: absolute;
    left: 5px;
    top: 5px;
    width: 380px;
    height: 275px;
    background: #fff;
    color: #000;
    border: 1px solid #000;
    overflow: hidden;
}
#chat-online {
    position: absolute;
    right: 5px;
    top: 5px;
    width: 100px;
    height: 275px;
    background: #fff;
    color: #000;
    border: 1px solid #000;
    overflow: hidden;
}
#chat-input {
    position: absolute;
    left: 5px;
    bottom: 5px;
    width: 483px;
    height: 25px;
    background: #fff;
    border: 1px solid #000;
    padding-left: 5px;
    color: #000;
}
</style>

<p class="warning">Salut à tous ! Bienvenue sur la diffusion live du concert AD'HOC. L'émission commencera à 16h00 et le live vers 20h00. Bonne écoute !</p>

<div id="chat-box">
  <div id="chat-content"></div>
  <div id="chat-online"></div>
  <input type="text" name="chat-input" id="chat-input" maxlength="40" />
</div>

<div style="margin-left: 10px;">
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="400" height="320" id="utv525120">
    <param name="flashvars" value="autoplay=false&amp;brand=embed&amp;cid=7227321&amp;v3=1"/>
    <param name="allowfullscreen" value="true"/>
    <param name="allowscriptaccess" value="always"/>
    <param name="movie" value="http://www.ustream.tv/flash/viewer.swf"/>
    <embed flashvars="autoplay=false&amp;brand=embed&amp;cid=7227321&amp;v3=1" width="400" height="320" allowfullscreen="true" allowscriptaccess="always" id="utv525120" name="utv_n_385554" src="http://www.ustream.tv/flash/viewer.swf" type="application/x-shockwave-flash" />
  </object>
</div>

{include file="common/footer.tpl"}
