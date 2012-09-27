<div id="login_wrapper">
	<div id="logo">
	    <a href="{config::base_href}">
	    {DRM} <span> - make development easiest</span>
	    </a>
	</div>
	<form method="post" action="login">
	    <p>Login: ##text->[name=login;validate=login;min=4;max=70;]##</p>
	    <p>Password: ##password->[name=password;min=4;max=70;]##</p>
	    <p>
			##submit->[name=submit;value=login]## 
			or <a href="login/forgotpass">forgot password</a>
	    </p>
	</form>
</div>
