<html>
<body style="margin: 0; padding: 0;">
{if !empty($unknown_video)}
<p class="infobulle error">Cette vidéo est introuvable !</p>
{else}
{$video->getPlayer(true)}
{/if} {* test unknown video *}
</body>
</html>
