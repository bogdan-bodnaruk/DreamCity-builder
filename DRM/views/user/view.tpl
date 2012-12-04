<div class="profile" style="width: 600px">
    <div class="name">
        <div class="title_name">{i18n::personal_info}</div>
        <div class="odd">{i18n::login}:</div>
        <div class="even">{data::login}</div>
        <div class="odd">{i18n::name}:</div>
        <div class="even">##test->[if="${data::name}"=="";then=-------;else={data::name}]##</div>
        <div class="odd">{i18n::surname}:</div>
        <div class="even">##test->[if="${data::surname}"=="";then=-------;else={data::surname}]##</div>
        <div class="odd">{i18n::email}:</div>
        <div class="even">{data::email}</div>
        <div class="odd">{i18n::Status}:</div>
        <div class="even">{data::status}</div>
        <div class="odd">{i18n::last_login}:</div>
        <div class="even">##test->[if="${data::last_login}"=="";then=-------;else={data::last_login}]##</div>
    </div>
</div>