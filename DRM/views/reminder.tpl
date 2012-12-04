<div id="reminder">
    ##message->[text={i18n::db_not_connected};class=db_not_connected;enabled=${db-message-enable}]##
    <div id="logo">
        <a href="{config::base_href}">{i18n::site_name}</a>
    </div>
	<form method="post" action="reminder">
	    <p>{i18n::email}: ##text->[name=email;validate=email;size=50]##</p>
	    <p>
			##submit->[name=submit;value={i18n::remind_pass}]##
			{i18n::or} <a href="login">{i18n::back_to_login}</a>
	    </p>
	</form>
</div>