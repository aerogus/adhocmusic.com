{include file="common/header.tpl"}

{if !empty($sent)}<p class="infobulle success">Votre message a bien été envoyé</p>{/if}

<div class="grid-2-small-1-tiny-1 has-gutter">

  <div class="col-1">

    <div class="box">
      <header>
        <h1>Messages reçus</h1>
      </header>
      <div>
        <table>
          <tr>
            <th>Lu</th>
            <th>De</th>
            <th>Date</th>
            <th>Message</th>
            <th>&nbsp;</th>
          </tr>
          {foreach from=$inbox key=cpt item=msg}
          <tr>
            <td><img src="/img/icones/{if !empty($msg->getReadTo())}email_open.png{else}email.png{/if}" alt=""></td>
            <td><a href="/messagerie/write?pseudo={$msg->getMembreFrom()->getPseudo()|escape}">{$msg->getMembreFrom()->getPseudo()|escape}</a></td>
            <td>{$msg->getDate()|date_format:'%d/%m/%Y à %H:%M'}</td>
            <td><a href="/messagerie/read/{$msg->getId()|escape}">{$msg->getText()|truncate:40|escape}</a></td>
            <td><p class="del-msg-to" data-msg-id="{$msg->getId()|escape}" title="Effacer ce message">❌</p></td>
          </tr>
          {/foreach}
        </table>
      </div>
    </div>

    <div class="box">
      <header>
        <h1>Messages envoyés</h1>
      </header>
      <div>
        <table>
          <tr>
            <th>Lu</th>
            <th>De</th>
            <th>Date</th>
            <th>Message</th>
            <th>&nbsp;</th>
          </tr>
          {foreach from=$outbox key=cpt item=msg}
          <tr>
            <td><img src="/img/icones/{if !empty($msg->getReadTo())}email_open.png{else}email.png{/if}" alt=""></td>
            <td><a href="/messagerie/write?pseudo={$msg->getMembreTo()->getPseudo()|escape}">{$msg->getMembreTo()->getPseudo()|escape}</a></td>
            <td>{$msg->getDate()|date_format:'%d/%m/%Y à %H:%M'}</td>
            <td><a href="/messagerie/read/{$msg->getId()|escape}">{$msg->getText()|truncate:40|escape}</a></td>
            <td><p class="del-msg-from" data-msg-id="{$msg->getId()|escape}" title="Effacer ce message">❌</p></td>
          </tr>
          {/foreach}
        </table>
      </div>
    </div>

  </div>

  <div class="col-1">

    <div class="box">
      <header>
        <h1>Écrire à :</h1>
      </header>
      <div>
        <form action="/messagerie/write" method="get">
          <input type="text" id="pseudo" name="pseudo" value="" autocomplete="off">
          <div id="suggests" style="padding-left:15px"></div>
        </form>
      </div>
    </div>

  </div>

</div>

{include file="common/footer.tpl"}
