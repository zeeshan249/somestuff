
@php
$path=Utils();

@endphp

@foreach($propertyfeatured as $getFeatured)
<div class="col-lg-6 col-md-12">


   <div class="property-listing property-1">

       <div class="listing-img-wrapper">
           <a href="{{route('single-property',$getFeatured->slug??'')}}">
       




               <img src="{{$path}}{{$getFeatured->images_video??''}}" class="img-fluid mx-auto" alt="" />


           </a>
       </div>

       <div class="listing-content">


           <div class="listing-detail-wrapper-box">
               <div class="listing-detail-wrapper">
                   <div class="listing-short-detail">
                       <h4 class="listing-name"><a href="{{route('single-property',$getFeatured->slug??'')}}">{{$getFeatured->property_headline??''}}</a></h4>
                       <div class="fr-can-rating">
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star"></i>
                           <span class="reviews_text">(42 Reviews)</span>
                       </div>
                       @if($getFeatured->product_category_name=="For Rent")
                       <span class="prt-types rent">{{$getFeatured->product_category_name??''}}</span>
                       @else
                       <span class="prt-types sale">{{$getFeatured->product_category_name??''}}</span>
                       @endif

                   </div>
                   <div class="list-price">
                       <h6 class="listing-card-info-price">${{$getFeatured->price_asked??''}}</h6>
                   </div>
               </div>
           </div>

           <div class="price-features-wrapper">
               <div class="list-fx-features">
                   <div class="listing-card-info-icon">
                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bed.svg" width="13" alt="" /></div>3 Beds
                   </div>
                   <div class="listing-card-info-icon">
                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bathtub.svg" width="13" alt="" /></div>1 Bath
                   </div>
                   <div class="listing-card-info-icon">
                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/move.svg" width="13" alt="" /></div>800 sqft
                   </div>
               </div>
           </div>

           <div class="listing-footer-wrapper">
               <div class="listing-locate">
                   <span class="listing-location"><i class="ti-location-pin"></i>{{$getFeatured->street_name??''}}</span>
               </div>
               <div class="listing-detail-btn">
                   <a href="{{route('single-property',$getFeatured->slug)}}" class="more-btn">View</a>
               </div>
           </div>


       </div>

   </div>

</div>
@endforeach
<!-- Single Property End -->


<!-- Single Property End -->

</div>

<!-- Pagination -->
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 text-center">
   <a href="{{route('propertylist')}}" class="btn btn-theme-light rounded">Browse More Properties</a>
</div>
</div>
