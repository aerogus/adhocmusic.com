{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle=$lieu->getName()|escape}

{if $lieu->hasPano()}
<applet archive="{#STATIC_URL#}/java/ptviewer-28-full.jar" code="ptviewer.class" width="480" height="300">
<param name="file" value="{#STATIC_URL#}/media/lieu/{$lieu->getId()}.360.jpg" />
</applet>
{else}
<p class="error">Ce lieu n'a pas de photo panoramique</p>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
