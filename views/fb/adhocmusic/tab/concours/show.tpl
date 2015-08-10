{include file="fb/adhocmusic/tab/common/header.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" boxtitle="Jeux Concours"}

{if empty($member)}
<div class="error">Vous devez avoir un compte adhoc valide sur adhocmusic.com et le lier à votre compte facebook pour pouvoir participer aux jeux concours</div>
{/if}

{$concours->getDescription()}

{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
