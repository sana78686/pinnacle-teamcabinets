@extends('layouts.tenant.master')
@section('title', 'Notifications')

@section('breadcrumb-title')
    <h2>Notifications</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card tc-notifications-page">
            <div class="card-body">
                @if ($notifications->isEmpty())
                    <p class="text-muted mb-0">No notifications yet.</p>
                @else
                    <ul class="list-unstyled tc-notifications-list mb-0">
                        @foreach ($notifications as $notification)
                            @php
                                $data = $notification->data;
                                $isUnread = $notification->read_at === null;
                            @endphp
                            <li class="tc-notifications-list__item {{ $isUnread ? 'tc-notifications-list__item--unread' : '' }}">
                                <div class="tc-notifications-list__icon">
                                    <i data-feather="bell"></i>
                                </div>
                                <div class="tc-notifications-list__body">
                                    <h6 class="mb-1">{{ $data['title'] ?? 'Notification' }}</h6>
                                    <p class="mb-1 text-muted">{{ $data['message'] ?? '' }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if (!empty($data['url']))
                                        <div class="mt-2">
                                            <a href="{{ $data['url'] }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    @endif
                                </div>
                                @if ($isUnread)
                                    <form method="POST" action="{{ route('tenant_notifications_read', $notification->id) }}"
                                        class="tc-notifications-list__mark">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link">Mark read</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @include('partials.tenant-pagination', ['paginator' => $notifications])
                @endif
            </div>
        </div>
    </div>
@endsection
