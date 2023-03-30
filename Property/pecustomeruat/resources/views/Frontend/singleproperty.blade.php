@extends('Frontend.Layouts.frontendlayout')
@section('content')
<div class="featured_slick_gallery gray">

   @php
   $path=Utils();

   @endphp

   <div class="featured_slick_gallery-slide">
      @foreach ($property_images as $propertyi)

      <div class="featured_slick_padd"><a href="{{$path}}{{$propertyi->images_video}}" class="mfp-gallery"><img src="{{$path}}{{$propertyi->images_video}}" class="img-fluid mx-auto" alt="" /></a></div>
      @endforeach


   </div>
   <!-- <a href="JavaScript:Void(0);" class="btn-view-pic">View photos</a> -->


</div>
<!-- ============================ Hero Banner End ================================== -->

<!-- ============================ Property Detail Start ================================== -->
<section class="gray-simple">
   <div class="container">
      <div class="row">

         <!-- property main detail -->
         <div class="col-lg-8 col-md-12 col-sm-12">

            <div class="property_block_wrap style-2 p-4">
               <div class="prt-detail-title-desc">
                  @if($property->ProductCategory->product_category_name=='For Rent')
                  <span class="prt-types rent">{{$property->ProductCategory->product_category_name}}</span>
                  @else
                  <span class="prt-types sale">{{$property->ProductCategory->product_category_name}}</span>
                  @endif
                  <h3>{{$property->property_name}}</h3>
                  <span><i class="lni-map-marker"></i>{{$property->street_name??''}}</span>
				      @if($property->ProductCategory->product_category_name=='For Sale')
				      <h3 class="prt-price-fix">${{$property->price_asked}}<sub></sub></h3>
				   @else
				      <h3 class="prt-price-fix">${{$property->price_asked}}<sub>/month</sub></h3>
				   @endif
                 
                  <div class="list-fx-features">
                     <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bed.svg" width="13" alt=""></div> {{$property->no_bedrooms}} Beds
                     </div>
                     <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bathtub.svg" width="13" alt=""></div> {{$property->no_toilets}} Bath
                     </div>
                     <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/move.svg" width="13" alt=""></div>{{$property->land_area}} sqft
                     </div>
                  </div>
               </div>
            </div>

            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#features" data-bs-target="#clOne" aria-controls="clOne" href="javascript:void(0);" aria-expanded="false"><h4 class="property_block_title">Detail & Features</h4></a>
               </div>
               <div id="clOne" class="panel-collapse collapse show" aria-labelledby="clOne">
                  <div class="block-body">
                     <ul class="deatil_features">
                        <li><strong>Bedrooms:</strong>{{$property->no_bedrooms??''}} Beds</li>
                        <li><strong>Bathrooms:</strong>{{$property->no_toilets??''}} Bath</li>
                        <li><strong>Areas:</strong>{{$property->land_area??''}} sq ft</li>
                        <li><strong>Garage</strong>{{$property->garage??''}}</li>

                        <li><strong>Property Type:</strong> {{$property->PropertyType->property_type}}</li>
                        <li><strong>Year:</strong>Built {{$property->year??''}}</li>
                        <li><strong>Cooling:</strong>{{$property->cooling??''}}</li>
                        <li><strong>Heating Type:</strong>{{$property->heatingtype??''}}</li>
                        <li><strong>Kitchen Features:</strong>{{$property->kitchen??''}}</li>
                        <li><strong>Exterior:</strong>{{$property->exteriour??''}}</li>
{{--                        <li><strong>Swimming Pool:</strong>Yes</li>--}}
                        <li><strong>Elevetor:</strong>{{$property->elevator}}</li>
                        <li><strong>Fireplace:</strong>{{$property->fireplace??''}}</li>
                        <li><strong>Free WiFi:</strong>{{$property->freewifi??''}}</li>

                     </ul>
                  </div>
               </div>

            </div>

            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo" aria-controls="clTwo" href="javascript:void(0);" aria-expanded="true"><h4 class="property_block_title">Description</h4></a>
               </div>
               <div id="clTwo" class="panel-collapse collapse show">
                  <div class="block-body">
                     <p>{!!$property->property_description!!}</p>
                  </div>
               </div>
            </div>

            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#amen"  data-bs-target="#clThree" aria-controls="clThree" href="javascript:void(0);" aria-expanded="true"><h4 class="property_block_title">Ameneties</h4></a>
               </div>

               <div id="clThree" class="panel-collapse collapse show">
                  <div class="block-body">
                     <ul class="avl-features third color">
                        @foreach($property_amenities as $prop)
                        <li>{{$prop->name}}</li>
                         @endforeach
                     </ul>
                  </div>
               </div>
            </div>

            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#vid"  data-bs-target="#clFour" aria-controls="clFour" href="javascript:void(0);" aria-expanded="true" class="collapsed"><h4 class="property_block_title">Property video</h4></a>
               </div>
              @foreach ($property_video as $video)

               <div id="clFour" class="panel-collapse collapse">
                  <div class="block-body">
                     <div class="property_video">
                        <div class="thumb">
                           <img class="pro_img img-fluid w100" src="{{url('/')}}/assets/frontend/img/p-6.jpg" alt="7.jpg">
                           <div class="overlay_icon">
                              <div class="bb-video-box">
                                 <div class="bb-video-box-inner">
                                    <div class="bb-video-box-innerup">
                                       <a  data-src="{{$video->images_video}}" href="{{$video->images_video}}" data-bs-toggle="modal" target="_blank"><i class="ti-control-play"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               @endforeach
            </div>

            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#floor"  data-bs-target="#clFive" aria-controls="clFive" href="javascript:void(0);" aria-expanded="true" class="collapsed"><h4 class="property_block_title">Floor Plan</h4></a>
               </div>

               <div id="clFive" class="panel-collapse collapse">
                  <div class="block-body">
                     <div class="accordion" id="floor-option">
                       
                        <div class="card">
                           
                           <div class="card-header" id="firstFloor">
													<h2 class="mb-0">
														<button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#firstfloor" aria-controls="firstfloor">Land Area<span>{{$property->land_area??''}} Sq M</span></button>									
													</h2>
												</div>

                        </div>


                        <div class="card">
                              @if($property->building_area!=null)
                              <div class="card-header" id="firstFloor">
													<h2 class="mb-0">
														<button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#firstfloor" aria-controls="firstfloor">Building Area<span>{{$property->building_area??''}} Sq M</span></button>									
													</h2>
												</div>
                              @else
                            
                              @endif
                           

                        </div>
                       


                     </div>
                  </div>
               </div>

            </div>


            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

               <div class="property_block_wrap_header">
                  <a data-bs-toggle="collapse" data-parent="#clSev"  data-bs-target="#clSev" aria-controls="clOne" href="javascript:void(0);" aria-expanded="true" class="collapsed"><h4 class="property_block_title">Gallery</h4></a>
               </div>

               <div id="clSev" class="panel-collapse collapse">
                  <div class="block-body">
                     <ul class="list-gallery-inline">
                        @foreach ($property_images as $gallery)
                        <li>
                           <a href="{{$path}}{{$gallery->images_video}}" class="mfp-gallery"><img src="{{$path}}{{$gallery->images_video}}" class="img-fluid mx-auto" alt="" /></a>
                        </li>
                        @endforeach

                     </ul>
                  </div>
               </div>

            </div>
            <!-- map location -->
            <div class="property_block_wrap style-2">
            <div class="map-area " id="map" style="width: 100%; height: 400px;" >
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26361414.263400003!2d-113.75849480805297!3d36.24080384347216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1632292334947!5m2!1sen!2sin" allowfullscreen="" loading="lazy" ></iframe>
            </div>

            </div>

         </div>

         <!-- property Sidebar -->
         <div class="col-lg-4 col-md-12 col-sm-12">

            <!-- Like And Share -->
            <div class="like_share_wrap b-0">
               <ul class="like_share_list">
                  <!--<li><a href="JavaScript:Void(0);" class="btn btn-likes" data-toggle="tooltip" data-original-title="Share"><i class="fas fa-share"></i>Share</a></li>-->
                  <!-- <li><a href="JavaScript:Void(0);" class="btn btn-likes" data-toggle="tooltip" data-original-title="Save"><i class="fas fa-heart"></i>Save</a></li> -->
               </ul>
            </div>

            <div class="details-sidebar">

               <!-- Agent Detail -->
               <div class="sides-widget">
                  <div class="sides-widget-header">
                     <div class="agent-photo"><img src="{{$agentimage}}{{$phone->agent_photo}}" alt=""></div>
                     <div class="sides-widget-details">
                        <h4><a href="#">Contact</a></h4>
                               @foreach($property->PropertyAgent as $p)

                               <input type="hidden" name="property_id" value="{{$p->user_id}}">
                                @endforeach
{{--                         phone received from single property function--}}
                               <span><i class="lni-phone-handset"></i>{{$phone->phone_1??''}} </span>

                     </div>
                     <div class="clearfix"></div>
                  </div>
                   <form  id="enquiry" method="POST" action="{{ route('property-enquiry') }}">
                       @csrf
                  <div class="sides-widget-body simple-form">
                      <input type="hidden" name="agent_id" value="{{$p->user_id??''}}">
                      <input type="hidden" name="property_id" value="{{$property->id??''}}">
                     <div class="form-group">
                        <label>Email</label>

                        <input type="text" class="form-control" placeholder="Your Email" name="email">
                         <i class="mdi mdi-check-circle-outline" id="email_err"></i>
                     </div>
                     <div class="form-group">
                        <label>Phone No.</label>
                        <input type="text" class="form-control" maxlength="12" placeholder="Your Phone" name="phone" id="mainphone">
                         <i class="mdi mdi-check-circle-outline" id="phone_err"></i>
                     </div>
                     <div class="form-group">
                        <label>Description</label>
                        <textarea  name="description" class="form-control"></textarea>
                         <i class="mdi mdi-check-circle-outline" id="description_err"></i>
                     </div>
                     <button id="btn_reg1" type="submit" class="btn btn-black btn-md rounded full-width">Send Message</button>
                  </div>
                   </form>
               </div>


               <!-- Featured Property -->
               <div class="sidebar-widgets">

                  <h4>Featured Property</h4>

                  <div class="sidebar_featured_property">
                      @foreach($propertyfeatured as $p)
                     @php
                     $db=DB::table('property_images')->where('property_id',$p['id'])->where('type','Image')->first();

                     @endphp

                     <div class="sides_list_property">


                        <div class="sides_list_property_thumb">
                           <img src="{{$path}}{{$db->images_video??''}}" class="img-fluid" alt="">
                        </div>

                        <div class="sides_list_property_detail">
                           <h4><a href="{{route('single-property',$p->slug)}}">{{$p->property_headline}}</a></h4>
                        
                           <div class="lists_property_price">
                              <div class="lists_property_types">
                                 <div class="property_types_vlix sale">{{$p->ProductCategory->product_category_name}}</div>
                              </div>
                              <div class="lists_property_price_value">
                                 <h4>${{$p->price_asked}}</h4>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     <!-- List Sibar Property -->
                     {{-- <div class="sides_list_property">
                        <div class="sides_list_property_thumb">
                           <img src="{{url('/')}}/assets/frontend/img/p-4.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="sides_list_property_detail">
                           <h4><a href="single-property-1.html">Montreal Quriqe Apartment</a></h4>
                           <span><i class="ti-location-pin"></i>Liverpool, London</span>
                           <div class="lists_property_price">
                              <div class="lists_property_types">
                                 <div class="property_types_vlix">For Rent</div>
                              </div>
                              <div class="lists_property_price_value">
                                 <h4>$7,380</h4>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- List Sibar Property -->
                     <div class="sides_list_property">
                        <div class="sides_list_property_thumb">
                           <img src="{{url('/')}}/assets/frontend/img/p-7.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="sides_list_property_detail">
                           <h4><a href="single-property-1.html">Curmic Studio For Office</a></h4>
                           <span><i class="ti-location-pin"></i>Montreal, Canada</span>
                           <div class="lists_property_price">
                              <div class="lists_property_types">
                                 <div class="property_types_vlix buy">For Buy</div>
                              </div>
                              <div class="lists_property_price_value">
                                 <h4>$8,730</h4>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- List Sibar Property -->
                     <div class="sides_list_property">
                        <div class="sides_list_property_thumb">
                           <img src="{{url('/')}}/assets/frontend/img/p-5.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="sides_list_property_detail">
                           <h4><a href="single-property-1.html">Montreal Quebec City</a></h4>
                           <span><i class="ti-location-pin"></i>Sreek View, New York</span>
                           <div class="lists_property_price">
                              <div class="lists_property_types">
                                 <div class="property_types_vlix">For Rent</div>
                              </div>
                              <div class="lists_property_price_value">
                                 <h4>$6,240</h4>
                              </div>
                           </div>
                        </div>
                     </div> --}}

                  </div>

               </div>

            </div>
         </div>

      </div>
   </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                    </button>
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>


                </div>

            </div>
        </div>
    </div>



    </div>



    </div>
</section>
<!-- ============================ Property Detail End ================================== -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNvtVwYvql-1rAft1n6X7AjNVItRUacRQ"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initialize();
        });
        var labels = 'i';

        function initialize() {
            var lat = '{{$property->latitude??''}}';
            var lng = '{{$property->longitude??''}}';
            var latlng = new google.maps.LatLng(lat, lng);
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                center: latlng
            });

            google.maps.event.addListener(map, 'click', function (event) {
                addMarker(event.latlng, map);

            });
            addMarker(latlng, map);
        }

        function addMarker(location, map) {
            var marker = new google.maps.Marker({
                position: location,
                label: labels,
                map: map
            });
            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
        }

        var contentString = '<div id="content">' +
            '<h5>' + '{{$property->street_name??''}}' + '</h5>' + '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        </script>
<script>

    $(document).ready(function() {

        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': false,
            'progressBar': true,
            'preventDuplicates': false,
            'showDuration': '6000',
            'hideDuration': '6000',
            'timeOut': '1500',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        } });
</script>
    <script>

        $(document).on('submit', '#enquiry', function (e) {
        e.preventDefault();
        let form = $(this);
        let submit_btn = form.find('button[type=submit]');
        let formData = new FormData(this);
        $.ajax({
        type: 'post',
        dataType: 'json',
        url: form.attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        beforeSend:function (){
        $('#btn_reg1').html('Processing...');
    },
        success: function (response) {
        if ((response.status == 'success')) {
        $('#enquiry')[0].reset();
        toastr.success(response.msg);
    }
        else {
        printErrorMsg(response.error);

    }
    },
        complete:function (data){
        $('#btn_reg1').html('Send Message');
    },

    });

    });
        function printErrorMsg(msg) {
        $.each(msg, function (key, value) {
            $('#' + key + '_err').attr('class',' mdi mdi-check-circle-outline text-danger').text(value);

        });

        $('input').on('keyup', function () {
        var key = $(this).attr('name');

        if ($(this).val() === '') {
        $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
    } else {
        $('#' + key + '_err').hide();
    }
    })
        $('textarea').on('keyup', function () {
        var key = $(this).attr('name');
        if ($(this).val() === '') {
        $('#' + key + '_err').attr('class','mdi mdi-check-circle-outline text-danger').show();
    } else {
        $('#' + key + '_err').hide();
    }
    })
    }
</script>
<script>
    $(document).ready(function() {

// Gets the video src from the data-src on each button

        var $videoSrc;
        $('.video-btn').click(function() {
            $videoSrc = $(this).data( "src" );
        });
        console.log($videoSrc);



// when the modal is opened autoplay it
        $('#myModal').on('shown.bs.modal', function (e) {

// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
            $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0&output=embed" );
        })



// stop playing the youtube video when I close the modal
        $('#myModal').on('hide.bs.modal', function (e) {
            // a poor man's stop video
            $("#video").attr('src',$videoSrc);
        })






// document ready
    });
</script>

<!-- ============================ Call To Action ================================== -->

@endsection
