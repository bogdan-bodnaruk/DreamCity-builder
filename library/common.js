var client_css = 'web/theme/css';
var library_path = 'library';

Modernizr.load([
    {
        load: [client_css + '/boilerplate.css', client_css + '/main.css', client_css + '/green.css']
    },
    {
        load: [library_path + '/chosen/chosen.css', library_path + '/chosen/chosen.min.js'],
        complete: function() {
            $('select').chosen();
        }
    },
    {
        test: $.browser.mozilla,
        yep: client_css + '/mozilla_reset.css'
    },
    {
        test: Modernizr.input.required,
        nope: library_path + '/modernizr.input.required.js'
    },
    {
        test: $("textarea").is("[id^='cked-']"),
        yep: library_path + '/ckeditor/ckeditor.js',
        callback: function() {
            for(i=0;i<$("textarea[id^='cked-']").length;i++) {
                if (CKEDITOR.instances[$("textarea[id^='cked-']")[i].id]){
                    delete CKEDITOR.instances[$("textarea[id^='cked-']")[i].id]
                };
                CKEDITOR.replace(
                    $("textarea[id^='cked-']")[i].id,
                    {toolbar : $("textarea[id^='cked-']")[i].classList[0]}
                );
            }
        }
    },
    {
        test: $("input").is("[id^=datepicker-]") || $("div").is("[id^=window-]"),
        yep: [library_path + '/jquery-ui/jquery-ui-1.8.23.custom.min.js',library_path + '/jquery-ui/jquery-ui-1.8.23.custom.css'],
        callback: function() {
            $("input[type='text'][id^=datepicker-]").datepicker();
            
            $("div[id^=window-]").dialog({
                autoOpen: false,
                modal: true
            });
            $("a[id^=window-]").on('click',function() {
                $("div[id^=" + this.id + "]").dialog("open");
                return false;
            });
            $("button[id^=window-]").on('click',function() {
                $("div[id^=" + this.id + "]").dialog("open");
                return false;
            });
        }
    },
    {
        test: $("div").is("[id^=fancybox-]") || $('a').is("[class^=fancybox-]"),
        yep: [library_path + '/fancybox/jquery.fancybox.js', library_path + '/fancybox/jquery.fancybox.css'],
        callback: function() {
            $("div[id^=fancybox-] a").fancybox({
                nextEffect: 'elastic',
                prevEffect: 'elastic',
                openEffect	: 'elastic',
                closeEffect	: 'elastic'
            });
            $("a.fancybox-video").on('click',function() {
                $.fancybox({
                    'padding' : 0,
                    'href' : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                    'type' : 'swf',
                    'swf' : {
                        'wmode': 'transparent',
                        'allowfullscreen': 'true'
                    }
                });
                return false;
            });
            $("a.fancybox-map, a.fancybox-iframe").on('click',function() {
                $.fancybox({
                    'href' : this.href,
                    'type' : 'iframe'
                });
                return false;
            });
            $("a.fancybox-ajax").on('click',function() {
                $.fancybox({
                    'href' : this.href,
                    'type' : 'ajax'
                });
                return false;
            });
        }
    },
    {
        load: library_path + '/prefixfree.min.js',
        complete: function() {
            console.clear();
        }
    },
    {
        test: $.browser.msie && $.browser.version<8,
        yep: library_path + '/ie_blocker/warning.js'
    }
]);

//test: Modernizr.input.required, nope: 'js/check_required.js', complete: function() { init(); }