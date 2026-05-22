@if (isset($paginator) && $paginator instanceof \Illuminate\Contracts\Pagination\Paginator && $paginator->total() > 0)
    <div class="tc-list-pagination d-flex flex-wrap align-items-center justify-content-between gap-2">
        <p class="tc-list-pagination__summary text-muted small mb-0">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </p>
        {{ $paginator->links('vendor.pagination.tc-admin') }}
    </div>
@endif
