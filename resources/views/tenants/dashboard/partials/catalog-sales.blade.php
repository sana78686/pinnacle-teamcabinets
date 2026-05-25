<div class="card tc-dash-card mb-4" id="tc-catalog-sales-widget">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0 tc-dash-card__title">Catalog sales</h5>
        <span class="small text-muted d-none" id="tc-catalog-sales-status" aria-live="polite"></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive table-sm tc-admin-datatable">
            <table class="table table-striped table-bordered table-sm mb-0" id="tc-catalog-sales-table">
                <thead>
                    <tr>
                        <th scope="col">Catalog</th>
                        <th scope="col" class="text-end">Total</th>
                        <th scope="col" class="text-end">Last quarter</th>
                        <th scope="col" class="text-end">Last month</th>
                        <th scope="col" class="text-end">Last week</th>
                    </tr>
                </thead>
                <tbody id="tc-catalog-sales-body">
                    @include('partials.tc-admin-datatable-empty', [
                        'colspan' => 5,
                        'icon' => 'icofont-refresh',
                        'message' => 'Loading catalog sales…',
                    ])
                </tbody>
            </table>
        </div>
    </div>
</div>
