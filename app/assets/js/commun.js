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
