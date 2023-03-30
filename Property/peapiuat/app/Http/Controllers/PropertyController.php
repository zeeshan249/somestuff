<?php

namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyImages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{   public $main;
    //this api for website
    public function getProperty(Request $request){
        $return = ['status' => true, 'message' => ''];
        $all_images = PropertyImages::where('type','image');
        $all_videos = PropertyImages::where('type','video');



        $all_images = $all_images->get();
        $all_videos = $all_videos->get();
        $all_property=Property::join('town','town.town_id','property.town_id')
        ->orderBy('property.created_at', 'DESC')
        ->get();
       
        $data = [
          'images'=>[],
          'videos'=>[],
          'productdata'=>[]
        ];

        if (count($all_images)) {

            foreach ($all_images as $value) {
                array_push($data['images'], [
                    'id' => $value->id,
                     'type'=>$value->type,
                    'property_id'=>$value->property_id,
                    'images_video'=>$value->images_video
                ]);
            }

        }

        if (count($all_videos)) {

            foreach ($all_videos as $value) {
                array_push($data['videos'], [
                    'id' => $value->id,
                    'type'=>$value->type,
                    'property_id'=>$value->property_id,
                    'images_video'=>$value->images_video
                ]);
            }

        }
        if(count($all_property)){
        foreach ($all_property as $property) {

            array_push($data['productdata'], [
                 'id' => $property->id,
                  'seller_name' =>$property->seller_name,
                  'price_asked' => $property->price_asked,
                  'landarea' => $property->land_area,
                  'buildingarea' => $property->building_area,
                  'property_name' => $property->property_name,
                  'property_price' => $property->property_price,
                  'property_description' => $property->property_description,
                  'property_headline' => $property->property_headline,
                  'property_classification_id' =>$property->PropertyClass->property_classification,
                  'product_category_id' =>$property->ProductCategory->product_category_name,
                  'no_bedrooms' =>$property->no_bedrooms,
                  'no_toilets' =>$property->no_toilets,
                  'province' =>$property->Province->province_name,
                   'town' => $property->town_name,
                  'slug'=>$property->slug,
                  'status'=>'Active'


            ]);
        }

    }

        $return['status'] = true;
        $return['data'] = $data;
        return response()->json($return, 200);

      }


public function  saveproperty(Request $request){
$user_id=$request->user_id;
    try {
        $rolecheck=DB::table('users')
            ->join('roles','roles.id','users.role_id')
            ->select('roles.name','roles.id')->where('user_id',$user_id)->first();
        if($rolecheck->id==30){
            $domain='Personal';

        }
        if($rolecheck->id==26){
            $domain='Agency';
        }
        if($rolecheck->id==3){
            $domain='Personal';
        }
        if($rolecheck->id==1){
            $domain='Personal';
        }
      

        //fetch associated broker
        $associated=DB::table('user_details')
        ->select('user_details.associated_broker_id')
        ->where('user_details.user_id',$request->agent_id)->first();
        
        $zipcodeB=DB::table('barangay')->select('barangay.zip_code')->where('barangay.barangay_id',$request->barangay_id)->first();
        DB::beginTransaction();
        $prop= DB::table('property')->where('property_headline', $request->property_headline)->count();
        if ( $prop>0) {
            return response()->json(['message' => 'Property Headline name already present please enter a new Property headline Name '], 200);
        }
    	    $landarea=$request->land_area;
			$saleprice=$request->price_asked;
      $id=  DB::table('property')->insertGetId(
            [

                'domain'=>$domain,
                'furnishing'=>$request->furnishing,
                'associated_broker_id'=>$request->associatedBroker,
                'user_type'=>$request->user_type,
                'user_id'=>$request->user_id,
                'seller_id' => $request->seller_id,
                'price_asked' => $request->price_asked,
                'land_area' => $request->land_area,
                'building_area' => $request->building_area,
                'property_name' => $request->property_name,
                'property_headline' => $request->property_headline,
                'property_description' => $request->property_description,
                'property_classification_id' => $request->property_classification_id,
                'property_type_id' => $request->property_type_id,
                'product_category_id' => $request->product_category_id,
                'unit_no' => $request->unit_no,
                'house_lot_no' => $request->house_lot_no,
                'street_name' => $request->street_name,
                'property_building_name' => $request->property_building_name,
                'barangay_id' => $request->barangay_id,
                'town_id' => $request->town_id,
                'province_id' => $request->province_id,
                'subdivision_id' => $request->subdivison_id,
                'zipcode' => $zipcodeB->zip_code,
                'select_floor_level' => $request->select_floor_level,
                'no_bedrooms' => $request->no_bedrooms,
                'no_toilets' => $request->no_toilets,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'slug' => Str::slug($request->property_headline).time(),
                'garage' => $request->garage,
                'cooling' => $request->cooling,
                'heatingtype' => $request->heatingtype,
                'elevator' => $request->elevator,
                'freewifi' => $request->freewifi,
                'exteriour' => $request->exteriour,
                'kitchen' => $request->kitchen,
                'year' => $request->year,
                'isFeatured' => $request->isFeatured!='null'?'No':$request->isFeatured,
                'agent_id' => $request->user_type==26?$request->user_id:$request->user_id,
                'agent2'=>$request->secondary_agent_id,
				'agent3'=>$request->third_agent_id,
                'rental_price_asked' => $request->rental_price_asked,
                'minimum_rental_period_rent' => $request->minimum_rental_period_rent,
                'car_spaces_rent' => $request->car_spaces_rent,
                'date_of_month_rent_due' => $request->date_of_month_rent_due,
                'period_can_extend' => $request->period_can_extend,
                'date_rental_started' => $request->date_rental_started,
                'current_rental_expires' => $request->current_rental_expires,
                'rental_switch_on' => $request->rental_switch_on,
                'sale_price' => $request->sale_price,
                 'price_per_sq_m' =>$landarea/$saleprice,
                'sale_switch_on' => $request->sale_switch_on,
                'agri_type' => $request->agri_type,
                'swimming_pool'=>$request->swimming_pool,
                'car_spaces_uncovered_property' => $request->car_spaces_uncovered_property,
                'garage_spaces_covered_property' => $request->garage_spaces_covered_property,
                'minimum_rental_period_sale' => $request->minimum_rental_period_sale,
                'fireplace' => $request->fireplace,
                'created_by' => $request->created_by,
                'updated_by' => $request->updated_by,

            ]
        );
 
      DB::table('notification')->insertGetId([
            'notification_type_id' => 1,
            'notification_subject' => 'One Property has been listed',
            'user_id' => $request->created_by,
        ]);
    

     $propertytracking=       DB::table('property_tracking')->insertGetId(
                [

                    'property_id' => $id,
                    'date_first_added' => date('Y-m-d'),
                    // 'date_last_modified' => $request->date_last_modified??'',
                    // 'date_last_status_change' => $request->date_last_status_change??'',
                    // 'date_suspended' => $request->description??'',
                    // 'suspended_reason'=>$request->created_by??'',
                    // 'modified_by'=>$request->updated_by??'',
                    // 'user_type'=>$request->user_type??'',
                    // 'date_modified_operator'=>$request->date_modified_operator??'',
                    // 'operator_name'=>$request->operator_name??''
                ]);

        DB::table('property_images')->insertGetId(
            [

                'property_id' => $id,
                'images_video' => 'default.jpg',
                'type' => 'Image',
                'isDefault' => 1,
                'description' => $request->description,
                'created_by'=>$request->created_by,
                'updated_by'=>$request->updated_by,
            ]);
	
	

          $commit=   DB::commit();
		
           
               \Mail::send('mail.addproperty', ["data1"=>$id], function($message) use($request){
                    $message->to("zeeshan.mymail@gmail.com");
                    $message->from("syed@gmail.com");
                    $message->subject('Property Added');
                });
			

	
            return response()->json([ 'message' => 'property  added successfully'], 200);
		

    }
                catch (Exception $ex) {

                        DB::rollback();

                            }


                       }

 public function getnotifications(Request  $request){
        $filterBy=$request->status;

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn ='notification.'.$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
       
        $rolecheck=DB::table('users')->select('users.role_id')->where('users.user_id',$request->user_id)->first();
         if($rolecheck->role_id==1){
            $getQuery = DB::table("notification")
            ->join('notification_type','notification_type.notification_type_id','=','notification.notification_type_id')
            ->select('notification.notification_id','notification_type.notification_type_icon','notification_type.notification_type',
                'notification.notification_subject','notification.notification_status','notification.created_at')
         
           
            ->where(function ($q) use ($filterBy) {
                $q
                ->where('notification.notification_subject','like', '%' . $filterBy . '%');
                // ->where('notification.notification_status','Active')
                //     ->orwhere('notification.notification_status','Inactive');

            })
            // ->where('notification.notification_status','Active')
            // ->orwhere('notification.notification_status','Inactive');
            ->orderBy($sortColumn, $sortOrder)
          ->orderBy('notification.notification_status','ASC')

            ->paginate($itemsPerPage);
         }
           else{
               $getQuery = DB::table("notification")
                ->join('notification_type','notification_type.notification_type_id','=','notification.notification_type_id')
                ->select('notification.notification_id','notification_type.notification_type_icon','notification_type.notification_type',
                     'notification.notification_subject','notification.notification_status','notification.created_at')
                    ->where('notification.user_id',$request->user_id)
   
               ->where(function ($q) use ($filterBy) {
                      $q
                    ->where('notification.notification_subject','like', '%' . $filterBy . '%');
        // ->where('notification.notification_status','Active')
        //     ->orwhere('notification.notification_status','Inactive');

                            })
    // ->where('notification.notification_status','Active')
    // ->orwhere('notification.notification_status','Inactive');
    ->orderBy($sortColumn, $sortOrder)
    ->orderBy('notification.notification_status','ASC')

    ->paginate($itemsPerPage);
        }
 

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function unreadNotification(Request $request){
        $rolecheck=DB::table('users')->select('users.role_id')->where('users.user_id',$request->user_id)->first();
        if($rolecheck->role_id==1){
            $getQuery = DB::table("notification")
            ->join('notification_type','notification_type.notification_type_id','=','notification.notification_type_id')
            ->select('notification.notification_id','notification_type.notification_type_icon','notification_type.notification_type',
                'notification.notification_subject','notification.notification_status','notification.created_at')
         
            ->where('notification.notification_status','Active')
            ->orderBy('notification.created_at', 'DESC')

        ->get();
        $getQueryCount=$getQuery->count();
        return response()->json(['resultData' => $getQuery,'count'=>$getQueryCount], 200);
        }
        else{
            $getQuery = DB::table("notification")
            ->join('notification_type','notification_type.notification_type_id','=','notification.notification_type_id')
            ->select('notification.notification_id','notification_type.notification_type_icon','notification_type.notification_type',
                'notification.notification_subject','notification.notification_status','notification.created_at')
            ->where('notification.user_id',$request->user_id)
            ->where('notification.notification_status','Active')
            ->orderBy('notification.created_at', 'DESC')

        ->get();
        $getQueryCount=$getQuery->count();
        return response()->json(['resultData' => $getQuery,'count'=>$getQueryCount], 200);
        }
       
    }

    public function NotificationStatus(Request  $request){
        $status = $request->status;
        $Id = $request->Id;
        try {
            $updateQuery = DB::table('notification')
                ->where('notification_id', $Id)
                ->update([
                    'notification_status' => $status,


                ]);
            if ($updateQuery > 0) {

                return response()->json(['success'=>'true','message' => ' Status Changed successfully'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }
    }

    public function  deleteNotification(Request $request){

        $Id = $request->Id;
        try {
            $updateQuery = DB::table('notification')
                ->where('notification_id', $Id)
                ->update([
                    'notification_status' => 'Deleted',
                ]);
            if ($updateQuery > 0) {

                return response()->json(['success'=>'true','message' => 'Deleted Notification'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }
    }
public function  propertyimagesupload(Request  $request)
{

    if($request->hasfile('images_video')) {

        $imageName = rand(1111, 9999) . time() . '.' . $request->images_video->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/featuredproperty/images');
        $request->images_video->move($destinationPath, $imageName);

        $saveQuery1 = DB::table('property_images')->insertGetId(
            [

                'property_id' => $request->property_id,
                'images_video' => $imageName,
                'type' => 'Image',
                'isDefault' => 0,
                'description' => $request->description,
                'created_by'=>$request->created_by,
                'updated_at'=>now(),
                'updated_by'=>$request->updated_by,
            ]);


    }
    //for type = video
    else{
        $saveQuery1 = DB::table('property_images')->insertGetId(
            [

                'property_id' => $request->property_id,
                'images_video' => $request->video_link,
                'type' => 'Video',
                'isDefault' => 0,
                'description' => $request->description,
                'created_by'=>$request->created_by,
            ]);

    }
    if ($saveQuery1 > 0) {
        $id = $saveQuery1;
//for type= image

        return response()->json(['message' => 'image/video added successfully'], 200);
    }
}
//show properties on admin panel

public function  allproperty(Request  $request){


        $productcategory=$request->product_category_id;
        $filterBy=$request->searchText;

        $user_id=$request->user_id;
    $rolecheck=DB::table('users')
        ->join('roles','roles.id','users.role_id')
        ->select('roles.name')->where('user_id',$user_id)->first();

        $getQuery = DB::table("property")->select(['property.id','seller.seller_name','property.rental_pricing_unit','property.date_sold','property.associated_broker_id','property.furnishing','property.domain','property.user_id','property.user_type','property.agent_id','users.full_name as agent_name','user_details.phone_1','user_details.phone_2','property.seller_id','property.land_area','property.building_area','property.land_area','property.property_name','property.property_headline'
            ,'property.property_description','property.price_asked','property.property_classification_id','property.status'
            ,'property.property_type_id','property.product_category_id','property.unit_no','property.house_lot_no','property.street_name','property.property_building_name','property.town_id','property.province_id','property.barangay_id',
            'property.subdivision_id','property.zipcode','property.select_floor_level','property.no_bedrooms','property.no_toilets','property.latitude'
            ,'property.longitude','property.latitude','property.slug','property.garage','property.cooling','property.heatingtype','property.elevator',
            'property.year','property.freewifi','property.exteriour','property.kitchen','property.isFeatured','property.agent_id','property.agri_type','property.rental_price_asked','property.minimum_rental_period_rent',
            'property.car_spaces_rent','property.date_of_month_rent_due','property.period_can_extend','property.car_spaces_rent','property.date_rental_started','property.current_rental_expires','property.rental_switch_on'
            ,'property.sale_price','property.sale_switch_on','property.price_per_sq_m','property.car_spaces_uncovered_property','property.garage_spaces_covered_property'
            ,'property.minimum_rental_period_sale','property.fireplace','property.status','property.swimming_pool','property_images.images_video',
            'property_tracking.date_first_added','property_tracking.date_last_modified','property_tracking.date_last_status_change','property_tracking.date_suspended','property_tracking.suspended_reason'
            ,'property_tracking.user_type','property_tracking.date_modified_operator','property_tracking.operator_name','property.price_rented','property.price_sold_for','property.zonal_value','property.zonning_code','subdivisions.subdivision_name'
            ,'property.active_property_date_limit','property.agent2','property.agent3'])
            ->join('user_details','user_details.user_id','property.agent_id')
            ->join('users','users.user_id','property.agent_id')
            ->leftjoin('seller','seller.seller_id','property.seller_id')
            ->join('product_category','product_category.product_category_id','property.product_category_id')
            ->join('property_tracking','property_tracking.property_id','property.id')
            ->leftjoin('subdivisions','property.subdivision_id','subdivisions.subdivision_id')
            ->join('barangay','property.barangay_id','barangay.barangay_id')
            ->join('town','property.town_id','town.town_id')
            ->join('province','property.province_id','province.province_id')
            
            ->leftjoin('property_images','property_images.property_id','=','property.id')


            ->where(function ($q) use ($rolecheck,$user_id) {

                if ($rolecheck->name != "Super Admin" && $rolecheck->name != "Operator") {
                    $q->where('property.user_id', $user_id);
                  }
            })
             ->where('property_images.isDefault',1)

            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%")
                    ->orWhere('town.town_name', 'like', "%$filterBy%")
                    ->orWhere('subdivisions.subdivision_name', 'like', "%$filterBy%")
                    ->orWhere('barangay.barangay_name', 'like', "%$filterBy%")
                    ->orWhere('province.province_name', 'like', "%$filterBy%")
                    ->orWhere('seller.seller_name', 'like', "%$filterBy%")
                    ->orWhere('users.full_name', 'like', "%$filterBy%");
                  

            })
            //for rent for sale
            ->where(function ($qp) use ($productcategory) {
                if($productcategory!=null){
                $qp->where('product_category.product_category_id', $productcategory)
                ->orderBy('product_category.product_category_name','ASC');
                }
           
            })
            //for seller name
         
        

            ->orderBy('property.created_at', 'DESC')
            ->paginate(200);

        return response()->json(['resultData' => $getQuery], 200);
    }



    public function  deletepropertyimages(Request  $request){
        $deleteCheck=DB::table('property_images')
        ->where('property_images.property_id', $request->property_id)
        ->where('property_images.id',$request->image_id)
        ->first();
        if($deleteCheck->isDefault==1){
            return response()->json(['message' => 'Cannot Delete  Default Image'], 200);  
        }
        else{
        
          
            if (file_exists(public_path('uploads/featuredproperty/images/'.$deleteCheck->images_video)) 
            &&  $image->images_video !='default.jpg' ) {
                unlink(public_path('uploads/featuredproperty/images/'.$image->images_video));
            }
            else{
                return response()->json(['message' => 'Cannot Delete  Default Image'], 200);       
            }
           
        $deleteQuery = DB::table('property_images')
            ->where('property_images.property_id', $request->property_id)
            ->where('property_images.id',$request->image_id)
            ->delete();
        if ($deleteQuery > 0) {

            return response()->json(['message' => 'Property image deleted successfully'], 200);
        }
    }
    }




  public function updateproperty(Request $request)
    {
        $user_id=$request->user_id;
        $status=$request->status;
       
    
        try {
            $rolecheck=DB::table('users')
            ->join('roles','roles.id','users.role_id')
            ->select('roles.name','roles.id')->where('user_id',$user_id)->first();
        if($rolecheck->id==30){
            $domain='Personal';

        }
        if($rolecheck->id==26){
            $domain='Agency';
        }
        if($rolecheck->id==3){
            $domain='Personal';
        }
        if($rolecheck->id==1){
            $domain='Personal';
        }
  

            //fetch associated broker
            $associated=DB::table('user_details')
                ->select('user_details.associated_broker_id')
                ->where('user_details.user_id',$request->agent_id)->first();
                $zipcodeB=DB::table('barangay')->select('barangay.zip_code')->where('barangay.barangay_id',$request->barangay_id)->first();
            DB::beginTransaction();
            $currentstatus=DB::table('property')->select('property.status')->where('property.id',$request->id)->first();
              
			$landarea=$request->land_area;
			$saleprice=$request->price_asked;

            $id=  DB::table('property')->where('id',$request->id)
                ->update([
                  
                                      'price_rented'=>$request->priceRented,
                    'price_sold_for'=>$request->priceSoldFor,
                    'zonal_value'=>$request->zonalValue,
                    'zonning_code'=>$request->zonningCode,
                    'domain'=>$request->domain,
                    'active_property_date_limit'=>$request->active_date,
                    'furnishing'=>$request->furnishing,
                    'associated_broker_id'=>$associated->associated_broker_id,
                    'user_type'=>$request->user_type,
                    'user_id'=>$request->user_id,
                    'seller_id' => $request->seller_id,
                    'price_asked' => $request->price_asked,
                    'land_area' => $request->land_area,
                    'building_area' => $request->building_area,
                    'property_name' => $request->property_name,
                    'property_headline' => $request->property_headline,
                    'property_description' => $request->property_description,
                    'property_classification_id' => $request->property_classification_id,
                    'property_type_id' => $request->property_type_id,
                    'product_category_id' => $request->product_category_id,
                    'unit_no' => $request->unit_no,
                    'house_lot_no' => $request->house_lot_no,
                    'street_name' => $request->street_name,
                    'property_building_name' => $request->property_building_name,
                    'barangay_id' => $request->barangay_id,
                    'town_id' => $request->town_id,
                    'province_id' => $request->province_id,
                    'subdivision_id' => $request->subdivison_id,
                    'zipcode' => $zipcodeB->zip_code,
                    'select_floor_level' => $request->select_floor_level,
                    'no_bedrooms' => $request->no_bedrooms,
                    'no_toilets' => $request->no_toilets,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,      
                    'garage' => $request->garage,
                    'cooling' => $request->cooling,
                    'heatingtype' => $request->heatingtype,
                    'elevator' => $request->elevator,
                    'freewifi' => $request->freewifi,
                    'exteriour' => $request->exteriour,
                    'kitchen' => $request->kitchen,
                    'year' => $request->year,
                    'isFeatured' => $request->isFeatured,
                    'agent_id' => $request->user_type==26?$request->user_id:$request->user_id,
                    'agent2'=>$request->secondary_agent_id,
		            'agent3'=>$request->third_agent_id,
                    'rental_price_asked' => $request->rental_price_asked,
                    'minimum_rental_period_rent' => $request->minimum_rental_period_rent,
                    'car_spaces_rent' => $request->car_spaces_rent,
                    'date_of_month_rent_due' => $request->date_of_month_rent_due,
                    'period_can_extend' => $request->period_can_extend,
                    'date_rental_started' => $request->date_rental_started,
                    'current_rental_expires' => $request->current_rental_expires,
                    'rental_switch_on' => $request->rental_switch_on,
                    'sale_price' => $request->sale_price,
                    'price_per_sq_m' => $landarea/$saleprice,
                    'sale_switch_on' => $request->sale_switch_on,
                    'agri_type' => $request->agri_type,
                    'swimming_pool'=>$request->swimming_pool,
                    'car_spaces_uncovered_property' => $request->car_spaces_uncovered_property,
                    'garage_spaces_covered_property' => $request->garage_spaces_covered_property,
                    'minimum_rental_period_sale' => $request->minimum_rental_period_sale,
                    'fireplace' => $request->fireplace,
                    'date_sold'=> $status=="Sold"?now():null,
                    'updated_by' => $request->updated_by,
                    'updated_at' => now(),
                    'status'=>$status,
                ]
            );
            if($id){
    
                $savenotification1 = DB::table('notification')->insertGetId([
                    'notification_type_id' => 10,
                    'notification_subject' => 'Property Details Modified For Property Headline'.$request->property_headline,
                    'user_id' => $request->updated_by,
                   ]);
            }
		   if($currentstatus->status != $status){
            
                \Mail::send('mail.addproperty', ["data1"=>''], function($message) use($request){
                    $message->to("zeeshan.mymail@gmail.com");
                    $message->from("syed@gmail.com");
                    $message->subject(' Property Status Updated');
                });

                $savenotification = DB::table('notification')->insertGetId([
                    'notification_type_id' => 9,
                    'notification_subject' => 'A Property Status Is Modified For Property Headline'.$request->property_headline,
                    'user_id' => $request->updated_by,
                   ]);
            }
    $statuscheck=DB::table('property')->select('property.status')->where('property.id',$request->id)->first();
    

  $rolename=DB::table('users')
  ->join('roles','roles.id','users.role_id')
  ->select('roles.name','users.full_name')->where('user_id',$request->user_id)->first();

  $propertytrack=  DB::table('property_tracking')
          ->where('property_id',$request->id)
          ->update([
    
                'date_last_modified' => date('Y-m-d'),
                'date_last_status_change' => $statuscheck->status==$status? date('Y-m-d'):null,
                'date_suspended' => $status=="Suspended"? date('Y-m-d'):null,
                'suspended_reason'=>$request->suspendedReason??'',
                'modified_by'=>$request->user_id??'',
                'user_type'=>$rolename->name??'',
                'date_modified_operator'=>$rolecheck->name=='Operator'? date('Y-m-d'):null,
                'operator_name'=>$rolecheck->name=='Operator'? $rolecheck->full_name:'',
            ]);
  

       
            DB::commit();

            return response()->json([ 'message' => ' property  updated successfully'], 200);

        }
        catch (Exception $ex) {

            DB::rollback();

        }


    }
    public  function  showallimagesvideo(Request  $request){
        $dbimage=DB::table('property_images')->where('property_id',$request->property_id)

            ->get();

        return response()->json(['resultdata' => $dbimage], 200);
    }

    public function  propertyimagesisDefault(Request $request){


        $updateQuery = DB::table('property_images')
            ->where('property_images.property_id', $request->property_id)
            ->where('property_images.id', $request->image_id)
            ->where('property_images.type','Image')
            ->update([
                'property_images.isDefault'=>$request->isDefault,
            ]);



    if($updateQuery) {


        $isNotDefault = DB::table('property_images')->where('property_id', $request->property_id)
            ->where('id', '!=', $request->image_id)
            ->where('property_images.type', 'Image')
            ->count();


        for ($x = 0; $x < $isNotDefault; $x++) {

            DB::table('property_images')
                ->where('property_id', $request->property_id)
                ->where('id', '!=', $request->image_id)
                ->where('property_images.type', 'Image')
                ->update([
                    'property_images.isDefault' => 0


                ]);

        }

    }
        return response()->json(['message' => "Default Image Set"], 200);

    }

    public function  propertyamenitiesupdate(Request  $request){
        $checkeddata=[];
    $masteramenities=DB::table('master_amenities')->where('status','active')->get();
    $mappedamenities=DB::table('master_amenities')
        ->join('property_amenities','property_amenities.property_id','=','master_amenities.id')
        ->where('property_amenities.property_id',$request->property_id)
        ->where('master_amenities.status','active')
             ->get();
        foreach ($mappedamenities as $value) {
            array_push($checkeddata, [
                'property_id'=>$value->property_id,
                'amenities_id'=>$value->amenities_id,
                'status'=>$value->status,
                'checked'=>'checked'
            ]);
        }
    return response()->json([$masteramenities,$checkeddata]);
    }


    public function GetMasterAmenitiesWithoutPagination(Request  $request){


        $getQuery = DB::table("master_amenities")->select(['*'])
            ->where('status','Active')
            ->orderBy('id','asc')
            ->get();



        return response()->json(['resultData' => $getQuery], 200);
    }
    public function  getpropertyamenities(Request  $request){
        $getQuery = DB::table("master_amenities")->select(['*'])
            ->where('status','Active')
            ->orderBy('id','asc')
            ->get();



        return response()->json(['resultData' => $getQuery], 200);

    }
    public function savePropertyMappingAmenities(Request $request){

        $propertyId=$request->propertyId;
        $ammentiesId=$request->ammentiesId;
        $ammenties=explode(",", $ammentiesId);
        DB::table('property_amenities')->where('property_id',$propertyId)->delete();
        for ($x=0;$x<count( $ammenties);$x++){
            DB::table('property_amenities')->updateOrInsert([
                'property_id'=>$propertyId,
                'amenities_id'=> $ammenties[$x],


            ],[  'property_id'=>$propertyId,
                'amenities_id'=> $ammenties[$x],
                'created_by'=>$request->created_by,

            ]);
        }


        return response()->json(['resultData' => '','message'=>'Property Amenities updated'], 200);

    }
     public function getSelectedPropertyAmenities(Request  $request){
         $propertyId=$request->propertyId;
        $getQuery= DB::table('property_amenities')
            ->select('property_amenities.amenities_id')
            ->where('property_id',$propertyId)->get();



         return response()->json(['resultData' => $getQuery], 200);

     }
     public function agentsecondary(Request $request){
      $user_id=$request->user_id;
      $agencyid=DB::table('users')
      ->select('user_details.associated_agency_id')
      ->join('user_details','user_details.user_id','users.user_id')
      ->where('users.user_id',$user_id)
      ->first();
      if($agencyid!==null)
      {
      $fetchassociatedagency=DB::table('users')
      ->join('user_details','user_details.user_id','users.user_id')
      ->select('users.user_id as secondary_agent_id','users.full_name')
      ->where('user_details.associated_agency_id',$agencyid->associated_agency_id)
      ->get();
      }
      else{
        return response()->json(['resultData' => []], 200);
      }
      return response()->json(['resultData' => $fetchassociatedagency], 200);
     }


    
     public function  deleteproperty(Request  $request){
        try{
          //image delete
        $image=  DB::table('property_images')
        ->select('property_images.images_video')
        ->where('property_images.property_id', $request->property_id)
        ->where('property_images.type','Image')
        ->get();

           foreach($image as $image){
            if (file_exists(public_path('uploads/featuredproperty/images/'.$image->images_video)) 
            &&  $image->images_video !='default.jpg' ) {
                unlink(public_path('uploads/featuredproperty/images/'.$image->images_video));
            }
           }

       
            DB::table('property_tracking')->where('property_tracking.property_id', $request->property_id)->delete();
            DB::table('property_images')->where('property_images.property_id', $request->property_id)->delete();

            DB::table('property_amenities')->where('property_amenities.property_id', $request->property_id)->delete();
            DB::table('property')->where('property.id', $request->property_id)->delete();
           
            
         
           return response()->json(['message' => 'Property deleted successfully'], 200);
        
           }
           catch (Exception $ex){
    
           }
    }
  
    public function getPropertyTrackingReport(Request $request){
        $itemsPerPage=$request->itemsPerPage;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
         $filterBy=$request->searchText;
         $user_id=$request->user_id;
      
 
         $getQuery = DB::table("property_tracking")->select(['property_tracking.id',
           DB::raw('DATE_FORMAT(property_tracking.date_first_added, "%Y-%m-%d") as date_first_added'),
           DB::raw('DATE_FORMAT(property_tracking.date_last_modified, "%Y-%m-%d") as date_last_modified'),  
           DB::raw('DATE_FORMAT(property_tracking.date_last_status_change, "%Y-%m-%d") as date_last_status_change'),  
           DB::raw('DATE_FORMAT(property_tracking.date_suspended, "%Y-%m-%d") as date_suspended'),  
            'property_tracking.user_type',
           DB::raw('DATE_FORMAT(property_tracking.date_modified_operator, "%Y-%m-%d") as date_modified_operator'),  
           'operator_name',
           'property.property_name'
           ])
            
             ->join('property','property.id','property_tracking.property_id')
             ->leftjoin('users','users.user_id','property_tracking.modified_by')
       
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('property.property_name', 'like', "%$filterBy%")
                    ->orWhere('property.property_headline', 'like', "%$filterBy%")
                    ->orWhere('property.property_description', 'like', "%$filterBy%");
 
            })
            
             ->orderBy($sortColumn, $sortOrder)
             ->paginate($itemsPerPage);
 
         return response()->json(['resultData' => $getQuery], 200);  
    }



}
