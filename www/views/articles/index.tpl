{include file="common/header.tpl"}

<div id="right">

{include file="common/boxstart.tpl" boxtitle="Participez"}
<p>Envie d'écrire des articles sur ce site ? Rejoignez-nous en tant que rédacteur ! Pour cela, <a href="/contact">contactez-nous</a></p>
{include file="common/boxend.tpl"}

{if !empty($comments)}
{include file="common/boxstart.tpl" boxtitle="Derniers commentaires"}
<ul>
{foreach from=$comments item=comment}
<li><strong>{$comment.pseudo}</strong> le {$comment.created_on|date_format:'%d/%m/%Y'}<br />
<em><a href="/{$comment.type_full}/show/{$comment.id_content}">{$comment.text|truncate:'200'}</a></em></li>
{/foreach}
</ul>
{include file="common/boxend.tpl"}
{/if}

</div>

<div id="left-center">

{if !empty($rub_err)}

  <div class="error">Rubrique introuvable</div>

{else}

  {if !empty($rubrique)}

    {include file="common/boxstart.tpl" boxtitle="{$rubrique.title|escape}"}

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

    {include file="common/boxend.tpl"}

  {else}

<script>
$(function() {
  $('.show-more-articles a').click(function(event) {
    event.preventDefault();
    var rub = $(this).parent().attr('id').substring(5, 100);
    $.get('/articles/more/' + rub, function(data) {
      $('#more-' + rub).html(data);
    });
  });
});
</script>

    {foreach from=$rubriques item=rubrique}

      {include file="common/boxstart.tpl" boxtitle="{$rubrique.title|escape}" boxtitlelink="{$rubrique.url}" boxtitle2="({$rubrique.nb_articles} articles)"}

        {foreach from=$last_articles_by_rubriques key=id_rubrique item=articles}
          {if $rubrique.id == $id_rubrique}
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
        {/foreach}

      <p class="show-more-articles" id="more-{$rubrique.alias|escape}"><a href="{$rubrique.url}">+ de {$rubrique.title}</a></p>

      {include file="common/boxend.tpl"}

    {/foreach}

  {/if} {* rubrique *}

{/if} {* rub_err *}

</div>

{include file="common/footer.tpl"}
