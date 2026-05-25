@extends('layouts.tenant.master')
@section('title', 'User Hierarchy')
@section('breadcrumb-title')
    <h2>Set Users <span>Under Role</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Roles</li>
    <li class="breadcrumb-item active">Hierarchy</li>
@endsection
@section('content')
    @include('partial.message')

    <div id="hierarchy-app" v-cloak>
        <div v-if="flash" class="alert" :class="flash.ok ? 'alert-success' : 'alert-danger'">@{{ flash.text }}</div>

        <div class="card tc-dash-card mb-3">
            <div class="card-header"><strong>Connect Representative to Admin</strong></div>
            <div class="card-body d-flex flex-wrap gap-2 align-items-center">
                <select v-model="repToConnect" class="form-select form-select-sm" style="max-width:320px;">
                    <option value="">Select Representative</option>
                    <option v-for="u in repUsers" :key="u.id" :value="u.id">@{{ u.name }}</option>
                </select>
                <button type="button" class="btn btn-sm tc-pn-btn tc-pn-btn--navy" :disabled="!repToConnect" @click="connectRepToAdmin">Connect</button>
            </div>
        </div>

        <div class="card tc-dash-card mb-3">
            <div class="card-header"><strong>Connect Showroom / Dealer / Distributor to Representative</strong></div>
            <div class="card-body row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small mb-1">User</label>
                    <select v-model="connectForm.user_id" class="form-select form-select-sm">
                        <option value="">Select user</option>
                        <option v-for="u in midTierUsers" :key="u.id" :value="u.id">@{{ u.name }} (@{{ u.user_type }})</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label small mb-1">Representative</label>
                    <select v-model="connectForm.rep_id" class="form-select form-select-sm">
                        <option value="">Select representative</option>
                        <option v-for="r in connectedReps" :key="r.id" :value="r.id">@{{ r.name }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm tc-pn-btn tc-pn-btn--navy w-100" :disabled="!connectForm.user_id || !connectForm.rep_id" @click="connectToRep">Connect</button>
                </div>
            </div>
        </div>

        <div class="mb-3 d-flex flex-wrap gap-2">
            <a :href="config.exportShowroomsUrl" class="btn btn-sm btn-outline-secondary">Export Showroom Connections CSV</a>
            <a :href="config.exportDealersUrl" class="btn btn-sm btn-outline-secondary">Export Dealer Connections CSV</a>
            <a :href="config.exportDistributorsUrl" class="btn btn-sm btn-outline-secondary">Export Distributor Connections CSV</a>
            <button type="button" class="btn btn-sm btn-light ms-auto" @click="fetchData" :disabled="loading">Refresh</button>
        </div>

        <div v-if="loading" class="text-center py-4 text-muted">Loading hierarchy…</div>

        <div v-else class="row g-3">
            <div class="col-lg-6">
                <div class="card tc-dash-card h-100">
                    <div class="card-header py-2"><strong>Rep → Showroom → Affiliate</strong></div>
                    <div class="card-body small">
                        <p v-if="!Object.keys(tree.rep_show_data || {}).length" class="text-muted mb-0">No connections.</p>
                        <div v-for="(children, repName) in tree.rep_show_data" :key="'s-' + repName" class="mb-3">
                            <div class="fw-bold">@{{ repName }}</div>
                            <div v-for="(affiliates, showName) in children" :key="showName" class="ms-3">
                                <div>└ @{{ showName }}</div>
                                <div v-for="affi in affiliates" :key="affi.id" class="ms-4 text-muted">└ @{{ affi.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card tc-dash-card h-100">
                    <div class="card-header py-2"><strong>Rep → Dealer → Affiliate</strong></div>
                    <div class="card-body small">
                        <p v-if="!Object.keys(tree.rep_dealer_data || {}).length" class="text-muted mb-0">No connections.</p>
                        <div v-for="(children, repName) in tree.rep_dealer_data" :key="'d-' + repName" class="mb-3">
                            <div class="fw-bold">@{{ repName }}</div>
                            <div v-for="(affiliates, dealerName) in children" :key="dealerName" class="ms-3">
                                <div>└ @{{ dealerName }}</div>
                                <div v-for="affi in affiliates" :key="affi.id" class="ms-4 text-muted">└ @{{ affi.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card tc-dash-card h-100">
                    <div class="card-header py-2"><strong>Rep → Distributor → Affiliate</strong></div>
                    <div class="card-body small">
                        <p v-if="!Object.keys(tree.rep_distri_data || {}).length" class="text-muted mb-0">No connections.</p>
                        <div v-for="(children, repName) in tree.rep_distri_data" :key="'di-' + repName" class="mb-3">
                            <div class="fw-bold">@{{ repName }}</div>
                            <div v-for="(affiliates, distName) in children" :key="distName" class="ms-3">
                                <div>└ @{{ distName }}</div>
                                <div v-for="affi in affiliates" :key="affi.id" class="ms-4 text-muted">└ @{{ affi.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card tc-dash-card h-100">
                    <div class="card-header py-2"><strong>Dealer ↔ Showroom</strong></div>
                    <div class="card-body small">
                        <p v-if="!(tree.dealer_showroom_data || []).length" class="text-muted mb-0">No dealer–showroom links.</p>
                        <div v-for="row in tree.dealer_showroom_data" :key="row.dealer_id + '-' + row.showroom_id" class="mb-2">
                            <div><span class="fw-semibold">@{{ row.dealer }}</span> → @{{ row.showroom }}</div>
                            <div v-for="affi in row.affiliates" :key="affi.id" class="ms-3 text-muted">└ @{{ affi.name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.HIERARCHY_CONFIG = @json($vueConfig ?? []);
    </script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="{{ tenant_static_asset('js/hierarchy-vue.js') }}?v=1"></script>
@endsection
