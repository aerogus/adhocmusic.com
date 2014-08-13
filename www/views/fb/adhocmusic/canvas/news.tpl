{include file="fb/adhocmusic/canvas/common/header.tpl"}

{foreach from=$newslist item=news}
  {include file="fb/adhocmusic/canvas/common/boxstart.tpl" title=$news.title}
  {$news.text}
  {include file="fb/adhocmusic/canvas/common/boxend.tpl"}
{/foreach}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
