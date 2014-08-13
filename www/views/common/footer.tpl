<div class="clearfix" style="clear: both;"></div>

</div>{* #main *}

<ul id="footer">
  <li>
    <ul class="footermenu" id="footermenuwho">
      <li><strong>QUI-SOMMES-NOUS?</strong></li>
      <li><a href="/assoce/presentation">L'Association</a></li>
      <li><a href="/assoce/concerts">Nos Concerts</a></li>
      <li><a href="/assoce/equipe">L'Equipe</a></li>
    </ul>
  </li>
  <li>
    <ul class="footermenu" id="footermenuchiffres">
      <li><strong>EN CHIFFRES</strong></li>
      <li><a href="/groupes/">{$global_counters.nb_groupes} groupes</a></li>
      <li><a href="/events/">{$global_counters.nb_events} concerts</a></li>
      <li><a href="/lieux/">{$global_counters.nb_lieux} lieux</a></li>
    </ul>
  </li>
  <li>
    <ul class="footermenu" id="footermenucontact">
      <li><strong>CONTACT</strong></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
      <li><a href="/contact">Contactez nous</a></li>
    </ul>
  </li>
  <li>
    <ul class="footermenu" id="footermenusocial">
      <li><strong>SUIVEZ NOUS</strong></li>
      <li><form id="form-newsletter" name="form-newsletter" style="margin-top: 3px;" action="/newsletters/subscriptions" method="post">
        <input type="email" name="email" style="background-color: #ffffff; font-size: 0.9em; width: 100px;" id="email" placeholder="Votre email" />
        <input type="hidden" name="action" value="sub" />
        <input id="form-newsletter-submit" name="form-newsletter-submit" type="submit" value="ok" />
      </form></li>
      <li style="padding-top: 5px">
        <a href="https://twitter.com/adhocmusic" title="Suivre @adhocmusic"><img src="{#STATIC_URL#}/img/twitter-adhocmusic.gif" alt="" /></a>
      </li>
    </ul>
  </li>
</ul>

</div>{* ? *}

<a id="up" href="#" title="haut de la page"><img src="{#STATIC_URL#}/img/icones/up.png" alt="" /></a>

{if !empty($prehome)}
{include file="prehome.tpl"}
{/if}

{* habillage custom cliquable *}
{if !empty($habillage)}
<script>
document.body.style.margin = "auto";
document.body.style.cursor = "pointer";
//document.body.style.background = "url(http://static.adhocmusic.com/img/backgrounds/adhoc-2014-05.jpg) no-repeat top center";
document.body.style.backgroundColor = "#ececec";
document.body.style.backgroundAttachment = "scroll"; // scroll ou fixed

habillageClick = function(e) {
  var t;
  if (!e) {
    var e = window.event;
  }
  if (e.target) {
    t = e.target;
  } else if (e.srcElement) {
    t = e.srcElement;
  }
  if (t.nodeType == 3) {
    t = t.parentNode;
  }
  if (t.tagName == 'BODY' || t.tagName == 'HTML') {
    window.location.href = 'http://www.adhocmusic.com/events/show/6465'; {* même fenêtre *}
    //window.open('http://www.adhocmusic.com/events/show/6465'); {* nouvelle fenêtre *}
  }  else {
    return;
  }
}
document.onclick = habillageClick;
</script>
{/if}

</body>

</html>
