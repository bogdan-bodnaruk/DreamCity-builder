<p class="h2_title">{i18n::user_login}</p>
<form action="login/enter" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>{i18n::login}</td>
            <td>
                <p>##text->[name=login^valide=login]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::password}</td>
            <td>
                <p>##password->[name=password]##</p>
                {user_error}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[value=enter]##</div>
            </td>
        </tr>
    </table>
</form>