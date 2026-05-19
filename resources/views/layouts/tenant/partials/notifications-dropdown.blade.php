<li class="onhover-dropdown tc-notifications-wrap">
    <a href="#" class="text-dark" aria-label="Notifications">
        <i data-feather="bell"></i>
        <span id="tc-notification-badge" class="tc-notification-badge" style="display:none;">0</span>
    </a>
    <ul class="onhover-show-div notification-dropdown">
        <li class="gradient-primary">
            <h5 class="f-w-700">Notifications</h5>
            <span id="tc-notification-summary">You have 0 unread notifications</span>
        </li>
        <li>
            <ul id="tc-notification-list" class="list-unstyled mb-0">
                <li class="p-3 text-muted text-center">Loading…</li>
            </ul>
        </li>
        <li class="bg-light txt-dark">
            <a href="{{ route('tenant_notifications_index') }}">View all</a>
            ·
            <a href="#" id="tc-notification-mark-all">Mark all read</a>
        </li>
    </ul>
</li>
