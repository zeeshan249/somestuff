@extends('Frontend.Layouts.frontendlayout')
@section('content')
<div class="page-title">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">

            <h2 class="ipt-title">All Agents</h2>
            <span class="ipn-subtitle">Lists of our all expert agents</span>

         </div>
      </div>
   </div>
</div>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Search Form End ================================== -->
<section class="gray-simple p-0">
   <div class="container">
      <!-- row Start -->
      <div class="row justify-content-center">
         <div class="col-lg-10 col-md-12">
            <div class="full-search-2 eclip-search italian-search hero-search-radius shadow-hard overlio-40">
               <div class="hero-search-content">
                  <div class="row">




                     <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="form-group">
                           <div class="input-with-icon">
                              <input type="text"  name="search"  class="form-control" placeholder="Search for a Agent">
                              <img src="{{url('/')}}/assets/frontend/img/pin.svg" width="20">
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-2 col-md-3 col-sm-12">

                        <div class="form-group" >
                           <button type="submit" onclick="searchagent()" class="btn search-btn black">Search</button>
                        </div>

                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /row -->
   </div>
</section>
<!-- ============================ Search Form End ================================== -->

<!-- ============================ Agent List Start ================================== -->
<section class="gray-simple">

   <div class="container">

       <div class="row" id="showdata" >



       </div>




      <div class="row" id="appenddata" >

         <!-- Single Agent -->
         
          @foreach($agents as $agent)

         <div class="col-lg-4 col-md-6 col-sm-12"  >
            <div class="agents-grid">

               <div class="agents-grid-wrap">

                  <div class="fr-grid-thumb">
                     <a href="{{route('agentpage',$agent['slug'])}}">
                        @if($agent['agent_photo']==null)
                       
                        <img src="{{$agentimage}}{{$defaultimage[0]}}" class="img-fluid mx-auto" alt="" />
                        @else
                        <img src="{{$agentimage}}{{$agent['agent_photo']}}" class="img-fluid mx-auto" alt="" />
                        @endif
                        
                     </a>
                  </div>

                  <div class="fr-grid-deatil">
                     <div class="fr-grid-deatil-flex">
                        <h5 class="fr-can-name"><a href="{{route('agentpage',$agent['slug'])}}">{{$agent['full_name']}}</a></h5>
                     @php
                     $count=DB::table('users')->join('property','property.agent_id','=','users.user_id')
                ->where('users.user_id',$agent['user_id'])
               ->count();
                     @endphp
                        <span class="agent-property">{{$count}} Properties</span>
                     </div>
                
                  </div>

               </div>

               <div class="fr-grid-info">
                  <ul>
                     <li><strong>Call:</strong>{{$agent['phone_1']}}</li>

                     <li>
                        <div class="fr-can-rating">
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star filled"></i>
                           <i class="fas fa-star"></i>
                           <span class="reviews_text">(42 Reviews)</span>
                        </div>
                     </li>
                  </ul>
               </div>

               <div class="fr-grid-footer">
                  <div class="fr-grid-footer-flex">
                   
                  </div>
                  <div class="fr-grid-footer-flex-right">
                     <a href="{{route('agentpage',$agent['slug'])}}" class="prt-view" tabindex="0">View</a>
                  </div>
               </div>

            </div>
         </div>
      @endforeach
         <!-- Single Agent -->


      </div>



   </div>
</section>
<!-- ============================ Agent List End ================================== -->
<script>
    function searchagent() {


        var agent =  $("input:text[name='search']").val();
        $.ajax({
            type: 'GET',
            url: `{{route('searchagents')}}`,
            data: {

                agent:agent,
            },
            success: function (response) {
                // console.log(response.data);
                $('#appenddata').hide();
                $('#showdata').html(response.html);
        

            },
        });
    }
</script>
<!-- ============================ Call To Action ================================== -->

@endsection
