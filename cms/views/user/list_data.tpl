<tr>
    <td  style="width: 400px;">
        <a href="user/login={paginator::login}" class="fancybox-ajax">
            ##test->[if="${paginator::name}" == "" && "${paginator::surname}" == "";then={i18n::login}: {paginator::login};else={paginator::name} {paginator::surname}]##
        </a>
    </td>
    <td>
        <div class="status-round">{paginator::status}</div>
        <span class="confirm" style="margin-right: 15px;">
            <a class="drm-icon drm-icon-warning" href="#" onclick="return false;">&#xe12c;</a>
            <label class="confirm-text" style="display: none;">user/delete/login={paginator::login}</label>
        </span>
        <a href="user/edit/login={paginator::login}" class="qtip-tooltip">
            <span class="drm-icon">&#xe041;</span>
        </a>
    </td>
</tr>