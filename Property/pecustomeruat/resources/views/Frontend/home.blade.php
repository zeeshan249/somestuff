@extends('Frontend.Layouts.frontendlayout')
@section('content')
 <style>
    .filtertext{
        margin-top:40px;
        margin-left:10px;
    }
    .slide{
        margin-bottom:13px;
    }
    #ft{
        margin-right:20px;
        margin-top:10px;
    }
 </style>
    <div class="image-bottom hero-banner" style="background:#2540a2 url({{url('/')}}/assets/frontend/img/new-banner.jpg) no-repeat;" data-overlay="7">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11 col-sm-12">
                    <div class="inner-banner-text text-center">
                 
                        <h2><span class="font-normal">Find Your</span> Perfect Place.</h2>
                    </div>
                    <div class="full-search-2 eclip-search italian-search hero-search-radius shadow-hard mt-5">
                        <div class="hero-search-content">
                            <form action="{{route('normalsearch')}}" method="post">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-4 col-md-4 col-sm-12 b-r">
                                        <div class="form-group">
                                            <div class="choose-propert-type">
                                                <ul>
                                                    @php
                                                        $classification=DB::table('property_type')->where('property_type_status','Active')->get();
                                                    @endphp
                                                    @foreach($rentsale as $rent)
                                                        <li>
                                                            <input id="cp-{{$rent->product_category_id}}" value="{{$rent->product_category_id}}" class="checkbox-custom" name="cpt" type="radio"  checked="checked">
                                                            <label for="cp-{{$rent->product_category_id}}" class="checkbox-custom-label">{{$rent->product_category_name}}</label>
                                                        </li>
                                                    @endforeach
                                                    <div style="padding-left: 10px">
                                                    <select id="ptypes" name="ptypes" class="form-control" >
                                                        @foreach($classification as $c)
                                                            <option value=""></option>
                                                            <option value="{{$c->property_type_id}}">{{$c->property_type}}</option>

                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-4 col-sm-10 p-0 elio">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <input type="hidden" name="propertytype" id="propertytype" class="form-control" >
                                                <input type="hidden" name="property_classification_id" id="property_classification_id" class="form-control" >
                                                <input type="hidden" name="nobedrooms" id="nobedrooms" class="form-control" >
                                                <input type="hidden" name="nobathrooms" id="nobathrooms" class="form-control" >
                                                <input type="hidden" name="singleprice" id="singleprice" class="form-control" >
                                                <input type="hidden" name="allamenities[]" id="allamenities" class="form-control"  >
                                                <input type="hidden" name="location" id="jj" class="form-control" placeholder="Search for a location" >
                                                <img src="{{url('/')}}/assets/frontend/img/pin.svg" width="20" style="margin-top:20px">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-sm-2">
                                  
                                        <div class="form-group">
                                     
                                            <a class="collapsed ad-search" data-bs-toggle="collapse" data-parent="#search" data-bs-target="#advance-search" href="javascript:void(0);" aria-expanded="false" aria-controls="advance-search">
                                      <span id="ft"> Filter  &nbsp; &nbsp; &nbsp;</span>     <i class="fa fa-sliders-h slide"></i></a>
                                        </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit"  class="btn search-btn black">Search</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <!-- Collapse Advance Search Form -->
                            <div class="collapse" id="advance-search" aria-expanded="false" role="banner">
                            @php
                                $classification=DB::table('property_classification')->where('property_classification_status','Active')->get();

                            @endphp
                            <!-- row -->
                                <div class="row">

                                  <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                      <h4 class="text-dark">Property Classification</h4>
                                 <ul class="no-ul-list third-row">
                                           @foreach($classification as $class)
                                               <li>
                                                   <input id="a-{{$class->property_classification_id}}" value="{{$class->property_classification_id}}" class="checkbox-custom" name="property_classification_id" type="radio">
                                                   <label for="a-{{$class->property_classification_id}}" class="checkbox-custom-label">{{$class->property_classification}}</label>
                                              </li>
                                           @endforeach

                                       </ul>
                                  </div>

                                </div>
                                <!-- /row -->


                                <!-- row -->
                                <div class="row">
{{--                                    @php--}}
{{--                                        $classification=DB::table('property_type')->where('property_type_status','Active')->get();--}}
{{--                                    @endphp--}}

{{--                                    <div class="form-group col-md-6">--}}
{{--                                        <label>Property Type</label>--}}
{{--                                        <select id="ptypes" name="ptypes" class="form-control">--}}
{{--                                            @foreach($classification as $c)--}}
{{--                                                <option value=""></option>--}}
{{--                                                <option value="{{$c->property_type_id}}">{{$c->property_type}}</option>--}}

{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-md-6">
                                        <div class="single_search_boxed">
                                            <div class="widget-boxed-header">
                                                <h4>
                                                    <a href="#fprice" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Price Range<span class="selected">$10,000 - $15,000</span></a>
                                                </h4>
                                            </div>
                                            <div class="widget-boxed-body collapse" id="fprice" data-parent="#fprice" style="">
                                                <div class="side-list no-border">
                                                    <!-- Single Filter Card -->
                                                    <div class="single_filter_card">
                                                        <div class="card-body pt-0">
                                                            <div class="inner_widget_link">
                                                                <ul class="no-ul-list filter-list">
                                                                    <li>
                                                                        <input id="e1" class="radio-custom" name="prices" onclick="propvalues()" value="1" type="radio">
                                                                        <label for="e1" class="radio-custom-label">Less Then $10,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e2" class="radio-custom" name="prices" onclick="propvalues()" value="2" type="radio">
                                                                        <label for="e2" class="radio-custom-label">$10,000 - $15,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e3" class="radio-custom" name="prices" value="3" onclick="propvalues()" type="radio">
                                                                        <label for="e3" class="radio-custom-label">$12,000 - $25,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e4" class="radio-custom" name="prices" onclick="propvalues()" value="4" type="radio" >
                                                                        <label for="e4" class="radio-custom-label">$30,000 - $35,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e5" class="radio-custom" value="5"  onclick="propvalues()" name="prices" type="radio">
                                                                        <label for="e5" class="radio-custom-label">$40,000 - $45,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e6" class="radio-custom" value="6" onclick="propvalues()" name="prices" type="radio">
                                                                        <label for="e6" class="radio-custom-label">$50,000 - $55,000</label>
                                                                    </li>
                                                                    <li>
                                                                        <input id="e7" class="radio-custom"  value="7" onclick="propvalues()" name="prices" type="radio">
                                                                        <label for="e7" class="radio-custom-label">$60,000 - $65,000</label>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->



                                <!-- row -->
                                <div class="row">

                                    {{--                               <div class="col-lg-12 col-md-12 col-sm-12 mt-3">--}}
                                    {{--                                   <h4 class="text-dark">Property Type</h4>--}}
                                    {{--                                   <ul class="no-ul-list third-row">--}}

                                    {{--                                       <li>--}}
                                    {{--                                           <input id="a-1" class="checkbox-custom" name="a-1" type="checkbox">--}}
                                    {{--                                           <label for="a-1" class="checkbox-custom-label">Land</label>--}}
                                    {{--                                       </li>--}}

                                    {{--                                       <li>--}}
                                    {{--                                           <input id="a-2" class="checkbox-custom" name="a-2" type="checkbox">--}}
                                    {{--                                           <label for="a-2" class="checkbox-custom-label">House</label>--}}
                                    {{--                                       </li>--}}

                                    {{--                                       <li>--}}
                                    {{--                                           <input id="a-3" class="checkbox-custom" name="a-3" type="checkbox">--}}
                                    {{--                                           <label for="a-3" class="checkbox-custom-label">Apartment</label>--}}
                                    {{--                                       </li>--}}

                                    {{--                                       <li>--}}
                                    {{--                                           <input id="a-3" class="checkbox-custom" name="a-3" type="checkbox">--}}
                                    {{--                                           <label for="a-3" class="checkbox-custom-label">Townhouse</label>--}}
                                    {{--                                       </li>--}}

                                    {{--                                       <li></li>--}}
                                    {{--                                       <li></li>--}}

                                    {{--                                   </ul>--}}



                                    {{--                               </div>--}}



                                </div>
                                <!-- /row -->


                                <!-- row -->
                                <div class="row">
                                    @php
                                        $town=DB::table('town')->where('town_status','Active')->get();

                                    @endphp

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <select id="town" name="town" class="form-control" >

                                                <option value="">Any Town</option>
                                                @foreach($town as $town)
                                                <option value="{{$town->town_id}}">{{$town->town_name}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <div class="input-with-icon">
                                                <select id="bedrooms" name="bedrooms" class="form-control">
                                                    <option value="">&nbsp;</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                                <i class="fas fa-bed"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group mb-2">
                                            <div class="input-with-icon">
                                                <select id="bathrooms" name="bathrooms" class="form-control">

                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                                <i class="fas fa-bath"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /row -->

                                <!-- row -->
                                <div class="row">
                                    @php
                                        $amenities=DB::table('master_amenities')->where('status','Active')->get()
                                    @endphp
                                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                        <h4 class="text-dark">Amenities & Features</h4>
                                        <ul class="no-ul-list third-row">
                                            @foreach($amenities as $amenities)
                                                <li>
                                                    <input id="g{{$amenities->id}}" class="checkbox-custom" name="allamenitiesfilter" type="checkbox" onclick="propvalues()"  value="{{$amenities->id}}">
                                                    <label for="g{{$amenities->id}}" class="checkbox-custom-label">{{$amenities->name}}</label>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>

                                </div>
                                <!-- /row -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ============================ Achievement End ================================== -->

    <!-- ============================ Latest Property For Sale Start ================================== -->


    @include('components.recentproperty')


    <!-- ============================ Latest Property For Sale End ================================== -->

    <!-- ============================ All Property ================================== -->
    <section class="bg-light">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2>Featured Property For Sale</h2>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
                    </div>
                </div>
            </div>

            <div class="row list-layout">

                <!-- Single Property Start -->
                @include('components.featuredproperty')

            </div>
    </section>
    <!-- ============================ All Featured Property ================================== -->

    <!-- ============================ Step How To Use Start ================================== -->
    <section>
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2>Explore Featured Agents</h2>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Single Agent -->
                @include('components.featuredagent')

            </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Step How To Use End ================================== -->

    <!-- ============================ Smart Testimonials ================================== -->
    <!--<section class="bg-orange">
       <div class="container">

           <div class="row justify-content-center">
               <div class="col-lg-7 col-md-10 text-center">
                   <div class="sec-heading center">
                       <h2>Good Reviews by Customers</h2>
                       <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
                   </div>
               </div>
           </div>

           <div class="row justify-content-center">

               <div class="col-lg-12 col-md-12">

                   <div class="smart-textimonials smart-center" id="smart-textimonials">

                       <div class="item">
                           <div class="item-box">
                               <div class="smart-tes-author">
                                   <div class="st-author-box">
                                       <div class="st-author-thumb">
                                           <div class="quotes bg-blue"><i class="ti-quote-right"></i></div>
                                           <img src="assets/img/user-3.jpg" class="img-fluid" alt="" />
                                       </div>
                                   </div>
                               </div>

                               <div class="smart-tes-content">
                                   <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
                               </div>

                               <div class="st-author-info">
                                   <h4 class="st-author-title">Adam Williams</h4>
                                   <span class="st-author-subtitle">CEO Of Microwoft</span>
                               </div>
                           </div>
                       </div>

                       <div class="item">
                           <div class="item-box">
                               <div class="smart-tes-author">
                                   <div class="st-author-box">
                                       <div class="st-author-thumb">
                                           <div class="quotes bg-inverse"><i class="ti-quote-right"></i></div>
                                           <img src="assets/img/user-8.jpg" class="img-fluid" alt="" />
                                       </div>
                                   </div>
                               </div>

                               <div class="smart-tes-content">
                                   <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
                               </div>

                               <div class="st-author-info">
                                   <h4 class="st-author-title">Retha Deowalim</h4>
                                   <span class="st-author-subtitle">CEO Of Apple</span>
                               </div>
                           </div>
                       </div>

                       <div class="item">
                           <div class="item-box">
                               <div class="smart-tes-author">
                                   <div class="st-author-box">
                                       <div class="st-author-thumb">
                                           <div class="quotes bg-purple"><i class="ti-quote-right"></i></div>
                                           <img src="assets/img/user-4.jpg" class="img-fluid" alt="" />
                                       </div>
                                   </div>
                               </div>

                               <div class="smart-tes-content">
                                   <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
                               </div>

                               <div class="st-author-info">
                                   <h4 class="st-author-title">Sam J. Wasim</h4>
                                   <span class="st-author-subtitle">Pio Founder</span>
                               </div>
                           </div>
                       </div>

                       <div class="item">
                           <div class="item-box">
                               <div class="smart-tes-author">
                                   <div class="st-author-box">
                                       <div class="st-author-thumb">
                                           <div class="quotes bg-primary"><i class="ti-quote-right"></i></div>
                                           <img src="assets/img/user-5.jpg" class="img-fluid" alt="" />
                                       </div>
                                   </div>
                               </div>

                               <div class="smart-tes-content">
                                   <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
                               </div>

                               <div class="st-author-info">
                                   <h4 class="st-author-title">Usan Gulwarm</h4>
                                   <span class="st-author-subtitle">CEO Of Facewarm</span>
                               </div>
                           </div>
                       </div>

                       <div class="item">
                           <div class="item-box">
                               <div class="smart-tes-author">
                                   <div class="st-author-box">
                                       <div class="st-author-thumb">
                                           <div class="quotes bg-success"><i class="ti-quote-right"></i></div>
                                           <img src="assets/img/user-6.jpg" class="img-fluid" alt="" />
                                       </div>
                                   </div>
                               </div>

                               <div class="smart-tes-content">
                                   <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
                               </div>

                               <div class="st-author-info">
                                   <h4 class="st-author-title">Shilpa Shethy</h4>
                                   <span class="st-author-subtitle">CEO Of Zapple</span>
                               </div>
                           </div>
                       </div>

                   </div>
               </div>

           </div>
       </div>
    </section> -->
    <!-- ============================ Smart Testimonials End ================================== -->



    <!-- ============================ Agency List Start ================================== -->
    <section class="gray-simple">

        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <div class="sec-heading center">
                        <h2>Latest Blog</h2>
                        <p>We post regulary most powerful articles for help and support.</p>
                    </div>
                </div>
            </div>

            <!-- row blogpost Start -->
            <div class="row">

                @include('components.blogpost')


            </div>
            <!-- /row -->
        </div>

    </section>
    <!-- ============================ Agency List End ================================== -->



    <!-- ============================ Call To Action ================================== -->

@endsection
