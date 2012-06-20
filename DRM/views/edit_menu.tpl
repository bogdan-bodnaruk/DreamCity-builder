<a href="menu/" style="margin: 0 0 -50px 20px;position: absolute;"><img src="./{config::app_path}/theme/images/icons/left.png" alt="Back" /></a>
<p class="h2_title">{i18n::edit_menu}</p>
<form action="menu/edit/id={data::id}" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>{i18n::name}</td>
            <td>
                <p>##text->[name=name^value={data::name}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::lang}</td>
            <td>
                <p>##lang->[name=lang^selected={data::lang}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::protect}</td>
            <td>
                <p>##permissions->[name=protect^selected={data::protect}]##</p>
            </td>
        </tr>
        <tr>
            <td>{i18n::type}</td>
            <td>
                <p>##select->[name=type^selected={data::type}^value={value}^text={text_type}]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>