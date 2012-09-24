var css = (env == 'production') ? library_path + '/min/?f=' + client_css : client_css;
var library = (env == 'production') ? library_path + '/min/?f=' + library_path : library_path;

Modernizr.load([
    {
        load: [css + '/boilerplate.css', css + '/main.css', css + '/green.css']
    },
    {
      load: '/.config/i18n/messages.'+ locale + '.js'
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
		test: $.browser.msie,
		yep: library + '/classList.js'
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
		test: $.browser.msie && $.browser.version==8.0,
		yep: [css + '/ie8.css', library + '/PIE.js'],
		callback: function() {
			if (window.PIE) {
				$('div.radio_wrapper > input[type="radio"]:first-child + label').css('border-radius', '5px 0 0 5px');
				$('div.radio_wrapper > input[type="radio"] + label:last-child').css('border-radius', '0 5px 5px 0');
				$('div.checkbox_wrapper > input[type="checkbox"]:first-child +label').css('border-radius', '5px 0 0 5px');
				$('div.checkbox_wrapper > input[type="checkbox"] + label:last-child').css('border-radius', '0 5px 5px 0');
				$(document).ready(function(){
					$('*').each(function() {
						PIE.attach(this);
					});
				});
			}
			
			$('label[for^=radio_]').on('click', function() {
				var idRadio = $(this).attr('for');
				var nameRadio = $('input[id='+ idRadio +']').attr('name');
				$('label[for^=radio_'+nameRadio+']').removeClass('radioСhecked');
				$('input[id=' + idRadio +']').attr('checked', 'checked');
				$(this).addClass('radioСhecked');
			});

			$('label[for^=checkbox_]').on('click', function() {
				$('input[id=' + $(this).attr('for') +']').attr('checked', 'checked');
				$(this).addClass('checkboxСhecked');
				$('body').click();
			});

			$('label[class^=checkboxСhecked]').live('click', function(){
				$('input[id=' + $(this).attr('for') +']').removeAttr('checked');
				$(this).removeClass('checkboxСhecked');
				$('body').click();
			});
			
			var checkedCheckbox = $('body').find('input[type=checkbox]:checked');
			if(checkedCheckbox.length >= 0) {
				for(var i=0; i<checkedCheckbox.length; i++) {
					$('label[for=checkbox_'+ $(checkedCheckbox[i]).attr('name') +']').addClass('checkboxСhecked');
				}
			};
			
			var checkedRadio = $('body').find('input[type=radio]:checked');
			if(checkedRadio.length >= 0) {
				for(var j=0; j<checkedRadio.length; j++) {
					$('label[for='+ $(checkedRadio[j]).attr('id') +']').addClass('radioСhecked');
				}
			};
		}
	},
	{
		test: $.browser.msie && $.browser.version==9.0,
		yep: [css + '/ie9.css', library + '/PIE.js'],
		callback: function() {
			if (window.PIE) {
				$('*').each(function() {
					PIE.attach(this);
				});
			}
		}
	},
    {
        test: $.browser.msie && $.browser.version<8,
        yep: library + '/ie_blocker/warning.js'
    }
]);
