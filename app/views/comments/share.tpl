{if !empty($title)}
<h4>Partager {$title|escape}</h4>
{/if}

<ul class="social-share-box">
  <li>
    <a href="https://www.facebook.com/sharer/sharer.php?u={$url|escape}" class="facebook">
      <span>Facebook</span>
    </a>
  </li>
  <li>
    <a href="http://twitter.com/home?status={$url|escape}%20via%20@adhocmusic" class="twitter">
      <span>Twitter</span>
    </a>
  </li>
</ul>
