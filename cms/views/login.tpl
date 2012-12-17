<div id="login_wrapper">
    ##message->[text={i18n::db_not_connected};class=db_not_connected;enabled=${db-message-enable}]##
	<div id="logo">
	    <a href="{config::base_href}">{i18n::site_name}</a>
	</div>
	<form method="post" action="login">
	    <p>
            {i18n::login}: ##text->[name=login;validate=login;min=4;max=70;]##
            ##message->[type=input;id=login;text={i18n::wrong_login};enabled=${login_error}]##
        </p>
	    <p>
            {i18n::password}: ##password->[name=password;min=4;max=70;]##
            ##message->[type=input;id=password;text={i18n::wrong_pass};enabled=${pass_error}]##
        </p>
	    <p>
			##submit->[name=submit;value=login]## 
			{i18n::or} <a href="recover">{i18n::forgot_pass}</a>
	    </p>
	</form>
</div>
