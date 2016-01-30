{include file="common/header.tpl"}

<script>
$(function() {
    $("#pseudo").keyup(function() {
        $.getJSON('/membres/autocomplete-pseudo.json', { q: $(this).val() }, function(data) {
            $("#suggests").empty();
            $('<ul>').appendTo('#suggests');
            $.each(data, function (key, val) {
                $('<li><a href="/messagerie/write?pseudo='+encodeURIComponent(val.pseudo)+'">'+encodeURIComponent(val.pseudo)+'</li>').appendTo('#suggests');
            });
            $('</ul>').appendTo('#suggests');
        });
    });
});

function deleteMessage(id, mode)
{
    var params = "mode="+mode+"&id="+id;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            location.reload(true);
        }
    };
    xhr.open("POST", '/messagerie/delete.json', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.setRequestHeader("Content-length", params.length);
    xhr.setRequestHeader("Connection", "close");
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send(params);
}
</script>

<div id="left-center">

{if !empty($sent)}<p class="success">Votre message a bien été envoyé</p>{/if}

{include file="common/boxstart.tpl" boxtitle="Messages reçus"}
<table align="center">
  <tr>
    <th>Lu</th>
    <th>De</th>
    <th>Date</th>
    <th>Message</th>
    <th>&nbsp;</th>
  </tr>
  {foreach from=$inbox key=cpt item=msg}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td><img src="/img/icones/{if !empty($msg.read)}email_open.png{else}email.png{/if}" alt=""></td>
    <td><a href="/messagerie/write?pseudo={$msg.pseudo|escape}">{$msg.pseudo|escape}</a></td>
    <td>{$msg.date|date_format:'%d/%m/%Y à %H:%M'}</td>
    <td><a href="/messagerie/read/{$msg.id|escape}">{$msg.text|truncate:40|escape}</a></td>
    <td><img src="/img/icones/delete.png" class="del-msg-to" id="del-msg-to-{$msg.id|escape}" alt="Effacer" onclick="deleteMessage({$msg.id|escape}, 'to');"></td>
  </tr>
  {/foreach}
</table>
{include file="common/boxend.tpl"}

{include file="common/boxstart.tpl" boxtitle="Messages envoyés"}
<table align="center">
  <tr>
    <th>Lu</th>
    <th>De</th>
    <th>Date</th>
    <th>Message</th>
    <th>&nbsp;</th>
  </tr>
  {foreach from=$outbox key=cpt item=msg}
  <tr class="{if $cpt is odd}odd{else}even{/if}">
    <td><img src="/img/icones/{if !empty($msg.read)}email_open.png{else}email.png{/if}" alt=""></td>
    <td><a href="/messagerie/write?pseudo={$msg.pseudo|escape}">{$msg.pseudo|escape}</a></td>
    <td>{$msg.date|date_format:'%d/%m/%Y à %H:%M'}</td>
    <td><a href="/messagerie/read/{$msg.id|escape}">{$msg.text|truncate:40|escape}</a></td>
    <td><img src="/img/icones/delete.png" class="del-msg-from" id="del-msg-from-{$msg.id|escape}" alt="Effacer" onclick="deleteMessage({$msg.id|escape}, 'from');"></td>
  </tr>
  {/foreach}
</table>
{include file="common/boxend.tpl"}

</div>

<div id="right">
{include file="common/boxstart.tpl" boxtitle="Ecrire à :"}
<form action="/messagerie/write" method="get">
  <input type="text" id="pseudo" name="pseudo" value="" autocomplete="off">
  <div id="suggests" style="padding-left: 15px;"></div>
</form>
{include file="common/boxend.tpl"}
</div>

{include file="common/footer.tpl"}
