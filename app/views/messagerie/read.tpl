{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Message reçu</h1>
  </header>
  <div>
    <ul>
      <li>De : <a href="/membres/{$msg.id_from}">{$msg.pseudo}</a></li>
      <li>Envoyé le : {$msg.date|date_format:'%d/%m/%Y %H:%M'}</li>
    </ul>
    <div class="msgread" style="margin: 10px; padding: 10px; border: 1px solid #666;">{$msg.text|@wordwrap|@nl2br}</div>
    {include file="messagerie/_write.tpl"}
  </div>
</div>

{include file="common/footer.tpl"}
