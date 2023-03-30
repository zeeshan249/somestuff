        <div class="row">
        @if ($paginator->hasPages())
								<div class="col-md-12">
									<ul class="pagination lms-page">
                                        @if ($paginator->onFirstPage())
										<li class="page-item prev disabled">
											<a class="page-link" href="javascript:void(0)" tabindex="-1"><i class="fas fa-angle-left"></i></a>
										</li>
                                        @else
                                        <li class="page-item prev ">
											<a class="page-link" data-page="{{ $paginator->currentPage() -1 }}" href="{{ $paginator->previousPageUrl() }}" tabindex="-1"><i class="fas fa-angle-left"></i></a>
										</li>
                                       @endif
                                       @foreach ($elements as $element)
                                       @if (is_string($element))
                                        <li class="page-item  disabled">
											{{$element}}
										</li>
                                       @endif

	 							       <!-- <li class="page-item first-page active">
											<a class="page-link" href="javascript:void(0)">1</a>
										</li> -->
                                        @if (is_array($element))
                          @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <li class="page-item first-page active">
											<a class="page-link" data-page="{{ $page }}" href="{{$url}}">{{$page}}</a>
										</li>
                            @else
                                     <li class="page-item">
											<a class="page-link" data-page="{{ $page }}" href="{{$url}}">{{$page}}</a>
										</li>
                          @endif
                          @endforeach
                          @endif
                         




                                     @endforeach
                                        @if ($paginator->hasMorePages())
										<li class="page-item next">
											<a class="page-link" data-page="{{ $paginator->currentPage()+1 }}" href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
										</li>
                                        @else
                                    	<li class="page-item next disabled">
											<a class="page-link" data-page="{{ $paginator->currentPage() }}" href="{{ $paginator->currentPage() }}"><i class="fas fa-angle-right"></i></a>
										</li>
                                        @endif
                                    </ul>
								</div>
                                @endif 
							</div>