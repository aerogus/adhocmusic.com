<style>
.share-box li {
    float: left;
    width: 65px;
    height: 70px;
    margin: 10px;
}
</style>

{if !empty($title)}
<h4>Promouvoir {$title|escape}</h4>
{/if}

<ul class="share-box">
  <li><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="adhocmusic" data-lang="fr">Tweeter</a><script src="http://platform.twitter.com/widgets.js"></script></li>
  <li><fb:like href="{$url|escape}" send="false" layout="box_count" width="65" show_faces="false" font="arial"></fb:like></li>
<li><g:plusone size="tall"></g:plusone></li>
</ul>
<br style="clear: both;" />
