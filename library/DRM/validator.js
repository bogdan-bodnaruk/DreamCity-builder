(function($) {
    $.fn.liveValidate = function(options) {
        var selector = this;
        var settings = {
            regex: {
                _email: /^[a-z0-9]+(?:[-\._]?[a-z0-9]+)*@(?:[a-z0-9]+(?:-?[a-z0-9]+)*\.)+[a-z]+$/,
                _url: /^(https?\:\:?\/\/)?(www.)?[^.]+\.\w{2,8}/,
                _number: /-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?/,
                _dateYYYYmmdd: /\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}/,
                _datemmddYYYY: /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}/,
                _login: /^[a-zA-Z0-9_]+$/,
                _password: /[a-zA-Z0-9_-]/,
                _text: /[\w!@$%^&*()№_+|\-\\\/,=.?'";:а-яА-ЯіІїЇєЄёЁ\s\ ]/,
                _num: /[0-9]/,
                _phone: /[0-9\-+]{5,18}/,
                _alpha: /[a-zA-Z]+/
            },
            events: {
                focusout: true,
                focusin: true,
                change: true,
                keyup: true,
                click: true,
                submit: true
            },
            classes: {
                error: '-input-error',
                valid: '-valid',
                active: '-active'
            }
        };
        var data = $.extend(settings, options);
        var error = 0;    

        $('.'+data.classes.error).live('mouseleave', function() {
            $(this).next('tooltip').removeClass('show');
        });
        $('.'+data.classes.error).live('mouseover', function() {
            $(this).next('tooltip').addClass('show');
        });


        var addMessage = function(el, icon, message) {
            if(!el.next().hasClass(data.classes.error)) {
                var coords = el.position();
                var top = coords.top-el.height()-25 +'px';
                var left = coords.left+el.width()-7 +'px';

                el.after('<span class="tooltip show" style="top: '+top+';left: '+left+'">'+message+'<div class="arrow-down"></div></span>');
                el.after(icon);
                error++;
            };
        };    

        var doValidation = function(event) {
            selector.live(event, function() {
                var el = $(this);
                var _class = el.attr('class').split(' ');
                var icon = '<span class="'+data.classes.error+'">i</span>';

                for(var i=0;i<_class.length;i++) {
                    if((el.val().length>0 || event=='focusout') && data.regex[_class[i]]) {
                        addMessage(el, icon, 'test');
                    };
                    if(el.val().length > el.attr('maxlength')) {
                        addMessage(el, icon, 'test123');
                    };
                    if(el.val().length < el.data('min')) {
                        addMessage(el, icon, 'test321');
                    };

                    if(error===0) {
                        el.next().remove('span.'+data.classes.error);
                    };
                }
            });
        };

        for(var events in data.events) {
            data.events[events] ? doValidation(events) : '';
        }    
    };  
})(jQuery); 

$(document).ready(function(){
    $('form input[type=text], form textarea').liveValidate();
});