<section>
    <div class="container">
 
 
 
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10 text-center">
                <div class="sec-heading center mb-4">
                    <h2>Recent Property</h2>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
                </div>
            </div>
        </div>
 
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="property-slide">
                
                @if($allFeaturedProperty!==null)

                
                
                @foreach($allFeaturedProperty as $all)
                  
           
               
                    <div class="single-items">
                        <div class="property-listing shadow-none property-2 border">
                              
                            <div class="listing-img-wrapper">
                                <div class="_exlio_125">$ {{$all->price_asked??''}}</div>
                                <div class="list-img-slide">
                                    <div class="click">
                                     
         
                                      
                                   
                                      
                                        <div><a href="{{route('single-property',$all->slug??'')}}">
                                           
                                            <img src="{{$path}}{{$all->images_video??''}}" class="img-fluid mx-auto" alt="" /></a>
                                         
                                        </div>
                                      
                                        
                                      
                                    </div>
                                </div>
                            </div>
 
                            <div class="listing-detail-wrapper">
                                <div class="listing-short-detail-wrap">
                                    <div class="listing-short-detail">
                                        @if($all->product_category_name=="For Rent")
                                        <span class="property-type elt_rent">{{$all->product_category_name??''}}</span>
                                        @else
                                        <span class="property-type elt_sale">{{$all->product_category_name??''}}</span>
                                        @endif
                                      
                                        <h4 class="listing-name verified"><a href="{{route('single-property',$all->slug)}}" class="prt-link-detail">{{$all->property_headline??''}}</a></h4>
                                    </div>
                                    <div class="listing-short-detail-flex">
                                        <div class="prt_saveed_12lk">
                                            <label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
 
                            <div class="price-features-wrapper">
                                <div class="list-fx-features">
                                    <div class="listing-card-info-icon">
                                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bed.svg" width="13" alt="" /></div>{{$all->no_bedrooms??''}} Beds
                                    </div>
                                    <div class="listing-card-info-icon">
                                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bathtub.svg" width="13" alt="" /></div>{{$all->no_toilets??''}}  Bath
                                    </div>
                                    <div class="listing-card-info-icon">
                                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/move.svg" width="13" alt="" /></div>{{$all->land_area??''}} sqft
                                    </div>
                                </div>
                            </div>
 
                            <div class="listing-detail-footer">
                                <div class="footer-first">
                                    <div class="foot-location"><img src="{{url('/')}}/assets/frontend/img/pin.svg" width="18" alt="" />{{$all->street_name??''}}</div>
                                </div>
                                <div class="footer-flex">
                                    <a href="{{route('single-property',$all->slug??'')}}" class="prt-view">View</a>
                                </div>
                            </div>
 
                        </div>
                    </div>
                    @endforeach
                    <!-- Single Property -->
                   @else
                   <div class="row">
               <div class="col-lg-12 col-md-12">
               <div class="listing-detail-footer">
                                <div class="footer-first">
                                    <div class="foot-location"><img src="{{url('/')}}/assets/frontend/img/pin.svg" width="18" alt="" />{{$all->street_name??''}}</div>
                                </div>
                                <div class="footer-flex">
                                    <a href="{{route('single-property',$all->slug??'')}}" class="prt-view">View</a>
                                </div>
                            </div>
                 </div>           
                   </div>
                   @endif
                    <!-- Single Property -->
                  
                    <!-- Single Property -->
                  
 
                </div>
            </div>
        </div>
 
    </div>
 </section>