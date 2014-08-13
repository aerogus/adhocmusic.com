{if !empty($articles)}
{foreach from=$articles item=article}
<div class="art-item">
  <a href="{$article.url}">
    <img src="{$article.image}" alt="" style="float: left; margin-right: 5px;" />
    <h3>{$article.title|escape}</h3>
    <span>{$article.created_on|date_format:'%e %B %Y'}</span>
    <p>{$article.intro|escape}</p>
  </a>
</div>
{/foreach}
{/if}
