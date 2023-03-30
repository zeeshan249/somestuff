@extends('Frontend.Layouts.frontendlayout')
@section('content')
<div class="page-title">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <h2 class="ipt-title">Property List</h2>
     

         </div>
      </div>
   </div>
</div>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ All Property ================================== -->
<section class="gray">

   <div class="container">
      <div class="row">

         <!-- property Sidebar -->
         <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="simple-sidebar sm-sidebar" id="filter_search"  style="left:0;">

               <div class="search-sidebar_header">
                  <h4 class="ssh_heading">Close Filter</h4>
                  <button onclick="closeFilterSearch()" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
               </div>

               <!-- Find New Property -->
               <div class="sidebar-widgets">

                  <div class="search-inner p-0">

{{--                     <div class="filter-search-box">--}}
{{--                        <div class="form-group">--}}
{{--                           <div class="input-with-icon">--}}
{{--                              <input type="text" class="form-control" placeholder="Search by space name…">--}}
{{--                              <i class="ti-search"></i>--}}
{{--                           </div>--}}
{{--                        </div>--}}
{{--                     </div>--}}

                     <div class="filter_wraps">

                        <!-- Single Search -->
                        <div class="single_search_boxed">
                           <div class="widget-boxed-header">
                              <h4>
                                 <a href="#where" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Where<span class="selected"></span></a>
                              </h4>

                           </div>
                           <div class="widget-boxed-body collapse" id="where" data-parent="#where">
                              <div class="side-list no-border">
                                 <!-- Single Filter Card -->
                                 <div class="single_filter_card">
                                    <div class="card-body pt-0">
                                       <div class="inner_widget_link">
                                          <ul class="no-ul-list filter-list">
                                              @foreach($town as $city)
                                             <li>
                                                <input id="b{{$city->town_id}}" onclick="properties(1)" class="radio-custom" value="{{$city->town_name}}" name="towncity" type="radio">
                                                <label for="b{{$city->town_id}}" class="radio-custom-label">{{$city->town_name}}</label>
                                             </li>
                                              @endforeach

                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Single Search -->
                        <div class="single_search_boxed">
                           <div class="widget-boxed-header">
                              <h4>
                                 <a href="#fptype" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Property Types<span class="selected"></span></a>
                              </h4>

                           </div>
                           <div class="widget-boxed-body collapse" id="fptype" data-parent="#fptype">
                              <div class="side-list no-border">
                                 <!-- Single Filter Card -->
                                 <div class="single_filter_card">
                                    <div class="card-body pt-0">
                                       <div class="inner_widget_link">
                                          <ul class="no-ul-list filter-list">
                                              @foreach($propertytypes as $type)
                                             <li>
                                                <input id="c{{$type->property_type_id}}" onclick="properties(1)" class="radio-custom" name="ptype" type="radio" value="{{$type->property_type_id}}">
                                                <label for="c{{$type->property_type_id}}" class="radio-custom-label">{{$type->property_type}}</label>
                                             </li>
                                              @endforeach

                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Single Search -->
                        <div class="single_search_boxed">
                           <div class="widget-boxed-header">
                              <h4>
                                 <a href="#fbedrooms" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Bedrooms<span class="selected"></span></a>
                              </h4>

                           </div>
                           <div class="widget-boxed-body collapse" id="fbedrooms" data-parent="#fbedrooms">
                              <div class="side-list no-border">
                                 <!-- Single Filter Card -->
                                 <div class="single_filter_card">
                                    <div class="card-body pt-0">
                                       <div class="inner_widget_link">
                                          <ul class="no-ul-list filter-list">
                                             <li>
                                                <input id="a1" onclick="properties(1)" class="radio-custom" name="bed" type="radio" value="1">
                                                <label for="a1" class="radio-custom-label">01 Bedrooms</label>
                                             </li>
                                             <li>
                                                <input id="a2"  onclick="properties(1)"  class="radio-custom" name="bed"  value="2" type="radio">
                                                <label for="a2" class="radio-custom-label">02 Bedrooms</label>
                                             </li>
                                             <li>
                                                <input id="a3" onclick="properties(1)"  class="radio-custom" name="bed" value="3" type="radio">
                                                <label for="a3" class="radio-custom-label" >03 Bedrooms</label>
                                             </li>
                                             <li>
                                                <input id="a4" onclick="properties(1)"  class="radio-custom" name="bed" type="radio" value="4" >
                                                <label for="a4" class="radio-custom-label" >04 Bedrooms</label>
                                             </li>
                                             <li>
                                                <input id="a5" onclick="properties(1)"  class="radio-custom" name="bed" type="radio" value="5">
                                                <label for="a5" class="radio-custom-label" >05 Bedrooms</label>
                                             </li>
                                             <li>
                                                <input id="a6" onclick="properties(1)"  class="radio-custom" name="bed" type="radio" value="6">
                                                <label for="a6" class="radio-custom-label" >06+ Bedrooms</label>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Single Search -->
                        <div class="single_search_boxed">
                           <div class="widget-boxed-header">
                              <h4>
                                 <a href="#fprice" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Price Range<span class="selected"></span></a>
                              </h4>

                           </div>
                           <div class="widget-boxed-body collapse" id="fprice" data-parent="#fprice">
                              <div class="side-list no-border">
                                 <!-- Single Filter Card -->
                                 <div class="single_filter_card">
                                    <div class="card-body pt-0">
                                       <div class="inner_widget_link">
                                          <ul class="no-ul-list filter-list">
                                             <li>
                                                <input id="e1" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="1">
                                                <label for="e1" class="radio-custom-label">Less Then $10,000</label>
                                             </li>
                                             <li>
                                                <input id="e2" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="2">
                                                <label for="e2" class="radio-custom-label">$10,000 - $15,000</label>
                                             </li>
                                             <li>
                                                <input id="e3"  onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="3">
                                                <label for="e3" class="radio-custom-label">$12,000 - $25,000</label>
                                             </li>
                                             <li>
                                                <input id="e4" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="4">
                                                <label for="e4" class="radio-custom-label">$30,000 - $35,000</label>
                                             </li>
                                             <li>
                                                <input id="e5" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="5">
                                                <label for="e5" class="radio-custom-label">$40,000 - $45,000</label>
                                             </li>
                                             <li>
                                                <input id="e6" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="6">
                                                <label for="e6" class="radio-custom-label">$50,000 - $55,000</label>
                                             </li>
                                             <li>
                                                <input id="e7" onclick="properties(1)" class="radio-custom" name="prices" type="radio" value="7">
                                                <label for="e7" class="radio-custom-label">$60,000 - $65,000</label>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- Single Search -->


                        <!-- Single Search -->
                        <div class="single_search_boxed">
                           <div class="widget-boxed-header">
                              <h4>
                                 <a href="#ameneties" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Ameneties<span class="selected">ADA Compliant</span></a>
                              </h4>

                           </div>
                           <div class="widget-boxed-body collapse" id="ameneties" data-parent="#ameneties">
                              <div class="side-list no-border">
                                 <!-- Single Filter Card -->
                                 <div class="single_filter_card">
                                    <div class="card-body pt-0">
                                       <div class="inner_widget_link">
                                          <ul class="no-ul-list filter-list">
                                              @php
                                                $amenities=DB::table('master_amenities')->where('status','Active')->get()
                                              @endphp
                                              @foreach($amenities as $amenities)

                                             <li>
                                                <input id="g{{$amenities->id}}" class="checkbox-custom" name="ADA" type="checkbox" onclick="properties(1)" name="amenities" value="{{$amenities->id}}">
                                                <label for="g{{$amenities->id}}" class="checkbox-custom-label">{{$amenities->name}}</label>
                                             </li>
                                              @endforeach

                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>


                  </div>
               </div>
            </div>
            <!-- Sidebar End -->

         </div>


         <div class="col-lg-8 col-md-12 list-layout">



            <div class="row" id="appenddata">

               <!-- Single Property Start -->

               <!-- Single Property End -->

               <!-- Single Property Start -->

               <!-- Single Property End -->

            </div>

            <!-- Pagination -->
             <div class="row" id="pagination">

             </div>

         </div>

      </div>
   </div>
</section>
<!-- ============================ All Property ================================== -->
<script>
    $(document).ready(function () {
        properties(1);
        $('#pageno').text(1);
    });
    function properties(page) {
        var a=[];

        var page=page;
        $("input:checkbox[name='ADA']:checked").each(function(){
          a.push($(this).val());
        });
        var price =  $("input:radio[name='prices']:checked").val();
        var ptype =  $("input:radio[name='ptype']:checked").val();
        var towncity =  $("input:radio[name='towncity']:checked").val();
        var bed =  $("input:radio[name='bed']:checked").val();
        var product_category_name = $("input:radio[name='product_category_name']:checked").val();
        $.ajax({
            type: 'GET',
            url: "{{route('getpropertyfilter')}}",
            data: {
                amenities_id:a,
                page:page,
                prices:price,
                ptype:ptype,
                towncity:towncity,
                bed:bed,
                product_category_name:product_category_name,
            },
            success: function (response) {
                $('#appenddata').html(response.html);
                $('#pagination').html(response.pagination);

            },
        });
    }
    $(document).on("click", ".pagination li a", function(e){
        e.preventDefault();
        var pageId = $(this).attr("data-page");

        properties(pageId);
        $('#pageno').text(pageId);
    });
</script>
<!-- ============================ Call To Action ================================== -->

@endsection
