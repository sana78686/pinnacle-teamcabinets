<div id="rep-workspace-app" class="tc-product-setup-vue" v-cloak>
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
        <a v-if="config.createUrl" :href="config.createUrl" class="btn btn-info btn-sm">
            <i class="icofont icofont-plus"></i> @{{ config.createLabel || 'Create' }}
        </a>
        <button type="button" class="btn btn-light btn-sm" @click="loadRows()" :disabled="loading">
            <i class="icofont icofont-refresh"></i> Refresh
        </button>
        <div class="ms-auto d-flex gap-2 align-items-center">
            <input type="search" class="form-control form-control-sm" v-model="search" placeholder="Search…" @keyup.enter="loadRows(1)" style="max-width:220px">
            <button type="button" class="btn btn-light btn-sm" @click="loadRows(1)">Search</button>
        </div>
    </div>

    <div v-if="flash" class="alert" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover table-sm mb-0">
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
                    <td :colspan="config.columns.length + 1" class="text-center py-4 text-muted">No records found.</td>
                </tr>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="col in config.columns" :key="col.key">
                        <span v-if="col.type === 'money'">$@{{ row[col.key] }}</span>
                        <span v-else>@{{ row[col.key] ?? '—' }}</span>
                    </td>
                    <td class="text-nowrap">
                        <a v-if="config.showUrl" :href="showUrl(row.id)" class="btn btn-sm btn-light">Show</a>
                        <a v-if="config.editUrl" :href="editUrl(row.id)" class="btn btn-sm btn-warning">Edit</a>
                        <button v-if="config.canDelete" type="button" class="btn btn-sm btn-danger" @click="destroyRow(row.id)">Delete</button>
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
</div>

<style>[v-cloak] { display: none !important; }</style>
