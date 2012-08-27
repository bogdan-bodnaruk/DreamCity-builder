var client_css = 'web/theme/css';
var library_path = 'library';

Modernizr.load([
    {
        load: [
                client_css + '/boilerplate.css',
                client_css + '/main.css',
                client_css + '/green.css'
        ]
    },
    {
        load: [
            library_path + '/chosen/chosen.css',
            library_path + '/chosen/chosen.min.js'
        ],
        complete: function() {
            $('select').chosen();
        }
    },
    {
        test: $.browser.mozilla,
        yep: client_css + '/mozilla_reset.css'
    },
    {
        load: library_path + '/prefixfree.min.js'
    },
    {
        test: Modernizr.input.required,
        nope: library_path + '/modernizr.input.required.js',
    }
]);


//test: Modernizr.input.required, nope: 'js/check_required.js', complete: function() { init(); }