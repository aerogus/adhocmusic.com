{literal}
var adhoc = {

    init:function()
    {
        adhoc.scrollToTop();
    },

    scrollToTop:function()
    {
        var toUp = $('#up');

        toUp.click(function() {                          
            adhoc.autoScroll();             
            return false;               
        });

        $(window).scroll(function() {
            if($(window).scrollTop() > 150) {
                toUp.fadeIn();
            }
            if($(window).scrollTop() < 150) {
                toUp.fadeOut();
            }
        });
    },
    
    autoScroll:function(callback)
    {
        if($.browser.webkit) {
            var body = $('body');
        } else {
            var body = $('html');
        }
        
        body.stop().animate({
        scrollTop:0
        }, 600, function() {
            if(typeof callback == 'function')
            {
                callback.call(this);
            }
        });
    }
}

function validateEmail(email)
{
    var reg = /^[a-z0-9._-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$/
    return (reg.exec(email)!=null)
}

function toggleDiv(id)
{
    div = document.getElementById(id);
    if(div.style.display == 'none')
    {
        div.style.display = 'block';
    }
    else
    {
        div.style.display = 'none';
    }
}

function popup(page, name, popupwidth, popupheight)
{
    coordleftpopup = Math.floor ((screen.width / 2)  - (popupwidth / 2));
    coordtoppopup  = Math.floor ((screen.height / 2) - (popupheight / 2));
    param = "width="+popupwidth+",height="+popupheight+",left="+coordleftpopup+",top="+coordtoppopup+",scrollbars=no";
    w = window.open(page, name, param);
    w.focus();
}

$(function() {

  $("#form-newsletter").submit(function() {
    if($("#email").val() == "" || validateEmail($("#email").val()) == 0) {
      alert("Précisez un email valide");
      return false;
    }
    return true;
  });

  adhoc.init();

  // menu
  $("ul#menu_haut li").find("ul").hide();
  $("ul#menu_haut li").hover(function() {
    $(this).find("ul").show();
  } , function() {
    $(this).find("ul").hide();
  });

  // fil d'ariane
  $("#breadCrumb").jBreadCrumb( { beginingElementsToLeaveOpen: 8 } );

  // thumbnail photo et video
  $(".thumb-80").hover(
    function() {
      $(this).children('.overlay-80').css('visibility', 'visible');
    },
    function() {
      $(this).children('.overlay-80').css('visibility', 'hidden');
    }
  );

  // login box
  $("#boxlogin-outter").find('span').hover(function() {
    $("#boxlogin-inner").show();
  });
  $("#boxlogin-inner").find(".boxtitle span").hover(function() {
    $("#boxlogin-inner").hide();
  });

});

{/literal}
