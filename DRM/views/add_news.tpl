<p class="h2_title">{i18n::add_news}</p>
<form action="add/news/" method="post">
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
                {i18n::coment}
            </td>
            <td>
                <p>##radio->[name=comment^checked=Yes^value={comment}^text={comment}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 10px;">
                {i18n::short_text}:
                <div>##ckeditor->[name=short_text^id=short_text^type=admin^validate=none^required=false]##</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 10px;">
                {i18n::full_text}:
                <div>##ckeditor->[name=full_text^id=full_text^type=admin^validate=none^required=false]##</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[name=submit^value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>