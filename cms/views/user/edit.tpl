<div class="button_menu ##test->[if="${session::status}"!=="Admin" && "${session::status}"!=="Moderator";then=detach]##" style="padding-top: 3px;position: absolute;">
    <a href="user" class="button select_admin_toggle add_comments">&#xe05c;</a>
</div>
<p class="h2_title">{i18n::edit_user}</p>
##message->[text={i18n::changes_saved};type=success;enabled=${saved}]##
<form action="user/edit/login={login}" method="post">
    <table class="data_table">
        <tr>
            <td>
                {i18n::login}
            </td>
            <td>
                <div class="status-round">{data::login}</div>
            </td>
        </tr>
        <tr>
            <td>
                {i18n::name}
            </td>
            <td>
                ##text->[name=name;value={data::name};min=3]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::surname}
            </td>
            <td>
                ##text->[name=surname;value={data::surname};min=3]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::email}
            </td>
            <td>
                ##text->[name=email;value={data::email};validate=email;min=6]##
            </td>
        </tr>
        <tr ##test->[if=("${session::status}"!=="Admin" && "${session::status}"!=="Moderator") || "${session::login}"=="${data::login}";then=class="detach"]##>
            <td>
                {i18n::Status}
            </td>
            <td>
                ##select->[name=status;selected=${data::status};text=$[Decan,Agent,Moderator,Admin];value=$[Decan,Agent,Moderator,Admin]]##
            </td>
        </tr>
        <tr class="univer">
            <td>
                {i18n::university}
            </td>
            <td>
                ##select->[name=university;text={i18n::university_text};value={i18n::university_val};selected=${data::university};id=university]##
                <div style="margin-top: 10px;display:none;" class="select-university">
                    ##text->[name=university_text;min=3;max=255;style=width:280px;required=false;selected=${data::university}]##
                </div>
            </td>
        </tr>
        ##include_tpl->[file=user/password.tpl]##
        <tr>
            <td colspan="2" style="text-align: center">
                ##submit->[name=submit;value={i18n::Save}]##
            </td>
        </tr>
    </table>
</form>
##include_tpl->[file=user/script.tpl]##