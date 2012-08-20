<!DOCTYPE html>
<html>
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>{config::title}</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <script src="{config::library_path}/modernizr.js" type="text/javascript"></script>
    <script src="{config::library_path}/common.js" type="text/javascript"></script>
</head>
<body>
    <div id="main">
        <div id="header">
            UI builder
        </div>
        <div id="content">
            <div id="menu">
                <p><a href="/ui/">Values</a></p
                <p><a href="/ui/textfields">Text fields</a></p>
                <p><a href="/ui/textarea">Text area</a></p>
                <p><a href="/ui/submit_and_button">Submit, button</a></p>
                <p><a href="/ui/ckeditor">Ckeditor</a></p>
                <p><a href="/ui/select">Select</a></p>
                <p><a href="/ui/radio">Radio</a></p>
                <p><a href="/ui/checkbox">Checkbox</a></p>
                <p><a href="/ui/specials">Specials</a></p>
                <p><a href="/ui/fancybox_galery">Fancybox galery</a></p>
            </div>
            {content}
        </div>
        <div id="footer">&nbsp;</div>
    </div>
</body>
</html>