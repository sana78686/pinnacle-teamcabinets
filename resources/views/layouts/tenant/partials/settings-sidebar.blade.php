@php
    $sectionIcons = [
        'tenant_site_setting' => 'settings',
        'tenant_home_setting_index' => 'layout',
        'pages.create' => 'file-text',
        'tenant_setting_manage_document' => 'book-open',
        'tenant_setting_manage_documentation_list' => 'list',
        'tenant_setting_manage_stmp' => 'mail',
        'tenant_setting_manage_stmp_list' => 'inbox',
        'tenant_setting_manage_email_content' => 'send',
        'tenant_setting_manage_email_content_list' => 'list',
        'tenant_setting_manage_term_condition' => 'file',
        'tenant_setting_manage_term_condition_list' => 'list',
        'tenant_setting_manage_credit' => 'credit-card',
        'tenant_setting_manage_credit_list' => 'list',
        'tenant_setting_manage_fuel' => 'droplet',
        'tenant_setting_manage_fuel_list' => 'list',
        'tenant_setting_manage_success' => 'check-circle',
        'tenant_setting_manage_success_list' => 'list',
        'tenant_setting_manage_index' => 'phone',
        'tenant_setting_manage_contact_list' => 'list',
        'tenant_setting_manage_create' => 'info',
        'tenant_setting_manage_about_List' => 'list',
    ];
@endphp
<aside class="tc-settings-sidebar">
    <h3 class="tc-settings-sidebar-title">Settings</h3>
    <p class="tc-settings-sidebar-desc">Choose a section to configure your dealer panel.</p>
    @if (!empty($tcFrontendUrl))
        <p class="tc-settings-sidebar-website">
            <a href="{{ $tcFrontendUrl }}" target="_blank" rel="noopener noreferrer"
                class="tc-settings-sidebar-website-link" title="Open public website in a new tab">
                <i data-feather="external-link" class="tc-settings-sidebar-website-icon" aria-hidden="true"></i>
                <span class="tc-settings-sidebar-website-label">{{ parse_url($tcFrontendUrl, PHP_URL_HOST) }}</span>
            </a>
        </p>
    @endif
    <nav class="tc-settings-nav" aria-label="Settings sections">
        @foreach (config('tenant_settings_menu.sections', []) as $section)
            @php
                $isActive = request()->routeIs($section['active'] ?? []);
                $icon = $section['icon'] ?? ($sectionIcons[$section['route']] ?? 'circle');
            @endphp
            <a href="{{ route($section['route']) }}"
                class="tc-settings-nav-link {{ $isActive ? 'is-active' : '' }}">
                <span class="tc-settings-nav-link__main">
                    <i data-feather="{{ $icon }}" class="tc-settings-nav-icon" aria-hidden="true"></i>
                    <span class="tc-settings-nav-label">{{ $section['label'] }}</span>
                </span>
                <span class="tc-settings-nav-dot" aria-hidden="true"></span>
            </a>
        @endforeach
    </nav>
</aside>
