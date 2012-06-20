<tr>
    <td style="width: 123px !important;padding-top: 30px;">
        <a href="menu/up_route/id={::id}/list={id}/"><img src="./{config::app_path}/theme/images/icons/up.png" width="30" alt="up" /></a>
        <img src="./{config::app_path}/theme/images/icons/cancel.png" width="30" alt="delete" onclick="if(confirm('{i18n::confirm_delete}')){parent.location='menu/delete_route/id={::id}/list={id}/';}" />
        <a href="menu/down_route/id={::id}/list={id}/"><img src="./{config::app_path}/theme/images/icons/down.png" width="30" alt="down" /></a>
    </td>
    <td style="width: 170px !important;text-align: right;padding-right: 10px;color: grey;">
        <p>{i18n::name}:</p>
        <p style="margin-top: 20px;">Url:</p>
    </td>
    <td style="width: 370px !important;padding-left: 10px;">
        <form action="menu/edit_route/id={::id}/list={id}/" name="{::id}" method="post">
            <p>##text->[name=name^value={::name}]##</p>
            <p>
                <div style="float: left;">##text->[name=route^value={::route}^style=width: 250px^validate=url]##</div>
                <div style="float: right;padding-right: 37px;margin-bottom: 5px;">##submit->[value={i18n::save}]##</div>
            </p>
        </form>
    </td>
</tr>