<li class="onhover-dropdown tc-notifications-wrap">
    <a href="#" class="tc-header-icon-btn tc-notification-bell" aria-label="Notifications">
        <i data-feather="bell" aria-hidden="true"></i>
        <span id="tc-notification-badge" class="tc-notification-badge" style="display:none;">0</span>
    </a>
    <ul class="onhover-show-div notification-dropdown tc-header-dropdown" role="menu">
        <li class="tc-header-dropdown__head">
            <h5>Notifications</h5>
            <span id="tc-notification-summary">You have 0 unread notifications</span>
        </li>
        <li class="tc-header-dropdown__body">
            <ul id="tc-notification-list" class="list-unstyled mb-0 tc-notification-list">
                <li class="tc-notification-list__empty">Loading…</li>
            </ul>
        </li>
        <li class="tc-header-dropdown__foot">
            <a href="{{ route('tenant_notifications_index') }}">View all</a>
            <a href="#" id="tc-notification-mark-all">Mark all read</a>
        </li>
    </ul>
</li>
