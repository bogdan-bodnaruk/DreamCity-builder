<div id="reminder">
    ##message->[text={i18n::db_not_connected};class=db_not_connected;enabled=${db-message-enable}]##
	<div id="logo">
	    <a href="{config::base_href}">
            &#123;DRM&#125; <span> - make development easiest</span>
	    </a>
	</div>
	<form method="post" action="login/reminder">
	    <p>
            Email: ##text->[name=test6;validate=email]##</p>
	    <p>Name: ##text->[name=login;validate=login;min=4;max=70;]## </p>
	    <p>
			##submit->[name=submit;value=Remind me password]##
			or <a href="login">back to login page</a>
	    </p>
	</form>
</div>
