/*global jQuery*/

jQuery(document).ready(function ($) {

  'use strict';

  $('.swipe-pagination li:first-child').addClass('on');

  var swipe = Swipe(document.getElementById('swipe'), {
    startSlide: 0,
    speed: 100,
    auto: 3000,
    continuous: true,
    disableScroll: false,
    stopPropagation: false,
    callback: function (idx, elem) {
      $('.swipe-pagination li')
        .removeClass('on')
        .filter('[data-index="' + idx + '"]')
        .addClass('on');
    }
  });
  $('.swipe-pagination li').on('mouseenter click', function () {
    swipe.slide($(this).data('index'));
  });

});
