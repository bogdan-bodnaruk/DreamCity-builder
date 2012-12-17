<div class="helper-buttons">
    <div class="button_menu">
        ##button->[value=&#xe084;class=select_admin_toggle]##
        <ul class="select_admin_toggle select_admin">
            <li ##test->[if="${cookie::onpage}"=="10";then=class="selected"]##>
                <a href="user/onpage=10">
                    {i18n::show_10_users}
                </a>
            </li>
            <li ##test->[if="${cookie::onpage}"=="20";then=class="selected"]##>
                <a href="user/onpage=20">
                    {i18n::show_20_users}
                </a>
            </li>
            <li ##test->[if="${cookie::onpage}"=="30";then=class="selected"]##>
                <a href="user/onpage=30">
                    {i18n::show_30_users}
                </a>
            </li>
            <li ##test->[if="${cookie::onpage}"=="50";then=class="selected"]##>
                <a href="user/onpage=50">
                    {i18n::show_50_users}
                </a>
            </li>
            <li ##test->[if="${cookie::onpage}"=="100";then=class="selected"]##>
                <a href="user/onpage=100">
                    {i18n::show_100_users}
                </a>
            </li>
            <li ##test->[if="${cookie::onpage}"=="${all}";then=class="selected"]##>
                <a href="user/onpage={all}">
                    {i18n::show_all_users}
                </a>
            </li>
        </ul>
    </div>
    <div class="button_menu">
        ##button->[value=&#xe110;class=select_admin_toggle]##
        <ul class="select_admin_toggle select_admin">
            <li ##test->[if="${cookie::direction}"=="asc";then=class="selected"]##>
                <a href="user/direction=ASC">
                    {i18n::direction} <b>{i18n::a-z}</b>
                </a>
            </li>
            <li ##test->[if="${cookie::direction}"=="desc" || "${cookie::direction}"=="";then=class="selected"]##>
                <a href="user/direction=DESC">
                    {i18n::direction} <b>{i18n::z-a}</b>
                </a>
            </li>
        </ul>
    </div>
    <div class="button_menu">
        ##button->[value=&#xe120;class=select_admin_toggle;style=padding-left:10px+padding-right:10px;]##
        <ul class="select_admin_toggle select_admin">
            <li ##test->[if="${cookie::order}"=="id";then=class="selected"]##>
                <a href="user/order=id">
                    {i18n::order_id}
                </a>
            </li>
            <li ##test->[if="${cookie::order}"=="name";then=class="selected"]##>
                <a href="user/order=name">
                    {i18n::order_name}
                </a>
            </li>
            <li ##test->[if="${cookie::order}"=="surname";then=class="selected"]##>
                <a href="user/order=surname">
                    {i18n::order_surname}
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="button_menu" style="padding-top: 3px;">
    <a href="user/add" class="button select_admin_toggle add_comments">&#xe108;</a>
</div>
<table class="data_table list">
    {data}
</table>
{paginator_buttons}