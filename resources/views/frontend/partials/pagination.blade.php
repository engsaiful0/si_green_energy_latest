{{-- Slaze "theme__pagination" for a LengthAwarePaginator: $paginator->links('frontend.partials.pagination') --}}
@if($paginator->hasPages())
<div class="row mt-50">
    <div class="col-xl-12">
        <div class="theme__pagination">
            <ul>
                @if(!$paginator->onFirstPage())
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous"><i class="fa-regular fa-angle-left"></i></a></li>
                @endif

                @foreach($elements as $element)
                    @if(is_string($element))
                        <li><a><i class="far fa-ellipsis-h"></i></a></li>
                    @endif
                    @if(is_array($element))
                        @foreach($element as $page => $url)
                        <li><a class="{{ $page == $paginator->currentPage() ? 'active' : '' }}" href="{{ $url }}"
                               @if($page == $paginator->currentPage()) aria-current="page" @endif>{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                        @endforeach
                    @endif
                @endforeach

                @if($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"><i class="fa-regular fa-angle-right"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endif
