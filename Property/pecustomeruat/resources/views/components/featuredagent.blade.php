
@foreach($agents as $agent)

<div class="col-lg-4 col-md-6 col-sm-12">
   <div class="agents-grid">

       <div class="agents-grid-wrap">

           <div class="fr-grid-thumb">
               <a href="{{route('agentpage',$agent['slug']??'')}}">
                @if($agent['agent_photo']==null)
                  <img src="{{$agentimage}}{{$defaultimage[0]}}" alt="">
                  @else
                  <img src="{{$agentimage}}{{$agent['agent_photo']??''}}" class="img-fluid mx-auto" alt="" />
                  @endif
                  
               </a>
           </div>

           <div class="fr-grid-deatil">
               <div class="fr-grid-deatil-flex">
                   <h5 class="fr-can-name"><a href="{{route('agentpage',$agent['slug']??'')}}">{{$agent['full_name']??''}}</a></h5>
                   @php
                       $count=DB::table('users')->join('property','property.agent_id','=','users.user_id')
                  ->where('users.user_id',$agent['user_id'])
                 ->count();
                   @endphp


                   <span class="agent-property">{{$count??''}} Properties</span>


               </div>
            
           </div>

       </div>

       <div class="fr-grid-info">
           <ul>
               <li><strong>Call:</strong>{{$agent['phone_1']??''}}</li>

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
               <!-- <span class="fr-position"><i class="lni-map-marker"></i>{{$agent['address']??''}}</span> -->
           </div>
           <div class="fr-grid-footer-flex-right">
               <a href="{{route('agentpage',$agent['slug']??'')}}" class="prt-view" tabindex="0">View</a>
           </div>
       </div>

   </div>
</div>
@endforeach
<!-- Single Agent -->


<!-- Single Agent -->



<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 text-center">
   <a href="{{route('agents')}}" class="btn btn-theme-light-2 rounded">Explore More Agents</a>
</div>
</div>
