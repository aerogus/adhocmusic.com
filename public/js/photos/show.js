/* global document, jQuery */

$(function() {

  $("#photofull").noContext();

  {if !empty($prev) && !empty($next) && true}
  $(document).keydown(function(e) {
    if (e.keyCode == 37) {
       window.location = '{$prev}#p';
       e.preventDefault();
    }
    if (e.keyCode == 39) {
       window.location = '{$next}#p';
       e.preventDefault();
    }
  });
  {/if}

});
