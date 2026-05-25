<div id="product-setup-app" class="tc-role-list-page tc-product-setup-vue" v-cloak>
    <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center gap-2">
        <button v-if="!config.trashed" type="button" class="text-white btn btn-info btn-sm" @click="openCreate" data-toggle="tooltip" title="Add a new record">
            <i class="icofont icofont-plus"></i> @{{ config.addLabel }}
        </button>
        <button type="button" class="btn btn-light btn-sm" @click="loadRows" :disabled="loading" data-toggle="tooltip" title="Refresh this list">
            <i class="icofont icofont-refresh"></i> Refresh
        </button>
        <button v-if="config.deactivateAllUrl" type="button" class="btn btn-warning btn-sm ms-auto" @click="deactivateAll" :disabled="loading">
            Deactivate All Products
        </button>
    </div>

    <div v-if="flash" class="alert mx-2" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

    <div class="card tc-dash-card mb-3">
        <div class="card-body p-0">
            <div class="table-responsive table-sm tc-admin-datatable">
                <table class="table table-striped table-bordered table-sm mb-0">
            <thead>
                <tr>
                    <th v-for="col in config.columns" :key="col.key">@{{ col.label }}</th>
                    <th style="width:200px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading">
                    <td :colspan="config.columns.length + 1" class="text-center py-4 text-muted">Loading…</td>
                </tr>
                <tr v-else-if="!rows.length">
                    <td :colspan="config.columns.length + 1" class="p-0 border-0">
                        <div class="tc-role-list-page__empty">
                            <i class="icofont icofont-file-document" aria-hidden="true"></i>
                            <p class="mb-0">No records found.</p>
                        </div>
                    </td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="col in config.columns" :key="col.key">
                        <template v-if="col.type === 'image'">
                            <img v-if="row[col.key]" :src="row[col.key]" alt="" class="tc-catalog-thumb" width="56" height="56">
                            <span v-else class="text-muted">—</span>
                        </template>
                        <span v-else-if="col.type === 'status'" class="badge" :class="row[col.key] ? 'badge-success' : 'badge-secondary'">
                            @{{ row[col.key] ? 'Active' : 'Inactive' }}
                        </span>
                        <template v-else-if="col.type === 'pdf'">
                            <a v-if="row.pdf_view_url" :href="row.pdf_view_url" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">View PDF</a>
                            <span v-else class="text-muted">—</span>
                        </template>
                        <span v-else-if="col.type === 'currency'">@{{ formatMoney(row[col.key]) }}</span>
                        <span v-else-if="col.type === 'weight'">@{{ formatWeight(row[col.key]) }}</span>
                        <span v-else>@{{ row[col.key] ?? '—' }}</span>
                    </td>
                    <td class="text-nowrap tc-admin-datatable__actions">
                        <template v-if="config.allowShow !== false">
                            <button type="button" class="btn btn-link btn-sm p-0 align-baseline tc-admin-datatable__edit" @click="openShow(row.id)">Show</button>
                            <span v-if="config.allowEdit !== false || config.trashed" class="text-muted"> | </span>
                        </template>
                        <button v-if="config.allowEdit !== false && !config.trashed" type="button" class="btn btn-link btn-sm p-0 align-baseline tc-admin-datatable__edit" @click="openEdit(row.id)">Edit</button>
                        <span v-if="config.allowEdit !== false && !config.trashed && config.api.destroy" class="text-muted"> | </span>
                        <button v-if="config.trashed && config.api.restore" type="button" class="btn btn-link btn-sm p-0 align-baseline text-success" @click="restoreRow(row.id)">Restore</button>
                        <button v-else-if="config.api.destroy" type="button" class="btn btn-link btn-sm p-0 text-danger align-baseline" @click="destroyRow(row.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
            </div>
        </div>

        <div v-if="pagination.last_page > 1" class="card-body border-top py-2">
            <nav class="tc-list-pagination">
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
        </div>
    </div>

    <div class="modal fade" id="ps-form-modal" tabindex="-1" aria-hidden="true" ref="formModalEl">
        <div class="modal-dialog modal-lg modal-dialog-centered tc-ps-modal-dialog">
            <div class="modal-content tc-ps-modal-content">
                <div class="modal-header tc-ps-modal-header">
                    <h5 class="modal-title">@{{ formMode === 'edit' ? 'Edit' : 'Add' }} @{{ config.singular }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submitForm" class="tc-ps-modal-form" ref="formEl">
                    <div class="modal-body tc-form-page tc-ps-modal-body">
                        <div v-if="formErrors.length" class="alert alert-danger">
                            <ul class="mb-0"><li v-for="(e,i) in formErrors" :key="i">@{{ e }}</li></ul>
                        </div>
                        <div class="row g-3">
                            <div v-for="field in config.fields" :key="field.name" class="form-group tc-field" :class="field.full ? 'col-12' : 'col-md-6'">
                                <label v-if="field.type !== 'checkbox'" class="form-label tc-ps-field-label" :for="'ps-' + field.name">
                                    @{{ field.label }}<span v-if="field.required" class="text-danger"> *</span>
                                    <span v-if="field.tip" class="tc-tip" :data-tip="field.tip" data-placement="top" tabindex="0" role="button" :aria-label="field.tip"><i>i</i></span>
                                </label>
                                <select v-if="field.type === 'select'" class="form-control form-select" :id="'ps-' + field.name" :name="field.name" v-model="form[field.name]" :required="field.required" :data-tip="field.tip || null">
                                    <option value="">--Select--</option>
                                    <option v-for="opt in optionsFor(field)" :key="opt.value" :value="opt.value">@{{ opt.label }}</option>
                                </select>
                                <textarea v-else-if="field.type === 'textarea'" class="form-control" :id="'ps-' + field.name" :name="field.name" v-model="form[field.name]" rows="3" :placeholder="field.placeholder || ''" :data-tip="field.tip || null"></textarea>
                                <div v-else-if="field.type === 'media'" class="tc-image-upload">
                                    <div v-if="formPreview[field.name]" class="tc-image-upload__preview mb-2">
                                        <img v-if="field.mediaType === 'image'" :src="formPreview[field.name]" alt="" class="tc-settings-preview-img">
                                        <a v-else-if="field.mediaType === 'pdf'" :href="formPreview[field.name]" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">View PDF</a>
                                    </div>
                                    <input type="file" class="form-control" :id="'ps-' + field.name" :name="field.name" :accept="field.accept || 'image/*'" :data-tip="field.tip || null" @change="onFile($event, field.name)">
                                    <div class="tc-image-upload__url mt-2">
                                        <label class="form-label small text-muted mb-1" :for="'ps-' + field.name + '-url'">Or paste a direct link</label>
                                        <input type="url" class="form-control" :id="'ps-' + field.name + '-url'" :name="field.name + '_url'" v-model="form[field.name + '_url']" :placeholder="field.urlPlaceholder || 'https://example.com/file'" :data-tip="field.urlTip || field.tip || null" inputmode="url" autocomplete="off">
                                    </div>
                                    <small v-if="field.hint" class="text-muted d-block mt-1">@{{ field.hint }}</small>
                                </div>
                                <div v-else-if="field.type === 'checkbox'" class="form-check mt-1">
                                    <input type="checkbox" class="form-check-input" :id="'ps-' + field.name" :name="field.name" v-model="form[field.name]" :data-tip="field.tip || null">
                                    <label class="form-check-label" :for="'ps-' + field.name">
                                        @{{ field.label }}
                                        <span v-if="field.tip" class="tc-tip" :data-tip="field.tip" data-placement="top" tabindex="0" role="button" :aria-label="field.tip"><i>i</i></span>
                                    </label>
                                </div>
                                <div v-else-if="field.prefix || field.suffix" class="input-group">
                                    <span v-if="field.prefix" class="input-group-text">@{{ field.prefix }}</span>
                                    <input class="form-control" :id="'ps-' + field.name" :name="field.name" type="number" v-model="form[field.name]" :required="field.required" :placeholder="field.placeholder || ''" :step="field.step || 'any'" :min="field.min ?? 0" :data-tip="field.tip || null" inputmode="decimal">
                                    <span v-if="field.suffix" class="input-group-text">@{{ field.suffix }}</span>
                                </div>
                                <input v-else-if="field.type === 'number'" class="form-control" :id="'ps-' + field.name" :name="field.name" type="number" v-model="form[field.name]" :required="field.required" :placeholder="field.placeholder || ''" :step="field.step || 'any'" :min="field.min ?? 0" :data-tip="field.tip || null" inputmode="decimal">
                                <input v-else class="form-control" :id="'ps-' + field.name" :name="field.name" :type="field.type || 'text'" v-model="form[field.name]" :required="field.required" :placeholder="field.placeholder || ''" :data-tip="field.tip || null">
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

    <div class="modal fade" id="ps-show-modal" tabindex="-1" aria-hidden="true" ref="showModalEl">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable tc-ps-modal-dialog">
            <div class="modal-content tc-ps-modal-content">
                <div class="modal-header tc-ps-modal-header">
                    <h5 class="modal-title">@{{ config.singular }} details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body tc-ps-modal-body" v-if="showRecord">
                    <table class="table table-bordered table-sm mb-0">
                        <tbody>
                            <tr v-for="col in config.showFields" :key="col.key">
                                <th style="width:35%">@{{ col.label }}</th>
                                <td>
                                    <img v-if="col.type === 'image' && showRecord[col.key]" :src="showRecord[col.key]" alt="" style="max-width:200px;border-radius:6px;">
                                    <a v-else-if="col.type === 'pdf' && showRecord.pdf_view_url" :href="showRecord.pdf_view_url" target="_blank" rel="noopener">View PDF</a>
                                    <a v-else-if="col.type === 'link' && showRecord[col.key]" :href="showRecord[col.key]" target="_blank" rel="noopener">Download</a>
                                    <span v-else-if="col.type === 'currency'">@{{ formatMoney(showRecord[col.key]) }}</span>
                                    <span v-else-if="col.type === 'weight'">@{{ formatWeight(showRecord[col.key]) }}</span>
                                    <span v-else-if="col.type === 'status'">@{{ showRecord[col.key] ? 'Active' : 'Inactive' }}</span>
                                    <span v-else>@{{ showRecord[col.key] ?? '—' }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer tc-ps-modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" @click="openEdit(showRecord.id); hideShowModal();">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
[v-cloak] { display: none !important; }
.tc-product-setup-vue .tc-catalog-thumb { object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6; }

.tc-product-setup-vue .tc-ps-modal-dialog {
    max-width: 920px;
}

.tc-product-setup-vue .tc-ps-modal-content {
    max-height: calc(100vh - 2rem);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.tc-product-setup-vue .tc-ps-modal-form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

.tc-product-setup-vue .tc-ps-modal-header,
.tc-product-setup-vue .tc-ps-modal-footer {
    flex-shrink: 0;
}

.tc-product-setup-vue .tc-ps-modal-body {
    flex: 1 1 auto;
    min-height: 0;
    max-height: min(68vh, 620px);
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}

.tc-product-setup-vue .tc-ps-field-label {
    display: inline-flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.15rem;
}

.tc-product-setup-vue .modal-body.tc-form-page .form-group {
    margin-bottom: 0;
}

.tc-product-setup-vue .form-check-label {
    display: inline-flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.15rem;
}

.tc-product-setup-vue .modal-body.tc-form-page .tc-image-upload input[type="url"].form-control {
    min-height: 42px;
}
</style>
