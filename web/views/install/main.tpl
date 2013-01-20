<!DOCTYPE html>
<html style="display: none;">
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>DRM Installer</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <script src="min/type=js/f=drm/e=0" type="text/javascript"></script>
</head>
<body>
<div id="main">
    <div id="menu_wrapper">
        <div id="logo">
            <a href="{config::base_href}">
                &#123;DRM&#125; <span> - make development easiest</span>
            </a>
        </div>
    </div>
    <div id="content">
        {content}
    </div>
    <div id="footer">{config::copyright}</div>
</div>
</body>
</html>