@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a href="" class="btn btn-disabled btn-sm pagination__prev">
                    <?php include "assets/website/img/arrow-prev.svg" ?>
                    <span>Prev</span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-white btn-sm pagination__prev" rel="prev" aria-label="@lang('pagination.previous')">
                    <?php include "assets/website/img/arrow-prev.svg" ?>
                    <span>Prev</span>
                </a>
            </li>
        @endif
        <ul class="pagination__list">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="pagination__list-dots" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-white btn-sm pagination__next" rel="next" aria-label="@lang('pagination.next')">
                    <span>Next</span>
                    <?php include "assets/website/img/arrow-next.svg" ?>
                </a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a href="#" class="btn btn-disabled btn-sm pagination__next">
                    <span>Next</span>
                    <?php include "assets/website/img/arrow-next.svg" ?>
                </a>
            </li>
        @endif
    </nav>
@endif
