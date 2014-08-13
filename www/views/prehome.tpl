<style>
#prehome-box {
    width: 353px;
    height: 520px;
    background-color: #000;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -260px;
    margin-left: -176px;
    z-index: 300;
    color: #fff;
    border: 3px solid #fff;
    box-shadow: 3px 3px 10px #000;
}
#prehome-background {
    position: absolute;
    z-index: 200;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: .8;
    filter: alpha(opacity=80);
    background-color: #fff;
}
</style>

<script>
$(function() {
  $(window).scroll(function() {
    $('#prehome-background').css('marginTop', $(window).scrollTop());
  });
  $("#prehome-close").click(function(){
    $('#prehome-background').remove();
    $('#prehome-box').remove();
  });
});
</script>


<div id="prehome-background"></div>
<div id="prehome-box">
  <a href="/contact" title="Contactez nous !">
    <img src="http://static.adhocmusic.com/img/recherche-groupes-dec-2012.jpg" alt="" />
  </a>
  <p id="prehome-close">Fermer la fenetre</p>
</div>

