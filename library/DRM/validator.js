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
                active: '-active',
                required: 'required',
            }
        };
        var data = $.extend(settings, options);

        var doValidation = function(event) {
            selector.live(event, function() {
                var _class = ($.trim($(this).attr('class'))).split(' ');
                for(var i=0;i<_class.length;i++) {
                    if(data.regex[_class[i]]) {
                        if(data.regex[_class[i]].test($(this).val())) {
                            $(this).next().remove('span.'+data.classes.error);
                        } else {
                            if(!$(this).next().hasClass(data.classes.error)) {
                                $(this).after('<span class="'+data.classes.error+'">i</span>');
                            };
                        };
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