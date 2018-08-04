
</div>{* .site-content *}

<footer>
<ul class="footer clearfix">
  <li>
    <ul>
      <li><h4>Qui sommes-nous ?</h4></li>
      <li><a href="/assoce">L’Association</a></li>
      <li><a href="/concerts">Nos Concerts</a></li>
      <li><a href="/equipe">L’Équipe</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><h4>Suivez nous</h4></li>
      <li class="facebook"><a href="https://facebook.com/adhocmusic" title="@adhocmusic sur Facebook">@adhocmusic</a></li>
      <li class="twitter"><a href="https://twitter.com/adhocmusic" title="@adhocmusic sur Twitter">@adhocmusic</a></li>
      <li class="email"><a href="https://www.adhocmusic.com/newsletters/subscriptions" title="Abonnement à la newsletter">Newsletter</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><h4>Contact</h4></li>
      <li><a href="/contact">Contactez nous</a></li>
      <li><a href="/partners">Partenaires</a></li>
    </ul>
  </li>
</ul>
</footer>

<button type="button" id="up" name="retour en haut de la page">↑</button>

{if $js_vars}
<script>
{foreach $js_vars as $js_var}
{$js_var}
{/foreach}
</script>
{/if}

<script>
{if $script_vars}
var asv = {$script_vars|json_encode_numeric_check nofilter}
{/if}
</script>

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
