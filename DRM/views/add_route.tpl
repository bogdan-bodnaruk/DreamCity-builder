<a href="menu/info/id={id}" style="margin: 0 0 -50px 20px;position: absolute;"><img src="./{config::app_path}/theme/images/icons/left.png" alt="Back" /></a>
<p class="h2_title">{i18n::add_route}</p>
<form action="menu/add_route/id={id}" method="post">
    <table cellpadding="0" cellspacing="0" border="0" class="data_table">
        <tr>
            <td>{i18n::name}:</td>
            <td>
                <p>##text->[name=name]##</p>
            </td>
        </tr>
        <tr>
            <td>Url:</td>
            <td>
                <p>##text->[name=route]##</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <div>##submit->[value={i18n::save}]##</div>
            </td>
        </tr>
    </table>
</form>