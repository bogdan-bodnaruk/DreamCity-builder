<div id="login_wrapper">
    ##message->[text={i18n::db_not_connected};class=db_not_connected;enabled=${db-message-enable}]##
	<div id="logo">
	    <a href="{config::base_href}">
            &#123;DRM&#125; <span> - make development easiest</span>
	    </a>
	</div>
	<form method="post" action="login">
	    <p>
            Login: ##text->[name=login;validate=login;min=4;max=70;]##
            ##message->[type=input;id=login;text={i18n::wrong_login};enabled=${login_error}]##
        </p>
	    <p>
            Password: ##password->[name=password;min=4;max=70;]##
            ##message->[type=input;id=password;text={i18n::wrong_pass};enabled=${pass_error}]##
        </p>
	    <p>
			##submit->[name=submit;value=login]## 
			or <a href="login/reminder">forgot password</a>
	    </p>
	</form>
</div>
