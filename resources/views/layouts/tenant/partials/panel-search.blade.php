<li class="tc-panel-search-li d-none d-lg-block">
    <div class="tc-panel-search" id="tc-panel-search" data-search-url="{{ route('tenant_panel_search') }}">
        <span class="tc-panel-search__icon" aria-hidden="true"><i data-feather="search"></i></span>
        <input
            type="search"
            class="tc-panel-search__input"
            id="tc-panel-search-input"
            name="q"
            placeholder="Search users, products, pages…"
            autocomplete="off"
            autocapitalize="off"
            spellcheck="false"
            aria-label="Search panel"
            aria-autocomplete="list"
            aria-controls="tc-panel-search-results"
            aria-expanded="false"
        >
        <kbd class="tc-panel-search__hint d-none d-xl-inline" aria-hidden="true">⌘K</kbd>
        <ul class="tc-panel-search__results" id="tc-panel-search-results" role="listbox" hidden></ul>
    </div>
</li>
<li class="d-lg-none">
    <button type="button" class="tc-header-icon-btn" id="tc-panel-search-mobile-btn" aria-label="Search">
        <i data-feather="search"></i>
    </button>
</li>
