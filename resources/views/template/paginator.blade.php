@if ($paginator->hasPages())
    <nav>
        <ul class="container__paginator">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            @else
            <a href="{{ url($paginator->previousPageUrl()) }}"><ion-icon name="caret-back-outline" id="paginator"></ion-icon></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <a href="{{ url($url) }}"><li>{{ $page }}</li></a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ url($paginator->nextPageUrl()) }}"><ion-icon name="caret-forward-outline" id="paginator"></ion-icon></a>
            @endif
        </ul>
    </nav>
@endif
