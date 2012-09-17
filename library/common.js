var css = (env == 'production') ? library_path + '/min/?f=' + client_css : client_css;
var library = (env == 'production') ? library_path + '/min/?f=' + library_path : library_path;

Modernizr.load([
    {
        load: [css + '/boilerplate.css', css + '/main.css', css + '/green.css']
    },
    {
        load: [library + '/chosen/chosen.css', library + '/chosen/chosen.min.js'],
        complete: function() {
            $('select').chosen();
        }
    },
    {
        test: $.browser.mozilla,
        yep: css + '/mozilla_reset.css'
    },
    {
        test: Modernizr.input.required,
        nope: library + '/modernizr.input.required.js'
    },
    {
        test: $("textarea").is("[id^='cked-']"),
        yep: library + '/ckeditor/ckeditor.js',
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
        yep: [library + '/jquery-ui/jquery-ui-1.8.23.custom.min.js',library + '/jquery-ui/jquery-ui-1.8.23.custom.css'],
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
        yep: [library + '/fancybox/jquery.fancybox.js', library + '/fancybox/jquery.fancybox.css'],
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
        test: $('form').length > 0,
        yep: library + '/jquery.h5validate.js',
        callback: function() {
            $('form').h5Validate();
        }
    },
    {
        load: library + '/prefixfree.min.js',
        complete: function() {
            console.clear();
        }
    },
    {
        test: $.browser.msie && $.browser.version<8,
        yep: library + '/ie_blocker/warning.js'
    }
]);

//test: Modernizr.input.required, nope: 'js/check_required.js', complete: function() { init(); }