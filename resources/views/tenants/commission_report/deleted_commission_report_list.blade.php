@extends('layouts.tenant.master')
@section('title', 'Restore Commission Report')
@section('breadcrumb-title')
    <h2>Commission Report <span>Restore</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Commission Report</li>
    <li class="breadcrumb-item active">Restore</li>
@endsection
@section('content')
    <div id="commission-report-app" class="tc-role-list-page" v-cloak>
        <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('tenant_commission_report_index') }}" class="btn btn-light btn-sm">
                <i class="icofont icofont-arrow-left"></i> Back to Report
            </a>
            <button type="button" class="btn btn-light btn-sm" @click="fetchData" :disabled="loading">
                <i class="icofont icofont-refresh"></i> Refresh
            </button>
        </div>

        <div class="card tc-dash-card mb-3 mt-2">
            
            <div class="card-body p-0">
                <div class="table-responsive table-sm">
                    <table class="table table-striped table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Job Name</th>
                                <th>Date</th>
                                <th>Door Style</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="loading">
                                <td colspan="6" class="text-center py-4 text-muted">Loading…</td>
                            </tr>
                            <template v-else v-for="order in rows" :key="order.order_id">
                                <tr v-for="(line, i) in order.door_lines" :key="order.order_id + '-' + i">
                                    <td>@{{ i === 0 ? order.order_id : '' }}</td>
                                    <td>@{{ i === 0 ? (order.customer_name || '—') : '' }}</td>
                                    <td>@{{ i === 0 ? order.job_name : '' }}</td>
                                    <td>@{{ i === 0 ? order.invoice_date : '' }}</td>
                                    <td>@{{ line.door_style }}</td>
                                    <td v-if="i === 0">
                                        <button type="button" class="btn btn-success btn-sm" @click="restoreOrder(order.order_id)">Restore</button>
                                    </td>
                                    <td v-else></td>
                                </tr>
                            </template>
                            <tr v-if="!loading && !rows.length">
                                <td colspan="6" class="p-0 border-0">
                                    <div class="tc-admin-datatable__empty">
                                        <i class="icofont icofont-spinner-alt-3" aria-hidden="true"></i>
                                        <p class="mb-0">No removed orders.</p>
                                        <p class="small text-muted mb-0 mt-1">Deleted commission rows can be restored from here.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.COMMISSION_REPORT_LIST = @json($vueConfig ?? []);
    </script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="{{ tenant_static_asset('js/commission-report-vue.js') }}?v=2"></script>
@endsection
