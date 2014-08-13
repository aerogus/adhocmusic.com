{include file="fb/adhocbandpage/tab/common/header.tpl"}

<script>
$(function() {
  $("#share").click(function() {
    FB.ui({
      method: 'apprequests',
      message: "Parlez de AD'HOC à vos amis !"
    });
  });
});
</script>

{include file="fb/adhocbandpage/tab/common/boxstart.tpl" title="Merci !"}
<p>Merci d'utiliser BandPage by AD'HOC sur votre page fans !</p>
<p><a id="share">Parlez donc de BandPage by AD'HOC à vos amis musiciens administrateurs de page groupes que vous connaissez.</a></p>
{include file="fb/adhocbandpage/tab/common/boxend.tpl"}

<fb:like-box href="http://www.facebook.com/bandpagebyadhoc" width="520" height="255" colorscheme="light" show_faces="true" stream="false" header="false"></fb:like-box>

{include file="fb/adhocbandpage/tab/common/footer.tpl"}
