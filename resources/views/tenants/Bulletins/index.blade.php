@extends('layouts.tenant.master')
@section('title', 'Bulletins')

@section('breadcrumb-title')
    <h2>Bulletins <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Bulletins</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="tc-bulletin-admin">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <a href="{{ route('tenant_bulletin_create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New Bulletin
            </a>
            <a href="{{ route('tenant_deleted_bulletin_list') }}" class="btn btn-outline-success btn-sm">Restore</a>
            <a href="{{ route('tenant_bulletin_index') }}" class="btn btn-light btn-sm">
                <i class="fa fa-refresh" aria-hidden="true"></i> Refresh
            </a>
            <div class="ms-auto d-flex flex-wrap gap-2">
                <a href="{{ route('bulletin_export') }}" class="btn btn-outline-primary btn-sm">Export</a>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#bulletinImportModal">Import</button>
            </div>
        </div>

        <form method="get" action="{{ route('tenant_bulletin_index') }}" class="tc-list-toolbar tc-list-toolbar--modern mb-3" data-tc-list-filter>
            <div class="tc-list-toolbar__row">
                <div class="tc-list-toolbar__search-wrap">
                    <label class="visually-hidden" for="tc_bulletin_search">Search bulletins</label>
                    <span class="tc-list-toolbar__search-icon" aria-hidden="true"><i data-feather="search"></i></span>
                    <input type="search" name="search" id="tc_bulletin_search" class="form-control tc-list-toolbar__search"
                        value="{{ $search }}" placeholder="Search title, description, or user type…" autocomplete="off">
                    @if ($search !== '')
                        <button type="button" class="tc-list-toolbar__clear" data-tc-list-clear aria-label="Clear search">&times;</button>
                    @endif
                </div>
                <div class="tc-list-toolbar__actions flex-wrap">
                    <label class="tc-list-toolbar__per-page mb-0">
                        <span class="text-muted">Sort</span>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach (\App\Support\BulletinAudience::adminSortOptions() as $value => $label)
                                <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="tc-list-toolbar__per-page mb-0">
                        <span class="text-muted">Audience</span>
                        <select name="audience" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="" @selected($audience === '')>All</option>
                            <option value="every_one" @selected($audience === 'every_one')>Every One</option>
                            <option value="specific_user" @selected($audience === 'specific_user')>Specific User</option>
                        </select>
                    </label>
                    @if ($bulletins->total() > 0)
                        <span class="tc-list-toolbar__count text-muted align-self-center">
                            Showing <strong>{{ $bulletins->firstItem() }}–{{ $bulletins->lastItem() }}</strong>
                            of <strong>{{ number_format($bulletins->total()) }}</strong>
                        </span>
                    @endif
                    <label class="tc-list-toolbar__per-page mb-0">
                        <span class="text-muted">Per page</span>
                        <select name="per_page" class="form-select form-select-sm" data-tc-list-per-page>
                            @foreach ([10, 15, 25, 50, 100] as $opt)
                                <option value="{{ $opt }}" @selected($perPage === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
        </form>

        <div class="card tc-bulletin-admin__card">
            <div class="table-responsive tc-admin-datatable mb-0">
                <table class="table table-hover table-striped table-sm mb-0 tc-bulletin-admin__table">
                    <thead>
                        <tr>
                            <th class="tc-bulletin-admin__col-id">#</th>
                            <th class="tc-bulletin-admin__col-thumb">File</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Audience</th>
                            <th>User type</th>
                            <th class="tc-bulletin-admin__col-date">Posted</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bulletins as $row)
                            <tr>
                                <td class="text-muted">{{ $row->id }}</td>
                                <td>
                                    @if ($row->image && $row->isImageAttachment())
                                        <a href="{{ $row->attachmentUrl() }}" target="_blank" rel="noopener" class="tc-bulletin-admin__thumb">
                                            <img src="{{ $row->attachmentUrl() }}" alt="">
                                        </a>
                                    @elseif ($row->image)
                                        <a href="{{ $row->attachmentUrl() }}" target="_blank" rel="noopener" class="tc-bulletin-admin__file-badge">
                                            {{ strtoupper($row->attachmentExtension()) }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $row->bulletin_title }}</td>
                                <td class="tc-bulletin-admin__desc">{{ \Illuminate\Support\Str::limit($row->bulletin_description, 90) }}</td>
                                <td>
                                    <span class="badge {{ $row->user_option === 'every_one' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ \App\Support\BulletinAudience::userOptionLabel($row->user_option) }}
                                    </span>
                                </td>
                                <td>{{ $row->user_option === 'specific_user' ? \App\Support\BulletinAudience::targetRoleLabel($row->target_role) : '—' }}</td>
                                <td class="text-nowrap text-muted small">{{ $row->created_at?->format('m/d/Y') ?? '—' }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('tenant_bulletin_show', $row->id) }}" class="btn btn-link btn-sm p-0">View</a>
                                    <span class="text-muted">|</span>
                                    <a href="{{ route('tenant_bulletin_edit', $row->id) }}" class="btn btn-link btn-sm p-0">Edit</a>
                                    <span class="text-muted">|</span>
                                    <a href="{{ route('tenant_bulletin_destroy', $row->id) }}" class="btn btn-link btn-sm p-0 text-danger"
                                        onclick="return confirm('Delete this bulletin?');">Delete</a>
                                </td>
                            </tr>
                        @empty
                            @include('partials.tc-admin-datatable-empty', [
                                'colspan' => 8,
                                'icon' => 'icofont-megaphone',
                                'message' => 'No bulletins yet.',
                                'hint' => 'Use Add New Bulletin to publish an announcement.',
                            ])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($bulletins->hasPages())
            <div class="mt-3">{{ $bulletins->links() }}</div>
        @endif
    </div>

    <div class="modal fade" id="bulletinImportModal" tabindex="-1" aria-labelledby="bulletinImportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulletinImportModalLabel">Import bulletins</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bulletin_import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label" for="bulletinFile">Excel / CSV file</label>
                        <input type="file" class="form-control" id="bulletinFile" name="bulletinFile" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ $panelAsset('js/tenant-list-filter.js') }}?v=1"></script>
@endsection
