<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Town;
use App\Models\User;
use DB;
use App\Models\PropertyImages;
use App\Api\Agentapi;
class AgentController extends Controller
{
    public function agents(){
     
        $path=Utils();
        $agentimage=AgentImage();

        $data = new Agentapi();
        $agentapi =   $data->allagents();
        $agents=$agentapi['data'];
        $defaultimage=['avatar-photo.png'];
        return view('Frontend.agents',compact('agents','path','agentimage','defaultimage'));
    }

    public function agentpage($slug){
        
        $path=Utils();
        $agentimage=AgentImage();

        $data = new Agentapi();
        $agentapi =   $data->singleagents($slug);
        $agents=$agentapi['data'];
        $defaultimage=['avatar-photo.png'];
        $propertyfeatured=Property::with('PropertyClass','ProductCategory','Province','PropertyImages','PropertyType','PropertyFloor')->where('isFeatured',true)->get();
        return view('Frontend.agentpage',compact('agents','path','agentimage','propertyfeatured','defaultimage'));
    }

    public function  searchagents(Request $request){
        $agentimage=AgentImage();
        $defaultimage=['avatar-photo.png'];
        $agents=User::
        join('roles','roles.id','=','users.role_id')
            ->join('user_details','user_details.user_id','=','users.user_id')
            ->where('users.user_status','Active')
            ->where('users.role_id',26)
            ->where('is_role_active',1)
            ->where('full_name','LIKE','%'.$request->agent.'%')
            ->select("*")
            ->first();
        if($agents) {
            $count = DB::table('users')->join('property', 'property.agent_id', '=', 'users.user_id')
                ->where('users.user_id', $agents['user_id'])
                ->count();
        }
        else{
            $count='';
        }
        $html = '';
        if($agents['agent_photo']) {
            $html .= '
  <div class="col-lg-4 col-md-6 col-sm-12" >
            <div class="agents-grid">

               <div class="agents-grid-wrap">

                  <div class="fr-grid-thumb">
                     <a href="' . route('agentpage', $agents['slug']) . '">
                        <img src="' . $agentimage . $agents['agent_photo'] . '" class="img-fluid mx-auto" alt="" />
                     </a>
                  </div>

                  <div class="fr-grid-deatil">
                     <div class="fr-grid-deatil-flex">
                        <h5 class="fr-can-name"><a href="' . route('agentpage', $agents['slug']) . '">' . $agents['full_name'] . '</a></h5>

                        <span class="agent-property">' . $count . 'Properties</span>
                     </div>
                     <div class="fr-grid-deatil-flex-right">
                        <div class="agent-email"><a href="mailto:' . $agents['email'] . '"><i class="ti-email"></i></a></div>
                     </div>
                  </div>

               </div>

               <div class="fr-grid-info">
                  <ul>
                     <li><strong>Call:' . $agents['phone_1'] . '</strong></li>

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
                     <span class="fr-position"><i class="lni-map-marker">' . $agents['address'] . '</i></span>
                  </div>
                  <div class="fr-grid-footer-flex-right">
                     <a href="' . route('agentpage', $agents['slug']) . '" class="prt-view" tabindex="0">View</a>
                  </div>
               </div>

            </div>
            </div>
        ';
        }
        else if($agents['agent_photo']==null){
            $html .= '
            <div class="col-lg-4 col-md-6 col-sm-12" >
                      <div class="agents-grid">
          
                         <div class="agents-grid-wrap">
          
                            <div class="fr-grid-thumb">
                               <a href="' . route('agentpage', $agents['slug']) . '">
                                  <img src="' . $agentimage . $defaultimage[0] . '" class="img-fluid mx-auto" alt="" />
                               </a>
                            </div>
          
                            <div class="fr-grid-deatil">
                               <div class="fr-grid-deatil-flex">
                                  <h5 class="fr-can-name"><a href="' . route('agentpage', $agents['slug']) . '">' . $agents['full_name'] . '</a></h5>
          
                                  <span class="agent-property">' . $count . 'Properties</span>
                               </div>
                               <div class="fr-grid-deatil-flex-right">
                                  <div class="agent-email"><a href="mailto:' . $agents['email'] . '"><i class="ti-email"></i></a></div>
                               </div>
                            </div>
          
                         </div>
          
                         <div class="fr-grid-info">
                            <ul>
                               <li><strong>Call:' . $agents['phone_1'] . '</strong></li>
          
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
                               <span class="fr-position"><i class="lni-map-marker">' . $agents['address'] . '</i></span>
                            </div>
                            <div class="fr-grid-footer-flex-right">
                               <a href="' . route('agentpage', $agents['slug']) . '" class="prt-view" tabindex="0">View</a>
                            </div>
                         </div>
          
                      </div>
                      </div>
                  '; 
        }
        else{
            $html='<p>No Data Found</p>';
        }
        return response()->json(['data'=>$agents,'html'=>$html]);
    }

    // public function singleagents($slug){
    //     $agents=User::

    //     join('roles','roles.id','=','users.role_id')
    //         ->join('user_details','user_details.user_id','=','users.user_id')


    //         ->where('users.role_id',26)
    //         ->where('is_role_active',1)


    //         ->where('users.slug',$slug)
    //         ->get();


    //     return response()->json(['data'=>$agents]);
    // }




}
