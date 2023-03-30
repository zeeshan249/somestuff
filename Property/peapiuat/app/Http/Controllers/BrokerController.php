<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;


class BrokerController extends Controller
{
    public $Namex = "Broker";


    public function Get(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("broker")->select(['broker.broker_id','broker.broker_name','broker.email_address','broker.phone_1','broker.phone_2'
        ,'broker.broker_license_number','broker.specialization_id','broker.province_id','broker.capability_id',
        'broker.status','broker.notes_about_broker','broker.unit_number','broker.house_number','broker.street_name','broker.building_name',
        'broker.subdivision_id','broker.barangay_id','broker.town_id','broker.province_id','broker.zip_code','broker.floor','broker.broker_association_id',
        'broker.address_province_id','broker.reason_for_inactive'])
            ->where(function ($q) use ($filterBy) {

                $q  ->orWhere('broker.broker_name', 'like', "%$filterBy%")
                    ->orwhere('broker.email_address', 'like', "%$filterBy%")
                    ->orwhere('broker.phone_1', 'like', "%$filterBy%")
                    ->orwhere('broker.broker_license_number', 'like', "%$filterBy%");

            })

            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Save(Request $request)
    {
  
        $broker_name = $request->broker_name??'';
        $email = $request->email_address??'';
        $phone_1 = $request->phone_1??'';
        $phone_2 = $request->phone_2??'';

        $broker_license_number = $request->broker_license_number??'';
        $specialization_id = $request->specialization_id??'';
        $province_id = $request->province_id??'';
        $address_province_id=$request->province_id??'';
        $capability_id=$request->capability_id??'';
        $notes_about_broker=$request->notes_about_broker??'';
        $status = $request->status??'';
        $unit_number = $request->unit_number??'';
        $house_number = $request->house_number??'';
        $street_name = $request->street_name??'';
        $building_name =$request->building_name??'';
        $subdivision_id= $request->subdivision_id??'';
        $barangay_id= $request->barangay_id??'';
        $town_id = $request->town_id??'';
        $zip_code = $request->zip_code??'';
        $created_by = $request->created_by??'';
        $unit_number = $request->unit_number??'';
        $house_number = $request->house_number??'';
        $street_name = $request->street_name??'';
        $building_name = $request->building_name??'';
        $subdivision_id = $request->subdivision_id??'';
        $barangay_id = $request->barangay_id??'';
        $town_id = $request->town_id??'';
        $province_id = $request->province_id??'';
        $zip_code= $request->zip_code??'';

        $floor = $request->floor;
        try {
            $comp = DB::table('broker')->where('broker_license_number',$broker_license_number)
                ->count();
            if ($comp > 0) {
                return response()->json(['success' => 'true', 'message' => 'Broker License no already exist enter a new '], 200);
            }
                 $comp1 = DB::table('broker')->where('broker_name',$broker_name)
            ->count();
                if ($comp1 > 0) {
                    return response()->json(['success' => 'true', 'message' => 'Broker Name already Exist'], 200);
                }
            DB::beginTransaction();
     

            $brokerdetails = DB::table('broker')->insertGetId(
                [

                    'broker_name' => $broker_name,
                    'email_address' =>  $email ,
                    'phone_1' => $phone_1,
                    'phone_2' => $phone_2,
                    'broker_association_id' =>$request->broker_association_id,
                    'broker_license_number' => $broker_license_number,
                    'specialization_id' =>  $specialization_id,
                    'province_id'=> $province_id,
                    'address_province_id'=>$province_id,
                    'capability_id'=>$capability_id,
                    'notes_about_broker'=>'dd',

                    'unit_number' => $unit_number,
                    'house_number' => $house_number,
                    'street_name' => $street_name,
                    'building_name' => $building_name,
                    'subdivision_id' => $subdivision_id,
                    'barangay_id' => $barangay_id,
                    'town_id' => $town_id,
                    'zip_code' => $zip_code,
                    
                    'floor' => $request->floor,
               

                ]);
            DB::commit();
            return response()->json(['success' => 'true','message'=>'broker  added successfully'], 200);
        }
        catch (Exception $ex) {

            DB::rollback();
            return response()->json(['success' => 'false','message'=>'something went wrong','error'=>$ex->getMessage()], 200);
        }

    }


    public function Update(Request $request)
    {
        try {
            $comp = DB::table('broker')
                ->where('broker_id','!=',$request->broker_id)
                ->where('broker_license_number', $request->broker_license_number)
                ->count();
            if ($comp > 0) {
                return response()->json(['success' => 'true', 'message' => 'Broker License no already exist enter a new'], 200);
            }
            $comp1 = DB::table('broker')
            ->where('broker_id','!=',$request->broker_id)
            ->where('broker_name', $request->broker_name)
            ->count();
            if ($comp1 > 0) {
            return response()->json(['success' => 'true', 'message' => 'Broker Name already Exist'], 200);
                        }
            DB::beginTransaction();
           
             $brokerassocationdetails=DB::table('broker')
            ->select('broker.broker_association_id')
            ->where('broker.broker_id', $request->broker_id)->first();
          
            $updateQuery = DB::table('broker')
                ->where('broker.broker_id', $request->broker_id)
                ->update([

                    'broker_name' => $request->broker_name,
                    'email_address' => $request->email_address,
                    'phone_1' => $request->phone_1,
                    'phone_2' => $request->phone_2,
                    'broker_association_id' => $request->broker_association_id,
                    'broker_license_number' => $request->broker_license_number,
                    'specialization_id' => $request->specialization_id,
                    'province_id' => $request->province_id,
                    'address_province_id' => $request->province_id,
                    'capability_id' => $request->capability_id,
                    'notes_about_broker' => $request->notes_about_broker,
                    'status' => $request->status,
                    'unit_number' => $request->unit_number,
                    'house_number' => $request->house_number,
                    'street_name' => $request->street_name,
                    'building_name' => $request->building_name,
                    'subdivision_id' => $request->subdivision_id,
                    'barangay_id' => $request->barangay_id,
                    'town_id' => $request->town_id,
                    'zip_code' => $request->zip_code,
                    'reason_for_inactive'=>$request->reason_for_inactive,
                    'floor' => $request->floor,

                ]);
            DB::commit();
            if($brokerassocationdetails->broker_association_id != $request->broker_association_id){
            
                \Mail::send('mail.addproperty', ["data1"=>''], function($message) use($request){
                    $message->to("zeeshan.mymail@gmail.com");
                    $message->from("syed@gmail.com");
                    $message->subject('Broker Details - Broker Association Is Modified');
                });

                $savenotification = DB::table('notification')->insertGetId([
                    'notification_type_id' => 12,
                    'notification_subject' => 'Broker Details - Broker Association Is Modified for broker '.$request->broker_name,
                    'user_id' => $request->updated_by,
                   ]);
            }
            if ($updateQuery > 0) {
         
//
                return response()->json(['message' => 'Broker  updated'], 200);
            }
        }
        catch (Exception $ex){
            DB::rollback();
            return response()->json(['success' => 'true','message'=>'something went wrong'], 200);
        }

    }

    //Delete user_skills
    public function Delete(Request $request)
    {


                $deleteQuery = DB::table('broker')->where('broker.broker_id', $request->broker_id)->delete();
                if ($deleteQuery > 0) {

                    return response()->json(['message' => 'Item deleted successfully'], 200);
                }

    }
    //web end

    // get all agency without pagination
    public function GetWithoutPagination(Request $request)
    {

        $id = $request->id;
        $status = $request->status;
        $getQuery = DB::table("broker")->select(['broker_id', 'broker_name'])
            ->orderBy('broker_id');
        if (isset($id)) {
            $getQuery->where('broker_id', '=', $id);
            if (isset($status)) {
                $getQuery->where('status', '=', $status);
            } else {
                $getQuery->where('status', '=', 'Active');

            }
        } else {
            if (isset($status)) {
                $getQuery->where('status', '=', $status);
            } else {
                $getQuery->where('status', '=', 'Active');

            }

        }

        $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function getBrokerById(Request  $request){
        $getQuery = DB::table("broker")->select(['broker.broker_id','broker.broker_name','broker.email_address','broker.phone_1','broker.phone_2'
            ,'broker.broker_license_number','broker.specialization_id','broker.province_id','broker.capability_id',
            'broker.status','broker.notes_about_broker','broker.unit_number','broker.house_number','broker.street_name','broker.building_name',
            'broker.subdivision_id','broker.barangay_id','broker.town_id','broker.province_id','broker.zip_code','broker.floor','broker.broker_association_id',
          'broker.address_province_id','broker.reason_for_inactive'])
            
           ->where('broker.broker_id',$request->broker_id)
           ->get();
        return response()->json(['resultData' => $getQuery], 200);
    }


    public function brokerlinkedtobrokerassociation(Request $request){
        $filterBy = $request->searchText;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
		 $itemsPerPage=$request->itemsPerPage;

        $getQuery = DB::table("broker")->select(['broker.broker_id','broker.broker_name','broker.email_address','broker.phone_1','broker.phone_2'
            ,'broker.broker_license_number','broker.specialization_id','broker.province_id','broker.capability_id',
            'broker.status','broker.notes_about_broker','broker.unit_number','broker.house_number','broker.street_name','broker.building_name',
            'broker.subdivision_id','broker.barangay_id','broker.town_id','broker.zip_code','broker.floor','broker.broker_association_id',
            'broker.address_province_id'
                      ,DB::raw("GROUP_CONCAT(broker_association.broker_association_name) as associations")])
            ->leftjoin("broker_association",\DB::raw("FIND_IN_SET(broker_association.broker_association_id,broker.broker_association_id)"),">",\DB::raw("'0'"))
          ->groupBy('broker.broker_name')
            ->where(function ($q) use ($filterBy) {

                $q  ->orWhere('broker.broker_name', 'like', "%$filterBy%")
                    ->orwhere('broker.email_address', 'like', "%$filterBy%")
                    ->orwhere('broker.phone_1', 'like', "%$filterBy%")
                    ->orwhere('broker.phone_2', 'like', "%$filterBy%")
                    ->orwhere('broker.broker_license_number', 'like', "%$filterBy%");

            })
        ->orderBy($sortColumn,$sortOrder)
        ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function listofindividualincludingstatus(Request  $request)
    {
	    $itemsPerPage=$request->itemsPerPage;
        $filterBy = $request->searchText;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $getQuery = DB::table("users")->select(['users.role_id','users.user_id','users.user_email','users.user_status','user_details.first_name','user_details.last_name'
            ,'users.full_name','user_details.nick_name','user_details.user_details_id','user_details.phone_1','user_details.phone_2'
            ,'user_details.birth_month','user_details.birth_day','user_details.website','user_details.open_property_limit'
            ,"user_details.user_id","user_details.active_user_date_limit","user_details.active_user_date_limit","user_details.is_address_same_as_agency"
            ,"user_details.unit_number","user_details.house_number","user_details.street_name","user_details.building_name","user_details.subdivision_id"
            ,"user_details.barangay_id" ,"user_details.town_id","user_details.province_id","user_details.zip_code"
            ,'user_details.floor','user_details.re_license','user_details.profile_statement','user_details.self_broker','user_details.associated_broker_id'
            ,'user_details.user_skills','user_details.user_skills as user_skills_id'

            ,'user_details.associated_agency_id','user_details.agent_photo','user_details.isFeatured','user_details.address','user_details.year'
            ,'user_details.user_description','roles.name as role_name','users.user_status',
            DB::raw("( SELECT count(property.user_id)
                FROM property where
                property.user_id=users.user_id

           ) as totalProperties")

        ])
            ->join('roles','roles.id','=','users.role_id')
            ->join('user_details', 'user_details.user_id', '=', 'users.user_id')


            ->where('roles.name','=','Individual')

            ->where(function ($q) use ($filterBy) {

                $q  ->orWhere('users.user_email', 'like', "%$filterBy%")
                    ->orwhere('users.full_name', 'like', "%$filterBy%")
                    ->orwhere('roles.name', 'like', "%$filterBy%")
                    ->orwhere('user_details.phone_1', 'like', "%$filterBy%")
                    ->orwhere('user_details.phone_2', 'like', "%$filterBy%");

            })
//            ->whereIn('users.user_status',['New','Inactive'])
//            ->orwhere('users.user_status','Active')
            ->orderBy($sortColumn,$sortOrder)
          ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function listofsoldproperties(Request $request){
		 $itemsPerPage=$request->itemsPerPage;
       $sortColumn=$request->sortColumn;
       $sortOrder=$request->sortOrder;
        $filterBy=$request->searchText;
        $user_id=$request->user_id;
        $rolecheck=DB::table('users')
            ->join('roles','roles.id','users.role_id')
            ->select('roles.name')->where('user_id',$user_id)->first();

        $getQuery = DB::table("property")->select(['property.id','property.furnishing','property.domain','property.user_id','property.user_type','property.agent_id',
            'users.full_name as agent_name','user_details.phone_1','user_details.phone_2','property.seller_id','property.building_area','property.land_area','property.property_name','property.property_headline'
            ,'property.property_description','property.price_asked','property.property_classification_id','property.status'
            ,'property.property_type_id','property.product_category_id','property.unit_no','property.house_lot_no','property.street_name','property.property_building_name','property.town_id','property.province_id','property.barangay_id',
            'property.subdivision_id','property.zipcode','property.select_floor_level','property.no_bedrooms','property.no_toilets','property.latitude'
            ,'property.longitude','property.slug','property.garage','property.cooling','property.heatingtype','property.elevator',
            'property.year','property.freewifi','property.exteriour','property.kitchen','property.isFeatured','property.agri_type','property.rental_price_asked','property.minimum_rental_period_rent',
            'property.car_spaces_rent','property.date_of_month_rent_due','property.period_can_extend','property.date_rental_started','property.current_rental_expires','property.rental_switch_on'
            ,'property.sale_price','property.sale_switch_on','property.price_per_sq_m','property.car_spaces_uncovered_property','property.garage_spaces_covered_property'
            ,'property.minimum_rental_period_sale','property.fireplace','property.swimming_pool','seller.seller_name'
           ,DB::raw("GROUP_CONCAT(broker.broker_name) as broker_associated")
          ,DB::raw('DATE_FORMAT(property.date_sold, "%Y-%m-%d") as date_sold')])
            ->join("broker",\DB::raw("FIND_IN_SET(broker.broker_id,property.associated_broker_id)"),">",\DB::raw("'0'"))
           ->groupBy('property.id')
            ->join('user_details','user_details.user_id','property.agent_id')
            ->join('users','users.user_id','property.agent_id')
            ->join('seller','seller.seller_id','property.seller_id')


            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.date_sold', 'like', "%$filterBy%")
                    ->orWhere('property.street_name', 'like', "%$filterBy%")
                    ->orWhere('seller.seller_name', 'like', "%$filterBy%")
                    ->orWhere('property.status', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%");

            })

            ->where('property.date_sold','>=',$request->date_sold_from_date)
            ->where('property.date_sold','<=',$request->date_sold_to_date)
            ->where('property.status','=','Sold')
            ->orwhere('property.status','=','Occupied')
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }


    public function countofproperties(Request $request){
		 $itemsPerPage=$request->itemsPerPage;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $filterBy=$request->searchText;
        $user_id=$request->user_id;
        $user_type=$request->user_type;
        $rolecheck=DB::table('users')
            ->join('roles','roles.id','users.role_id')
            ->select('roles.name','roles.id')->where('user_id',$user_id)->first();

        $getQuery = DB::table("property")
      

        ->select('property.id','property.user_id','users.user_status'
        ,'users.full_name','roles.name as role_type',

          DB::raw("( SELECT count(property.id)
                FROM property where
                property.user_id=users.user_id

           ) as totalProperties"))

       
            // ->where(function ($q) use ($rolecheck,$user_id) {
            //     if($user_id !=null) {
            //     if ($rolecheck->name != 'Super Admin') {
            //         $q->where('property.user_id', $user_id);
            //     }
            //      }
            //    })
            ->join('users','users.user_id','property.user_id')
            ->join('roles','roles.id','property.user_type')

            ->where(function ($q) use ($user_type) {
                if($user_type !=null) {
                    $q->where('property.user_type', $user_type);
                }
            })

            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%")
                    ->orWhere('users.full_name', 'like', "%$filterBy%");

            })
              ->groupBy('property.user_id')
             ->orderBy($sortColumn,$sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);

    }

    public function  openpendingpropertyreport(Request $request){
		$itemsPerPage=$request->itemsPerPage;
        $filterBy=$request->searchText;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $getQuery = DB::table("property")->select(['property.id','property.furnishing','property.domain','property.user_id','property.user_type','property.agent_id',
            'users.full_name as agent_name','user_details.phone_1','user_details.phone_2','property.seller_id','property.building_area','property.land_area','property.property_name','property.property_headline'
            ,'property.property_description','property.price_asked','property.property_classification_id','property.status'
            ,'property.property_type_id','property.product_category_id','property.unit_no','property.house_lot_no','property.street_name','property.property_building_name','property.town_id','property.province_id','property.barangay_id',
            'property.subdivision_id','property.zipcode','property.select_floor_level','property.no_bedrooms','property.no_toilets','property.latitude'
            ,'property.longitude','property.slug','property.garage','property.cooling','property.heatingtype','property.elevator',
            'property.year','property.freewifi','property.exteriour','property.kitchen','property.isFeatured','property.agri_type','property.rental_price_asked','property.minimum_rental_period_rent',
            'property.car_spaces_rent','property.date_of_month_rent_due','property.period_can_extend','property.date_rental_started','property.current_rental_expires','property.rental_switch_on'
            ,'property.sale_price','property.sale_switch_on','property.price_per_sq_m','property.car_spaces_uncovered_property','property.garage_spaces_covered_property'
            ,'property.minimum_rental_period_sale','property.fireplace','property.swimming_pool','seller.seller_name'
            ,DB::raw("GROUP_CONCAT(broker.broker_name) as broker_associated")
            ,DB::raw('DATE_FORMAT(property.date_sold, "%d-%m-%Y") as date_sold')
            ,DB::raw(("TIMESTAMPDIFF(MONTH, date_format(property.created_at,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) as months"))
            ,DB::raw(("TIMESTAMPDIFF(MONTH, date_format(property.updated_at,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d')) as  pending"))
            ])
            ->join("broker",\DB::raw("FIND_IN_SET(broker.broker_id,property.associated_broker_id)"),">",\DB::raw("'0'"))
            ->groupBy('property.id')
            ->join('user_details','user_details.user_id','property.agent_id')
            ->join('users','users.user_id','property.agent_id')
            ->join('seller','seller.seller_id','property.seller_id')


            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%");

            })

//   ,DB::raw('SELECT DATEDIFF(month, "2021-08-09","2022-08-09") AS DateDiff')
            ->where('property.status','=','Open')
            ->orwhere('property.status','=','Pending')

            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }


    public function  propertylinkedtobroker(Request  $request){
		$itemsPerPage=$request->itemsPerPage;
        $filterBy=$request->searchText;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $getQuery = DB::table("property")->select(['property.id','property.furnishing','property.domain','property.user_id','property.user_type','property.agent_id',
            'users.full_name as agent_name','user_details.phone_1','user_details.phone_2','property.seller_id','property.building_area','property.land_area','property.property_name','property.property_headline'
            ,'property.property_description','property.price_asked','property.property_classification_id','property.status'
            ,'property.property_type_id','property.product_category_id','property.unit_no','property.house_lot_no','property.street_name','property.property_building_name','property.town_id','property.province_id','property.barangay_id',
            'property.subdivision_id','property.zipcode','property.select_floor_level','property.no_bedrooms','property.no_toilets','property.latitude'
            ,'property.longitude','property.slug','property.garage','property.cooling','property.heatingtype','property.elevator',
            'property.year','property.freewifi','property.exteriour','property.kitchen','property.isFeatured','property.agri_type','property.rental_price_asked','property.minimum_rental_period_rent',
            'property.car_spaces_rent','property.date_of_month_rent_due','property.period_can_extend','property.date_rental_started','property.current_rental_expires','property.rental_switch_on'
            ,'property.sale_price','property.sale_switch_on','property.price_per_sq_m','property.car_spaces_uncovered_property','property.garage_spaces_covered_property'
            ,'property.minimum_rental_period_sale','property.fireplace','property.swimming_pool','seller.seller_name'
            ,DB::raw("GROUP_CONCAT(broker.broker_name) as broker_associated")
            ,DB::raw('DATE_FORMAT(property.date_sold, "%Y-%m-%d") as date_sold')
            ,DB::raw(("DATEDIFF(property.created_at,current_timestamp())AS Day"))
        ])
            ->join("broker",\DB::raw("FIND_IN_SET(broker.broker_id,property.associated_broker_id)"),">",\DB::raw("'0'"))
            ->groupBy('property.id')
            ->join('user_details','user_details.user_id','property.agent_id')
            ->join('users','users.user_id','property.agent_id')
            ->join('seller','seller.seller_id','property.seller_id')


            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%")
                     ->orWhere('seller.seller_name', 'like', "%$filterBy%")
                    ->orWhere('users.full_name', 'like', "%$filterBy%");
            })

//   ,DB::raw('SELECT DATEDIFF(month, "2021-08-09","2022-08-09") AS DateDiff')

//
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public  function  getListOfAttachments(Request $request){
		$itemsPerPage=$request->itemsPerPage;
        $filterBy=$request->searchText;
        $type=$request->attachment_type;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $k=0;
        $getQuery = DB::table("property")->select(['property.id','seller.seller_name','property.date_sold','property.associated_broker_id','property.furnishing','property.domain','property.user_id','property.user_type','property.agent_id','users.full_name as agent_name','user_details.phone_1','user_details.phone_2','property.seller_id','property.land_area','property.building_area','property.land_area','property.property_name','property.property_headline'
            ,'property.property_description','property.price_asked','property.property_classification_id','property.status'
            ,'property.property_type_id','property.product_category_id','property.unit_no','property.house_lot_no','property.street_name','property.property_building_name','property.town_id','property.province_id','property.barangay_id',
            'property.subdivision_id','property.zipcode','property.select_floor_level','property.no_bedrooms','property.no_toilets','property.latitude'
            ,'property.longitude','property.latitude','property.slug','property.garage','property.cooling','property.heatingtype','property.elevator',
            'property.year','property.freewifi','property.exteriour','property.kitchen','property.isFeatured','property.agent_id','property.agri_type','property.rental_price_asked','property.minimum_rental_period_rent',
            'property.car_spaces_rent','property.date_of_month_rent_due','property.period_can_extend','property.car_spaces_rent','property.date_rental_started','property.current_rental_expires','property.rental_switch_on'
            ,'property.sale_price','property.sale_switch_on','property.price_per_sq_m','property.car_spaces_uncovered_property','property.garage_spaces_covered_property'
            ,'property.minimum_rental_period_sale','property.fireplace','property.swimming_pool','property_images.images_video'
        ,'property_images.type','property_images.id as image_video_id'
      
        ])
            ->join('user_details','user_details.user_id','property.agent_id')
             ->join('users','users.user_id','property.agent_id')
            ->join('seller','seller.seller_id','property.seller_id')

            ->join('property_images','property_images.property_id','=','property.id')
          

            
            ->where(function ($q) use ($type) {
                if($type!=null){
             $q->orWhere('property_images.type',$type);
                }
            })

            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                ->orWhere('seller.seller_name', 'like', "%$filterBy%")
                ->orWhere('seller.seller_name', 'like', "%$filterBy%")
                ->orWhere('users.full_name', 'like', "%$filterBy%")
                ->orWhere('property.property_headline', 'like', "%$filterBy%")
                ->orWhere('property.property_description', 'like', "%$filterBy%")
                ->orWhere('property_images.type', 'like', "%$filterBy%");

            })

//   ,DB::raw('SELECT DATEDIFF(month, "2021-08-09","2022-08-09") AS DateDiff')



            ->orderBy($sortColumn, $sortOrder)
        
            ->paginate($itemsPerPage);
//        https://mgtspe.dreamplesk.com/public/uploads/featuredproperty/images/p-6.jpg
        return response()->json(['resultData' => $getQuery], 200);
    }

}
