
</div>{* .site-content *}

<footer>
  <ul class="footer clearfix">
    <li>
      <ul>
        <li><h4>Qui sommes-nous ?</h4></li>
        <li><a href="/assoce">L’association</a></li>
        <li><a href="/concerts">Nos concerts</a></li>
        <li><a href="/equipe">L’équipe</a></li>
        <li><a href="/mentions-legales">Mentions légales</a></li>
      </ul>
    </li>
    <li>
      <ul>
        <li><h4>Suivez nous</h4></li>
        <li class="facebook"><a href="https://facebook.com/adhocmusic" title="@adhocmusic sur Facebook">@adhocmusic</a></li>
        <li class="twitter"><a href="https://twitter.com/adhocmusic" title="@adhocmusic sur Twitter">@adhocmusic</a></li>
        <li class="instagram"><a href="https://instagram.com/adhoc.music" title="@adhoc.music sur Instagram">@adhoc.music</a></li>
        <li class="email"><a href="/newsletters/subscriptions" title="Abonnement à la newsletter">Newsletter</a></li>
      </ul>
    </li>
    <li>
      <ul>
        <li><h4>Contact</h4></li>
        <li><a href="/contact">Contactez-nous</a></li>
        <li><a href="/partners">Partenaires</a></li>
        <li><a href="/map">Plan du site</a></li>
      </ul>
    </li>
  </ul>
  <div class="txtcenter italic mas">Association loi 1901 à but non lucratif œuvrant pour le développement des musiques actuelles à <a href="https://www.ville-epinay-sur-orge.fr">Épinay-sur-Orge</a> depuis 1996</div>
</footer>

<button type="button" id="up" name="retour en haut de la page">↑</button>

{if $js_vars}
<script>
{foreach $js_vars as $js_var}
{$js_var}
{/foreach}
</script>
{/if}

{if $script_vars}
<script>
var asv = {$script_vars|json_encode_numeric_check nofilter}
</script>
{/if}

{foreach $footer_scripts as $script_url}
<script src="{$script_url}"></script>
{/foreach}

{foreach $inline_scripts as $inline_script}
<script>
{$inline_script}
</script>
{/foreach}

</body>
</html>
