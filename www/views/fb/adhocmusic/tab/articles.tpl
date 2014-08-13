{include file="fb/adhocmusic/tab/common/header.tpl"}

{include file="fb/adhocmusic/tab/common/boxstart.tpl"}

<ul>
{foreach from=$articles item=article}
  <li>
    <div>
      <a href="/fb/adhocmusic/tab/article/{$article.id}"><strong>{$article.title|escape}</strong></a><br />
      [{$article.rubrique_title|upper|escape}] Par {$article.pseudo} le {$article.created_on|date_format:'%e %B %Y'}
    </div>
    <div>
      {$article.intro|escape} <a href="/fb/adhocmusic/tab/article/{$article.id}">[ Lire la suite ... ]</a>
    </div>
  </li>
{/foreach}
</ul>

{include file="fb/adhocmusic/tab/common/boxend.tpl"}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
