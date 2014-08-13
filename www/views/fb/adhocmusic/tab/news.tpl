{include file="fb/adhocmusic/tab/common/header.tpl"}

{foreach from=$newslist item=news}
  {include file="fb/adhocmusic/tab/common/boxstart.tpl" title=$news.title}
  {$news.text}
  {include file="fb/adhocmusic/tab/common/boxend.tpl"}
{/foreach}

{include file="fb/adhocmusic/tab/common/footer.tpl"}
