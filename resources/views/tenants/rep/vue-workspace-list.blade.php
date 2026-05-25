<div id="rep-workspace-app" class="tc-role-list-page tc-product-setup-vue" v-cloak>
    <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center gap-2">
        <a v-if="config.createUrl" :href="config.createUrl" class="text-white btn btn-info btn-sm">
            <i class="icofont icofont-plus"></i> @{{ config.createLabel || 'Create' }}
        </a>
        <a v-if="config.restoreUrl" :href="config.restoreUrl" class="btn btn-success btn-sm">
            <i class="icofont icofont-spinner-alt-3"></i> @{{ config.restoreLabel || 'Restore' }}
        </a>
        <button type="button" class="btn btn-light btn-sm" @click="loadRows()" :disabled="loading">
            <i class="icofont icofont-refresh"></i> Refresh
        </button>
    </div>

    <div v-if="flash" class="alert mx-2" :class="flash.ok ? 'alert-success' : 'alert-danger'" role="alert">@{{ flash.text }}</div>

    <div class="card tc-dash-card mb-3">
        <div class="card-body border-bottom py-3">
            <form @submit.prevent="loadRows(1)" class="tc-list-toolbar tc-list-toolbar--modern">
                <div class="tc-list-toolbar__row">
                    <div class="tc-list-toolbar__search-wrap">
                        <label class="visually-hidden" for="rep_workspace_search">Search</label>
                        <span class="tc-list-toolbar__search-icon" aria-hidden="true">
                            <i data-feather="search"></i>
                        </span>
                        <input type="search" id="rep_workspace_search" v-model="search"
                            class="form-control tc-list-toolbar__search" placeholder="Filter…"
                            autocomplete="off" @keyup.enter="loadRows(1)">
                        <button v-if="search.trim()" type="button" class="tc-list-toolbar__clear"
                            @click="clearSearch" aria-label="Clear search">&times;</button>
                    </div>
                    <div class="tc-list-toolbar__actions">
                        <span class="tc-list-toolbar__count text-muted">
                            <template v-if="pagination.total > 0">
                                Showing <strong>@{{ paginationFrom }}–@{{ paginationTo }}</strong> of <strong>@{{ pagination.total }}</strong>
                            </template>
                            <template v-else-if="!loading">No records</template>
                        </span>
                        <label class="tc-list-toolbar__per-page mb-0">
                            <span class="text-muted">Per page</span>
                            <select v-model.number="perPage" class="form-select form-select-sm" @change="loadRows(1)">
                                <option v-for="opt in perPageOptions" :key="opt" :value="opt">@{{ opt }}</option>
                            </select>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive table-sm tc-admin-datatable">
                <table class="table table-striped table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th v-for="col in config.columns" :key="col.key" scope="col">@{{ col.label }}</th>
                            <th scope="col" style="width:200px">Action</th>
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
                                    <p class="mb-0">@{{ emptyMessage }}</p>
                                </div>
                            </td>
                        </tr>
                        <tr v-for="row in rows" :key="row.id" :class="{ 'tc-row-unviewed': row.is_unviewed }">
                            <td v-for="col in config.columns" :key="col.key">
                                <span v-if="col.type === 'money'">$@{{ row[col.key] }}</span>
                                <span v-else>@{{ row[col.key] ?? '—' }}</span>
                            </td>
                            <td class="text-nowrap tc-admin-datatable__actions">
                                <a v-if="config.showUrl" :href="showUrl(row.id)" class="tc-admin-datatable__edit">Show</a>
                                <template v-if="config.editUrl">
                                    <span v-if="config.showUrl" class="text-muted"> | </span>
                                    <a :href="editUrl(row.id)" class="tc-admin-datatable__edit">Edit</a>
                                </template>
                                <template v-if="config.canDelete">
                                    <span v-if="config.showUrl || config.editUrl" class="text-muted"> | </span>
                                    <button type="button" class="btn btn-link btn-sm p-0 text-danger align-baseline"
                                        @click="destroyRow(row.id)">Delete</button>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="pagination.last_page > 1" class="card-body border-top py-2">
            <nav class="tc-list-pagination d-flex flex-wrap align-items-center justify-content-between gap-2">
                <p class="tc-list-pagination__summary text-muted small mb-0">
                    Showing @{{ paginationFrom }} to @{{ paginationTo }} of @{{ pagination.total }} entries
                </p>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item" :class="{ disabled: pagination.current_page <= 1 }">
                        <button type="button" class="page-link" @click="goPage(pagination.current_page - 1)">Prev</button>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">Page @{{ pagination.current_page }} / @{{ pagination.last_page }}</span>
                    </li>
                    <li class="page-item" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                        <button type="button" class="page-link" @click="goPage(pagination.current_page + 1)">Next</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>[v-cloak] { display: none !important; }</style>
