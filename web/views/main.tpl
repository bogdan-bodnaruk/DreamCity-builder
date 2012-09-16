<!DOCTYPE html>
<html>
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>{config::title}</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <script type="text/javascript">
        var client_css = '{config::client_css}';
        var library_path = '{config::library_path}';
        var env = '{config::env}';
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
    <script src="{config::library}/modernizr.js" type="text/javascript"></script>
    <script src="{config::library}/common.js" type="text/javascript" defer="defer"></script>
</head>
<body>
    <div id="main">
        <ul id="menu">
            <li><a href="/ui/">Values</a></li>
            <li><a href="/ui/textfields">Text fields</a></li>
            <li><a href="/ui/textarea">Text area</a></li>
            <li><a href="/ui/submit_and_button">Submit, button</a></li>
            <li><a href="/ui/ckeditor">Ckeditor</a></li>
            <li><a href="/ui/select">Select</a></li>
            <li><a href="/ui/radio">Radio</a></li>
            <li><a href="/ui/checkbox">Checkbox</a></li>
            <li><a href="/ui/specials">Specials</a></li>
            <li><a href="/ui/fancybox">Fancybox galery</a></li>
            <li><a href="/ui/kcaptcha">Kcaptcha</a></li>
        </ul>
        <div id="header">
            UI builder {config::generator_version}
        </div>
        <div id="content">
            {content}
        </div>
        <div id="footer">{config::copyright}</div>
    </div>
</body>
</html>