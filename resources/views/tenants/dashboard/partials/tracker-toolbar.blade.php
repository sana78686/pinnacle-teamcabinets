@php
    $trackerPerPage = (int) ($trackerPerPage ?? 10);
    $trackerSearch = $trackerSearch ?? '';
    $total = $trackerRows->total();
    $from = $total > 0 ? $trackerRows->firstItem() : 0;
    $to = $total > 0 ? $trackerRows->lastItem() : 0;
@endphp
<form method="get" action="{{ route('tenant_dashboard') }}" id="tcTrackerFilterForm" class="tc-tracker-toolbar">
    @foreach (request()->except(['tracker_page', 'tracker_per_page', 'tracker_search']) as $key => $val)
        @if (is_scalar($val) && $val !== '')
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach
    <div class="tc-tracker-toolbar__row">
        <div class="tc-tracker-toolbar__search-wrap">
            <label class="visually-hidden" for="tracker_search">Search orders</label>
            <span class="tc-tracker-toolbar__search-icon" aria-hidden="true">
                <i data-feather="search"></i>
            </span>
            <input type="search" name="tracker_search" id="tracker_search" class="form-control tc-tracker-toolbar__search"
                value="{{ $trackerSearch }}" placeholder="Search by customer, job, order #, SC #…" autocomplete="off">
            @if ($trackerSearch !== '')
                <button type="button" class="tc-tracker-toolbar__clear" id="tcTrackerSearchClear" aria-label="Clear search">&times;</button>
            @endif
        </div>
        <div class="tc-tracker-toolbar__actions">
            <span class="tc-tracker-toolbar__count text-muted">
                @if ($total > 0)
                    Showing <strong>{{ $from }}–{{ $to }}</strong> of <strong>{{ number_format($total) }}</strong>
                @else
                    No records
                @endif
            </span>
            <label class="tc-tracker-toolbar__per-page mb-0">
                <span class="text-muted">Per page</span>
                <select name="tracker_per_page" class="form-select form-select-sm" id="tracker_per_page">
                    @foreach ([10, 15, 25, 50] as $opt)
                        <option value="{{ $opt }}" @selected($trackerPerPage === $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</form>
