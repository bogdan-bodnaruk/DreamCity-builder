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

/*
DRM.ieLocker = function() {
    var path = DRM.libraryPath+'/DRM/drmJQuery/images/';
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
}*/
