<div class="row">
    @if ($paginator->hasPages())
    <div class="col-lg-12 col-md-12 col-sm-12">
        <ul class="pagination p-center">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link"  href="#" aria-label="Previous">
                    <span class="ti-arrow-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" data-page="{{ $paginator->currentPage() -1 }}" href="javascript:void(0);" aria-label="Previous">
                    <span class="ti-arrow-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @endif

            @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">{{ $element }}</li>
            @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
            <li class="page-item active">
                <a class="page-link active" data-page="{{ $page }}"  href="javascript:void(0);">{{ $page }}</a>
            </li>
                        @else
                            <li class="page-item " >
                                <a class="page-link " data-page="{{ $page }}"  href="javascript:void(0);">{{ $page }}</a>
                            </li>
                            @endif

                    @endforeach
                @endif
                @endforeach
{{--            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--            <li class="page-item active"><a class="page-link" href="#">3</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="#">...</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="#">18</a></li>--}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" data-page="{{ $paginator->currentPage()+1 }}" href="javascript:void(0);" aria-label="Next">
                        <span class="ti-arrow-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" data-page="{{ $paginator->currentPage() }}" href="javascript:void(0);" aria-label="Next">
                        <span class="ti-arrow-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
        @endif

