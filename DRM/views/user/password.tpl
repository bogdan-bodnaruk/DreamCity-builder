<tr ##test->[if="${session::login}"!=="${data::login}";then=class="detach"]##>
    <td>
        {i18n::password}:
    </td>
    <td>
        ##password->[name=password;validate=login;required=false;min=5;max=255]##
        ##message->[text={i18n::empty_password};type=input;enabled=${empty_password}]##
        ##message->[text={i18n::password_not_true};type=input;enabled=${password_not_true}]##
    </td>
</tr>
<tr ##test->[if="${session::login}"!=="${data::login}";then=class="detach"]##>
    <td>
        {i18n::new_password}:
    </td>
    <td>
        ##password->[name=new_password;validate=login;required=false;min=5;max=255]##
        ##message->[text={i18n::empty_new_password};type=input;enabled=${empty_new_password}]##
        ##message->[text={i18n::password_repeat};type=input;enabled=${password_repeat}]##
    </td>
</tr>
<tr ##test->[if="${session::login}"!=="${data::login}";then=class="detach"]##>
    <td>
        {i18n::re_new_password}:
    </td>
    <td>
        ##password->[name=re_new_password;validate=login;required=false;min=5;max=255]##
        ##message->[text={i18n::empty_renew_passw};type=input;enabled=${empty_renew_password}]##
    </td>
</tr>