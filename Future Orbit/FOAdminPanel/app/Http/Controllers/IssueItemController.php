<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;

class IssueItemController extends Controller
{
  public function getAllItems(Request $request){
    
    $perPage = $request->perPage ? $request->perPage : 100;
    $filterBy = $request->filterBy;
    $centerId = $request->centerId;
    $result = DB::table('lms_item_add')

        ->where('lms_item_add.item_status', '=', 1)

        ->where(function ($q) use ($filterBy) {
            $q->where('lms_item_add.item_name', 'like', "%$filterBy%")
                ->orWhere('lms_item_add.item_type', 'like', "%$filterBy%")
                ->orWhere('lms_item_add.item_desription', $filterBy);
        })

        ->select(
            'lms_item_add.item_id',
            'lms_item_add.item_name',
            'lms_item_add.item_desription',
            'lms_item_add.item_status',
            'lms_item_add.item_image',
            DB::raw("date_format(lms_item_add.created_at,'%d-%m-%y') as created_at"),
            DB::raw("
                    (case when lms_item_add.item_status  = '1' then 'Active'
                    when       lms_item_add.item_status  = '0' then 'Inactive'         
                    ELSE 'Active' end) as 'item_status'"),

     
        )
        ->orderBy('lms_item_add.created_at','desc')
        ->paginate($perPage);
    return $result;
  }



   public function itemadd(Request $request)
   {
    $itemName=$request->itemName;
    $itemType=$request->itemType;
    $itemDescription=$request->itemDescription;
    if ($request->hasFile('itemImage')) {
        $file= $request->file('itemImage');
        $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = 'public/user_profile_images';
        $request->file('itemImage')->storeAs($destinationPath, $filename);
        $selectedImage= $filename;
    }
    else{
        $selectedImage= '';  
    }
  
    $result = ItemModel::itemadd(
        $itemName,
        $itemType,
        $itemDescription,
        $selectedImage,
    );
     return response()->json($result);
   }
}
