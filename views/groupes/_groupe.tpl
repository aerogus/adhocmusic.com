<li class="boxgrp {$groupe.class}">
  <a name="{$groupe.id}" href="{$groupe.url}" title="{$groupe.mini_text|escape}">
  <img src="{$groupe.mini_photo}" alt="" class="imggrp" />
  <strong>{$groupe.name|escape}</strong><br />
  <em>{$groupe.style|escape}</em><br />
  Maj: {$groupe.modified_on|date_format:"%d/%m/%y"}
  </a>
</li>

