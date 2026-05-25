@extends('layouts.tenant.role.master')
@section('title', 'My Downloads')

@section('breadcrumb-title')
    <h2>My <span>Downloads</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">My Downloads</li>
@endsection

@section('content')
    <div class="container-fluid">
        @if ($documents->isEmpty() && ($adminFiles ?? collect())->isEmpty())
            <div class="card tc-dash-card">
                <div class="card-body">
                    <p class="mb-0 text-muted">No documents are available for your account yet.</p>
                </div>
            </div>
        @else
            @if (($adminFiles ?? collect())->isNotEmpty())
                <h5 class="mb-3">Files from admin</h5>
                <div class="row g-3 mb-4">
                    @foreach ($adminFiles as $doc)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 tc-download-card">
                                <div class="card-body text-center">
                                    <div class="py-4 text-muted">
                                        <i data-feather="file" style="width:48px;height:48px;"></i>
                                        <p class="mb-0 mt-2 small fw-semibold">{{ $doc['name'] }}</p>
                                        @if (!empty($doc['description']))
                                            <p class="mb-0 mt-1 small text-muted">{{ $doc['description'] }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ $doc['url'] }}" class="btn btn-info btn-sm mt-2" download>Download</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($documents->isNotEmpty())
                <h5 class="mb-3">Documentation</h5>
                <div class="row g-3">
                    @foreach ($documents as $doc)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 tc-download-card">
                                <div class="card-body text-center">
                                    @if ($doc['is_pdf'])
                                        <iframe
                                            src="https://docs.google.com/gview?url={{ urlencode($doc['url']) }}&embedded=true"
                                            style="width:100%;height:280px;border:0;border-radius:6px;"
                                            title="{{ $doc['name'] }}"
                                        ></iframe>
                                    @else
                                        <div class="py-5 text-muted">
                                            <i data-feather="file" style="width:48px;height:48px;"></i>
                                            <p class="mb-0 mt-2 small">{{ $doc['name'] }}</p>
                                        </div>
                                    @endif
                                    <a href="{{ $doc['url'] }}" class="btn btn-info btn-sm mt-3" download>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
@endsection

@section('script')
    <script>if (window.feather) { feather.replace(); }</script>
@endsection
