<div id="login_wrapper">
    {db-not-connected-message}
	<div id="logo">
	    <a href="{config::base_href}">
            &#123;DRM&#125; <span> - make development easiest</span>
	    </a>
	</div>
	<form method="post" action="login">
	    <p>Login: ##text->[name=login;validate=login;min=4;max=70;]##{error}</p>
	    <p>Password: ##password->[name=password;min=4;max=70;]##</p>
	    <p>
			##submit->[name=submit;value=login]## 
			or <a href="login/forgotpass">forgot password</a>
	    </p>
	</form>
</div>
