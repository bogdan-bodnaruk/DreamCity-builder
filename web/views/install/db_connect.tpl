<div style="width: 300px;margin: 50px auto;text-align: right;">
    <div class="h2_title">DB connect settings</div>
    <form method="post" action="install/">
        <p>
            Host: ##text->[name=host;value={config::db_host};min=3;max=100]##
        </p>
        <p>
            Login: ##text->[name=login;value={config::db_user};min=3;max=100;validate=login]##
        </p>
        <p>
            Password: ##text->[name=password;value={config::db_password};min=3;max=100;validate=login]##
        </p>
        <p>
            ##submit->[name=submit;value=Try connect...]##
        </p>
    </form>
</div>