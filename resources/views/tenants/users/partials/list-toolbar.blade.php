@php
    $perPage = (int) ($perPage ?? request('per_page', tenant_list_per_page()));
    $search = $search ?? request('search', '');
    $perPageOptions = $perPageOptions ?? [10, 15, 25, 50, 100];
    $paginator = $paginator ?? null;
    $total = $paginator?->total() ?? 0;
    $from = $total > 0 ? $paginator->firstItem() : 0;
    $to = $total > 0 ? $paginator->lastItem() : 0;
@endphp
<form method="get" action="{{ $listUrl ?? route('tenant_user_index') }}" class="tc-list-toolbar tc-list-toolbar--modern"
    data-tc-users-list-filter autocomplete="off">
    @foreach (request()->except(['page', 'per_page', 'search']) as $key => $val)
        @if (is_scalar($val) && $val !== '')
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach
    <div class="tc-list-toolbar__row">
        <div class="tc-list-toolbar__search-wrap tc-users-search-wrap">
            <label class="visually-hidden" for="tc_users_list_search">Search users</label>
            <span class="tc-list-toolbar__search-icon" aria-hidden="true">
                <i data-feather="search"></i>
            </span>
            <input type="search" name="search" id="tc_users_list_search" class="form-control tc-list-toolbar__search"
                value="{{ $search }}" placeholder="Search name, role, or email…" autocomplete="off"
                data-tc-users-search-input role="combobox" aria-expanded="false" aria-controls="tc_users_autocomplete"
                aria-autocomplete="list">
            <button type="button" class="tc-list-toolbar__clear {{ $search === '' ? 'd-none' : '' }}"
                data-tc-users-search-clear aria-label="Clear search">&times;</button>
            <ul id="tc_users_autocomplete" class="tc-users-autocomplete" data-tc-users-autocomplete hidden></ul>
        </div>
        <div class="tc-list-toolbar__actions">
            <span class="tc-list-toolbar__count text-muted" data-tc-users-list-count>
                @if ($total > 0)
                    Showing <strong>{{ $from }}–{{ $to }}</strong> of <strong>{{ number_format($total) }}</strong>
                @else
                    No records
                @endif
            </span>
            <label class="tc-list-toolbar__per-page mb-0">
                <span class="text-muted">Per page</span>
                <select name="per_page" class="form-select form-select-sm" data-tc-users-per-page>
                    @foreach ($perPageOptions as $opt)
                        <option value="{{ $opt }}" @selected($perPage === (int) $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</form>
