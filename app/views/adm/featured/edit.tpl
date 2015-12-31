{include file="common/header.tpl" js_jquery_jcrop=false js_jquery_ui=true css_jquery_ui=true js_jquery_ui_datepicker=true}

<script>
$(function() {

    $("#datdeb, #datfin").datepicker({
        dateFormat: 'yy-mm-dd',
        showAnim: 'slideDown'
    });

    $("#form-featured-edit").submit(function () {
        var valid = true;
        if($("#title").val() === 0) {
            $("#error_title").fadeIn();
            valid = false;
        } else {
            $("#error_title").fadeOut();
        }
        if($("#description").val().length === 0) {
            $("#error_description").fadeIn();
            valid = false;
        } else {
            $("#error_description").fadeOut();
        }
        return valid;
    });

});
</script>

<div class="box">
  <header>
    <h1>Edition à l'affiche</h1>
  </header>
  <div>
    <form id="form-featured-edit" name="form-featured-edit" action="/adm/featured/edit" method="post" enctype="multipart/form-data">
      <ul>
        <li>
          <div class="error" id="error_title"{if empty($error_title)} style="display: none"{/if}>Vous devez saisir un titre</div>
          <label for="title">Titre</label>
          <input style="width: 650px;" maxlength="35" type="text" name="title" id="title" value="{$data.title|escape}">
        </li>
        <li>
          <div class="error" id="error_description"{if empty($error_description)} style="display: none"{/if}>Vous devez saisir une description</div>
          <label for="description">Description</label>
          <input style="width: 650px;" maxlength="85" type="text" name="description" id="description" value="{$data.description|escape}">
        </li>
        <li>
          <div class="error" id="error_link"{if empty($error_link)} style="display: none"{/if}>Vous devez saisir un lien</div>
          <label for="link">Lien</label>
          <input style="width: 650px;" type="text" name="link" id="link" value="{$data.link|escape}">
        </li>
        <li>
          <div class="error" id="error_image"{if empty($error_image)} style="display: none"{/if}>Vous devez choisir une image</div>
          <label for="image">Image (.jpg 427x240)</label>
          <input type="file" name="image" id="image">
          <img src="{$data.image}" alt="">
        </li>
        <li>
          <div class="error" id="error_datdeb"{if empty($error_datdeb)} style="display: none"{/if}>Vous devez saisir une date de début</div>
          <label for="datdeb">Début</label>
          <input type="text" name="datdeb" id="datdeb" value="{$data.datdeb|date_format:"%Y-%m-%d"}">
        </li>
        <li>
          <div class="error" id="error_datfin"{if empty($error_datfin)} style="display: none"{/if}>Vous devez saisir une date de fin</div>
          <label for="datfin">Fin</label>
          <input type="text" name="datfin" id="datfin" value="{$data.datfin|date_format:"%Y-%m-%d"}">
        </li>
        <li>
          <label for="online">En Ligne</label>
          <input type="checkbox" name="online" id="online"{if $data.online} checked="checked"{/if}>
        </li>
      </ul>
      <input id="form-featured-edit-submit" name="form-featured-edit-submit" type="submit" class="button" value="Modifier">
      <input type="hidden" name="id" value="{$data.id|escape}">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
