$(function(){
    //$("a").live('click', function(event){
    //    href = $(this).attr("href");
    //    if(href!=='#' && href!=='') {
    //        history.replaceState(null,null,href);
    //        $("#content").load(href);
    //        
    //        return false;
    //    }
    //});
    
    $(function() {
        var t = $('<div class="scroll-to-top-button"></div>'),
            d = $(document);
        $('body').append(t);
        
        t.css({
            opacity: 0,
            position: 'absolute',
            top: 0,
            right: '5%'
        });
    
        t.click(function() {
            $('html,body').animate({
                scrollTop: 0
            }, 1000);
        });
    
        $(window).scroll(function() {
            var sv = d.scrollTop();
            if (sv < 10) {
                t.clearQueue().fadeOut(200);
                return;
            }
    
            t.css('display', '').clearQueue().animate({
                top: sv,
                opacity: 0.8
            }, 500);
        });
    });
    
});

function open_panel() {
    $.get("adminpanel/ajax/",{},onAjaxSuccess);
   
    function onAjaxSuccess(data) {
        $('.background').removeClass();
        $("#adminpanel").html('<div class="panel">'+data+'</div>');
        $("body").prepend("<div class='background' onClick='close_panel()'></div>");
    }
    return false;
 }
 
function close_panel() {
   $(".background").detach();
   $("#adminpanel").html('<div id="adminpanel" onClick="open_panel()">&nbsp;Admin panel</div>');
}