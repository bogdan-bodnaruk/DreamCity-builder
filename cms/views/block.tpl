<!DOCTYPE html>
<html style="display: none;">
<head>
    <meta charset="{config::encoding}" />
    <base href="{config::base_href}" />
    <title>Site currently blocked</title>
    <meta name="Description" content="{config::description}" />
    <meta name="keywords" content="{config::keyword}" />
    <meta name="generator" content="{config::generator}" />
    <script src="min/type=js/f=drm/e=0" type="text/javascript"></script>
</head>
<body id="blocked">
<div class="gears">
    <div id="login_wrapper">
        <form method="post" action="login">
            <p>Login: ##text->[name=login;validate=login;min=4;max=70;]##</p>
            <p>Password: ##password->[name=password;min=4;max=70;]##</p>
            <p>##submit->[name=submit;value=login]##</p>
        </form>
    </div>
</div>
</body>
</html>