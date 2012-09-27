<div id="forgot">
	<div id="logo">
	    <a href="{config::base_href}">
	    {DRM} <span> - make development easiest</span>
	    </a>
	</div>
	<form method="post" action="login/forgotpass">
	    <p>Email: ##text->[name=test6;validate=email]##</p>
	    <p>Name: ##text->[name=login;validate=login;min=4;max=70;]## </p>
	    <p>
			##submit->[name=submit;value=sendpass]## 
			or <a href="login">back to login page</a>
	    </p>
	</form>
</div>
