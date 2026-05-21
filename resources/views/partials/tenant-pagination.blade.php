@if (isset($paginator) && $paginator instanceof \Illuminate\Contracts\Pagination\Paginator && $paginator->hasPages())
    <div class="tc-list-pagination">
        @if ($paginator->total() > 0)
            <p class="tc-list-pagination__summary text-muted small mb-2">
                Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}
            </p>
        @endif
        {{ $paginator->links('pagination::bootstrap-5') }}
    </div>
@endif
