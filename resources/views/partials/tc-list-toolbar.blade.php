@php
    $perPage = (int) ($perPage ?? request('per_page', tenant_list_per_page()));
    $search = $search ?? request('search', '');
    $perPageOptions = $perPageOptions ?? [10, 15, 25, 50, 100];
    $searchPlaceholder = $searchPlaceholder ?? 'Filter…';
    $paginator = $paginator ?? null;
    $total = $paginator?->total();
    $from = $total > 0 ? $paginator->firstItem() : 0;
    $to = $total > 0 ? $paginator->lastItem() : 0;
    $toolbarExcept = ['page', 'per_page', 'search'];
    if (! empty($userTypeFilters)) {
        $toolbarExcept[] = 'user_type';
    }
@endphp
<form method="get" action="{{ $listUrl ?? url()->current() }}" class="tc-list-toolbar tc-list-toolbar--modern" data-tc-list-filter>
    @foreach (request()->except($toolbarExcept) as $key => $val)
        @if (is_scalar($val) && $val !== '')
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach
    <div class="tc-list-toolbar__row">
        <div class="tc-list-toolbar__search-wrap">
            <label class="visually-hidden" for="tc_list_search">Search</label>
            <span class="tc-list-toolbar__search-icon" aria-hidden="true">
                <i data-feather="search"></i>
            </span>
            <input type="search" name="search" id="tc_list_search" class="form-control tc-list-toolbar__search"
                value="{{ $search }}" placeholder="{{ $searchPlaceholder }}" autocomplete="off">
            @if ($search !== '')
                <button type="button" class="tc-list-toolbar__clear" data-tc-list-clear aria-label="Clear search">&times;</button>
            @endif
        </div>
        <div class="tc-list-toolbar__actions">
            @if ($paginator)
                <span class="tc-list-toolbar__count text-muted">
                    @if ($total > 0)
                        Showing <strong>{{ $from }}–{{ $to }}</strong> of <strong>{{ number_format($total) }}</strong>
                    @else
                        No records
                    @endif
                </span>
            @endif
            @if (! empty($userTypeFilters))
                <label class="tc-list-toolbar__per-page mb-0">
                    <span class="text-muted">User</span>
                    <select name="user_type" class="form-select form-select-sm tc-list-toolbar__select"
                        data-tc-list-user-type onchange="this.form.submit()" aria-label="Filter by user type">
                        @foreach ($userTypeFilters as $value => $label)
                            <option value="{{ $value }}" @selected(($userType ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
            @endif
            <label class="tc-list-toolbar__per-page mb-0">
                <span class="text-muted">Per page</span>
                <select name="per_page" class="form-select form-select-sm" data-tc-list-per-page>
                    @foreach ($perPageOptions as $opt)
                        <option value="{{ $opt }}" @selected($perPage === (int) $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</form>
