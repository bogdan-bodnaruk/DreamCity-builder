/**
 * h5Validate
 * @version v0.8.3
 * Using semantic versioning: http://semver.org/
 * @author Eric Hamilton http://ericleads.com/
 * @copyright 2010 - 2012 Eric Hamilton
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Developed under the sponsorship of RootMusic, Zumba Fitness, LLC, and Rese Property Management
 */

/*global jQuery, window, console */
(function ($) {
    'use strict';
    var console = window.console || function () {},
        h5 = { // Public API
            defaults : {
                debug: false,

                RODom: false,

                // HTML5-compatible validation pattern library that can be extended and/or overriden.
                patternLibrary : {
                    //** TODO: Test the new regex patterns. Should I apply these to the new input types?
                    // **TODO: password

                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    drm_email: /((([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-zA-Z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?/,

                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/iri/
                    drm_url: /(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-zA-Z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?/,

                    // Number, including positive, negative, and floating decimal. Credit: bassistance
                    drm_number: /-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?/,

                    // Date in ISO format. Credit: bassistance
                    drm_dateYYYYmmdd: /\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}/,
                    drm_datemmddYYYY: /\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}/,

                    drm_login: /[a-zA-Z]/,
                    drm_password: /[a-zA-Z0-9]/,
                    drm_text: /[\w!@$%^&*()№_+|\-\\,=.?'";:а-яА-ЯіІїЇєЄёЁ\s\ ]/,
                    drm_num: /[0-9]/,

                    drm_phone: /[0-9\-+]{5,18}/,
                    drm_alpha: /[a-zA-Z]+/,
                    drm_alphaNumeric: /\w+/,
                    drm_integer: /-?\d+/
                },

// The prefix to use for dynamically-created class names.
                classPrefix: '',

                errorClass: error_class, // No prefix for these.
                validClass: valid_class, // "
                activeClass: active_class, // Prefix will get prepended.
                requiredClass: 'required',
                requiredAttribute: 'required',
                patternAttribute: 'pattern',

// Attribute which stores the ID of the error container element (without the hash).
                errorAttribute: 'data-error-text',

// Events API
                customEvents: {
                    'validate': true
                },

// Setup KB event delegation.
                kbSelectors: ':input:not(:button):not(:disabled):not(.novalidate)',
                focusout: true,
                focusin: false,
                change: true,
                keyup: false,
                activeKeyup: true,

// Setup mouse event delegation.
                mSelectors: '[type="range"]:not(:disabled):not(.novalidate), :radio:not(:disabled):not(.novalidate), :checkbox:not(:disabled):not(.novalidate), select:not(:disabled):not(.novalidate), option:not(:disabled):not(.novalidate)',
                click: true,

// What do we name the required .data variable?
                requiredVar: 'h5-required',

// What do we name the pattern .data variable?
                patternVar: 'h5-pattern',
                stripMarkup: true,

// Validate on submit?
// **TODO: This isn't implemented, yet.
                submit: true,

// Callback stubs
                invalidCallback: function () {},
                validCallback: function () {},

// When submitting, validate elements that haven't been validated yet?
                validateOnSubmit: true,

// Elements to validate with allValid (only validating visible elements)
                allValidSelectors: ':input:visible:not(:button):not(:disabled):not(.novalidate)',

// Mark field invalid.
// ** TODO: Highlight labels
// ** TODO: Implement setCustomValidity as per the spec:
// http://www.whatwg.org/specs/web-apps/current-work/multipage/association-of-controls-and-forms.html#dom-cva-setcustomvalidity
                markInvalid: function markInvalid(options) {
                    var $element = $(options.element),
                        $errorID = $(options.errorID);
                    $element.addClass(options.errorClass).removeClass(options.validClass);
                    $element.after(function(){
						var drmError = $(this).attr('name');
                        if(!$('div[id^='+drmError+']').hasClass('drm-error_text')) {
                            $element.after('<div class="drm-error_text" id="'+ $element.attr('name') +'">i</div>');
							if (window.PIE && $.browser.msie) {
								$('div.drm-error_text').each(function() {
									PIE.attach(this);
								});
							}
                        }
                    });

// User needs help. Enable active validation.
                    $element.addClass(options.settings.activeClass);

                    if ($errorID.length) { // These ifs are technically not needed, but improve server-side performance
                        if ($element.attr('title')) {
                            $errorID.text($element.attr('title'));
                        }
                        $errorID.show();
                    }
                    $element.data('valid', false);
                    options.settings.invalidCallback.call(options.element, options.validity);
                    return $element;
                },

// Mark field valid.
                markValid: function markValid(options) {
                    var $element = $(options.element),
                        $errorID = $(options.errorID);
                    $element.addClass(options.validClass).removeClass(options.errorClass);

                    if ($errorID.length) {
                        $errorID.hide();
                    }
                    $element.data('valid', true);
                    options.settings.validCallback.call(options.element, options.validity);
                    return $element;
                },

// Unmark field
                unmark: function unmark(options) {
                    var $element = $(options.element);
                    var drmError = $element.form.find("#" + options.element.id);
                    $element.removeClass(options.errorClass).removeClass(options.validClass);
					if ($.browser.msie) {
						$('.drm-error_text').hide();
					}
					drmError.removeClass(options.errorClass);
					drmError.removeClass(options.validClass);
                    return $element;
                }
            }
        },

// Aliases
        defaults = h5.defaults,
        patternLibrary = defaults.patternLibrary,

        createValidity = function createValidity(validity) {
            return $.extend({
                customError: validity.customError || false,
                patternMismatch: validity.patternMismatch || false,
                rangeOverflow: validity.rangeOverflow || false,
                rangeUnderflow: validity.rangeUnderflow || false,
                stepMismatch: validity.stepMismatch || false,
                tooLong: validity.tooLong || false,
                typeMismatch: validity.typeMismatch || false,
                valid: validity.valid || true,
                valueMissing: validity.valueMissing || false
            }, validity);
        },

        methods = {
            /**
             * Check the validity of the current field
             * @param {object} settings instance settings
             * @param {object} options
             * .revalidate - trigger validation function first?
             * @return {Boolean}
             */
            isValid: function (settings, options) {
                var $this = $(this);

                options = (settings && options) || {};

// Revalidate defaults to true
                if (options.revalidate !== false) {
                    $this.trigger('validate');
                }

                return $this.data('valid'); // get the validation result
            },
            allValid: function (config, options) {
                var valid = true,
                    formValidity = [],
                    $this = $(this),
                    getValidity = function getValidity(e, data) {
                        data.e = e;
                        formValidity.push(data);
                    },
                    settings = $.extend({}, config, options); // allow options to override settings

                options = options || {};

// Make sure we're not triggering handlers more than we need to.
                $this.undelegate(settings.allValidSelectors,
                    '.allValid', getValidity);
                $this.delegate(settings.allValidSelectors,
                    'validated.allValid', getValidity);

                $this.find(settings.allValidSelectors).each(function () {
                    var $this = $(this);
                    valid = $this.h5Validate('isValid', options) && valid;
                });

                $this.trigger('formValidated', {valid: valid, elements: formValidity});
                return valid;
            },
            validate: function (settings) {
// Get the HTML5 pattern attribute if it exists.
// ** TODO: If a pattern class exists, grab the pattern from the patternLibrary, but the pattern attrib should override that value.
                var $this = $(this),
                    pattern,
                    re,
                    value,
                    errorClass,
                    validClass,
                    errorIDbare,
                    errorID,
                    required,
                    validity,
                    $checkRequired;

                pattern = $this.filter('[pattern]')[0] ? $this.attr('pattern') : false,

// The pattern attribute must match the whole value, not just a subset:
// "...as if it implied a ^(?: at the start of the pattern and a )$ at the end."
                    re = new RegExp('^(?:' + pattern + ')$'),
                    value = ($this.is('[type=checkbox]')) ?
                        $this.is(':checked') : (($this.is('[type=radio]')) ?
                        $(settings.el)
                            .find('input[name=' + $this.attr('name') + ']:checked')
                            .length > 0 : $this.val()),
                    errorClass = settings.errorClass,
                    validClass = settings.validClass,
                    errorIDbare = $this.attr(settings.errorAttribute) || false, // Get the ID of the error element.
                    errorID = errorIDbare ? '#' + errorIDbare.replace(/(:|\.|\[|\])/g,'\\$1') : false, // Add the hash for convenience. This is done in two steps to avoid two attribute lookups.
                    required = false,
                    validity = createValidity({element: this, valid: true}),
                    $checkRequired = $('<input required>');

                /* If the required attribute exists, set it required to true, unless it's set 'false'.
                 * This is a minor deviation from the spec, but it seems some browsers have falsey
                 * required values if the attribute is empty (should be true). The more conformant
                 * version of this failed sanity checking in the browser environment.
                 * This plugin is meant to be practical, not ideologically married to the spec.
                 */
// Feature fork
                if ($checkRequired.filter('[required]') && $checkRequired.filter('[required]').length) {
                    required = ($this.filter('[required]').length && $this.attr('required') !== 'false');
                } else {
                    required = ($this.attr('required') !== undefined);
                }

                if (settings.debug && window.console) {
                    console.log('Validate called on "' + value + '" with regex "' + re + '". Required: ' + required); // **DEBUG
                    console.log('Regex test: ' + re.test(value) + ', Pattern: ' + pattern); // **DEBUG
                }

                if (required && !value) {
                    validity.valid = false;
                    validity.valueMissing = true;
                } else if (pattern && !re.test(value) && value) {
                    validity.valid = false;
                    validity.patternMismatch = true;
                } else {
                    validity.valid = true; // redundant?

                    if (!settings.RODom) {
                        settings.markValid({
                            element: this,
                            validity: validity,
                            errorClass: errorClass,
                            validClass: validClass,
                            errorID: errorID,
                            settings: settings
                        });
                    }
                }

                if (!validity.valid) {
                    if (!settings.RODom) {
                        settings.markInvalid({
                            element: this,
                            validity: validity,
                            errorClass: errorClass,
                            validClass: validClass,
                            errorID: errorID,
                            settings: settings
                        });
                    }
                }
                $this.trigger('validated', validity);
            },

            /**
             * Take the event preferences and delegate the events to selected
             * objects.
             *
             * @param {object} eventFlags The object containing event flags.
             *
             * @returns {element} The passed element (for method chaining).
             */
            delegateEvents: function (selectors, eventFlags, element, settings) {
                var events = {},
                    key = 0,
                    validate = function () {
                        settings.validate.call(this, settings);
                    };
                $.each(eventFlags, function (key, value) {
                    if (value) {
                        events[key] = key;
                    }
                });
// key = 0;
                for (key in events) {
                    if (events.hasOwnProperty(key)) {
                        $(element).delegate(selectors, events[key] + '.h5Validate', validate);
                    }
                }
                return element;
            },
            /**
             * Prepare for event delegation.
             *
             * @param {object} settings The full plugin state, including
             * options.
             *
             * @returns {object} jQuery object for chaining.
             */
            bindDelegation: function (settings) {
                var $this = $(this);
// Attach patterns from the library to elements.
// **TODO: pattern / validation method matching should
// take place inside the validate action.
                $.each(patternLibrary, function (key, value) {
                    var pattern = value.toString();
                    var max = $('.' + settings.classPrefix + key).attr('maxlength');
                    var min = $('.' + settings.classPrefix + key).attr('data-min');

                    if(key == 'drm_login' || key == 'drm_password' || key == 'drm_text' || key == 'drm_num') {
                        if(max >= 1000 || max == null) {
                            max = '+';
                        } else {
                            max = '{'+ (min==undefined ? '0' : min) +',' + max + '}';
                        };
                        pattern = pattern.substring(1, pattern.length - 1) + max;
                    } else {
                        pattern = pattern.substring(1, pattern.length - 1);
                    }

                    $('.' + settings.classPrefix + key).attr('pattern', pattern);
                });

                $this.filter('form').attr('novalidate', 'novalidate');
                $this.find('form').attr('novalidate', 'novalidate');
                $this.parents('form').attr('novalidate', 'novalidate');

                return this.each(function () {
                    var kbEvents = {
                            focusout: settings.focusout,
                            focusin: settings.focusin,
                            change: settings.change,
                            keyup: settings.keyup
                        },
                        mEvents = {
                            click: settings.click
                        },
                        activeEvents = {
                            keyup: settings.activeKeyup
                        };

                    settings.delegateEvents(':input', settings.customEvents, this, settings);
                    settings.delegateEvents(settings.kbSelectors, kbEvents, this, settings);
                    settings.delegateEvents(settings.mSelectors, mEvents, this, settings);
                    settings.delegateEvents(settings.activeClassSelector, activeEvents, this, settings);
                });
            }
        },

        instances = [],

        buildSettings = function buildSettings(options) {
// Combine defaults and options to get current settings.
            var settings = $.extend({}, defaults, options, methods),
                activeClass = settings.classPrefix + settings.activeClass;

            return $.extend(settings, {
                activeClass: activeClass,
                activeClassSelector: '.' + activeClass,
                requiredClass: settings.classPrefix + settings.requiredClass,
                el: this
            });
        },

        getInstance = function getInstance() {
            var $parent = $(this).closest('[data-h5-instanceId]');
            return instances[$parent.attr('data-h5-instanceId')];
        },

        setInstance = function setInstance(settings) {
            var instanceId = instances.push(settings) - 1;
            if (settings.RODom !== true) {
                $(this).attr('data-h5-instanceId', instanceId);
            }
            $(this).trigger('instance', { 'data-h5-instanceId': instanceId });
        };

    $.h5Validate = {
        /**
         * Take a map of pattern names and HTML5-compatible regular
         * expressions, and add them to the patternLibrary. Patterns in
         * the library are automatically assigned to HTML element pattern
         * attributes for validation.
         *
         * @param {Object} patterns A map of pattern names and HTML5 compatible
         * regular expressions.
         *
         * @returns {Object} patternLibrary The modified pattern library
         */
        addPatterns: function (patterns) {
            var patternLibrary = defaults.patternLibrary,
                key;
            for (key in patterns) {
                if (patterns.hasOwnProperty(key)) {
                    patternLibrary[key] = patterns[key];
                }
            }
            return patternLibrary;
        },
        /**
         * Take a valid jQuery selector, and a list of valid values to
         * validate against.
         * If the user input isn't in the list, validation fails.
         *
         * @param {String} selector Any valid jQuery selector.
         *
         * @param {Array} values A list of valid values to validate selected
         * fields against.
         */
        validValues: function (selector, values) {
            var i = 0,
                ln = values.length,
                pattern = '',
                re;
// Build regex pattern
            for (i = 0; i < ln; i += 1) {
                pattern = pattern ? pattern + '|' + values[i] : values[i];
            }
            re = new RegExp('^(?:' + pattern + ')$');
            $(selector).data('regex', re);
        }
    };

    $.fn.h5Validate = function h5Validate(options) {
        var	action,
            args,
            settings;

        if (typeof options === 'string' && typeof methods[options] === 'function') {
// Whoah, hold on there! First we need to get the instance:
            settings = getInstance.call(this);

            args = [].slice.call(arguments, 0);
            action = options;
            args.shift();
            args = $.merge([settings], args);

// Use settings here so we can plug methods into the instance dynamically?
            return settings[action].apply(this, args);
        }

        settings = buildSettings.call(this, options);
        setInstance.call(this, settings);

// Returning the jQuery object allows for method chaining.
        return methods.bindDelegation.call(this, settings);
    };
}(jQuery));

$('input[type=text], input[type=password]').live('click', function(){
    var name = '#' + $(this).attr('name');
    $(name).remove();
});

$('div.drm-error_text').live('mouseover', function(){
    var name = $(this).attr('id');
    var error = '';
    var get_charset = Number($('input[name='+ name +']').val().length);
	
    if($('input[name='+ name +']').attr('data-min')==undefined) {
        var min_charset = 0;
    } else {
        var min_charset = Number($('input[name='+ name +']').attr('data-min').length)+1;
    };

    if($('input[name='+ name +']').attr('maxlength')==undefined) {
        var max_charset = 100000;
    } else {
        var max_charset = Number($('input[name='+ name +']').attr('maxlength').length)+1;
    };

    if($('input[name='+ name +']').hasClass('drm_text')) {
        error = 'Please enter a valid text.';
    };

    if($('input[name='+ name +']').hasClass('drm_num')) {
        error = 'Please enter only digits.';
    };

    if($('input[name='+ name +']').hasClass('drm_phone')) {
        error = 'Please enter a valid phone number.';
    };

    if($('input[name='+ name +']').hasClass('drm_email')) {
        error = 'Please enter a valid email address.';
    };

    if($('input[name='+ name +']').hasClass('drm_url')) {
        error = 'Please enter a valid URL.';
    };

    if($('input[name='+ name +']').hasClass('drm_dateYYYYmmdd')) {
        error = 'Please enter a valid date. (YYYYmmdd)';
    };

    if($('input[name='+ name +']').hasClass('drm_datemmddYYYY')) {
        error = 'Please enter a valid date. (mmddYYYY)';
    };

    if($('input[name='+ name +']').hasClass('drm_login') || $('input[name='+ name +']').hasClass('drm_password')) {
        error = "This field must be only alphabetic symbols";
    };
	
	if(get_charset < min_charset) {
        error = 'Please enter at least ' + min_charset + ' characters';
    };

    if(get_charset > max_charset) {
        error = 'Please enter no more than ' + min_charset + ' characters.';
    };

    if(get_charset == 0 && $('input[name='+ name +']').attr('required')) {
        error = "This field is required";
    };
	

    $(this).after('<div class="tooltip">'+ error +'</div>');
	if (window.PIE && $.browser.msie) {
		$('div.tooltip').each(function() {
			PIE.attach(this);
		});
	}
});

$('div.drm-error_text').live('mouseout', function(){
	
	$('.tooltip').hide();
    $('.tooltip').detach();
});