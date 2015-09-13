$(function () {
  $.featureList(
    $("#tabs li a"),
    $("#output li"),
    {
      start_item: 0,
      transition_interval: 3000
    }
  );
});
