<p class="h2_title">{i18n::menu_info}</p>
<table cellpadding="0" cellspacing="0" border="0" class="data_table">
    <thead>
        <tr>
            <td style="width: 123px !important;">
                <a href="menu/"><img src="./{config::app_path}/theme/images/icons/left.png" alt="Back" /></a>
                <a href="menu/add_route/id={id}"><img src="./{config::app_path}/theme/images/icons/add.png" alt="add" /></a>
            </td>
            <td style="width: 170px !important;">{i18n::name}</td>
            <td style="width: 380px !important;">{i18n::value}</td>
        </tr>
    </thead>
    {table}
</table>
<br />
{paginator_buttons}