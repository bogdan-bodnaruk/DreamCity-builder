var DRM = {};
    DRM.environment = '{env}';
    DRM.libraryPath = '{library}';
   /* DRM.library = 'library'; DRM.libraryPathProduction = 'library/min/?f=library';*/
    /*DRM.library = (DRM.environment == 'production' ? DRM.libraryPathProduction : DRM.libraryPath); */
    DRM.css = [];
    DRM.locale = '{locale}';

    DRM.JQueryInited = false;
    DRM.JQueryVersion = '1.8.3';
    DRM.JQueryLoad = 'local'; /* cdn, local */
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
                document.write('<script type="text/javascript" src="min/js/?f=yepnope"></script>');
            }
            setTimeout('YepNopeLoader()', 50);
        }
    };
    !DRM.YepNopeInited ? YepNopeLoader() : '';

    DRM.loadMainCss = function() {
        DRM.css.push('boilerplate','green','main');
        yepnope({
            load: ['/.config/i18n/messages.'+ DRM.locale + '.js',
                   DRM.library + '/DRM/drmJQuery/drmJQuery.js',
            ],
            complete: function() {
                $('html').show();
            }
        });
    };

    DRM.chosen = function() {
        if($('select').length) {
            DRM.css.push('chosen');
            yepnope({
                load: [DRM.library + '/chosen/chosen.min.js'],
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
            yepnope({
                load: [DRM.library + '/qTip2/jquery.qtip.min.js'],
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
            yepnope({
                load: [DRM.library + '/fancybox/jquery.fancybox.js'],
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
            yepnope({
                load: [DRM.library + '/jquery-ui/jquery-ui-1.8.23.custom.min.js'],
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
                load: ['preload!'+DRM.libraryPath + '/DRM/PIE.js',
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
            yepnope.injectCss("min/css/?f="+files);

        } else {
            for(var i=0;i<DRM.css.length;i++) {
                yepnope.injectCss("min/css/?f="+DRM.css[i]);
            }
        }
    };

    DRM.init = function() {
        DRM.loadMainCss();
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