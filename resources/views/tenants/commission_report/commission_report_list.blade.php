@extends('layouts.tenant.master')
@section('title', 'Commission Report')
@section('breadcrumb-title')
    <h2>Commission Report <span>List</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Commission Report</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
    <div id="commission-report-app" class="tc-role-list-page" v-cloak>
        <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center gap-2">
            @if (tenant_can('commission-list'))
                <a href="{{ route('tenant_commission_report_user_types') }}" class="btn btn-info btn-sm text-white">
                    <i class="icofont icofont-users"></i> User Type Commissions
                </a>
                <a href="{{ route('tenant_commission_report_saving') }}" class="btn btn-warning btn-sm text-dark">
                    <i class="icofont icofont-chart-pie"></i> Saving Report
                </a>
            @endif
            <a href="{{ route('tenant_deleted_commission_report_list') }}" class="btn btn-success btn-sm">
                <i class="icofont icofont-spinner-alt-3"></i> Restore Report
            </a>
            <button type="button" class="btn btn-light btn-sm" @click="fetchData" :disabled="loading">
                <i class="icofont icofont-refresh"></i> Refresh
            </button>
            <button type="button" class="btn btn-primary btn-sm text-white ms-auto" @click="exportCsv">
                <i class="icofont icofont-upload-alt"></i> Export CSV
            </button>
        </div>

        
        <div v-if="flash" class="alert mx-2" :class="flash.ok ? 'alert-success' : 'alert-danger'">@{{ flash.text }}</div>

        <div class="card tc-dash-card mb-3">
            <div class="card-body border-bottom py-3">
                <form @submit.prevent="fetchData" class="row g-2 align-items-end">
                    <div v-if="config.showRepFilter" class="col-md-4">
                        <label class="form-label small mb-1">Representative</label>
                        <select v-model="filters.rep_id" class="form-select form-select-sm">
                            <option value="">All Representatives</option>
                            <option v-for="rep in representatives" :key="rep.id" :value="rep.id">@{{ rep.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-1">From</label>
                        <input type="date" v-model="filters.from" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-1">To</label>
                        <input type="date" v-model="filters.to" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="loading">Search</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" @click="resetFilters">Reset</button>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive table-sm">
                    <table class="table table-striped table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Order By</th>
                                <th>Customer Name</th>
                                <th>Invoice #</th>
                                <th>Job Name</th>
                                <th>Invoice Date</th>
                                <th>Door Style</th>
                                <th>List Price</th>
                                <th>Customer PF</th>
                                <th>Customer Cost</th>
                                <th>Aff PF</th>
                                <th>Aff Cost</th>
                                <th>Aff Commission</th>
                                <th>Rep PF</th>
                                <th>Rep Cost</th>
                                <th>Rep Commission</th>
                                <th style="width:140px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="loading">
                                <td colspan="16" class="text-center py-4 text-muted">Loading…</td>
                            </tr>
                            <template v-else v-for="order in rows" :key="order.order_id">
                                <tr v-for="(line, i) in order.door_lines" :key="order.order_id + '-' + i">
                                    <td>@{{ i === 0 ? order.order_id : '' }}</td>
                                    <td>@{{ i === 0 ? (order.customer_name || '—') : '' }}</td>
                                    <td>@{{ i === 0 ? order.invoice_number : '' }}</td>
                                    <td>@{{ i === 0 ? order.job_name : '' }}</td>
                                    <td>@{{ i === 0 ? order.invoice_date : '' }}</td>
                                    <td>@{{ line.door_style }}</td>
                                    <td>@{{ fmt(line.list_price) }}</td>
                                    <td>@{{ show(line.user_door_factor) }}</td>
                                    <td>@{{ fmt(line.user_door_price) }}</td>
                                    <td>@{{ show(line.parent_door_factor) }}</td>
                                    <td>@{{ line.parent_cost_display || (line.parent_door_price ? fmt(line.parent_door_price) : 'N/A') }}</td>
                                    <td>@{{ line.aff_commission_display || (line.aff_commission ? fmt(line.aff_commission) : 'N/A') }}</td>
                                    <td>@{{ show(line.rep_door_factor) }}</td>
                                    <td>@{{ line.rep_cost_display || (line.rep_door_price ? fmt(line.rep_door_price) : 'N/A') }}</td>
                                    <td>@{{ line.rep_commission_display || (line.rep_commission ? fmt(line.rep_commission) : 'N/A') }}</td>
                                    <td v-if="i === 0" class="text-nowrap">
                                        <a :href="orderUrl(order.order_id)" class="tc-admin-datatable__edit">View</a>
                                        <template v-if="!config.deleted">
                                            <span class="text-muted"> | </span>
                                            <button type="button" class="btn btn-link btn-sm p-0 text-danger" @click="deleteOrder(order.order_id)">Delete</button>
                                        </template>
                                    </td>
                                    <td v-else></td>
                                </tr>
                            </template>
                            <tr v-if="!loading && !rows.length">
                                <td colspan="16" class="text-center py-4 text-muted">No records found.</td>
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
