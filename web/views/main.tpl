<!DOCTYPE html>
<html style="display: none">
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>{config::title}</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <script src="min/js/f=drm/e=0" type="text/javascript"></script>
</head>
<body>
    <div id="main">
        <div id="menu_wrapper">
            <div id="logo">
                <a href="{config::base_href}">
                    &#123;DRM&#125; <span> - make development easiest</span>
                </a>
            </div>
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
                <li><a href="/ui/fancybox">Fancybox</a></li>
                <li><a href="/ui/kcaptcha">Kcaptcha</a></li>
                <li><a href="/ui/validate">Validate</a></li>
            </ul>
        </div>
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