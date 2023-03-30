@extends('Frontend.Layouts.frontendlayout')
@section('content')
<div class="image-cover page-title">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <h2 class="ipt-title">Agent Detail</h2>
     

         </div>
      </div>
   </div>
</div>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Agency Name Start================================== -->
<section class="agent-page p-0 gray-simple">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="agency agency-list overlio-40">

               <div class="agency-avatar">
                  @if($agents[0]['agent_photo']==null)
                  <img src="{{$agentimage}}{{$defaultimage[0]}}" alt="">
                  @else
                  <img src="{{$agentimage}}{{$agents[0]['agent_photo']??''}}" alt="">
                  @endif
                 
               </div>

               <div class="agency-content">
                  <div class="agency-name">
                     <h4><a href="#">{{$agents[0]['full_name']??''}}</a></h4>
                     <!-- <span><i class="lni-map-marker"></i>{{$agents[0]['address']??''}}</span> -->
                  </div>

                  <div class="agency-desc">
                  <p>{{$agents[0]['user_description']??''}}</p>
                  </div>

                  <div class="prt-detio">
                      @php
                          $count=DB::table('users')->join('property','property.agent_id','=','users.user_id')
                     ->where('users.user_id',$agents[0]['user_id'])
                    ->count();
                      @endphp
                     <span>{{$count}} Property</span>
                  </div>

                  <ul class="social-icons">
                     <li><a class="facebook" href="#"><i class="lni-facebook"></i></a></li>
                     <li><a class="twitter" href="#"><i class="lni-twitter"></i></a></li>
                     <li><a class="linkedin" href="#"><i class="lni-instagram"></i></a></li>
                     <li><a class="linkedin" href="#"><i class="lni-linkedin"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
               </div>

            </div>
         </div>
      </div>
   </div>
</section>
<!-- ============================ Agency Name ================================== -->

<!-- ============================ About Agency ================================== -->
<section class="min gray-simple">
   <div class="container">
      <div class="row">

         <!-- property main detail -->
         <div class="col-lg-8 col-md-12 col-sm-12">

            <!-- Single Block Wrap -->
            <div class="block-wrap">

               <div class="block-header">
                  <h4 class="block-title">Agent Info</h4>
               </div>

               <div class="block-body">
                  <ul class="dw-proprty-info">
                     <li><strong>Name</strong>{{$agents[0]['full_name']??''}}</li>
                     
                     
                     @php
                          $count=DB::table('town')
             ->where('town.town_id',$agents[0]['town_id'])->first();
                      
                      @endphp
                     <li><strong>City</strong>{{$count->town_name??''}}</li>


                     <li><strong>Phone</strong>{{$agents[0]['phone_1']??''}}</li>
                     

              

               
                     <li><strong>Email</strong>{{$agents[0]['user_email']??''}}</li>






                  </ul>
               </div>

            </div>

            <!-- Single Block Wrap -->
            <div class="block-wraps">
               <div class="block-wraps-header">

                  <div class="block-header">
                     <ul class="nav nav-tabs customize-tab" id="myTab" role="tablist">
                       <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="rental-tab" data-bs-toggle="tab" href="#rental" role="tab" aria-controls="rental" aria-selected="true">Rental</a>
                       </li>
                       <li class="nav-item" role="presentation">
                        <a class="nav-link" id="sale-tab" data-bs-toggle="tab" href="#sale" role="tab" aria-controls="sale" aria-selected="false">For Sale</a>
                       </li>
                     </ul>
                  </div>

                  <div class="block-body">
                     <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="rental" role="tabpanel" aria-labelledby="rental-tab">
                           <!-- row -->
                           <div class="row">
                              <!-- Single Property -->
                             @php
                                 $prop=DB::table('property')
->join('product_category','product_category.product_category_id','=','property.product_category_id')
->join('property_images','property_images.property_id','=','property.id')

 ->where('property_images.type','Image')
 ->where('property_images.isDefault',1)

         ->where('property.agent_id',$agents[0]['user_id'])

         ->where('product_category.product_category_name','For Rent')->get();

                   
                             @endphp

                               @foreach($prop as $prop)
                              
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                 <div class="property-listing property-2">

                                    <div class="listing-img-wrapper">
                                       <div class="list-img-slide">
                                          <div class="clicks">
                                             <div><img src="{{$path}}{{$prop->images_video}}" class="img-fluid mx-auto" alt="" /></div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="listing-detail-wrapper">
                                       <div class="listing-short-detail-wrap">
                                          <div class="listing-short-detail">
                                             <span class="property-type">For Rent</span>
                                             <h4 class="listing-name verified"><a href="{{route('single-property',$prop->slug)}}" class="prt-link-detail">{{$prop->property_name}}</a></h4>
                                          </div>
                                          <div class="listing-short-detail-flex">
                                             <h6 class="listing-card-info-price">${{$prop->price_asked}}</h6>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="price-features-wrapper">
                                       <div class="list-fx-features">
                                          <div class="listing-card-info-icon">
                                             <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bed.svg" width="13" alt="" /></div>{{$prop->no_bedrooms}} Beds
                                          </div>
                                          <div class="listing-card-info-icon">
                                             <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bathtub.svg" width="13" alt="" /></div>{{$prop->no_toilets}}Bath
                                          </div>
                                          <div class="listing-card-info-icon">
                                             <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/move.svg" width="13" alt="" /></div>{{$prop->no_toilets}} sqft
                                          </div>
                                       </div>
                                    </div>

                                    <div class="listing-detail-footer">
                                       <div class="footer-first">
                                          <div class="foot-location"><img src="{{url('/')}}/assets/frontend/img/pin.svg" width="18" alt="" />{{$prop->building_area}}</div>
                                       </div>
                                       <div class="footer-flex">
                                          <a href="{{route('single-property',$prop->slug)}}" class="prt-view">View</a>
                                       </div>
                                    </div>

                                 </div>
                              </div>
                                 @endforeach
                              <!-- End Single Property -->

                              <!-- Single Property -->

                              <!-- End Single Property -->
                           </div>
                           <!-- // row -->

                           <div class="row">
                              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                 <a href="{{route('propertylist')}}" class="btn btn-theme-light-2 rounded">Explore More Property</a>
                              </div>
                           </div>

                        </div>

                        <div class="tab-pane fade" id="sale" role="tabpanel" aria-labelledby="sale-tab">
                           <!-- row -->
                           <div class="row">
                              <!-- Single Property -->

                               @php
                                   $propsale=DB::table('property')
->join('product_category','product_category.product_category_id','=','property.product_category_id')
   ->join('property_images','property_images.property_id','=','property.id')

     ->where('property_images.type','Image')
     ->where('property_images.isDefault',1)

             ->where('property.agent_id',$agents[0]['user_id'])

             ->where('product_category.product_category_name','For Sale')->get();

                               @endphp

                               @foreach($propsale as $prop)
                             
                                   <div class="col-lg-6 col-md-6 col-sm-12">
                                       <div class="property-listing property-2">

                                           <div class="listing-img-wrapper">
                                               <div class="list-img-slide">
                                                   <div class="clicks">
                                                       <div><img src="{{$path}}{{$prop->images_video}}" class="img-fluid mx-auto" alt="" /></div>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="listing-detail-wrapper">
                                               <div class="listing-short-detail-wrap">
                                                   <div class="listing-short-detail">
                                                       <span class="property-type">For Sale</span>
                                                       <h4 class="listing-name verified"><a href="{{route('single-property',$prop->slug)}}" class="prt-link-detail">{{$prop->property_name}}</a></h4>
                                                   </div>
                                                   <div class="listing-short-detail-flex">
                                                       <h6 class="listing-card-info-price">${{$prop->price_asked}}</h6>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="price-features-wrapper">
                                               <div class="list-fx-features">
                                                   <div class="listing-card-info-icon">
                                                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bed.svg" width="13" alt="" /></div>{{$prop->no_bedrooms}} Beds
                                                   </div>
                                                   <div class="listing-card-info-icon">
                                                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/bathtub.svg" width="13" alt="" /></div>{{$prop->no_toilets}}Bath
                                                   </div>
                                                   <div class="listing-card-info-icon">
                                                       <div class="inc-fleat-icon"><img src="{{url('/')}}/assets/frontend/img/move.svg" width="13" alt="" /></div>{{$prop->no_toilets}} sqft
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="listing-detail-footer">
                                               <div class="footer-first">
                                                   <div class="foot-location"><img src="{{url('/')}}/assets/frontend/img/pin.svg" width="18" alt="" />{{$prop->building_area}}</div>
                                               </div>
                                               <div class="footer-flex">
                                                   <a href="{{route('single-property',$prop->slug)}}" class="prt-view">View</a>
                                               </div>
                                           </div>

                                       </div>
                                   </div>
                           @endforeach
                              <!-- End Single Property -->


                              <!-- End Single Property -->

                           </div>
                           <!-- // row -->

                           <div class="row">
                              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                 <a href="#" class="btn btn-theme-light-2 rounded">Explore More Property</a>
                              </div>
                           </div>

                        </div>

                     </div>
                  </div>

               </div>
            </div>
         </div>

         <!-- property Sidebar -->
         <div class="col-lg-4 col-md-12 col-sm-12">

            <div class="details-sidebar">

               <!-- Agent Detail -->
               <div class="sides-widget">
                  <div class="sides-widget-header">
             
                     <div class="agent-photo">
                        @if($agents[0]['agent_photo']==null)
                        <img src="{{$agentimage}}{{$defaultimage[0]}}" alt="">
                        @else
                        <img src="{{$agentimage}}{{$agents[0]['agent_photo']??''}}" alt="">
                        @endif
                     </div>
                     <div class="sides-widget-details">
                        <h4><a href="#">Contact</a></h4>
                        <span><i class="lni-phone-handset"></i>{{$agents[0]['phone_1']}}</span>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                   <form  id="agentenquiry" method="POST" action="{{ route('agentenquiry') }}">
                       @csrf
                  <div class="sides-widget-body simple-form">
                      <input type="hidden" value="{{$agents[0]['user_id']}}" name="agent_ids">
                      <div class="form-group">
                          <label>Email</label>

                          <input type="text" class="form-control"  name="email">
                          <i class="mdi mdi-check-circle-outline" id="email_err"></i>
                      </div>
                      <div class="form-group">
                          <label>Phone No.</label>
                          <input type="text" class="form-control" id="fullphone" name="phone" maxlength="12" id="propenqphone">
                          <i class="mdi mdi-check-circle-outline" id="phone_err"></i>
                      </div>
                      <div class="form-group">
                          <label>Description</label>
                          <textarea  name="description" class="form-control"></textarea>
                          <i class="mdi mdi-check-circle-outline" id="description_err"></i>
                      </div>
                     <button  id="btn_reg2" type="submit" class="btn btn-black btn-md rounded full-width">Send Message</button>
                  </div>
                   </form>
               </div>
               <!-- Featured Property -->
               <div class="sidebar-widgets">

                  <h4>Featured Property</h4>

                  <div class="sidebar_featured_property">

                     <!-- List Sibar Property -->
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


                  </div>

               </div>

            </div>

         </div>

      </div>
   </div>
</section>
<!-- ============================ About Agency End ================================== -->
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

    $(document).on('submit', '#agentenquiry', function (e) {
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
                $('#btn_reg2').html('Processing...');
            },
            success: function (response) {
                if ((response.status == 'success')) {
                    $('#agentenquiry')[0].reset();
                    toastr.success(response.msg);
                }
                else {
                    printErrorMsg(response.error);

                }
            },
            complete:function (data){
                $('#btn_reg2').html('Send Message');
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

<!-- ============================ Call To Action ================================== -->


<script type="text/javascript">
        $(function () {
            $('#fullphone').keypress(function (e) {
                let myArray = [];
        for (i = 48; i < 58; i++) myArray.push(i);
          if (!(myArray.indexOf(e.which) >= 0)) e.preventDefault();
            });
        });
    </script>
@endsection
