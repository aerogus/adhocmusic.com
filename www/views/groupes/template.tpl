{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Couleurs Fiche Groupe"}

<p>Valeurs entre 000000 (noir) et ffffff (blanc)</p>
<p><a href="/groupes/show/{$groupe->getId()}">Voir Fiche Groupe</a></p>
<form method="post" action="/groupes/template" enctype="multipart/form-data">
  <table align="center">
    <tr><td>Couleur fond de page</td><td><img src="{$tpl.body_background_color_thumb}" alt="" /></td><td><input name="body_background_color" type="text" size="10" maxlength="6" value="{$tpl.body_background_color}" /></td></tr>
    <tr><td>Image fond de page</td><td>&nbsp;</td><td><input name="body_background_image" type="file" /></td></tr>
    <tr><td>Couleur fond des titres</td><td><img src="{$tpl.title_background_color_thumb}" alt="" /></td><td><input name="title_background_color" type="text" size="10" maxlength="6" value="{$tpl.title_background_color}" /></td></tr>
    <tr><td>Couleur des titres</td><td><img src="{$tpl.title_color_thumb}" alt="" /></td><td><input name="title_color" type="text" size="10" maxlength="6" value="{$tpl.title_color}" /></td></tr>
    <tr><td>Couleur fond des fenêtres</td><td><img src="{$tpl.content_background_color_thumb}" alt="" /></td><td><input name="content_background_color" type="text" size="10" maxlength="6" value="{$tpl.content_background_color}" /></td></tr>
    <tr><td>Couleur des textes</td><td><img src="{$tpl.content_text_color_thumb}" alt="" /></td><td><input name="content_text_color" type="text" size="10" maxlength="6" value="{$tpl.content_text_color}" /></td></tr>
    <tr><td>Couleur des liens</td><td><img src="{$tpl.content_link_color_thumb}" alt="" /></td><td><input name="content_link_color" type="text" size="10" maxlength="6" value="{$tpl.content_link_color}" /></td></tr>
    <tr><td colspan="3" align="center"><input type="submit" value="Ok" /> <a href="/membres/groupes/">Mes Groupes</a></td></tr>
  </table>
  <input type="hidden" name="id_groupe" value="{$groupe->getId()}" />
</form>

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
