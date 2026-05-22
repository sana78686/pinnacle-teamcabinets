@php
    $perPage = (int) ($perPage ?? request('per_page', tenant_list_per_page()));
    $search = $search ?? request('search', '');
    $perPageOptions = $perPageOptions ?? [10, 15, 25, 50, 100];
@endphp
<form method="get" action="{{ $listUrl ?? url()->current() }}" class="tc-list-toolbar row align-items-center g-2 mb-3">
    @foreach (request()->except(['page', 'per_page', 'search']) as $key => $val)
        @if (is_scalar($val) && $val !== '')
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endif
    @endforeach
    <div class="col-auto">
        <label class="tc-list-toolbar__label mb-0 me-1">Show</label>
        <select name="per_page" class="form-control form-control-sm d-inline-block tc-list-toolbar__select" onchange="this.form.submit()">
            @foreach ($perPageOptions as $opt)
                <option value="{{ $opt }}" @selected($perPage === (int) $opt)>{{ $opt }}</option>
            @endforeach
        </select>
        <span class="text-muted small ms-1">entries</span>
    </div>
    <div class="col-auto ms-md-auto">
        <label class="tc-list-toolbar__label mb-0 me-1">Search:</label>
        <input type="search" name="search" class="form-control form-control-sm d-inline-block tc-list-toolbar__search"
            value="{{ $search }}" placeholder="Filter…">
        <button type="submit" class="btn btn-sm btn-light ms-1">Go</button>
        @if ($search !== '')
            <a href="{{ $listUrl ?? url()->current() }}" class="btn btn-sm btn-link">Clear</a>
        @endif
    </div>
</form>
