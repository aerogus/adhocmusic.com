
</div>{* .site-content *}

<footer>
<ul class="footer clearfix">
  <li>
    <ul>
      <li><h4>Qui sommes-nous ?</h4></li>
      <li><a href="/assoce/presentation">L'Association</a></li>
      <li><a href="/assoce/concerts">Nos Concerts</a></li>
      <li><a href="/assoce/equipe">L'Équipe</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><h4>Suivez nous</h4></li>
      <li class="facebook"><a href="https://facebook.com/adhocmusic" title="@adhocmusic sur Facebook">@adhocmusic</a></li>
      <li class="twitter"><a href="https://twitter.com/adhocmusic" title="@adhocmusic sur Twitter">@adhocmusic</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><h4>Contact</h4></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
      <li><a href="/contact">Contactez nous</a></li>
    </ul>
  </li>
</ul>
</footer>

<a id="up" href="#" title="haut de la page"><img src="/img/icones/up.png" alt=""></a>

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
