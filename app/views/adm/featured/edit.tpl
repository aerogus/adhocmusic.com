{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Edition à l'affiche</h1>
  </header>
  <div>
    <form id="form-featured-edit" name="form-featured-edit" action="/adm/featured/edit" method="post" enctype="multipart/form-data">
      <ul>
        <li>
          <div class="infobulle error" id="error_title"{if empty($error_title)} style="display:none"{/if}>Vous devez saisir un titre</div>
          <label for="title">Titre</label>
          <input style="width:400px" maxlength="35" type="text" name="title" id="title" value="{$data.title|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_description"{if empty($error_description)} style="display:none"{/if}>Vous devez saisir une description</div>
          <label for="description">Description</label>
          <input style="width:680px" maxlength="85" type="text" name="description" id="description" value="{$data.description|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_url"{if empty($error_url)} style="display:none"{/if}>Vous devez saisir un lien</div>
          <label for="url">Lien</label>
          <input style="width:680px" type="text" name="url" id="url" value="{$data.url|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_image"{if empty($error_image)} style="display:none"{/if}>Vous devez choisir une image</div>
          <label for="image">Image (.jpg|.png|.gif 1000x375)</label>
          <input type="file" name="image" id="image">
          <img src="{$data.image}" alt="">
        </li>
        <li>
          <div class="infobulle error" id="error_datdeb"{if empty($error_datdeb)} style="display:none"{/if}>Vous devez saisir une date de début</div>
          <label for="datdeb">Début</label>
          <input type="text" name="datdeb" id="datdeb" value="{$data.datdeb|date_format:"%Y-%m-%d"}">
        </li>
        <li>
          <div class="infobulle error" id="error_datfin"{if empty($error_datfin)} style="display:none"{/if}>Vous devez saisir une date de fin</div>
          <label for="datfin">Fin</label>
          <input type="text" name="datfin" id="datfin" value="{$data.datfin|date_format:"%Y-%m-%d"}">
        </li>
        <li>
          <label for="online">En ligne</label>
          <input class="switch" type="checkbox" name="online" id="online"{if $data.online} checked="checked"{/if}>
        </li>
      </ul>
      <input id="form-featured-edit-submit" name="form-featured-edit-submit" type="submit" class="btn btn--primary" value="Modifier">
      <input type="hidden" name="id" value="{$data.id|escape}">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
