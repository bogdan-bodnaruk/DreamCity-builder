<tr style="vertical-align: top; line-height: 100%;">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td width="50">
                <p style="margin-top: -9px;">{i18n::name}, {i18n::sename}:</p>
            </td>
            <td width="150" style="font-size: 11px;font-weight: bold;">
                <p>{::name} {::sename}</p>
            </td>
            <td width="150" style="font-size: 12px;text-align: right;padding-right: 5px;">
                <p>{i18n::address}:</p>
            </td>
            <td width="260" style="font-size: 11px;font-weight: bold;">
                <p>{::country}, {::city}</p>
            </td>
            <td width="63" style="padding-top: 10px;">
                <img src="./{config::app_path}/theme/images/icons/cancel.png" alt="delete" onclick="if(confirm('{i18n::confirm_delete}')){parent.location='delete/user/id={::id}';}" />
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-top: -9px;">{i18n::login}:</p>
            </td>
            <td style="font-size: 11px;font-weight: bold;">
                <p>{::login}</p>
            </td>
            <td style="font-size: 12px;text-align: right;padding-right: 5px;">
                <p>{i18n::phone}:</p>
            </td>
            <td style="font-size: 11px;font-weight: bold;">
                <p>{::phone}</p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p style="margin-top: -9px;">{i18n::email}:</p>
            </td>
            <td style="font-size: 11px;font-weight: bold;">
                <p>{::email}</p>
            </td>
            <td style="font-size: 12px;text-align: right;padding-right: 5px;">
                <p>{i18n::last_login}:</p>
            </td>
            <td style="font-size: 11px;font-weight: bold;">
                <p>{::last_login}</p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p style="margin-top: -9px;">{i18n::status}:</p>
            </td>
            <td style="font-size: 11px;">
                <p>
                    <form action="users/permissions/id={::id}/" method="post">
                        <p style="margin-top: -3px;"><b>{::status}</b></p>
                        ##permissions->[name=protect^selected=0^js=onchange:this.form.submit()]##
                    </form>
                </p>
            </td>
            <td style="font-size: 12px;text-align: right;padding-right: 5px;">
                <p>{i18n::date_register}:</p>
            </td>
            <td style="font-size: 11px;font-weight: bold;">
                <p>{::date_register}</p>
            </td>
            <td></td>
        </tr>
    </table>
</tr>