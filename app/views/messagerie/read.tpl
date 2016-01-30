{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Message"}
<ul>
  <li>De : <a href="/membres/show/{$msg.from}">{$msg.pseudo}</a></li>
  <li>Envoyé le : {$msg.date|date_format:'%d/%m/%Y %H:%M'}</li>
</ul>
<div class="msgread" style="margin: 10px; padding: 10px; border: 1px solid #666;">{$msg.text|@wordwrap|@nl2br}</div>

{include file="messagerie/_write.tpl"}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
