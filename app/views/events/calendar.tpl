<table class="calendar">
  <thead>
    <tr class="top">
      <th><a href="/events/?y={$prev_year}&amp;m={$prev_month}">◀</a></th>
      <th colspan="5"><a href="/events/?y={$year}&amp;m={$month}">{$months[$month]} {$year}</a></th>
      <th><a href="/events/?y={$next_year}&amp;m={$next_month}">▶</a></th>
    </tr>
    <tr class="days">
      <th>Lun</th>
      <th>Mar</th>
      <th>Mer</th>
      <th>Jeu</th>
      <th>Ven</th>
      <th>Sam</th>
      <th>Dim</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$cal item=row}
    <tr>
      {foreach from=$row item=cel}
        {if $cel.num == null}
          <td class="blank">&nbsp;</td>
        {elseif $cel.link == null}
          <td class="none{if $cel.selected} today{/if}">{$cel.num}</td>
        {else}
          <td class="event{if $cel.selected} today{/if}"><a href="/events/{$cel.link}" title="{$cel.title}">{$cel.num}</a></td>
        {/if}
     {/foreach}
    </tr>
    {/foreach}
  </tbody>
</table>
