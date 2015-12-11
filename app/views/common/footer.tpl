
</div>{* #main *}

</div>{* #conteneur *}

<footer>
<ul class="footer clearfix">
  <li>
    <ul>
      <li><strong>QUI SOMMES-NOUS?</strong></li>
      <li><a href="/assoce/presentation">L'Association</a></li>
      <li><a href="/assoce/concerts">Nos Concerts</a></li>
      <li><a href="/assoce/equipe">L'Équipe</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><strong>SUIVEZ NOUS</strong></li>
      <li><a href="https://facebook.com/adhocmusic" title="AD'HOC Music sur Facebook"><img src="{#STATIC_URL#}/img/emails/facebook.png" width="16" height="16" alt="Facebook">/adhocmusic</a></li>
      <li><a href="https://twitter.com/adhocmusic" title="@adhocmusic sur Twitter"><img src="{#STATIC_URL#}/img/emails/twitter.png" width="16" height="16" alt="Twitter">@adhocmusic</a></li>
    </ul>
  </li>
  <li>
    <ul>
      <li><strong>CONTACT</strong></li>
      <li><a href="/partners">Partenaires</a></li>
      <li><a href="/visuels">Visuels</a></li>
      <li><a href="/contact">Contactez nous</a></li>
    </ul>
  </li>
</ul>
</footer>

<a id="up" href="#" title="haut de la page"><img src="{#STATIC_URL#}/img/icones/up.png" alt=""></a>

{foreach from=$footer_scripts item=script_url}
<script src="{$script_url}"></script>
{/foreach}

{foreach from=$inline_scripts item=inline_script}
<script>
{$inline_script}
</script>
{/foreach}

</body>

</html>
