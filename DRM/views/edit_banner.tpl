<p class="h2_title">{i18n::edit_banner}</p>
<form action="edit/banner/id={data::id}/" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>
                {i18n::lang}:
            </td>
            <td>
                <p>##lang->[name=lang^selected={data::lang}]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::theme}:
            </td>
            <td>
                <p>##text->[name=theme^value={data::theme}]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::protect}:
            </td>
            <td>
                <p>##permissions->[name=protect^selected={data::protect}]##</p>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::banner_side}
            </td>
            <td>
                <p>##radio->[name=side^checked={data::side}^value={side}^text={side}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##textarea->[name=code^validate=none^value={data::code}]##</div>
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