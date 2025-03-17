<div class="pagination-container">
    @if ($paginator->hasPages())
    <ul class="pagination">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><li class="page-item-btn {{ $paginator->onFirstPage() ? 'disabled' : '' }}"><</li></a>
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <a class="page-link" href="{{ $url }}"><li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </li></a>
                @endforeach
            @endif
        @endforeach
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><li class="page-item-btn {{ $paginator->hasMorePages() ? '' : 'disabled' }}">></li> </a>
    </ul>
    @endif
</div>


