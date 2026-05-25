@extends('layouts.tenant.master')
@section('title', 'Admin Saving Report')
@section('breadcrumb-title')
    <h2>Tax / Commission / Shipping <span>Totals</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_commission_report_index') }}">Commission Report</a></li>
    <li class="breadcrumb-item active">Saving Report</li>
@endsection
@section('content')
    <div id="commission-report-app" class="tc-role-list-page" v-cloak>
        <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('tenant_commission_report_index') }}" class="btn btn-light btn-sm">
                <i class="icofont icofont-arrow-left"></i> Commission List
            </a>
            <button type="button" class="btn btn-light btn-sm" @click="fetchData" :disabled="loading">
                <i class="icofont icofont-refresh"></i> Refresh
            </button>
            <button type="button" class="btn btn-primary btn-sm text-white ms-auto" @click="exportCsv">
                <i class="icofont icofont-upload-alt"></i> Export CSV
            </button>
        </div>

        <div class="card tc-dash-card mb-3">
            <div class="card-body border-bottom py-3">
                <p class="small text-muted mb-2">Default range: last Thursday through last Wednesday (CI weekly saving report).</p>
                <form @submit.prevent="fetchData" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small mb-1">Representative</label>
                        <select v-model="filters.rep_id" class="form-select form-select-sm">
                            <option value="">All Representatives</option>
                            <option value="all">All (explicit)</option>
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
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive table-sm">
                    <table class="table table-striped table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Door Style</th>
                                <th>List Price</th>
                                <th>Customer Cost</th>
                                <th>Aff Comm</th>
                                <th>Rep Comm</th>
                                <th>Mfg</th>
                                <th>Rep $</th>
                                <th>Aff $</th>
                                <th>Sub-Aff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="loading">
                                <td colspan="13" class="text-center py-4 text-muted">Loading…</td>
                            </tr>
                            <template v-else v-for="order in rows" :key="order.order_id">
                                <tr v-for="(line, i) in order.door_lines" :key="order.order_id + '-' + i">
                                    <td>@{{ i === 0 ? order.invoice_number : '' }}</td>
                                    <td>@{{ i === 0 ? (order.customer_name || '—') : '' }}</td>
                                    <td>@{{ i === 0 ? order.invoice_date : '' }}</td>
                                    <td>@{{ line.door_style }}</td>
                                    <td>@{{ fmt(line.product_actual_price || line.list_price) }}</td>
                                    <td>@{{ fmt(line.user_door_price) }}</td>
                                    <td>@{{ line.aff_commission_display || 'N/A' }}</td>
                                    <td>@{{ line.rep_commission_display || 'N/A' }}</td>
                                    <td>@{{ i === 0 ? fmt(order.mfg_comm) : '' }}</td>
                                    <td>@{{ i === 0 ? fmt(order.rep_comm) : '' }}</td>
                                    <td>@{{ i === 0 ? fmt(order.aff_comm) : '' }}</td>
                                    <td>@{{ i === 0 ? fmt(order.sub_aff_commission) : '' }}</td>
                                    <td v-if="i === 0" class="text-nowrap">
                                        <a :href="orderUrl(order.order_id)" class="tc-admin-datatable__edit">View</a>
                                    </td>
                                    <td v-else></td>
                                </tr>
                            </template>
                            <tr v-if="!loading && !rows.length">
                                <td colspan="13" class="text-center py-4 text-muted">No records found.</td>
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
