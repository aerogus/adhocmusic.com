{include file="common/header.tpl"}

<div class="grid-2-small-1 has-gutter-l">

  <div class="col-1">

  <div class="box">
    <header>
      <h3>Contacter AD’HOC</h3>
    </header>
    <div>

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

      <form id="form-contact" name="form-contact" method="post" action="/contact" enctype="multipart/form-data">
        <ul>
          <li>
            <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner votre nom</div>
            <label for="name">Nom</label>
            <input name="name" id="name" type="text" maxlength="80" value="{$name|escape}" style="width: 360px; padding: 5px;">
          </li>
          <li>
            <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Votre email semble incorrect</div>
            <label for="email">Email</label>
            <input name="email" id="email" type="email" maxlength="80" value="{$email|escape}" style="width: 360px; padding: 5px;">
          </li>
          <li>
            <div class="infobulle error" id="error_subject"{if empty($error_subject)} style="display: none"{/if}>Vous devez saisir un sujet</div>
            <label for="subject">Sujet</label>
            <input name="subject" id="subject" type="text" maxlength="80" value="{$subject|escape}" style="width: 360px; padding: 5px;">
          </li>
          <li>
            <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
            <label for="text">Message</label>
            <textarea name="text" id="text" rows="10" cols="80" style="width: 360px; padding: 5px;">{$text|escape}</textarea>
          </li>
          <li>
            <label for="mailing">Je souhaite recevoir les newsletters de l'association</label>
            <input type="checkbox" class="switch" id="mailing" name="mailing"{if !empty($mailing)} checked="checked"{/if}>
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
  </div>{* .box *}

  </div>{* .col-1 *}

  <div class="col-1">

    <div class="box">
      <header>
        <h3>Adresse Postale</h3>
      </header>
      <div>
        <strong>Association AD’HOC</strong><br>
        <address>8, rue de l’église<br>
        91360 Épinay-sur-Orge</address>
      </div>
    </div>

    <div class="box">
      <header>
        <h3>Questions fréquentes</h3>
      </header>
      <div class="reset">
        {if $faq|@count > 0}
          {foreach from=$faq item=f}
          <div class="faq">
            <h3 class="flex-row-reverse">{$f.question} <i class="icon-arrow--right"></i></h3>
            <p>{$f.answer}</p>
          </div>
          {/foreach}
        {else}
          <p>Aucune question fréquente</p>
        {/if}
      </div>
    </div>

  </div>{* .col-1 *}

</div>{* .grid-2-small-1 *}

{include file="common/footer.tpl"}
