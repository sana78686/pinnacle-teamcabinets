<nav aria-label="...">
    <ul class="pagination pagination-primary">
        {{-- Previous page link --}}
        @if ($users->onFirstPage())
            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a></li>
        @endif

        {{-- Current page and surrounding pages --}}
        @if ($users->currentPage() > 1)
            <li class="page-item"><a class="page-link" href="{{ $users->url(1) }}">1</a></li> <!-- First page -->
        @endif

        @if ($users->currentPage() > 2)
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li> <!-- Ellipsis before current page -->
        @endif

        <li class="page-item active">
            <a class="page-link" href="#">{{ $users->currentPage() }}</a> <!-- Current page -->
        </li>

        @if ($users->currentPage() < $users->lastPage() - 1)
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li> <!-- Ellipsis after current page -->
        @endif

        @if ($users->currentPage() < $users->lastPage())
            <li class="page-item"><a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a></li> <!-- Last page -->
        @endif

        {{-- Next page link --}}
        @if ($users->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
        @endif
    </ul>
</nav>
