<!DOCTYPE html>
<html>
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>DRM Installer</title>
    <meta name="generator" content="{config::generator}" />
    <script type="text/javascript">
        var client_css = '{config::client_css}';
        var library_path = '{config::library_path}';
        var env = '{config::env}';
        var locale = '{config::current_locale}';
        var warning_class = '{config::warning_class}';
        var error_class = '{config::error_class}';
        var valid_class = '{config::valid_class}';
        var active_class = '{config::active_class}';
    </script>
    <link type="text/css" href="{config::css}/boilerplate.css" rel="stylesheet" />
    <link type="text/css" href="{config::css}/main.css" rel="stylesheet" />
    <link type="text/css" href="{config::css}/green.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
    <script src="{config::library}/modernizr.js" type="text/javascript"></script>
    <script src="{config::library}/common.js" type="text/javascript" defer="defer"></script>
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