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
                document.write('<script type="text/javascript" src="min/js/c=false/f=yepnope;jquery"></script>');   //don't compress and cache 31day (86400 x 31)
            }
            setTimeout('JSLoader()', 50);
        }
    };
    JSLoader();

    DRM.loadMainCss = function() {
        DRM.css.push('boilerplate','green','main');
        DRM.js.push(DRM.locale);
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
        if($('form').length>0) {
            DRM.js.push('h5');
            DRM.callbacks.h5 = function() {
                $('form').h5Validate();
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

        DRM.confirm.method = function(params) {
            var button = '';
            $.each(params.buttons, function (name, obj, href) {
                button += '<a href="' + obj['href'] + '" class="button ' + obj['class'] + '">' + name + '</a>';
            });

            var markup = ['<div id="DRM-confirm"><div id="confirmBox"><h1>',message.confirm,'</h1>',
                '<p>',message.confirm_message,'</p><div id="confirmButtons">',button,'</div></div></div>'
            ].join('');

            $(markup).appendTo('body').show();

            $('.confirm-no').live('click', function(){
                $('#DRM-confirm').remove();
                return false;
            });

            $('a.button.click-submit').live('click', function(){
                $('a.submit.confirm').closest('form').submit();
                return false;
            });
        };

        DRM.ieLocker = function() {
            var path = DRM.libraryPath+'/DRM/images/';
            var div = document.createElement("div");

            var browsers = [{
                name : "Firefox",
                icon : path + "ff.png",
                //link : "http://www.mozilla.com/firefox/"
            },{
                name : "Chrome",
                icon : path + "ch.png",
                //link : "http://www.google.com/chrome/"
            },{
                name : "Opera",
                icon : path + "op.png",
                //link : "http://www.opera.com/download/"
            },{
                name : "Internet Explorer 8+",
                icon : path + "ie.png",
                //link : "http://windows.microsoft.com/en-US/internet-explorer/downloads/ie"
            }];

            var markup = "<div style='margin: 10% 20%;'><h1 style='color:white;font-size: 18px;'>" + message.ie_out_of_date + "</h1>"
                        + "<p style='color:white;margin-top: 20px;'>" + message.ie_recomendations + "</p>"
                        + "<p style='color:white;'>" + message.ie_other_browsers + "</p>"
                        + "<div style='text-align: center;margin-top: 20px;'>";

            for (var i=0;i<browsers.length;i++) {
                markup += "<a href='" + browsers[i].link + "' title='" + browsers[i].name + "'><img src='" + browsers[i].icon + "' /></a>";
            }

            $('body').css({'background-image':'url('+path+'opacity80.png)','overflow':'hidden','z-index':'2147483647'});
            $('body').html($(div).html(markup+'</div></div>'));
        }
    };

    DRM.loadCSS = function() {
        if(DRM.environment == 'production') {
            var files = '';
            for(var i=0;i<DRM.css.length;i++) {
               files += DRM.css[i]+';';
            }
            yepnope.injectCss("min/css/{hash_css}f="+files);

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
            yepnope.injectJs("min/js/{hash_js}f="+files,
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
                yepnope.injectJs("min/js/f="+DRM.js[i],
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
        DRM.h5validate();
        DRM.mozilla();
        DRM.chosen();
        DRM.ie();
        DRM.loadCSS();
        DRM.loadJS();
        DRM.run();
    };