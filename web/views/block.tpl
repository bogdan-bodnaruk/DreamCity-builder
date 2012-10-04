<!DOCTYPE html>
<html>
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>Site currently blocked</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <link rel="shortcut icon" href="{config::app_path}/theme/images/warning.png" />
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
    <div id="login_wrapper">
        <div id="logo">
            <a href="{config::base_href}">
                &#123;DRM&#125; <span> - make development easiest</span>
            </a>
        </div>
        <form method="post" action="login">
            <p>Login: ##text->[name=login;validate=login;min=4;max=70;]##</p>
            <p>Password: ##password->[name=password;min=4;max=70;]##</p>
            <p>##submit->[name=submit;value=login]##</p>
        </form>
    </div>
    <div id="footer">{config::copyright}</div>
</div>
</body>
</html>