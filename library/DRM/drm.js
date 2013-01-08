var DRM = {};
    DRM.environment = '{env}';
    DRM.library = '{library}';
    DRM.css = [];
    DRM.js = [];
    DRM.locale = '{locale}';
    /*DRM.ajax = true;  doesn't work yet
    DRM.fullAjax = true;*/

    DRM.JQueryInited = false;
    var JQueryLoader = function() {
        if (typeof(jQuery) == 'undefined') {
            if (!DRM.JQueryInited) {
                DRM.JQueryInited = true;
                document.write('<script type="text/javascript" src="min/js/f=jquery/c=false/e=2678400"></script>');   //don't compress and cache 31day (86400 x 31)
            }
            setTimeout('JQueryLoader()', 50);
        }
    };

    JQueryLoader();


    DRM.YepNopeInited = false;
    var YepNopeLoader = function() {
        if (typeof(yepnope) == 'undefined') {
            if (!DRM.YepNopeInited) {
                DRM.YepNopeInited = true;
                document.write('<script type="text/javascript" src="min/js/f=yepnope/c=false/e=2678400"></script>');   //don't compress and cache 31day (86400 x 31)
            }
            setTimeout('YepNopeLoader()', 50);
        }
    };
    !DRM.YepNopeInited ? YepNopeLoader() : '';

    DRM.loadMainCss = function() {
        DRM.css.push('boilerplate','green','main');
        DRM.js.push(DRM.locale,'drmjquery');
    };

    DRM.chosen = function() {
        if($('select').length) {
            DRM.css.push('chosen');
            yepnope({
                load: ['/min/js/f=chosen/e=604800'], // Cache 7day (86400 x 7)
                complete: function() {
                    $('select').chosen({disable_search_threshold: 10});
                }
            });
        }
    };

    DRM.mozilla = function() {
        if($.browser.mozilla) {
            DRM.css.push('mozilla_reset');
        }
    };

    DRM.qtip2 = function() {
        if($('.qtip-tooltip').length > 0) {
            DRM.css.push('qtip');
            DRM.js.push('qtip');
            yepnope({
                //load: ['/min/js/f=qtip/e=604800'],
                // Cache 7day (86400 x 7)
                callback: function() {
                    $('a.qtip-tooltip[title]').qtip({
                        position: {
                            my: 'bottom center',
                            at: 'top center'
                        },
                        style: {
                            classes: 'ui-tooltip-shadow ui-tooltip-bootstrap'
                        }
                    });
                }
            });
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
            yepnope({
                //load: ['/min/js/f=fancybox/e=604800'],
                // Cache 7day (86400 x 7)
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
            });

        }
    };

    DRM.jQueryUI = function() {
        if($("input").is("[id^=datepicker-]") || $("div").is("[id^=window-]")) {
            DRM.css.push('jqueryui');
            DRM.js.push('jqueryui');
            yepnope({
                //load: ['/min/js/f=jqueryui/e=2678400'],
                // Cache 31day (86400 x 31)
                callback: function() {
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
            });
        }
    };

    /*Need testing*/
    DRM.ie = function() {
        if($.browser.msie) {
            yepnope({
                load: ['preload!min/js/f=pie/c=false/e=2678400',   //don't compress and cache 31day (86400 x 31)
                        'min/js/f=classlist'],
                complete: function() {
                    if($.browser.version<8) {
                        DRM.ieLocker();
                    }
                },
                callback: function() {
                    if (window.PIE) {
                        $('*').each(function() {
                            PIE.attach(this);
                        });
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

    DRM.h5validate = function() {
        yepnope({
            test: $('form').length > 0,
                yep: DRM.library + '/jquery.h5validate.js',
                callback: function() {
                $('form').h5Validate();
            }
        });
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
            yepnope.injectCss("min/css/f="+files);

        } else {
            for(var i=0;i<DRM.css.length;i++) {
                yepnope.injectCss("min/css/f="+DRM.css[i]);
            }
        }
    };

    DRM.loadJS = function() {
        if(DRM.environment == 'production') {
            var files = '';
            for(var i=0;i<DRM.js.length;i++) {
               files += DRM.js[i]+';';
            }
            yepnope.injectJs("min/js/f="+files);

        } else {
            for(var i=0;i<DRM.js.length;i++) {
                yepnope.injectJs("min/js/f="+DRM.js[i]);
            }
        }
    };

    DRM.init = function() {
        DRM.loadMainCss();
        DRM.loadJS();
        DRM.chosen();
        DRM.ckeditor();
        DRM.qtip2();
        DRM.confirm();
        DRM.fancybox();
        DRM.jQueryUI();
        DRM.h5validate();
        DRM.mozilla();
        DRM.ie();

        DRM.run();
    };

    window.onload = function() {
        DRM.init();
        DRM.loadCSS();
        $('html').show();
    };