(function ($) {
    $.confirm = function (params) {
        var buttonHTML = '';
        $.each(params.buttons, function (name, obj, href) {
            buttonHTML += '<a href="' + obj['href'] + '" class="button ' + obj['class'] + '">' + name + '</a>';
        });

        var markup = [
            '<div id="confirmOverlay">',
            '<div id="confirmBox">',
            '<h1>', message.confirm, '</h1>',
            '<p>', message.confirm_message, '</p>',
            '<div id="confirmButtons">',
            buttonHTML,
            '</div></div></div>'
        ].join('');

        $(markup).appendTo('body').show();

        $('.confirm-no').live('click', function(){
            $('#confirmOverlay').remove();
            return false;
        });

        $('a.button.click-submit').live('click', function(){
            $('a.submit.confirm').closest('form').submit();
            return false;
        });
    }
})(jQuery);