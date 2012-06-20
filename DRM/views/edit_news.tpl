<p class="h2_title">{i18n::edit_news}</p>
<form action="edit/news/id={data::id}/" method="post">
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
                {i18n::coment}
            </td>
            <td>
                <p>##radio->[name=comment^checked={data::comment}^value={comment}^text={comment}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 10px;">
                {i18n::short_text}:
                <div style="text-align: center;">
                    <img src="/{config::app_path}/theme/images/loading.gif" alt="loading..." id="loading" />
                    <textarea name="text" id="text" style="display: none;">{data::short_text}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 10px;">
                {i18n::full_text}:
                <div style="text-align: center;">
                    <img src="/{config::app_path}/theme/images/loading.gif" alt="loading..." id="loading_full" />
                    <textarea name="full_text" id="full_text" style="display: none;">{data::full_text}</textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[name=submit^value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    if(CKEDITOR.instances["text"]) {delete CKEDITOR.instances["text"] };
    CKEDITOR.replace("text",{toolbar : "admin"});
    $("#loading").detach();
    
    if(CKEDITOR.instances["full_text"]) {delete CKEDITOR.instances["full_text"] };
    $("#loading_full").detach();
    CKEDITOR.replace("full_text",{toolbar : "admin"});
</script>