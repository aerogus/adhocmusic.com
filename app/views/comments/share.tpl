<style>
.share-box li {
  float: left;
}
.share-box li a {
  display: inline-block;
  margin: 10px;
  padding: 5px;
  color: #fff;
  font-weight: bold;
}
</style>

{if !empty($title)}
<h4>Promouvoir {$title|escape}</h4>
{/if}

<ul class="share-box">
  <li><a href="https://www.facebook.com/sharer/sharer.php?u={$url|escape}" style="background:#3a5795;color:#fff">Facebook</a></li>
  <li><a href="http://twitter.com/home?status={$url|escape}%20via%20@adhocmusic" style="background:#55acee;color:#fff">Twitter</a></li>
  <li><a href="https://plus.google.com/share?url={$url|escape}" style="background:#dd5044;color:#fff">Google+</a></li>
</ul>
<br style="clear: both;" />
