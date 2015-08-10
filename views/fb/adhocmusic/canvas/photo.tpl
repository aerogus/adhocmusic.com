{include file="fb/adhocmusic/canvas/common/header.tpl"}

{if !empty($photo)}
{include file="fb/adhocmusic/canvas/common/boxstart.tpl" title="Photo"}
<p align="center"><img src="{$pho.thumb_680_url}" align="center" /></p>
<p>
<img src="{#STATIC_URL#}/img/icones/signature.png" alt="" /> <strong>{$photo->getName()}</strong><br />
<img src="{#STATIC_URL#}/img/icones/photo.png" alt="" /> <strong>{$photo->getCredits()}</strong><br />
{if !empty($groupe)}<img src="{#STATIC_URL#}/img/icones/groupe.png" alt="" /> <a href="?m=groupe&id={$groupe->getId()}"><strong>{$groupe->getName()}</strong></a><br />{/if}
{if !empty($event)}<img src="{#STATIC_URL#}/img/icones/event.png" alt="" /> <a href="?m=event&id={$event->getId()}"><strong>{$event->getName()}</strong></a> ({$event->getDate()}<br />{/if}
{if !empty($lieu)}<img src="{#STATIC_URL#}/img/icones/lieu.png" alt="" /> <a href="?m=lieu&id={$lieu->getId()}"><strong>{$lieu->getName()}</strong></a> ({$lieu->getIdDepartement()} - {$lieu->getCity()})<br />{/if}
{if !empty($membre)}<img src="{#STATIC_URL#}/img/icones/upload.png" alt="" /> <a href="?m=profil&id={$membre->getId()}"><strong>{$membre->getPseudo()}</strong></a><br />{/if}
{if $photo.who}<img src="{#STATIC_URL#}/img/icones/tag.png" alt="" /> {$str_who}{/if}
</p>
{include file="fb/adhocmusic/canvas/common/boxend.tpl"}
{/if}

{if !empty($error)}
<p>Photo introuvable</p>
{/if}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
