{include file="common/header.tpl"}

<p>Vos amis Facebook sont-ils sur AD'HOC ?</p>
<ul>
{foreach from=$friends item=friend}
  <li class="fb-profil{if !empty($friend->adhoc)} fb-profil-with-account{/if}">
    <img src="http://graph.facebook.com/{$friend->id|escape:'url'}/picture" alt="" />
    F: <a href="http://www.facebook.com/profile.php?id={$friend->id|escape}">{$friend->name|escape}</a><br />
    {if !empty($friend->adhoc)}
    A: <a href="/membres/show/{$friend->id_contact|escape}">{$friend->pseudo|escape}</a>
    {/if}
  </li>
{/foreach}
</ul>

<hr class="spacer" />

{include file="common/footer.tpl"}

