@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <span class="page-item-btn"><</span>
    @else
        <span wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="page-item-btn"><</span>
    @endif

    @foreach ($elements as $element)
        @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="page-item active">{{ $page }}</span>
            @else
                <span wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" class="page-item">{{ $page }}</span>
            @endif
        @endforeach
    @endforeach

    @if ($paginator->hasMorePages())
        <span wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="page-item-btn">></span>
    @else
        <span class="page-item-btn">></span>
    @endif
@endif