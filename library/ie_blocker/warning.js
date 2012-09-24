(function(){
    var browsers = [
        {
            name : "Firefox",
            icon : library_path + "/ie_blocker/ff.png",
            link : "http://www.mozilla.com/firefox/"
        },
        {
            name : "Chrome",
            icon : library_path + "/ie_blocker/ch.png",
            link : "http://www.google.com/chrome/"
        },
        {
            name : "Opera",
            icon : library_path + "/ie_blocker/op.png",
            link : "http://www.opera.com/download/"
        },
        {
            name : "Internet Explorer 8+",
            icon : library_path + "/ie_blocker/ie.png",
            link : "http://windows.microsoft.com/en-US/internet-explorer/downloads/ie"
        }];
    var markup = "<div style='margin: 10% 20%;'><h1 style='color:white;font-size: 18px;'>" + message.ie_out_of_date + "</h1>"
                  + "<p style='color:white;margin-top: 20px;'>" + message.ie_recomendations + "</p>"
                  + "<p style='color:white;'>" + message.ie_other_browsers + "</p>"
                  + "<div style='text-align: center;margin-top: 20px;'>";

    for (var i=0;i<browsers.length;i++) {
        markup += "<a href='" + browsers[i].link + "' title='" + browsers[i].name + "'><img src='" + browsers[i].icon + "' /></a>";
    }
    markup += '</div></div>';

    var div = document.createElement("div");
    div.setAttribute("id", "old-browser-warning");
    //Ouch... setAttribute("style", ...) does not work in IE < 8
    div.style.top = div.style.left = div.style.margin = div.style.right = div.style.bottom = "0";
    div.style.backgroundImage = "url('"+ library_path +"/ie_blocker/opacity80.png')";
    div.style.position = "fixed";
    div.style.overflow = "auto";
    div.style.zIndex = "2147483647";

    if (/MSIE 6/i.test(navigator.userAgent)) { //Ouch... fixed position does not work in IE < 7
        div.style.position = "absolute";
        div.style.width = "100%";
        function max(a,b) { return a > b ? a : b; }
        div.style.height = max(document.body.scrollHeight, document.body.clientHeight) + "px";
    }

    div.innerHTML = markup;
    document.body.appendChild(div);
})();