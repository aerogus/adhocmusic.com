{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Liaisons groupe / styles"}

<form id="form-groupe-de-style" name="form-groupe-de-style" action="/adm/groupe-de-style" method="post">
  <fieldset>
    <ol>
      <li>
        <label for="name">Nom</label>
        <strong>{$groupe->getName()|escape}</strong>
      </li>
      <li>
        <label for="style">Style</label>
        <strong>{$groupe->getStyle()|escape}</strong>
      </li>
      <li>
        <label for="style_1">Style 1</label>
        {$form_style.0}
      </li>
      <li>
        <label for="style_2">Style 2</label>
        {$form_style.1}
      </li>
      <li>
        <label for="style_3">Style 3</label>
        {$form_style.2}
      </li>
      <li>
        <label for="influences">Influences</label>
        {$groupe->getInfluences()|escape}
      </li>
      <li>
        <label for="mini_text">Mini Texte</label>
        {$groupe->getMiniText()|escape}
      </li>
      <li>
        <label for="text">Texte</label>
        {$groupe->getText()|escape}
      </li>
    </ol>
  </fieldset>
  <input id="form-groupe-de-style-submit" name="form-groupe-de-style-submit" type="submit" class="button" value="Ok" />
  <input type="hidden" name="id_groupe" value="{$groupe->getId()|escape}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}