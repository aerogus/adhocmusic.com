{include file="common/header.tpl"}

{include file="common/boxstart.tpl" boxtitle="Recherche"}

{if !empty($show_form)}

<script src="http://www.google.com/jsapi"></script>
<script>
  google.load('search', '1', { language : 'fr', style : google.loader.themes.MINIMALIST });
  google.setOnLoadCallback(function() {
    var cse = new google.search.CustomSearchControl('003898017768300040063:iezzclsqcqg');
    cse.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    var options = new google.search.DrawOptions();
    options.setSearchFormRoot('cse-search-form');
    cse.draw('cse', options);
    cse.execute('{$q|escape:'javascript'}');
  }, true);
</script>

<style>
.gsc-control-cse {
    font-family: Arial, sans-serif;
    border: #fff solid 0px;
    background-color: #ececec;
}
input.gsc-input {
    border-color: #222;
    color: #000;
}
table.gsc-search-box {
    display: none;
    border: 0px solid #ffffff;
}
.gsc-resultsHeader {
    display: none;
}
.gsc-tabHeader.gsc-tabhActive {
    border-color: #333333;
    background-color: #333333;
}
.gsc-tabsArea {
    border-color: #333333;
}
.gsc-webResult.gsc-result {
   border: solid 0px #333;
   background-color: #ececec;
}
.gsc-webResult.gsc-result:hover {
    border-color: #000000;
    background-color: #ffc0c0;
    border: solid 0px #444;
}
.gs-webResult.gs-result a.gs-title:link,
.gs-webResult.gs-result a.gs-title:link b {
    color: #c00;
}
.gs-webResult.gs-result a.gs-title:visited,
.gs-webResult.gs-result a.gs-title:visited b {
    color: #c00;
}
.gs-webResult.gs-result a.gs-title:hover,
.gs-webResult.gs-result a.gs-title:hover b {
    color: #c00;
}
.gs-webResult.gs-result a.gs-title:active,
.gs-webResult.gs-result a.gs-title:active b {
    color: #c00;
}
.gsc-cursor-page {
    color: #444444;
}
a.gsc-trailing-more-results:link {
    color: #444444;
}
.gs-webResult.gs-result .gs-snippet {
   color: #000;
}
.gs-webResult.gs-result .gs-visibleUrl {
    color: #000;
}
.gs-webResult.gs-result .gs-visibleUrl-short {
    color: #006600;
}
.gs-webResult.gs-result .gs-visibleUrl-short {
    display: none;
}
.gs-webResult.gs-result .gs-visibleUrl-long {
    display: block;
    color: #006600;
}
.gsc-cursor-box {
    border-color: #333;
}
.gsc-results .gsc-cursor-page {
    background-color: #ccc;
    color: #000;
}
.gsc-results .gsc-cursor-page.gsc-cursor-current-page {
    background-color: #ccc;
    color: #000;
}
.gs-promotion.gs-result {
    border-color: #CCCCCC;
    background-color: #E6E6E6;
}
.gs-promotion.gs-result a.gs-title:link {
    color: #0000CC;
}
.gs-promotion.gs-result a.gs-title:visited {
    color: #0000CC;
}
.gs-promotion.gs-result a.gs-title:hover {
    color: #444444;
}
.gs-promotion.gs-result a.gs-title:active {
    color: #00CC00;
}
.gs-promotion.gs-result .gs-snippet {
    color: #333333;
}
.gs-promotion.gs-result .gs-visibleUrl,
.gs-promotion.gs-result .gs-visibleUrl-short {
    color: #00CC00;
}
</style>
{/if}

{if !empty($show_results)}
<div id="cse" style="width: 100%;"></div>
{/if}

{include file="common/boxend.tpl"}

{include file="common/footer.tpl"}
