@if ($paginator->hasPages())
    <nav class="govuk-body" role="navigation" aria-label="Pagination">
        <div class="pagination__summary">
          Showing {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </div>
        <ul class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pagination__link" aria-hidden="true">&laquo; Previous</span>
                </li>
            @else
                <li class="pagination__item">
                    <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo; Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item" aria-current="page"><span class="pagination__link current">{{ $page }}</span></li>
                        @else
                            <li class="pagination__item"><a class="pagination__link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__item">
                    <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next &raquo;</a>
                </li>
            @else
                <li class="pagination__item" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pagination__link" aria-hidden="true">Next &raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
