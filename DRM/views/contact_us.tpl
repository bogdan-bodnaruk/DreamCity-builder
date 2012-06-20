<p class="h2_title">{i18n::contact_us}</p>
<form action="contact_us" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>{i18n::name}:</td>
            <td>
                <p>##text->[name=name^value={data::name} {data::sename}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::email}:</td>
            <td>
                <p>##text->[name=email^validate=email^value={data::email}]##</p>
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
                <p>##text->[name=city^value={data::city}^required=false]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::your_phone}:</td>
            <td>
                <p>##text->[name=phone^required=false^value={data::phone}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::theme}:</td>
            <td>
                <p>##text->[name=theme]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::text}:</td>
            <td>
                <p>##textarea->[name=text^cols=60^rows=10^max=1000]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::enter_code}:</td>
            <td>
                <p>
                    <img style="border:1px solid #96A6C5;" src="{captcha}" />
                    <br />
                    ##text->[name=captcha^style=width:131px]##
                    {captcha_error}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[value={i18n::sent}]##</div>
            </td>
        </tr>
    </table>
</form>