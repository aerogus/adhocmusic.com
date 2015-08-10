{include file="fb/adhocmusic/tab/common/header.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" title={$article->getTitle()}}

<h1>{$article->getTitle()}</h1>
<p>Posté par {$article->getPseudo()} le {$article->getCreatedOn()|date_format:"%A %e %B %Y"}</p>

{$article->getText()}

{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl" title="Commentaires"}
<fb:like href="{$article->getUrl()}" show_faces="false" width="480" font="arial"></fb:like>
<fb:comments href="{$article->getUrl()}" num_posts="2" width="480" migrated="1"></fb:comments>
{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
