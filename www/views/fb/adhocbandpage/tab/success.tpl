{include file="fb/adhocbandpage/tab/common/header.tpl"}

<script>
$(function() {
  $("#share").click(function() {
    FB.ui({
      method: 'apprequests',
      message: "Parlez de BandPage by AD'HOC à vos amis !"
    });
  });
});
</script>

{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Merci et Bienvenue"}
<h2>Bienvenue sur l'application BandPage by AD'HOC !</h2>
<p>L'onglet a du être installé sur votre page fans. Si ce n'était pas le cas, merci de contacter le webmaster d'AD'HOC via <a href="http://www.adhocmusic.com/contact">http://www.adhocmusic.com/contact</a> qui vous aidera.</p>
<fb:like-box href="http://www.facebook.com/bandpagebyadhoc" width="520" height="255" colorscheme="light" show_faces="true" stream="false" header="false"></fb:like-box>
<p><a id="share" style="display: block; margin: 25px 0; width: 470px; padding: 25px; border: 1px solid #000">Parlez donc de BandPage by AD'HOC à vos amis musiciens administrateurs de page groupes</a></p>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}

{include file="fb/adhocbandpage/tab/common/footer.tpl"}
