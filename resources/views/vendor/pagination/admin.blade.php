{{-- resources/views/vendor/pagination/admin.blade.php --}}
{{-- Custom pagination that matches the admin design system --}}
{{-- Register in AppServiceProvider: Paginator::defaultView('vendor.pagination.admin') --}}

@if ($paginator->hasPages())
<div class="pagination">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <button class="pagination__btn" disabled aria-label="Previous" aria-disabled="true">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
    @else
        <button wire:click="previousPage" class="pagination__btn" aria-label="Previous">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="pagination__ellipsis">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <button class="pagination__btn active" aria-current="page">{{ $page }}</button>
                @else
                    <button wire:click="gotoPage({{ $page }})" class="pagination__btn">{{ $page }}</button>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <button wire:click="nextPage" class="pagination__btn" aria-label="Next">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
    @else
        <button class="pagination__btn" disabled aria-label="Next" aria-disabled="true">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
    @endif

</div>
@endif