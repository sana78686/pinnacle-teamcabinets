@if (!empty($tcFrontendUrl))
    <a href="{{ $tcFrontendUrl }}" target="_blank" rel="noopener noreferrer"
        class="tc-page-storefront-link" title="Open public website in a new tab">
        <span class="tc-page-storefront-link__url">{{ $tcFrontendUrl }}</span>
        <i data-feather="external-link" class="tc-page-storefront-link__icon" aria-hidden="true"></i>
    </a>
@endif
