{include file="common/header.tpl"}

<div class="box">
  <header>
    <h1>Ajout à l'affiche</h1>
  </header>
  <div>
    <form id="form-featured-create" name="form-featured-create" action="/adm/featured/create" method="post" enctype="multipart/form-data">
      <ul>
        <li>
          <div class="infobulle error" id="error_title"{if empty($error_title)} style="display:none"{/if}>Vous devez saisir un titre</div>
          <label for="title">Titre (35 car.)</label>
          <input style="width:400px" maxlength="35" type="text" name="title" id="title" value="{$data.title|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_description"{if empty($error_description)} style="display:none"{/if}>Vous devez saisir une description</div>
          <label for="description">Description (85 car.)</label>
          <input style="width:680px" maxlength="85" type="text" name="description" id="description" value="{$data.description|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_url"{if empty($error_url)} style="display:none"{/if}>Vous devez saisir un lien</div>
          <label for="url">Lien</label>
          <input style="width:680px" type="text" name="url" id="url" value="{$data.url|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_image"{if empty($error_image)} style="display:none"{/if}>Vous devez choisir une image</div>
          <label for="image">Image (.jpg 1000x375)</label>
          <input type="file" name="image" id="image">
        </li>
        <li>
          <div class="infobulle error" id="error_datdeb"{if empty($error_datdeb)} style="display:none"{/if}>Vous devez saisir une date de début</div>
          <label for="datdeb">Début</label>
          <input type="text" name="datdeb" id="datdeb" value="{$data.datdeb|escape}">
        </li>
        <li>
          <div class="infobulle error" id="error_datfin"{if empty($error_datfin)} style="display:none"{/if}>Vous devez saisir une date de fin</div>
          <label for="datfin">Fin</label>
          <input type="text" name="datfin" id="datfin" value="{$data.datfin|escape}">
        </li>
        <li>
          <label for="online">En ligne</label>
          <input class="switch" type="checkbox" name="online" id="online"{if $data.online} checked="checked"{/if}>
        </li>
      </ul>
      <input id="form-featured-create-submit" name="form-featured-create-submit" type="submit" value="Ajouter" class="btn btn--primary">
    </form>
  </div>
</div>

{include file="common/footer.tpl"}
