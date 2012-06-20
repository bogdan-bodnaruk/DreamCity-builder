<p class="h2_title">{i18n::add_page}</p>
<form action="add/page/" method="post">
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
                {i18n::append_menu}:
            </td>
            <td>
                <p>##select->[name=menu^value={id}^text={name}]##</p>
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
                {i18n::coment}
            </td>
            <td>
                <p>##radio->[name=comment^checked=Yes^value={comment}^text={comment}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##ckeditor->[name=text^id=text^type=admin^validate=none^required=false]##</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[name=submit^value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>