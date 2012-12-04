<div class="button_menu" style="padding-top: 3px;position: absolute;">
    <a href="user" class="button select_admin_toggle add_comments">&#xe05c;</a>
</div>
<p class="h2_title">{i18n::add_new_user}</p>
<form action="user/add" method="post">
    <table class="data_table">
        <tr>
            <td>
                {i18n::login}
            </td>
            <td>
                ##text->[name=login;validate=login;min=5]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::password}
            </td>
            <td>
                ##text->[name=password;validate=login;min=5]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::name}
            </td>
            <td>
                ##text->[name=name;min=3]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::surname}
            </td>
            <td>
                ##text->[name=surname;min=3]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::email}
            </td>
            <td>
                ##text->[name=email;validate=email;min=6]##
            </td>
        </tr>
        <tr>
            <td>
                {i18n::Status}
            </td>
            <td>
                ##select->[name=status;text=$[Decan,Agent,Moderator,Admin];value=$[Decan,Agent,Moderator,Admin]]##
            </td>
        </tr>
        <tr class="univer">
            <td>
                {i18n::university}
            </td>
            <td>
                ##select->[name=university;text={i18n::university_text};value={i18n::university_val};id=university]##
                <div style="margin-top: 10px;display:none;" class="select-university">
                    ##text->[name=university_text;min=3;max=255;style=width:280px;required=false]##
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                ##submit->[name=submit;value={i18n::Save}]##
            </td>
        </tr>
    </table>
</form>
##include_tpl->[file=user/script.tpl]##