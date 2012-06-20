<tr>
    <td style="width: 75px !important;">
        <a href="menu/info/id={::id}"><img src="./{config::app_path}/theme/images/icons/info.png" width="25" alt="info" /></a>
        <a href="menu/edit/id={::id}"><img src="./{config::app_path}/theme/images/icons/smart.png" width="25" alt="edit" /></a>
        <img src="./{config::app_path}/theme/images/icons/remove.png" width="25" alt="delete" onclick="if(confirm('{i18n::confirm_delete}')){parent.location='menu/delete/id={::id}';}" />
    </td>
    <td style="width: 300px !important;">{::name}</td>
    <td style="width: 70px !important;text-align: center;font-size: 12px;">{::protect}</td>
    <td style="width: 70px !important;text-align: center;font-size: 12px;">{::lang}</td>
    <td style="width: 70px !important;text-align: center;font-size: 12px;">{::type}</td>
</tr>