{include file="fb/adhocmusic/canvas/common/header.tpl"}

<script src="{#STATIC_URL#}/js/jquery.featureList-1.0.0.js"></script>

<script>
$(function() {
  $.featureList(
    $("#tabs li a"),
    $("#output li"), {
      start_item: 0,
      transition_interval: 3000
    }
  );
});
</script>

{include file="common/boxstart.tpl" bboxtitle="La sélection du mois" widtth="700px;"}

<div id="feature_list" style="width: 688px;">
  <ul id="tabs">
    {foreach from=$featured item=f}
    <li>
      <a href="{$f.link|escape}">
        <h3>{$f.title|escape}</h3>
        <span>{$f.description|escape}</span>
      </a>
    </li>
    {/foreach}
  </ul>
  <ul id="output">
    {foreach from=$featured item=f}
    <li>
      <a href="{$f.link|escape}">
        <img src="{$f.image|escape}" alt="" />
      </a>
    </li>
    {/foreach}
  </ul>
</div>

{include file="common/boxend.tpl"}

{include file="fb/adhocmusic/canvas/common/footer.tpl"}
