<!-- Custom Pagination Component -->
<div class="custom-pagination">
    <nav aria-label="Page navigation">
        <ul class="pagination-list">
            <!-- Previous Button -->
            @if($paginator->onFirstPage())
                <li class="pagination-item disabled">
                    <span class="pagination-link prev-btn">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link prev-btn">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            <!-- Page Numbers -->
            @php
                $start = max(1, $paginator->currentPage() - 2);
                $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
                
                // Ensure we show at least 5 pages if available
                if ($end - $start < 4) {
                    if ($start == 1) {
                        $end = min($paginator->lastPage(), $start + 4);
                    } else {
                        $start = max(1, $end - 4);
                    }
                }
            @endphp

            <!-- First page if not in range -->
            @if($start > 1)
                <li class="pagination-item">
                    <a href="{{ $paginator->url(1) }}" class="pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="pagination-item dots">
                        <span class="pagination-link">...</span>
                    </li>
                @endif
            @endif

            <!-- Page range -->
            @for($page = $start; $page <= $end; $page++)
                @if($page == $paginator->currentPage())
                    <li class="pagination-item active">
                        <span class="pagination-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="pagination-item">
                        <a href="{{ $paginator->url($page) }}" class="pagination-link">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            <!-- Last page if not in range -->
            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <li class="pagination-item dots">
                        <span class="pagination-link">...</span>
                    </li>
                @endif
                <li class="pagination-item">
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-link">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            <!-- Next Button -->
            @if($paginator->hasMorePages())
                <li class="pagination-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link next-btn">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled">
                    <span class="pagination-link next-btn">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
</div>
