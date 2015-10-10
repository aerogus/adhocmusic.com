{include file="common/header.tpl"}

{if !empty($unknown_photo)}

<p class="error">Cette photo est introuvable !</p>

{else}

{include file="common/boxstart.tpl" boxtitle="Supprimer une photo"}
<form id="form-photo-delete" name="form-photo-delete" method="post" action="/photos/delete">
  <fieldset>
    <ol>
      <li>
        <img src="{$photo->getThumb400Url()}" alt="" />
      </li>
      <li>
        Titre :
        {$photo->getName()|escape}
      </li>
      <li>
        Photographe :
        {$photo->getCredits()|escape}
      </li>
      {if !empty($groupe)}
      <li>
        Groupe :
        {$groupe->getName()|escape}
      </li>
      {/if}
      {if !empty($event)}
      <li>
        Evénement :
        {$event->getDate()} - {$event->getName()|escape}
      </li>
      {/if}
      {if !empty($lieu)}
      <li>
        Lieu :
        {$lieu->getIdDepartement()} - {$lieu->getName()|escape}
      </li>
      {/if}
    </ol>
  </fieldset>
  <input id="form-photo-delete-submit" name="form-photo-delete-submit" type="submit" class="button" value="Supprimer" />
  <input type="hidden" name="id" value="{$photo->getId()}" />
</form>
{include file="common/boxend.tpl"}

{/if}

{include file="common/footer.tpl"}
