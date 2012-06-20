<p class="h2_title">{i18n::add_banner}</p>
<form action="add/banner/" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>
                {i18n::lang}:
            </td>
            <td>
                <p>##lang->[name=lang]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::theme}:
            </td>
            <td>
                <p>##text->[name=theme]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::protect}:
            </td>
            <td>
                <p>##permissions->[name=protect]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::banner_side}
            </td>
            <td>
                <p>##radio->[name=side^checked=Right^value={side}^text={side}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##textarea->[name=code^placeholder={i18n::type_code}^validate=none^cols=80^rows=10]##</div>
                <div class="info">{i18n::type_code_info}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[name=submit^value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>