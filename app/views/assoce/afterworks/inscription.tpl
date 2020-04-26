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
        <strong>Votre message a bien été envoyé, merci !</strong><br>
        Nous tâcherons d’y répondre dans les plus brefs délais<br>
        Musicalement,<br>
        L’Equipe AD’HOC
      </div>
      {/if}

      {if !empty($sent_ko)}
      <div class="infobulle error">Message non envoyé</div>
      {/if}

      {if !empty($show_form)}
      <form id="form-contact" name="form-contact" method="post" action="/afterworks/inscription" enctype="multipart/form-data">
        <ul>
          <li>
            <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner votre nom de scène</div>
            <label for="name">Nom de scène</label>
            <input name="name" id="name" type="text" maxlength="80" placeholder="Votre nom de scène" value="{$name|escape}" style="width:100%">
          </li>
          <li>
            <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Votre email semble incorrect</div>
            <label for="email">E-mail</label>
            <input name="email" id="email" type="email" maxlength="80" placeholder="Votre e-mail" value="{$email|escape}" style="width:100%">
          </li>
          <li>
            <div class="infobulle error" id="error_date"{if empty($error_date)} style="display: none"{/if}>Vous devez saisir la date</div>
            <label for="subject">Date</label>
            <select name="date" style="width:100%">
              <option value="2020-05-01">Afterwork S5E6 - Vendredi 1er mai 2020</option>
            </select>
          </li>
          <li>
            <div class="infobulle error" id="error_hour"{if empty($error_hour)} style="display: none"{/if}>Vous devez saisir un créneau</div>
            <label for="subject">Créneau souhaité</label>
            <input type="checkbox" name="hour" value="1930-2030"/> 19h30-20h30<br/>
            <input type="checkbox" name="hour" value="2030-2130"/> 20h30-21h30<br/>
            <input type="checkbox" name="hour" value="2130-2230"/> 21h30-22h30<br/>
          </li>
          <li>
            <div class="infobulle error" id="error_photo"{if empty($error_hour)} style="display: none"{/if}>Vous devez saisir une photo</div>
            <input type="file"/>
          </li>
          <li>
            <div class="infobulle error" id="error_instrument"{if empty($error_email)} style="display: none"{/if}>Votre instrument est manquant</div>
            <label for="instrument">Instrument</label>
            <input name="instrument" id="instrument" type="text" maxlength="80" placeholder="Votre instrument" value="{$instrument|escape}" style="width:100%">
           </li>
          <li>
            <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
            <label for="text">Infos à savoir</label>
            <textarea name="text" id="text" placeholder="tout ce que vous souhaitez nous communiquez, faites : setlist, backing-track ou pas, reprises, compos..." style="width:100%;height:160px">{$text|escape}</textarea>
          </li>
          <li>
            <div class="infobulle error" id="error_check"{if empty($error_check)} style="display: none"{/if}>Erreur à la vérification du code de sécurité</div>
            <input id="form-contact-submit" data-check="{$check|escape}" name="form-contact-submit" type="submit" value="Envoyer" class="button" style="padding: 5px 0;">
          </li>
        </ul>
        <input name="check" id="check" type="hidden" value="">
      </form>
      {/if}

    </div>
  </div>

{include file="common/footer.tpl"}
