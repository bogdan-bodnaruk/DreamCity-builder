(function($) {
    $.fn.liveValidate = function(options) {
        var that = this;
        var __ = {
            settings: {
                regex: {
                    _email: /^[a-z0-9]+(?:[-\._]?[a-z0-9]+)*@(?:[a-z0-9]+(?:-?[a-z0-9]+)*\.)+[a-z]+$/,
                    _url: /^(https?\:\:?\/\/)?(www.)?[^.]+\.\w{2,8}/,
                    _num: /-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?/,
                    _dateYYYYmmdd: /\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}/,
                    _datemmddYYYY: /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}/,
                    _login: /^[a-zA-Z0-9_]+$/,
                    _password: /[a-zA-Z0-9_-]/,
                    _text: /[\w!@$%^&*()№_+|\-\\\/,=.?'";:а-яА-ЯіІїЇєЄёЁ\s\ ]/,
                    _int: /[0-9]/,
                    _phone: /[0-9\-+]{5,18}/
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
                    warning: '-input-warning'
                }
            },
            addMessage: function(el, message) {
                if(!el.next().hasClass(this.data.classes.error)) {
                    var coords = el.position();
                    var top = coords.top-el.height();
                    var left = coords.left+el.width();
                    
                    el.addClass(this.data.classes.warning);
                    el.after('<div class="tooltip show">'+message+'<i class="arrow-down"></i></div>');
                    el.after('<i class="'+this.data.classes.error+'">i</i>');
                    el.next().css({
                        'top'   :top+18,
                        'left'  :left-5
                    });
                    el.next().next().css({
                        'top':top-25,
                        'left':left-7
                    });

                    $(el.parents('form')).on('submit', function() {
                        $('.tooltip').show();
                        return false;
                    });
                };
            },
            validate: function(event) {
                that.on(event, function() {
                    var el = $(this);
                    var error = 0; 
                    var _class = el.attr('class').split(' ');

                    for(var i=0;i<_class.length;i++) {
                        if(el.val().length>0 && __.data.regex[_class[i]]) {
                            if(!(__.data.regex[_class[i]].test($(this).val()))) {
                                error += __.addMessage(el, DRM.message['not'+_class]);
                            }
                        };

                        if(el.val().length > el.attr('maxlength')) {
                            error += __.addMessage(el, DRM.lang('minChar', el.attr('maxlength')));
                        };

                        if(event=='focusout' || event=='submit') {
                            if(el.val().length < el.data('min') && el.val().length>0) {
                                error += __.addMessage(el, DRM.lang('minChar', el.data('min')));
                            }
                            if(el.attr('required')=='required' && el.val().length==0) {
                                error += __.addMessage(el, DRM.message.required);
                            }
                        }

                        if(error===0) {
                            el.removeClass(__.data.classes.warning).siblings('i.'+__.data.classes.error+',div.tooltip').remove();
                            $(el.parents('form')).unbind('submit');
                        };
                    }

                    if(event == 'focusin' || event == 'focusout') {
                        el.next().next().toggleClass('show');
                    }
                });
            },
            init: function() {
                $('.'+__.data.classes.error).on('mouseover mouseout', function() {
                    if(!$(this).prev().is(':focus')) {
                        $(this).next().toggleClass('show');
                    };
                });

                $(window).off().on('resize', function() {
                    $('.'+data.classes.error).each(function() {
                        var input = $(this).prev().position();
                        var top = input.top-$(this).prev().height();
                        var left = input.left+$(this).prev().width();
                        $(this).css({
                            'top'   : top+18,
                            'left'  : left-5
                        });
                        $(this).next().css({
                            'top'   : top-25,
                            'left'  : left-7
                        });
                    });
                });  

                for(var events in this.data.events) {
                    this.data.events[events] ? this.validate(events) : '';
                }   
            }
        };
        __.data = $.extend(__.settings, options);
        __.init();
    };
})(jQuery); 