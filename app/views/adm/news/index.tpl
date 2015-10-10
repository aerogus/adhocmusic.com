{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Les News"}

<a class="button" href="/adm/news/create">Rédiger une news</a>

<table>
  <tr>
    <th>Crée le</th>
    <th>Modifié le</th>
    <th>Titre</th>
    <th>En Ligne</th>
  </tr>
  {foreach from=$newslist item=news}
  <tr>
    <td>{$news.created_on|date_format:'%d/%m/%Y %H:%M'}</td>
    <td>{$news.modified_on|date_format:'%d/%m/%Y %H:%M'}</td>
    <td><a href="/adm/news/edit/{$news.id|escape}">{$news.title|escape}</a></td>
    <td>{$news.online|display_on_off_icon}</td>
  </tr>
{/foreach}
</table>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
