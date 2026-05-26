@php
    $showRoute = $showRoute ?? null;
    $editRoute = $editRoute ?? null;
    $destroyRoute = $destroyRoute ?? null;
    $rowLabel = $rowLabel ?? 'Record';
    $listUrl = $listUrl ?? url()->current();
    $perPage = (int) ($perPage ?? request('per_page', tenant_list_per_page()));
    $search = $search ?? request('search', '');
    $pickListRoute = $pickListRoute ?? null;
    $exportCsvUrl = $exportCsvUrl ?? null;
@endphp

@if ($showListToolbar ?? true)
    @include('partials.tc-list-toolbar', [
        'listUrl' => $listUrl,
        'perPage' => $perPage,
        'search' => $search,
    ])
@endif

<div class="table-responsive table-sm tc-admin-datatable">
    <table class="table table-striped table-bordered table-sm mb-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Job name</th>
                <th scope="col">Quote name</th>
                <th scope="col">Customer</th>
                <th scope="col">Total</th>
                <th scope="col">Weight</th>
                <th scope="col">Assemble</th>
                <th scope="col">Shipping</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr class="{{ tenant_admin_unviewed_row_class($record) }}">
                    <td>{{ $records->firstItem() + $loop->index }}</td>
                    <td>{{ $record->job_name }}</td>
                    <td>{{ filled($record->quote_name ?? null) ? $record->quote_name : '—' }}</td>
                    <td>{{ $record->user?->name ?? $record->user_email ?? '—' }}</td>
                    <td>${{ number_format((float) ($record->grand_total_cost ?? 0), 2) }}</td>
                    <td>{{ $record->sub_total_weight ?? '0' }} lbs</td>
                    <td>{{ ucfirst($record->assemble_cabinets_check ?? '—') }}</td>
                    <td>{{ ucfirst($record->shipping_status ?? '—') }}</td>
                    <td>{{ $record->created_at?->format('M j, Y') ?? '—' }}</td>
                    <td class="text-nowrap">
                        @if ($showRoute)
                            <a href="{{ route($showRoute, $record->id) }}">Show</a>
                        @endif
                        @if ($pickListRoute)
                            @if ($showRoute) | @endif
                            <a href="{{ route($pickListRoute, $record->id) }}">Pick List</a>
                        @endif
                        @if ($editRoute)
                            @if ($showRoute) | @endif
                            <a href="{{ route($editRoute, $record->id) }}">Edit</a>
                        @endif
                        @if ($destroyRoute)
                            @if ($showRoute || $editRoute) | @endif
                            <form action="{{ route($destroyRoute, $record->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Delete this {{ strtolower($rowLabel) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm p-0 text-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                @include('partials.tc-admin-datatable-empty', [
                    'colspan' => 10,
                    'icon' => 'icofont-file-document',
                    'message' => 'No ' . strtolower($rowLabel) . 's yet.',
                    'hint' => 'Use the order workspace to create one.',
                ])
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.tenant-pagination', ['paginator' => $records])
