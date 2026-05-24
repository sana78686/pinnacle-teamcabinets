@extends('layouts.tenant.settings')
@section('title', 'Email Settings')

@section('setting_content')
@php
    $modules = \App\Support\EmailSettingsVueConfig::modules();
    $initialTab = request('tab') === 'content' ? 'email-content' : 'smtp';
    $vueBoot = [
        'csrf' => csrf_token(),
        'initialTab' => $initialTab,
        'modules' => $modules,
        'api' => [
            'meta' => route('tenant_email_settings_api_meta'),
            'testSmtp' => route('tenant_email_settings_api_test_smtp'),
            'smtp' => [
                'index' => route('tenant_email_settings_api_index', ['type' => 'smtp']),
                'store' => route('tenant_email_settings_api_store', ['type' => 'smtp']),
                'show' => route('tenant_email_settings_api_show', ['type' => 'smtp', 'id' => '__ID__']),
                'update' => route('tenant_email_settings_api_update', ['type' => 'smtp', 'id' => '__ID__']),
                'destroy' => route('tenant_email_settings_api_destroy', ['type' => 'smtp', 'id' => '__ID__']),
                'restore' => route('tenant_email_settings_api_restore', ['type' => 'smtp', 'id' => '__ID__']),
            ],
            'email-content' => [
                'index' => route('tenant_email_settings_api_index', ['type' => 'email-content']),
                'store' => route('tenant_email_settings_api_store', ['type' => 'email-content']),
                'show' => route('tenant_email_settings_api_show', ['type' => 'email-content', 'id' => '__ID__']),
                'update' => route('tenant_email_settings_api_update', ['type' => 'email-content', 'id' => '__ID__']),
                'destroy' => route('tenant_email_settings_api_destroy', ['type' => 'email-content', 'id' => '__ID__']),
                'restore' => route('tenant_email_settings_api_restore', ['type' => 'email-content', 'id' => '__ID__']),
            ],
        ],
    ];
@endphp

<div id="email-settings-app" class="tc-product-setup-vue" v-cloak>
    <h3 class="tc-settings-section__title mb-3">Email Settings</h3>

    <nav class="tc-wd-subnav mb-3" aria-label="Email settings tabs">
        <button type="button" class="tc-wd-subnav__link" :class="{ 'is-active': activeTab === 'smtp' }" @click="setTab('smtp')">
            Manage SMTP Details
        </button>
        <button type="button" class="tc-wd-subnav__link" :class="{ 'is-active': activeTab === 'email-content' }" @click="setTab('email-content')">
            Manage Emails Content
        </button>
    </nav>

    <p class="text-muted f-12 mb-3" v-if="config.note">@{{ config.note }}</p>


    <div class="alert alert-warning py-2 f-12 mb-3" v-if="activeTab === 'smtp' && !showTrashed">
        <strong>NOTE:</strong> You cannot delete an SMTP account that is already in use to send emails.
    </div>
    <div class="alert alert-info py-2 f-12 mb-3" v-if="showTrashed">
        Showing deleted records. Use <strong>Restore</strong> to bring a record back.
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <button v-if="!showTrashed" type="button" class="btn btn-info btn-sm" @click="openCreate">
            <i class="icofont icofont-plus"></i> @{{ config.addLabel }}
        </button>
        <button type="button" class="btn btn-light btn-sm" @click="toggleTrashed">
            @{{ showTrashed ? 'Back to active list' : 'View deleted / Restore' }}
        </button>
        <button type="button" class="btn btn-light btn-sm" @click="loadRows()" :disabled="loading">
            <i class="icofont icofont-refresh"></i> Refresh
        </button>
    </div>

    <div v-if="flash" class="alert" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th v-for="col in config.columns" :key="col.key">@{{ col.label }}</th>
                    <th style="width:240px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading">
                    <td :colspan="config.columns.length + 1" class="text-center py-4 text-muted">Loading…</td>
                </tr>
                <tr v-else-if="!rows.length">
                    <td :colspan="config.columns.length + 1" class="text-center py-4 text-muted">No records found.</td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="col in config.columns" :key="col.key">@{{ row[col.key] ?? '—' }}</td>
                    <td class="text-nowrap">
                        <template v-if="showTrashed">
                            <button type="button" class="btn btn-sm btn-success" @click="restoreRow(row.id)">Restore</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-sm btn-light" @click="openShow(row.id)">Show</button>
                            <button type="button" class="btn btn-sm btn-warning" @click="openEdit(row.id)">Edit</button>
                            <button v-if="activeTab === 'smtp'" type="button" class="btn btn-sm btn-info" @click="testSmtpRow(row)" :disabled="testing">Test</button>
                            <button type="button" class="btn btn-sm btn-danger" @click="destroyRow(row.id, row)" :disabled="row.in_use">Delete</button>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <nav v-if="pagination.last_page > 1" class="mt-3">
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                <button type="button" class="page-link" @click="goPage(pagination.current_page - 1)">Prev</button>
            </li>
            <li class="page-item disabled"><span class="page-link">Page @{{ pagination.current_page }} / @{{ pagination.last_page }}</span></li>
            <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                <button type="button" class="page-link" @click="goPage(pagination.current_page + 1)">Next</button>
            </li>
        </ul>
    </nav>

    <div class="modal fade" id="es-form-modal" tabindex="-1" aria-hidden="true" ref="formModalEl">
        <div class="modal-dialog modal-lg modal-dialog-centered tc-ps-modal-dialog">
            <div class="modal-content tc-ps-modal-content">
                <div class="modal-header tc-ps-modal-header">
                    <h5 class="modal-title">@{{ formMode === 'edit' ? 'Edit' : 'Add' }} @{{ config.singular }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitForm" class="tc-ps-modal-form">
                    <div class="modal-body tc-form-page tc-ps-modal-body">
                        <div v-if="formErrors.length" class="alert alert-danger">
                            <ul class="mb-0"><li v-for="(e,i) in formErrors" :key="i">@{{ e }}</li></ul>
                        </div>
                        <div class="row g-3">
                            <div v-for="field in config.fields" :key="field.name" class="form-group tc-field" :class="field.full ? 'col-12' : 'col-md-6'">
                                <label class="form-label tc-ps-field-label" :for="'es-' + field.name">
                                    @{{ field.label }}<span v-if="field.required && !(formMode === 'edit' && field.name === 'smtp_password')" class="text-danger"> *</span>
                                    <span v-if="field.tip" class="tc-tip" :data-tip="field.tip" data-placement="top" tabindex="0" role="button"><i>i</i></span>
                                </label>
                                <select v-if="field.type === 'select'" class="form-control form-select" :id="'es-' + field.name" v-model="form[field.name]" :required="field.required">
                                    <option value="">--Select--</option>
                                    <option v-for="opt in optionsFor(field)" :key="opt.value" :value="opt.value">@{{ opt.label }}</option>
                                </select>
                                <textarea v-else-if="field.type === 'textarea'" class="form-control" :id="'es-' + field.name" v-model="form[field.name]" :rows="field.rows || 5" :required="field.required"></textarea>
                                <input v-else class="form-control" :id="'es-' + field.name" :type="field.type || 'text'" v-model="form[field.name]" :required="field.required && !(formMode === 'edit' && field.name === 'smtp_password')" :placeholder="field.placeholder || ''">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer tc-ps-modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" :disabled="saving">@{{ saving ? 'Saving…' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="es-show-modal" tabindex="-1" aria-hidden="true" ref="showModalEl">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@{{ config.singular }} details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body tc-form-page" v-if="showRecord">
                    <dl class="row mb-0">
                        <template v-for="field in config.showFields" :key="field.key">
                            <dt class="col-sm-4">@{{ field.label }}</dt>
                            <dd class="col-sm-8">
                                <span v-if="field.type === 'html'" v-html="showValue(field, showRecord)"></span>
                                <span v-else>@{{ showValue(field, showRecord) }}</span>
                            </dd>
                        </template>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('setting_script')
<script>
window.EMAIL_SETTINGS_CRUD = @json($vueBoot);
</script>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="{{ tenant_static_asset('js/email-settings-vue.js') }}?v=1"></script>
@endsection
