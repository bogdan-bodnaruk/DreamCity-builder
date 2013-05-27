var d = {
    config: {
        debug: true
    },
    debug: function(message, type) {
        if(this.config.debug) {
            console.log('[' + type.toUpperCase() + '] ' + message);
        };
    },
    i18n: function(key, value) {
        var m = this.message[key];
        if(value) {
            value = this.explode(';',value);
            if(value.length) {
                for(var i=0 in value) {
                    m = m.replace('{' + i + '}', value[i]);
                }
            };
        };
        return m;
    },
    explode: function(delimiter, value) {
        var test = function(value, name) {
            value = d.is.empty(value) ? undefined : value;
            if(!d.is.string(value) && !d.is.number(value)) {
                d.debug(name + ' can\'t be ' + typeof (value), 'error');
                return false;
            };
            return true;
        };

        if(test(delimiter, 'Delimiter') && test(value, 'Value')) {
            return value.toString().split(delimiter.toString());
        };
    },
    trim: function( str ) {
        return str.replace(/^\s+|\s+$/g, '');
    },
    is: {
        empty: function(value) {
            return !!(value === undefined || value === '' || value === null);
        },
        string: function(value) {
            return !!(typeof (value) === 'string');
        },
        number: function(value) {
            return !!(typeof (value) === 'number');
        },
        object: function(value) {
            return !!(typeof (value) === 'object');
        },
        array: function(value) {
            return !!(typeof (value) === 'array');
        }
    },
    cookie: {
        _year: function( year ) {
            return d.is.empty(year) ? 0 : (year * 365 * 31 * 24 * 60 * 60 * 1000);
        },
        _month: function( month ) {
            return d.is.empty(month) ? 0 : (month * 31 * 24 * 60 * 60 * 1000);
        },
        _day: function( day ) {
            return d.is.empty(day) ? 0 : (day * 24 * 60 * 60 * 1000);
        },
        _hour: function( hour ) {
            return d.is.empty(hour) ? 0 : (hour * 60 * 60 * 1000);
        },
        _minute: function( minute ) {
            return d.is.empty(minute) ? 0 : (minute * 60 * 1000);
        },
        set: function( obj ) {
            if( obj ) {
                var timezone = new Date();
                timezone = this._minute(-timezone.getTimezoneOffset());

                var cookie = obj.name  + '=' + escape(obj.value) + ';'
                var expires = this._year(obj.year) +
                    this._month(obj.month) +
                    this._day(obj.day) +
                    this._hour(obj.hour) +
                    this._minute(obj.minute);
                expires = (new Date((new Date()).getTime() + expires + timezone)).toGMTString();
                cookie += 'expires=' + expires + ';';
                document.cookie = cookie;
            } else {
                d.debug('For set cookie need some attributes', 'error');
            };
        },
        update: function( obj ) {
            if( this.get( obj.name )) {
                d.cookie.set(obj);
            };
        },
        delete: function( name )  {
            if( this.get( name )) {
                d.cookie.set({
                    name: name,
                    value: '',
                    year: -1
                });
            };
        },
        get: function( name ) {
            var cookie = d.explode(';', document.cookie);
            for( var i in cookie ) {
                var getName = d.explode('=', cookie[i]);
                if(d.trim(getName[0]) == name) {
                    return getName[1];
                };
            };
        }
    },
    browser: {
        name: [/chrome/,/safari/,/firefox/,/opera/,/msie/],
        mobile: [/android/,/blackberry/,/iphone/,/ipad/,/ipod/,/opera mini/,/iemobile/],

        type: function(name) {
            var navigator = window.navigator.userAgent.toLowerCase();
            for( var i in name ) {
                if( name[i].test(navigator) ) {
                    return (name[i].toString()).split('/').join('');
                };
            }
        },
        check: function() {
            return this.type( this.name );
        },
        isMobile: function() {
            return this.type( this.mobile );
        }
    },
    run: {
        i18n: function() {
            var findAll = document.querySelectorAll('i18n');
            for( var i in findAll ) {
                if( d.is.object(findAll[i]) ) {
                    var key = findAll[i].getAttribute('key');
                    var value = findAll[i].getAttribute('value') || false;

                    if( d.is.empty(key) ) {
                        d.debug('i18n tag should have key', 'WARNING')
                    } else {
                        var message = document.createTextNode( d.i18n(key, value) );
                        var tag = findAll[i].parentNode;
                        tag.insertBefore(message, findAll[i]);
                        tag.removeChild(findAll[i]);
                    };
                };
            }
        },
        browser: function() {
            document.querySelector('html').className += ' ' + d.browser.check();
        },
        isMobile: function() {
            if( d.browser.isMobile() ) {
                document.querySelector('html').className += ' ' + d.browser.isMobile();
            };
        }
    },
    start: function() {
        var start = (new Date()).getTime();

        for( var i in this.run ) {
            this.run[i]();
        }

        if( this.config.debug ) {
            var end = (new Date()).getTime();
            this.debug('d.run was spent ' + ((end - start)/1000) + ' seconds', 'info');
        };
    }
}

d.start();

var DRM = {
    js          : [],
    css         : [],
    locale      : '{locale}',
    library     : '{library}',
    callbacks   : {},
    environment : '{env}',
    JQueryLoad  : function() {
        if (typeof(jQuery) === 'undefined') {
            if (!DRM.JQueryInit) {
                DRM.JQueryInit = true;
                document.write('<script src="/min/type=js/c=false/f=yepnope;jquery"></script>');   //don't compress and cache 31day (86400 x 31)
            }
        }
    },
    loadMainCss : function() {
        this.css.push('boilerplate','green','main');
        this.js.push(this.locale, 'helpers');
    },
    chosen      : function() {
        if($('select').length) {
            this.css.push('chosen');
            this.js.push('chosen');
            this.callbacks.chosen = function() {
                $("select").chosen({
                    disable_search_threshold: 10
                });
            };
        }
    },
    mozilla     : function() {
        $.browser.mozilla ? this.css.push('mozilla_reset') : '';
    },
    qtip2 : function() {
        if($('.qtip-tooltip').length) {
            this.css.push('qtip2');
            this.js.push('qtip2');

            this.callbacks.qtip = function() {
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
    },
    confirm     : function() {
        if($('.confirm').length) {
            $('.confirm').on('click', function(){
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
    },
    ckeditor    : function() {
        yepnope({
            test: $("textarea").is("[id^='cked-']"),
            yep: DRM.library + '/ckeditor/ckeditor.js',
            callback: function() {
                for(var i=0;i<$("textarea[id^='cked-']").length;i++) {
                    var selector = $("textarea[id^='cked-']")[i];
                    var id = $("textarea[id^='cked-']")[i].id;
                    if (CKEDITOR.instances[id]) {
                        delete CKEDITOR.instances[id];
                    };
                    CKEDITOR.replace(
                        id,{
                            toolbar : $(selector).attr('class')
                        }
                    );
                }
            }
        });
    },
    fancybox    : function() {
        if($("div").is("[id^=fancybox-]") || $('a').is("[class^=fancybox-]")) {
            this.css.push('fancybox');
            this.js.push('fancybox');

            this.callbacks.fancybox = function() {
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
    },
    jQueryUI    : function() {
        if($("input").is("[id^=datepicker-]") || $("div").is("[id^=window-]")) {
            this.css.push('jqueryui');
            this.js.push('jqueryui');

            this.callbacks.jqueryui = function() {
                $("input[type='text'][id^=datepicker-]").datepicker({
                    yearRange:'-65:+15'
                });

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
    },
    ie: function() {
        if($.browser.msie) {
            if($.browser.version==8.0) {
                this.css.push('ie8');
            } else if($.browser.version==9.0) {
                this.css.push('ie9');
            } else if($.browser.version<8) {
                this.ieLocker();
            }
        }
    },
    validate: function() {
        if($('form').length) {
            this.js.push('validate');
            this.callbacks.validate = function() {
                $('form input[type=text], form textarea').liveValidate();
            }
        }
    },
    run: function() {
        $('.detach').remove();

        $('a.selected').on('click', function(e){
            e.preventDefault();
        });

        $('a').each(function(){
            if($(this).attr('href')==window.location.pathname){
                $(this).addClass('selected');
            };
        });

        $('a[href=#]').on('click', function(){
            return false;
        });
    },
    loadCSS: function() {
        if(this.environment == 'production') {
            var files = '';
            for(var i=0;i<this.css.length;i++) {
                files += this.css[i]+';';
            }
            yepnope.injectCss("/min/type=css/{hash_css}f="+files);
        } else {
            for(var i=0;i<this.css.length;i++) {
                yepnope.injectCss("/min/type=css/f="+this.css[i]);
            }
        }
    },
    loadJS: function() {
        if(this.environment == 'production') {
            var files = '';
            for(var i=0;i<this.js.length;i++) {
                files += this.js[i]+';';
            }
            yepnope.injectJs("/min/type=js/{hash_js}f="+files,
                function(){
                    if(DRM.callbacks && typeof(DRM.callbacks)=="object") {
                        for (var i in DRM.callbacks) {
                            DRM.callbacks[i]();
                        }
                    }
                }
            );
        } else {
            for(var i=0;i<this.js.length;i++) {
                yepnope.injectJs("/min/type=js/f="+this.js[i],
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
    },
    init: function() {
        this.loadMainCss();
        this.qtip2();
        this.ckeditor();
        this.confirm();
        this.fancybox();
        this.jQueryUI();
        this.mozilla();
        this.chosen();
        this.ie();
        this.loadCSS();
        this.loadJS();
        this.validate();
        this.run();
    }
};

DRM.JQueryLoad();

window.onload = function() {
    DRM.init();
    $('html').show();
};