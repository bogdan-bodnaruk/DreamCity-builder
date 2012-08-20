var client_css = 'web/theme/css';
var library_path = 'library';

Modernizr.load([
    {
        load: [
                client_css + '/boilerplate.css',
                client_css + '/main.css',
                client_css + '/green.css'
        ]
    },
    {
        load: '//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js',
        complete: function () {
            if ( !window.jQuery ) {
                Modernizr.load(library_path + '/jquery-1.8.0.min.js');
            }
        }
    },
    {
        load: [
                library_path + '/prefixfree.min.js'
        ]
    },
    {
        load: [client_css + '/mozilla_reset.css']
    }

]);

//test: Modernizr.input.required, nope: 'js/check_required.js', complete: function() { init(); }

/*
$(function(){
    
    $("select").chosen();
    $('#slider').nivoSlider();
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

function fade_alert() {
    $('html,body').animate({scrollTop:0},0);
    $('.success').delay(1000);
    $('.success').slideUp();
}*/
