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
        @if ($documents->isEmpty())
            <div class="card tc-dash-card">
                <div class="card-body">
                    <p class="mb-0 text-muted">No documents are available for your account yet.</p>
                </div>
            </div>
        @else
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
    </div>
@endsection

@section('script')
    <script>if (window.feather) { feather.replace(); }</script>
@endsection
