{include file="common/header.tpl"}

  <div class="box">
    <header>
      <h1>Inscription aux afterworks</h1>
    </header>
    <div>

      <p>Afin de nous permettre de bien mener l’Afterwork S5E6 – on line, merci de t’inscrire via ce formulaire, et de nous préciser si tu joues seul, accompagné, voire avec un backing-track.<br/>
      Nous essaierons de respecter vos demandes de plages horaires, mais nous aviserons également avec les autres participants.
      Au plaisir de t’accueillir en ligne !</p>

      {if !empty($sent_ok)}
      <div class="infobulle success">
          <p>Salut,<br/>Nous avons bien reçu ta demande de participation à l’Afterwork S5E6 on line, merci à toi ! Voici un récapitulatif de ton inscription :</p>
          <p>Nom de scène: {$name|escape}</p>
          <p>E-mail: {$email|escape}</p>
          <p>Date: {$date|escape}</p>
          <p>Créneau(x) souhaité(s): {$creneaux|escape}</p>
          <p>Photo: <a href="{$photo_url}">{$photo_url}</a></p>
          <p>Instrument: {$instrument|escape|@nl2br}</p>
          <p>Infos: {$text|escape|@nl2br}</p>
      </div>
      {/if}

      {if !empty($sent_ko)}
      <div class="infobulle error">Message non envoyé, flûte, contactez-nous directement sur Facebook</div>
      {/if}

      {if !empty($show_form)}
      <form id="form-afterworks" name="form-afterworks" method="post" action="/afterworks/inscription" enctype="multipart/form-data">
        <ul class="grid-2-small-1 has-gutter-xl">
          <li>
            <label for="name">Nom de scène</label>
            <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner votre nom de scène</div>
            <input name="name" id="name" type="text" maxlength="80" placeholder="Votre nom de scène" value="{$name|escape}" style="width:100%">
          </li>
          <li>
            <label for="email">E-mail</label>
            <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Votre email semble incorrect</div>
            <input name="email" id="email" type="email" maxlength="80" placeholder="Votre e-mail" value="{$email|escape}" style="width:100%">
          </li>
        </ul>
        <ul class="grid-2-small-1 has-gutter-xl">
          <li>
            <label for="date">Date</label>
            <div class="infobulle error" id="error_date"{if empty($error_date)} style="display: none"{/if}>Vous devez saisir la date</div>
            <select id="date" name="date" style="width:100%">
              <option value="">--</option>
              <option value="2020-05-01">Afterwork S5E6 - Vendredi 1er mai 2020</option>
            </select>
          </li>
          <li>
            <label>Créneau(x) souhaité(s)</label>
            <div class="infobulle error" id="error_hour"{if empty($error_hour)} style="display: none"{/if}>Vous devez saisir au moins un créneau</div>
            <ul class="is-unstyled">
              <li>
                <input type="checkbox" class="checkbox" name="h1930-2030" id="h1930-2030"/>
                <label for="h1930-2030">19h30-20h30</label>
              </li>
              <li>
                <input type="checkbox" class="checkbox" name="h2030-2130" id="h2030-2130"/>
                <label for="h2030-2130">20h30-21h30</label>
              </li>
              <li>
                <input type="checkbox" class="checkbox" name="h2130-2230" id="h2130-2230"/>
                <label for="h2130-2230">21h30-22h30</label>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="grid-2-small-1 has-gutter-xl">
          <li>
            <label for="instrument">Instrument</label>
            <div class="infobulle error" id="error_instrument"{if empty($error_instrument)} style="display: none"{/if}>Votre instrument est manquant</div>
            <textarea name="instrument" id="instrument" placeholder="Votre instrument" style="width:100%;height:160px">{$instrument|escape}</textarea>
           </li>
          <li>
            <label for="text">Infos à savoir</label>
            <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
            <textarea name="text" id="text" placeholder="tout ce que vous souhaitez nous communiquez, faites : setlist, backing-track ou pas, reprises, compos..." style="width:100%;height:160px">{$text|escape}</textarea>
          </li>
        </ul>
        <ul class="grid-2-small-1 has-gutter-xl">
          <li>
            <label for="photo">Photo (.jpg, < 2Mo)</label>
            <div class="infobulle error" id="error_photo"{if empty($error_photo)} style="display: none"{/if}>Vous devez saisir une photo</div>
            <input type="file" name="photo"/>
          </li>
          <li>
            <div class="infobulle error" id="error_check"{if empty($error_check)} style="display: none"{/if}>Erreur à la vérification du code de sécurité</div>
            <input id="form-afterworks-submit" data-check="{$check|escape}" name="form-afterworks-submit" type="submit" value="Valider mon inscription à l'afterwork" class="btn btn-primary">
          </li>
        </ul>
        <input name="check" id="check" type="hidden" value="">
      </form>
      {/if}

    </div>
  </div>

{include file="common/footer.tpl"}
