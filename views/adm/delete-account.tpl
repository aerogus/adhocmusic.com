{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Suppression Compte"}

<form method="get">
  <fieldset>
    <ol>
      <li>
        <label for="id">id_contact</label>
        <input type="text" name="id" value="{if !empty($id)}{$id}{/if}" />
      </li>
      <li>
        <label for="email">email</label>
        <input type="text" name="email" value="{if !empty($email)}{$email}{/if}" />
      </li>
    </ol>
  </fieldset>
  <input type="submit" value="Ok" /></td>
</form>

<hr />

{if !empty($action)}
  {if $action == 'show'}
  {elseif $action == 'delete'}
  {/if}
{/if}

{$content}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
