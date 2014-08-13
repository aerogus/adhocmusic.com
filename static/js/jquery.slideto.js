/*
 * jQuery UI slideTo function
 * 
 * Copyright (c) 2011 Pieter Pareit
 *
 * http://www.scriptbreaker.com
 *
 */
(function($){
    $.fn.extend({
         slideTo: function (options) {
              var options =  $.extend({ // Default values
                   transition: 0, // millisecond, transition time
                   
                   top:'na', //pixel or 'center' position of the element
                   left:'na', //pixel or 'center' position of the element

                   bottom:'na', //pixel or 'center' position of the element
                   right:'na', //pixel or 'center' position of the element
                   
                   inside:window // element, center into window
                                      
              }, options);

              return this.each(function() {
                   var props = {position:'absolute'};
                   var top = $(this).position().top;
                   var left = $(this).position().left;

                   if(options.top != 'na'){
                       //--- calculate top position
                       if (options.top == 'center') {
                            top = ($(options.inside).height() - $(this).outerHeight()) / 2;
                       }else{
                           top = options.top;
                       }

                       //calculate the offset (only when the parent is relative)
                       if(options.inside == window || options.inside == document){
                           offsetTop = 0;
                           $(this).parents().each(function(){
                              if($(this).css("position") == 'relative'){
                                  offsetTop += $(this).offset().top;
                              }
                           })
                           top -= offsetTop;
                       }
                       top += $(options.inside).scrollTop();
                       
                       $.extend(props, {top: top+'px'});
                   }else if(options.bottom != 'na'){
                       top = $(options.inside).height() - $(this).outerHeight() - options.bottom;
                       
                       //calculate the offset (only when the parent is relative)
                       if(options.inside == window || options.inside == document){
                           offsetTop = 0;
                           $(this).parents().each(function(){
                              if($(this).css("position") == 'relative'){
                                  offsetTop += $(this).offset().top;
                              }
                           })
                           top -= offsetTop;
                       }
                       
                       if(top < $(options.inside).scrollTop()){
                           top += $(options.inside).scrollTop();
                       }
                       $.extend(props, {top: top+'px'});
                   }

                   if(options.left != 'na'){
                       //--- calculate left position
                       if (options.left == 'center') {
                             left = ($(options.inside).width() - $(this).outerWidth()) / 2;
                       }else{
                            left = options.left;
                       }

                       //calculate the offset (only when the parent is relative)
                       if(options.inside == window || options.inside == document){
                           offsetLeft = 0;
                           $(this).parents().each(function(){
                              if($(this).css("position") == 'relative'){
                                  offsetLeft += $(this).offset().left;
                              }
                           })
                           left -= offsetLeft;
                       }

                       left += $(options.inside).scrollLeft();
                      
                       
                       $.extend(props, {left: left+'px'});
                   }else if(options.right != 'na'){

                       //calculate the offset (only when the parent is relative)
                       if(options.inside == window || options.inside == document){
                           offsetLeft = 0;
                           $(this).parents().each(function(){
                              if($(this).css("position") == 'relative'){
                                  offsetLeft += $(this).offset().left;
                              }
                           })
                           left -= offsetLeft;
                       }
                       
                       left = $(options.inside).width() - $(this).outerWidth() - options.right;
                       left += $(options.inside).scrollLeft();
                       $.extend(props, {left: left+'px'});
                   }

                   //set the animation
                   if (options.transition > 0) $(this).animate(props, options.transition);
                   else $(this).css(props);
                   return $(this);
              });
         }
    });
})(jQuery);
