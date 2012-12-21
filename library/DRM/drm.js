var DRM = {};
    DRM.environment = 'production';
    DRM.libraryPath = 'library';
    DRM.libraryPathProduction = 'library/min/?f=library';
    DRM.library = (DRM.environment == 'production' ? DRM.libraryPathProduction : DRM.libraryPath);
    DRM.cssPath = 'web/theme/css';
    DRM.cssPathProduction = 'library/min/?f=web/theme/css';
    DRM.css = (DRM.environment == 'production' ? DRM.cssPathProduction : DRM.cssPath);
    DRM.locale = 'en';

    DRM.JQueryInited = false;
    DRM.JQueryVersion = '1.8.3';
    DRM.JQueryLoad = 'local'; // cdn, local
    DRM.JQueryCDN = '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/'+DRM.JQueryVersion+'/jquery.min.js"></script>';
    DRM.JQueryLocal = '<script type="text/javascript" src="'+DRM.libraryPath+'/DRM/jquery-'+DRM.JQueryVersion +'.min.js"></script>';

    DRM.ajax = true;
    DRM.fullAjax = true;

    var JQueryLoader = function() {
        if (typeof(jQuery) == 'undefined') {
            if (!DRM.JQueryInited) {
                DRM.JQueryInited = true;
                document.write(DRM.JQueryLoad == 'cdn' ? DRM.JQueryCDN : DRM.JQueryLocal);
            }
            setTimeout('JQueryLoader()', 50);
        }
    };

    DRM.JQueryLoad ? JQueryLoader() : '';


    DRM.YepNopeInited = false;
    var YepNopeLoader = function() {
        if (typeof(yepnope) == 'undefined') {
            if (!DRM.YepNopeInited) {
                DRM.YepNopeInited = true;
                document.write('<script type="text/javascript" src="'+DRM.library+'/DRM/yepnope.js"></script>');
            }
            setTimeout('YepNopeLoader()', 50);
        }
    };
    !DRM.YepNopeInited ? YepNopeLoader() : '';

    DRM.loadMainCss = function() {
        yepnope({
            load: ['/.config/i18n/messages.'+ DRM.locale + '.js',
                   DRM.library + '/DRM/drmJQuery/drmJQuery.js',
                   DRM.library + '/DRM/drmJQuery/drmJQuery.css'
            ],
            complete: function() {
                DRM.loadCSS(['main','boilerplate','green']);
                $('html').show();
            }
        });
    }

    DRM.chosen = function() {
        if($('select').length) {
            yepnope({
                load: [DRM.library + '/chosen/chosen.css',
                       DRM.library + '/chosen/chosen.min.js'],
                complete: function() {
                    $('select').chosen({disable_search_threshold: 10});
                }
            });
        }
    }

    DRM.mozilla = function() {
        if($.browser.mozilla) {
            yepnope({
                load: DRM.css + '/mozilla_reset.css'
            });
        }
    }

    DRM.qtip2 = function() {
        yepnope({
            test: $('.qtip-tooltip').length > 0,
            yep: [DRM.library + '/qTip2/jquery.qtip.min.js',
                  DRM.library + '/qTip2/jquery.qtip.min.css'],
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
    }

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
    }

    DRM.fancybox = function() {
        yepnope({
            test: $("div").is("[id^=fancybox-]") || $('a').is("[class^=fancybox-]"),
                yep: [DRM.library + '/fancybox/jquery.fancybox.js', DRM.library + '/fancybox/jquery.fancybox.css'],
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

    DRM.jQueryUI = function() {
        yepnope({
            test: $("input").is("[id^=datepicker-]") || $("div").is("[id^=window-]"),
                yep: [DRM.library + '/jquery-ui/jquery-ui-1.8.23.custom.min.js',DRM.library + '/jquery-ui/jquery-ui-1.8.23.custom.css'],
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

    // Need testing
    DRM.ie = function() {
        if($.browser.msie) {
            yepnope({
                load: ['ie9!' + DRM.css + '/ie9.css',
                       'ie8!' + DRM.css + '/ie8.css',
                       'preload!'+DRM.libraryPath + '/DRM/PIE.js',
                        DRM.library + '/DRM/classList.js'],
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
        }
    }

    DRM.h5validate = function() {
        yepnope({
            test: $('form').length > 0,
                yep: DRM.library + '/jquery.h5validate.js',
                callback: function() {
                $('form').h5Validate();
            }
        });
    }

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
    }

    DRM.loadCSS = function(css) {
        if(DRM.environment == 'production') {
            var files = '';
            for(var i=0;i<css.length;i++) {
               files += css[i]+';';
            }
            yepnope.injectCss("min/css/?f="+files);

        } else {
            for(var i=0;i<css.length;i++) {
                yepnope.injectCss("min/css/?f="+css[i]);
            }
        }
    }

    DRM.init = function() {
        DRM.chosen();
        DRM.mozilla();
        DRM.ckeditor();
        DRM.qtip2();
        DRM.confirm();
        DRM.fancybox();
        DRM.jQueryUI();
        DRM.h5validate();
        DRM.ie();
        DRM.run();
    }

    window.onload = function() {
        DRM.loadMainCss();
        DRM.init();
    };