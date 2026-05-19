@extends('layouts.mega.master')

@section('title', 'Tenants')

@section('content')
@php
    $statusLegend = [
        'green' => 'Paid (active subscription)',
        'blue' => 'Free access (super admin)',
        'yellow' => 'Trial',
        'orange' => 'Past due',
        'grey' => 'Unpaid / expired',
    ];
@endphp

<x-admin-list
    title="Tenants"
    :create-url="route('registeration')"
    create-label="Register New Tenant">
    <x-slot:toolbar>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($statusLegend as $color => $label)
                <span class="tenant-status-legend">
                    <span class="tenant-status-dot tenant-status-dot--{{ $color }}"></span>
                    {{ $label }}
                </span>
            @endforeach
        </div>
    </x-slot:toolbar>

    <div class="admin-table-wrap">
        <table class="table admin-table table-hover">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>#</th>
                    <th>Database ID</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Tenant URL</th>
                    <th>Trial ends</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tenants as $index => $row)
                    @php
                        $tenant = $row['tenant'];
                        $status = $row['status'];
                    @endphp
                    <tr>
                        <td>
                            <span class="tenant-status-dot tenant-status-dot--{{ $status['color'] }}"
                                title="{{ $status['title'] }}"></span>
                            <span class="small">{{ $status['label'] }}</span>
                        </td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tenant->id }}</td>
                        <td>{{ $tenant->company_name }}</td>
                        <td>{{ $tenant->name ?? 'N/A' }}</td>
                        <td>{{ $tenant->email ?? 'N/A' }}</td>
                        <td>
                            @if ($tenant->getDomain() !== 'No Domain')
                                <a href="http://{{ $tenant->getDomain() }}" target="_blank" rel="noopener">{{ $tenant->getDomain() }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $tenant->trial_ends_at?->format('Y-m-d') ?? '—' }}</td>
                        <td>
                            <button type="button"
                                class="btn btn-sm btn-outline-primary js-tenant-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#tenantSubscriptionModal"
                                data-tenant-id="{{ $tenant->id }}"
                                data-company="{{ $tenant->company_name }}"
                                data-action="{{ route('admin.tenants.subscription.update', $tenant) }}"
                                data-status="{{ $tenant->subscription_status ?? '' }}"
                                data-trial-ends="{{ $tenant->trial_ends_at?->format('Y-m-d') }}"
                                data-complimentary-ends="{{ $tenant->complimentary_ends_at?->format('Y-m-d') }}"
                                data-subscription-ends="{{ $tenant->subscription_ends_at?->format('Y-m-d') }}"
                                data-is-complimentary="{{ $tenant->is_complimentary ? '1' : '0' }}">
                                Edit
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr class="admin-table-empty">
                        <td colspan="9">No tenants registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-list>

<div class="modal fade" id="tenantSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="tenantSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tenantSubscriptionModalLabel">Manage subscription</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tenantSubscriptionForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p class="text-muted mb-3">Tenant: <strong id="modalTenantCompany">—</strong></p>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="modal_access_type">Access type</label>
                            <select name="access_type" id="modal_access_type" class="form-control" required>
                                <option value="trial">Trial period</option>
                                <option value="paid">Mark as paid</option>
                                <option value="complimentary_unlimited">Free (unlimited)</option>
                                <option value="complimentary_until">Free until date</option>
                                <option value="expired">Unpaid / expired</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group" id="modalTrialDaysWrap">
                            <label for="modal_trial_days">Trial days</label>
                            <input type="number" name="trial_days" id="modal_trial_days" class="form-control"
                                value="{{ config('pinnacle.trial_days', 14) }}" min="1" max="365">
                        </div>
                        <div class="col-md-6 form-group d-none" id="modalComplimentaryWrap">
                            <label for="modal_complimentary_until">Free until</label>
                            <input type="date" name="complimentary_until" id="modal_complimentary_until" class="form-control">
                        </div>
                        <div class="col-md-6 form-group d-none" id="modalPaidWrap">
                            <label for="modal_subscription_ends_at">Paid until (optional)</label>
                            <input type="date" name="subscription_ends_at" id="modal_subscription_ends_at" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function () {
    var modal = document.getElementById('tenantSubscriptionModal');
    if (!modal) return;

    var form = document.getElementById('tenantSubscriptionForm');
    var companyEl = document.getElementById('modalTenantCompany');
    var accessType = document.getElementById('modal_access_type');
    var trialWrap = document.getElementById('modalTrialDaysWrap');
    var complimentaryWrap = document.getElementById('modalComplimentaryWrap');
    var paidWrap = document.getElementById('modalPaidWrap');

    function toggleFields() {
        var v = accessType.value;
        trialWrap.classList.toggle('d-none', v !== 'trial');
        complimentaryWrap.classList.toggle('d-none', v !== 'complimentary_until');
        paidWrap.classList.toggle('d-none', v !== 'paid');
    }

    accessType.addEventListener('change', toggleFields);

    document.querySelectorAll('.js-tenant-edit').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.action = btn.getAttribute('data-action') || '';
            companyEl.textContent = btn.getAttribute('data-company') || '—';

            var status = btn.getAttribute('data-status') || '';
            var isComplimentary = btn.getAttribute('data-is-complimentary') === '1';
            var trialEnds = btn.getAttribute('data-trial-ends') || '';
            var complimentaryEnds = btn.getAttribute('data-complimentary-ends') || '';
            var subscriptionEnds = btn.getAttribute('data-subscription-ends') || '';

            if (status === 'expired') {
                accessType.value = 'expired';
            } else if (status === 'active') {
                accessType.value = 'paid';
            } else if (isComplimentary && complimentaryEnds) {
                accessType.value = 'complimentary_until';
                document.getElementById('modal_complimentary_until').value = complimentaryEnds;
            } else if (isComplimentary) {
                accessType.value = 'complimentary_unlimited';
            } else if (trialEnds) {
                accessType.value = 'trial';
            } else {
                accessType.value = 'trial';
            }

            if (subscriptionEnds) {
                document.getElementById('modal_subscription_ends_at').value = subscriptionEnds;
            }

            toggleFields();
        });
    });

    toggleFields();
})();
</script>
@endsection
