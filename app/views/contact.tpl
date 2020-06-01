{include file="common/header.tpl"}

<div class="grid-3-small-1 has-gutter">

  <div class="col-2">

  <div class="box">
    <header>
      <h1>Contacter l’association AD’HOC</h1>
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
        <section class="grid-4">
          <div class="col-1">
            <label for="name" class="col-form-label">Nom</label>
          </div>
          <div class="col-3">
            <div class="infobulle error" id="error_name"{if empty($error_name)} style="display: none"{/if}>Vous devez renseigner votre nom</div>
            <input name="name" id="name" type="text" maxlength="80" required="required" placeholder="Votre nom" value="{$name|escape}" class="w100">
          </div>
          <div class="col-1">
            <label for="email" class="col-form-label">E-mail</label>
          </div>
          <div class="col-3">
            <div class="infobulle error" id="error_email"{if empty($error_email)} style="display: none"{/if}>Votre email semble incorrect</div>
            <input name="email" id="email" type="email" maxlength="80" required="required" placeholder="Votre e-mail" value="{$email|escape}" class="w100">
          </div>
          <div class="col-1">
            <label for="subject" class="col-form-label">Sujet</label>
          </div>
          <div class="col-3">
            <div class="infobulle error" id="error_subject"{if empty($error_subject)} style="display: none"{/if}>Vous devez saisir un sujet</div>
            <input name="subject" id="subject" type="text" maxlength="80" required="required" placeholder="Votre sujet" value="{$subject|escape}" class="w100">
          </div>
          <div class="col-1">
            <label for="text" class="col-form-label">Message</label>
          </div>
          <div class="col-3">
            <div class="infobulle error" id="error_text"{if empty($error_text)} style="display: none"{/if}>Vous devez écrire quelque chose !</div>
            <textarea name="text" id="text" placeholder="Votre message" required="required" class="w100" rows="6">{$text|escape}</textarea>
          </div>
          <div class="col-1">
            <label for="mailing" class="col-form-label">Newsletter</label>
          </div>
          <div class="col-3">
            <input type="checkbox" class="switch" id="mailing" name="mailing"{if !empty($mailing)} checked="checked"{/if}>
            Je souhaite recevoir la newsletter
          </div>
          <div class="col-1"></div>
          <div class="col-3">
            <div class="infobulle error" id="error_check"{if empty($error_check)} style="display: none"{/if}>Erreur à la vérification du code de sécurité</div>
            <input id="form-contact-submit" data-check="{$check|escape}" name="form-contact-submit" type="submit" value="Envoyer" class="btn btn--primary"/>
          </div>
        </section>
        <input name="check" id="check" type="hidden" value="">
      </form>

      {/if}

    </div>
  </div>{* .box *}

  </div>{* .col-1 *}

  <div class="col-1">

    <div class="box">
      <header>
        <h2>Adresse Postale</h2>
      </header>
      <div>
        <strong>Association AD’HOC</strong><br>
        <address>8, rue de l’église<br>
        91360 Épinay-sur-Orge</address>
      </div>
    </div>

    <div class="box">
      <header>
        <h2>Questions fréquentes</h2>
      </header>
      {if $faq|@count > 0}
      <div class="reset">
        {foreach from=$faq item=f}
        <div class="faq">
          <h3 class="flex-row-reverse">{$f->getQuestion()} <i class="icon-arrow--right"></i></h3>
          <p>{$f->getAnswer()}</p>
        </div>
        {/foreach}
      </div>
      {else}
      <div>
        <p>Aucune questions fréquentes</p>
      </div>
      {/if}
    </div>

  </div>{* .col-1 *}

</div>{* .grid-2-small-1 *}

{include file="common/footer.tpl"}
