<p class="h2_title">{i18n::edit_profile}</p>
<form action="profile/save/" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>{i18n::login}:</td>
            <td>
                <p><b>{data::login}</b></p>
            </td>
        </tr>
        <tr>
            <td>{i18n::email}:</td>
            <td>
                <p>##text->[name=email^validate=email^value={data::email}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::password}:</td>
            <td>
                <p>##password->[name=old_password^min=5^max=120^required=false^style=border:1px solid #73ACB4]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::new_password}:</td>
            <td>
                <p>##password->[name=password^min=5^max=120^required=false^style=border:1px solid #73ACB4]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::re_password}:</td>
            <td>
                <p>##password->[name=re_password^min=5^max=120^validate=re_password^required=false^style=border:1px solid #73ACB4]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::name}:</td>
            <td>
                <p>##text->[name=name^value={data::name}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::se_name}:</td>
            <td>
                <p>##text->[name=se_name^required=false^value={data::sename}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::country}:</td>
            <td>
                <p>##select->[name=country^selected={data::country}^value={country_val}^text={country_text}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::city}:</td>
            <td>
                <p>##text->[name=city^required=false^value={data::city}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::your_phone}:</td>
            <td>
                <p>##text->[name=phone^required=false^value={data::phone}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>
                    ##submit->[value={i18n::save}]##
                </div>
            </td>
        </tr>
    </table>
</form>