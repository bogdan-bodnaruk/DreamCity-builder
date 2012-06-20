<p class="h2_title">{i18n::menu_list}</p>
<table cellpadding="0" cellspacing="0" border="0" class="data_table">
    <thead>
        <tr>
            <td style="width: 75px !important;"><a href="menu/add/"><img src="./{config::app_path}/theme/images/icons/add.png" alt="add" /></a></td>
            <td style="width: 300px !important;">{i18n::name}</td>
            <td style="width: 70px !important;">{i18n::protect}</td>
            <td style="width: 70px !important;">{i18n::lang}</td>
            <td style="width: 70px !important;">{i18n::type}</td>
        </tr>
    </thead>
    <tbody>
        {table}
    </tbody>
</table>
<br />
{paginator_buttons}