<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{

    public function agentapi(){
        $agents=User::
            join('roles','roles.id','=','users.role_id')
            ->join('user_details','user_details.user_id','=','users.user_id')

            ->where('roles.name','Agent')
            ->where('users.user_status','Active')
         
            ->orderby('users.full_name','ASC')
            ->select("*")
            ->limit(4)
            ->get();


        return response()->json(['data'=>$agents]);
    }

    public function allagents(){
        $agents=User::
              join('roles','roles.id','=','users.role_id')
            ->join('user_details','user_details.user_id','=','users.user_id')

            ->where('roles.name','Agent')
            ->where('users.user_status','Active')
            ->orderby('users.full_name','ASC')
            ->select("*")
            ->get();


        return response()->json(['data'=>$agents]);
    }


    public function singleagents($slug){
        $agents=User::
        join('roles','roles.id','=','users.role_id')
            ->join('user_details','user_details.user_id','=','users.user_id')
            // ->join('town','town.town_id','=','user_details.town_id')

            ->where('roles.name','Agent')
            ->where('users.user_status','Active')


            ->where('users.slug',$slug)
            ->get();


        return response()->json(['data'=>$agents]);
    }

    //admin panel report agent

    public function  agentreport(Request $request){


            $itemsPerPage = $request->itemsPerPage;
            $sortColumn = $request->sortColumn;
            $sortOrder = $request->sortOrder;
            $filterBy = $request->searchText;

            $getQuery = DB::table("users")->select(['users.full_name','users.user_id',
              'user_details.phone_1 as primary_phone','users.user_email'
                ])
//                ->join('property','property.agent_id','users.user_id')
                ->join('roles','roles.id','users.role_id')
                ->join('user_details','user_details.user_id','users.user_id')

//



                ->where('roles.name','Agent')
                ->where(function ($q) use ($filterBy) {
                    $q
                        ->Where('users.full_name', 'like', "%$filterBy%")
                        ->orWhere('users.user_email', 'like', "%$filterBy%")
                        ->orWhere('user_details.phone_1', 'like', "%$filterBy%");
//                        ->orWhere('agency.phone_1', 'like', "%$filterBy%")
//                        ->orWhere('agency.phone_2', 'like', "%$filterBy%");
                })
                ->orderBy($sortColumn,$sortOrder)
                ->paginate($itemsPerPage);
            return response()->json(['resultData' => $getQuery], 200);
        }

    public function userreport(Request  $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("users")->select(['users.full_name','users.user_id','roles.name as role_name',
            'user_details.phone_1 as primary_phone','users.user_email',
            'user_details.phone_2 as secondary_phone','users.user_status'
        ])

            ->join('roles','roles.id','users.role_id')
            ->join('user_details','user_details.user_id','users.user_id')

            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('users.full_name', 'like', "%$filterBy%")
                    ->orWhere('users.user_email', 'like', "%$filterBy%")
                    ->orWhere('user_details.phone_1', 'like', "%$filterBy%")
                    ->orWhere('user_details.phone_2', 'like', "%$filterBy%");

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function usertobeactivated(Request  $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("users")->select(['users.full_name','users.user_id','roles.name as role_name',
            'user_details.phone_1 as primary_phone','users.user_email',
            'user_details.phone_2 as secondary_phone','users.user_status'
        ])

            ->join('roles','roles.id','users.role_id')
            ->join('user_details','user_details.user_id','users.user_id')
             ->where('users.user_status','!=','Active')

            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('users.full_name', 'like', "%$filterBy%")
                    ->orWhere('users.user_email', 'like', "%$filterBy%")
                    ->orWhere('roles.name', 'like', "%$filterBy%")
                    ->orWhere('user_details.phone_1', 'like', "%$filterBy%")
                    ->orWhere('user_details.phone_2', 'like', "%$filterBy%");

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }

        public function agentsbasedagency(Request $request){
            $itemsPerPage = $request->itemsPerPage;
            $sortColumn = $request->sortColumn;
            $sortOrder = $request->sortOrder;
            $filterBy = $request->searchText;

            $getQuery = DB::table("agency")
                ->select(['agency.agency_name','agency.owner_name','agency.contact_person','users.full_name as AgentName',
                    'agency.email_address as agency_email_address','users.user_email as agent_email','agency.phone_1'
                    ])

                //  ->join('user_details',DB::raw("FIND_IN_SET(agency.agency_id,user_details.associated_agency_id)"), ">", \DB::raw("'0'"))
                ->join('user_details','user_details.associated_agency_id','agency.agency_id')
                // ->groupBy('user_details.user_id')
                ->join('users','users.user_id','user_details.user_id')
                ->join('roles','roles.id','users.role_id')
                 ->where('roles.name','Agent')

               ->where(function ($q) use ($filterBy) {
                   $q
                       ->orWhere('users.full_name', 'like', "%$filterBy%")
                       ->orWhere('users.user_email', 'like', "%$filterBy%")
                       ->orWhere('agency.agency_name', 'like', "%$filterBy%")
                       ->orWhere('agency.owner_name', 'like', "%$filterBy%")
                       ->orWhere('agency.contact_person', 'like', "%$filterBy%");

               })

                ->orderBy($sortColumn, $sortOrder)
                ->paginate($itemsPerPage);
            return response()->json(['resultData' => $getQuery], 200);
        }


}
