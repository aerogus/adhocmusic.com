/*global jQuery*/

jQuery(document).ready(function ($) {

    'use strict';

    var bullets = $('.swipe-pagination li');
    var swipe = Swipe(document.getElementById('swipe'), {
        startSlide: 0,
        speed: 100,
        auto: 3000,
        continuous: true,
        disableScroll: false,
        stopPropagation: false,
        callback: function (idx, elem) {
            var i = bullets.length;
            while (i--) {
                bullets[i].className = '';
            }
            bullets[idx].className = 'on';
        }
    });
    $('.swipe-pagination li').hover(function () {
        swipe.slide($(this).attr('data-index'));
    });
    $('.swipe-pagination li').click(function () {
        swipe.slide($(this).attr('data-index'));
    });

});
