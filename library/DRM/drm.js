var DRM = {};
    DRM.environment = '{env}';
    DRM.library = '{library}';
    DRM.css = [];
    DRM.js = [];
    DRM.locale = '{locale}';
    DRM.callbacks = {};
    /*DRM.ajax = true;  doesn't work yet
    DRM.fullAjax = true;*/

    DRM.JSInited = false;
    var JSLoader = function() {
        if (typeof(jQuery) == 'undefined') {
            if (!DRM.JSInited) {
                DRM.JSInited = true;
                document.write('<script type="text/javascript" src="min/type=js/c=false/f=yepnope;jquery"></script>');   //don't compress and cache 31day (86400 x 31)
            }
            setTimeout('JSLoader()', 50);
        }
    };
    JSLoader();

    DRM.loadMainCss = function() {
        DRM.css.push('boilerplate','green','main');
        DRM.js.push(DRM.locale, 'helpers');
    };

    DRM.chosen = function() {
        if($('select').length) {
            DRM.css.push('chosen');
            DRM.js.push('chosen');
            DRM.callbacks.chosen = function() {
                $("select").chosen({disable_search_threshold: 10});
            };
        }
    };

    DRM.mozilla = function() {
        if($.browser.mozilla) {
            DRM.css.push('mozilla_reset');
        }
    };

    DRM.qtip2 = function() {
        if($('.qtip-tooltip').length > 0) {
            DRM.css.push('qtip2');
            DRM.js.push('qtip2');

            DRM.callbacks.qtip = function() {
                $('a.qtip-tooltip[title]').qtip({
                    position: {
                        my: 'bottom center',
                        at: 'top center'
                    },
                    style: {
                        classes: 'ui-tooltip-shadow ui-tooltip-bootstrap'
                    }
                });
            };
        }
    };

    DRM.confirm = function() {
        if($('.confirm').length > 0) {
            $('.confirm').live('click', function(){
                DRM.confirm.method({
                    'buttons': {
                        'Yes': {
                            'href'  : $(this).children("label.confirm-text").text(),
                            'class' : $(this).hasClass('submit') ? 'click-submit' : ''
                        },
                        'No': {
                            'href'	: '#',
                            'class' : 'confirm-no'
                        }
                    }
                });
                return false;
            });
        }
    };

    DRM.ckeditor = function() {
        yepnope({
            test: $("textarea").is("[id^='cked-']"),
            yep: DRM.library + '/ckeditor/ckeditor.js',
            callback: function() {
                for(i=0;i<$("textarea[id^='cked-']").length;i++) {
                    if (CKEDITOR.instances[$("textarea[id^='cked-']")[i].id]) {
                        delete CKEDITOR.instances[$("textarea[id^='cked-']")[i].id]
                    };
                    CKEDITOR.replace(
                        $("textarea[id^='cked-']")[i].id, {
                            toolbar : $("textarea[id^='cked-']")[i].classList[0]
                        }
                    );
                }
            }
        });
    };

    DRM.fancybox = function() {
        if($("div").is("[id^=fancybox-]") || $('a').is("[class^=fancybox-]")) {
            DRM.css.push('fancybox');
            DRM.js.push('fancybox');

            DRM.callbacks.fancybox = function() {
                $("div[id^=fancybox-]>a").fancybox({
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
            };
        }
    };

    DRM.jQueryUI = function() {
        if($("input").is("[id^=datepicker-]") || $("div").is("[id^=window-]")) {
            DRM.css.push('jqueryui');
            DRM.js.push('jqueryui');

            DRM.callbacks.jqueryui = function() {
                $("input[type='text'][id^=datepicker-]").datepicker({yearRange:'-65:+15' });

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
        }
    };

    /*Need testing*/
    DRM.ie = function() {
        if($.browser.msie) {
            yepnope({
                load: ['min/type=js/f=classlist'],
                complete: function() {
                    if($.browser.version<8) {
                        DRM.ieLocker();
                    }
                }
            });
            if($.browser.version==8.0) {
                DRM.css.push('ie8');
            }
            if($.browser.version==9.0) {
                DRM.css.push('ie9');
            }
        }
    };

    DRM.validate = function() {
        if($('form').length>0) {
            DRM.js.push('validate');
            DRM.callbacks.validate = function() {
                $('form input[type=text], form textarea').liveValidate();
            }
        }
    };

    DRM.run = function() {
        $('.detach').remove();

        $('a.selected').live('click', function(e){
            e.preventDefault();
        });

        $('a').each(function(){
            if($(this).attr('href')==window.location.pathname){
                $(this).addClass('selected');
            };
        });

        $('a[href=#]').live('click', function(){
            return false;
        });        
    };

    DRM.loadCSS = function() {
        if(DRM.environment == 'production') {
            var files = '';
            for(var i=0;i<DRM.css.length;i++) {
               files += DRM.css[i]+';';
            }
            yepnope.injectCss("min/type=css/{hash_css}f="+files);

        } else {
            for(var i=0;i<DRM.css.length;i++) {
                yepnope.injectCss("min/type=css/f="+DRM.css[i]);
            }
        }
    };

    DRM.loadJS = function() {
        if(DRM.environment == 'production') {
            var files = '';
            for(var i=0;i<DRM.js.length;i++) {
               files += DRM.js[i]+';';
            }
            yepnope.injectJs("min/type=js/{hash_js}f="+files,
                function(){
                    if(DRM.callbacks && typeof(DRM.callbacks)=="object") {
                        for (var i in DRM.callbacks) {
                            DRM.callbacks[i]();
                        }
                    }
                }
            );
        } else {
            for(var i=0;i<DRM.js.length;i++) {
                yepnope.injectJs("min/type=js/f="+DRM.js[i],
                    function(){
                        if(DRM.callbacks && typeof(DRM.callbacks)=="object") {
                            for (var i in DRM.callbacks) {
                                DRM.callbacks[i]();
                            }
                        }
                    }
                );
            }
        }
    };

    window.onload = function() {
        DRM.loadMainCss();
        DRM.qtip2();
        DRM.ckeditor();
        DRM.confirm();
        DRM.fancybox();
        DRM.jQueryUI();
        DRM.validate();
        DRM.mozilla();
        DRM.chosen();
        DRM.ie();
        DRM.loadCSS();
        DRM.loadJS();
        DRM.run();
        $('html').show();
    };