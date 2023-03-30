<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\CollectionModel;
use Exception;
class CollectionController extends Controller
{
    public function __construct()
    {

    }
    // Check Department in DB and then Save
    public function saveDailyCollection(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $advocate_share  = trim($request->advocateShare);
            $notary_public_share  = trim($request->NotaryPublicShare);
            $AWC_share   = trim($request->AWCShare );
            $advocate_id=  $request->selectedAdvocateId;
            $head_id  = $request->selectedDepartmentId;
            $loggedUserId = $request->loggedUserId;
            $short_code = $request->short_code;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $collection_id = $request->editCollectionId;
            $Quantity = $request->Quantity;
            $departmentName = $request->departmentName;
            $withAdvocateReceipt =$request->withAdvocateReceipt;
            $court_id = $request->court_id;
            $result=CollectionModel::saveDailyCollection($centerId,
            $advocate_share,$notary_public_share ,$AWC_share ,$advocate_id,$head_id,$loggedUserId,$short_code,$isSaveEditClicked,$collection_id,$Quantity,$departmentName,$withAdvocateReceipt,$court_id);
            return response()->json($result);

        }

    }

    //Get the collection
    public function getAllCollection(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->where('daily_collection.collection_is_active', '=', "1")
             ->where(DB::raw('DATE(collection_created_at)'), '=', DB::raw('curdate()'))
             ->where('daily_collection.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id','daily_collection.advocate_share','daily_collection.notary_public_share',
             'daily_collection.AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"))
            ->orderBy('daily_collection.collection_id', 'DESC')
            ->paginate(400);
        return $getData;
    }

    //Get the collection datewise
    public function getAllCollectionDateWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 10;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->leftjoin('lms_court', 'lms_court.lms_court_id', '=', 'daily_collection.court_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
             ->select('daily_collection.notary_bar_code','lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id','daily_collection.advocate_share','daily_collection.notary_public_share',
             'lms_court.lms_court_name', 'daily_collection.AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"),DB::raw('daily_collection.quantity as HeadCount'))
            ->orderBy('daily_collection.collection_created_at', 'asc')
            ->paginate(400);
        return $getData;
    }

    //Get the collection headwise
    public function getAllCollectionHeadWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
              ->where('lms_department.lms_department_id', $selectedHead)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id','daily_collection.advocate_share','daily_collection.notary_public_share',
             'daily_collection.AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"),
             DB::raw('sum(daily_collection.quantity)as HeadCount'))
            ->orderBy('daily_collection.collection_created_at', 'asc')
            ->paginate(400);
        return $getData;
    }


    //Get the collection headwise datwwise
    public function getAllCollectionDateWiseHeadWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id',
              DB::raw('sum(daily_collection.advocate_share) as advocate_share,
             sum(daily_collection.notary_public_share) as notary_public_share,
             sum(daily_collection.AWC_share) as AWC_share '),  'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"),
             DB::raw('sum(daily_collection.Quantity)as HeadCount'),
              //Code Changes Start 01/04/2021
              DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
              //Code Changes End 01/04/2021
             )
            ->orderBy('daily_collection.collection_created_at', 'asc')
              ->groupBy('daily_collection.head_id')
            ->paginate(400);
        return $getData;
    }


     //Get the collection headwise datwwise
    public function getAllCollectionDateWiseAdvocateWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
             ->select( 'daily_collection.advocate_id','lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id',
              DB::raw('sum(daily_collection.advocate_share) as advocate_share,
             sum(daily_collection.notary_public_share) as notary_public_share,
             sum(daily_collection.AWC_share) as AWC_share '), 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"),
             DB::raw('sum(daily_collection.Quantity)as HeadCount'),
              //Code Changes Start 01/04/2021
              DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
              //Code Changes End 01/04/2021
              )
            ->orderBy('daily_collection.collection_created_at', 'asc')
              ->groupBy( 'daily_collection.advocate_id')
            ->paginate(400);
        return $getData;
    }



    //Get total collection headwise
    public function getTotalCollectionHeadWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
              ->where('lms_department.lms_department_id', $selectedHead)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
             'daily_collection.head_id',
             DB::raw('sum(daily_collection.advocate_share) as advocate_share,
             sum(daily_collection.notary_public_share) as notary_public_share,
             sum(daily_collection.AWC_share) as AWC_share '),
              'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"))
              ->groupBy('daily_collection.head_id',\DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") '))
            ->orderBy('daily_collection.collection_created_at', 'asc')


            ->paginate(400);
        return $getData;
    }


    //Update Department
    public function updateDepartment(Request $request)
    {
        $centerId = $request->centerId;
        $departmentName = $request->departmentName;
        $departmentId = $request->departmentId;
        $isDepartmentActive = $request->isDepartmentActive;
        $loggedUserId = $request->loggedUserId;
        $result=DepartmentModel::updateDepartment($centerId,
        $departmentName,$departmentId,$isDepartmentActive,$loggedUserId);
        return response()->json($result);

    }

     //Get All Active Department without pagination
     public function getActiveDepartmentWithoutPagination(Request $request)
     {
         $centerId = $request->centerId;

         $getQuery= DB::table("lms_department")->
             select(['lms_department_id', 'lms_department_name','AdvocateShare','NotaryPublicShare','AWCShare',DB::raw("concat(lms_department_id,' ',lms_department_name) as Head")])
             ->where('lms_department_is_active', 1)
             ->where('lms_center_id', $centerId)
             ->get();
             return $getQuery;

     }



     //================================ Refund Entry ===============================================

     //Get All Active User _ Advocate without pagination
     public function getActiveAdvocatetRefundEligbleWithoutPagination(Request $request)
     {
            return $getQuery = DB::select("select distinct lms_user.lms_user_id, lms_user.lms_user_full_name,
            concat(lms_user.lms_user_id,' ',lms_user.lms_user_full_name) as AdvocateName
            from lms_user join model_has_roles
            on lms_user.lms_user_id=model_has_roles.model_id
            join daily_refund on lms_user.lms_user_id = daily_refund.user_id
			where model_has_roles.role_id=3 and lms_user.lms_user_is_active=1 order by lms_user.lms_user_full_name");
     }

      //Get the pending refund by advocate
    public function getAllPendingRefundAdvocate(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $selectedAdvocateId = $request->selectedAdvocateId;
        $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')
             ->where('daily_refund.is_refund_done', '=', "0")
             ->where('daily_refund.user_id', '=', $selectedAdvocateId)
             ->where('daily_refund.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.collection_amount',
             'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.collection_date, "%d-%m-%y") as collection_created_at'),'daily_refund.receipt_no'
             )
            ->orderBy('daily_refund.collection_id', 'DESC')
            ->paginate(400);
        return $getData;
    }



      //Get the pending refund by advocate
    public function getAllPendingRefundByReceiptNumber(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $receipt_no = $request->receipt_no;
        $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')
             ->where('daily_refund.is_refund_done', '=', "0")
             ->where('daily_refund.receipt_no', '=', $receipt_no)
             ->where('daily_refund.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.collection_amount',
             'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),'daily_refund.receipt_no'
             )
            ->orderBy('daily_refund.collection_id', 'DESC')
            ->paginate(400);
        return $getData;
    }


      //Get the completed refund by advocate
    public function getAllCompletedRefundAdvocate(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $selectedAdvocateId = $request->selectedAdvocateId;
        $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')
             ->where('daily_refund.is_refund_done', '=', "1")
             ->where('daily_refund.user_id', '=', $selectedAdvocateId)
             ->where('daily_refund.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.collection_amount',
             'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),'daily_refund.receipt_no'
             )
            ->orderBy('daily_refund.refund_date', 'ASC')
            ->paginate(400);
        return $getData;
    }


       //Get the completed refund by advocate
    public function getAllRefundSessionWise(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $refund_session_value = $request->refund_session_value;
        $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')

             ->where('daily_refund.refund_session_value', $refund_session_value)
             ->where('daily_refund.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.collection_amount',
             'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),'daily_refund.receipt_no','daily_refund.notary_public_collection_amount'
             )
            ->orderBy('daily_refund.refund_date', 'ASC')
            ->paginate(400);
        return $getData;
    }
//===================================================== Dashboard ========================================
//Get the collection
    public function getDashboardDailyCollection(Request $request)
    {
        $centerId = $request->centerId;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->where('daily_collection.collection_is_active', '=', "1")
             ->where(DB::raw('DATE(collection_created_at)'), '=', DB::raw('curdate()'))
             ->where('daily_collection.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id','daily_collection.advocate_share','daily_collection.notary_public_share',
             'daily_collection.AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%h") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"))
            ->orderBy('daily_collection.collection_id', 'DESC')
            ->get();

        return response()->json(['dashboardData'=>$getData]);
    }



    //======================================= Refund ===========================================
    //=============================================================================================

     //Update Role
    public function updateRefundByAdvocate(Request $request)
    {
        $refund_id = $request->refund_id;
       // $refund_amount = $request->collection_amount;

          $refund_amount = DB::table("daily_refund")
             ->where('daily_refund.refund_id',  $refund_id)
             ->select('daily_refund.collection_amount','daily_refund.notary_public_collection_amount','daily_refund.AWC_collection_amount' )
            ->get();
            $refund_amount_result = $refund_amount->toArray();


        $updateRefund = DB::table('daily_refund')
            ->where('refund_id', $refund_id)
            ->update([
                'is_refund_done' => '1',
               'refund_amount' =>$refund_amount_result[0]->collection_amount,
                 'notary_public_refund_amount' =>$refund_amount_result[0]->notary_public_collection_amount,
                'AWC_refund_amount' =>$refund_amount_result[0]->AWC_collection_amount,
                'refund_date' => now(),

            ]);

        if ($updateRefund > 0) {

            return response()->json(['responseData' => 1]);
        } else {
            return response()->json(['responseData' => 2]);
        }
    }


     //Update Receipt
    public function updateRefundByReceipt(Request $request)
    {

         try {

            DB::beginTransaction();

        $receipt_no = $request->receipt_no;
          $refund_session_value = $request->refund_session_value;

        $refund_amount = DB::table("daily_refund")
             ->where('daily_refund.advocate_bar_code',  $receipt_no)
             ->select('daily_refund.collection_amount','daily_refund.refund_amount' )
            ->get();
            $refund_amount_result = $refund_amount->toArray();



            if($refund_amount_result[0]->collection_amount != $refund_amount_result[0]->refund_amount)
             {
                $updateRefund = DB::table('daily_refund')
                ->where('advocate_bar_code', $receipt_no)

                ->update([
                    'refund_session_value' => $refund_session_value,
                    'is_refund_done' => '1',
                    'refund_amount' =>$refund_amount_result[0]->collection_amount,
                    'advocate_refund_date' => now(),

                ]);

                DB::commit();
                return response()->json(['responseData' => 1]);
             }
             else
             {
                DB::commit();
                return response()->json(['responseData' => 3]);
             }




             } catch (Exception $ex) {

            DB::rollback();
            return response()->json(['responseData' => 2]);
        }


    }



    //Code Changes Start 01/04/2021
     //Update Receipt Noraty
     public function update_refund_by_notary(Request $request)
     {

          try {

             DB::beginTransaction();

         $receipt_no = $request->receipt_no;
           $refund_session_value = $request->refund_session_value;

         $refund_amount = DB::table("daily_refund")
              ->where('daily_refund.notary_bar_code',  $receipt_no)
              ->select('daily_refund.collection_amount','daily_refund.notary_public_collection_amount','daily_refund.AWC_collection_amount'
              ,'daily_refund.notary_public_refund_amount'
              )
             ->get();
             $refund_amount_result = $refund_amount->toArray();


             if($refund_amount_result[0]->notary_public_collection_amount != $refund_amount_result[0]->notary_public_refund_amount)
             {
                 $updateRefund = DB::table('daily_refund')
                 ->where('notary_bar_code', $receipt_no)

                 ->update([
                     'refund_session_value' => $refund_session_value,
                     'is_refund_done' => '2',

                       'notary_public_refund_amount' =>$refund_amount_result[0]->notary_public_collection_amount,

                     'refund_date' => now(),

                 ]);

                 DB::commit();
                 return response()->json(['responseData' => 1]);
             }
             else
             {
                 DB::commit();
                 return response()->json(['responseData' => 3]);
             }




              } catch (Exception $ex) {

             DB::rollback();
             return response()->json(['responseData' => 2]);
         }


     }

 //Code Changes End 01/04/2021

     // ================================================================= Advocate Collection & Refund =================================================================

     public function getAdvocateCollectionAndRefundReceiptWise(Request $request)
     {
          $selectedStartDate= $request->selectedStartDate;
         $selectedEndDate= $request->selectedEndDate;
         $selectedHead= $request->selectedHead;

         $centerId = $request->centerId;
         $perPage = $request->perPage ? $request->perPage : 50;
         $getData = DB::table("daily_collection")
              ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
              ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
               ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
               ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
               ->where('daily_collection.lms_center_id', $centerId)
               ->whereRaw('daily_collection.advocate_share > 0')
              ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
              'daily_collection.head_id','daily_collection.receipt_no','lms_department.lms_department_name',
              'daily_refund.advocate_bar_code',

               DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
               DB::raw('DATE_FORMAT(daily_refund.advocate_refund_date, "%d-%m-%y") as refund_date'),
               DB::raw('(daily_refund.collection_amount) as Total'),
               DB::raw('(daily_refund.refund_amount) as refund_amount'),
               DB::raw('sum(daily_refund.quantity)as HeadCount'))

                ->groupBy('daily_collection.receipt_no')
                ->orderBy('daily_collection.collection_created_at', 'asc')


             ->paginate(400);
         return $getData;
     }

     public function getAdvocateHeadWiseCollectionAndRefund(Request $request)
     {
          $selectedStartDate= $request->selectedStartDate;
         $selectedEndDate= $request->selectedEndDate;
         $selectedHead= $request->selectedHead;

         $centerId = $request->centerId;
         $perPage = $request->perPage ? $request->perPage : 50;
         $getData = DB::table("daily_collection")
              ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
              ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
              ->whereRaw('daily_collection.advocate_share > 0')
              ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
              'daily_collection.head_id','lms_department.lms_department_name',
              DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
              DB::raw('DATE_FORMAT(daily_refund.advocate_refund_date, "%d-%m-%y") as refund_date'),
              DB::raw('sum(daily_refund.collection_amount) as Total'),
              DB::raw('sum(daily_refund.refund_amount) as refund_amount'),
              DB::raw('sum(daily_refund.quantity)as HeadCount'),
              //Code Changes Start 01/04/2021
              DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
             //Code Changes End 01/04/2021
              )
              ->groupBy('daily_collection.head_id')
              ->orderBy('daily_collection.collection_created_at', 'asc')


             ->paginate(400);
         return $getData;
     }

     public function getAdvocateWiseCollectionAndRefundAdvocate(Request $request)
    {
         $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
             ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
             ->where('daily_collection.lms_center_id', $centerId)
             ->whereRaw('daily_collection.advocate_share > 0')
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
             'daily_collection.head_id','lms_department.lms_department_name',
             DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
             DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),
             DB::raw('sum(daily_collection.advocate_share) as Total'),
             DB::raw('sum(daily_refund.refund_amount) as refund_amount'),
             DB::raw('sum(daily_refund.quantity)as HeadCount'),
              //Code Changes Start 01/04/2021
              DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
              //Code Changes End 01/04/2021
             )
             ->groupBy('lms_user.lms_user_id')
             ->orderBy('daily_collection.collection_created_at', 'asc')


            ->paginate(400);
        return $getData;
    }

    //==================================CollectionAndRefundReport=====================================
    public function getAllCollectionAndRefundReceiptWise(Request $request)
    {
         $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
              ->whereRaw('daily_collection.notary_public_share > 0')
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
             'daily_collection.head_id','daily_collection.receipt_no','lms_department.lms_department_name',
             'daily_refund.notary_bar_code',

              DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
              DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),
              DB::raw('(daily_refund.notary_public_collection_amount) as Total'),
              DB::raw('(daily_refund.notary_public_refund_amount) as refund_amount'),
              DB::raw('sum(daily_refund.quantity)as HeadCount'))

               ->groupBy('daily_collection.receipt_no')
               ->orderBy('daily_collection.collection_created_at', 'asc')


            ->paginate(400);
        return $getData;
    }

     public function getHeadWiseCollectionAndRefund(Request $request)
    {
         $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
             ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
             ->where('daily_collection.lms_center_id', $centerId)
             ->whereRaw('daily_collection.notary_public_share > 0')
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
             'daily_collection.head_id','lms_department.lms_department_name',
             DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
             DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),
             DB::raw('sum(daily_collection.notary_public_share) as Total'),
             DB::raw('sum(daily_refund.notary_public_refund_amount) as refund_amount'),
             DB::raw('sum(daily_refund.quantity)as HeadCount'),
             //Code Changes Start 01/04/2021
             DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
            //Code Changes End 01/04/2021
             )
             ->groupBy('daily_collection.head_id')
             ->orderBy('daily_collection.collection_created_at', 'asc')


            ->paginate(400);
        return $getData;
    }


    public function getAdvocateWiseCollectionAndRefund(Request $request)
    {
         $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
             ->join('daily_refund', 'daily_collection.receipt_no', '=', 'daily_refund.receipt_no')
             ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
             ->where('daily_collection.lms_center_id', $centerId)
             ->whereRaw('daily_collection.notary_public_share > 0')
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id',
             'daily_collection.head_id','lms_department.lms_department_name',
             DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),
             DB::raw('DATE_FORMAT(daily_refund.refund_date, "%d-%m-%y") as refund_date'),
             DB::raw('sum(daily_collection.notary_public_share) as Total'),
             DB::raw('sum( daily_refund.notary_public_refund_amount ) as refund_amount'),
             DB::raw('sum(daily_refund.quantity)as HeadCount'),
              //Code Changes Start 01/04/2021
              DB::raw('concat(SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", 1)," - ",SUBSTRING_INDEX(GROUP_CONCAT(CAST(daily_collection.receipt_no AS CHAR) ORDER BY daily_collection.receipt_no ASC), ",", -1))as receipt_no')
              //Code Changes End 01/04/2021
             )
             ->groupBy('lms_user.lms_user_id')
             ->orderBy('daily_collection.collection_created_at', 'asc')


            ->paginate(400);
        return $getData;
    }


    //Daily Refund ===========================================


    //Get the collection datewise
    public function getAllRefundDateWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')
              ->whereRaw('date(collection_date) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_refund.lms_center_id', $centerId)
             ->select( 'lms_department.lms_department_id','lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.refund_amount as advocate_share','daily_refund.notary_public_refund_amount as notary_public_share',
             'daily_refund.AWC_refund_amount as AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.collection_date, "%d-%m-%y") as collection_created_at'),'daily_refund.receipt_no',
             DB::raw("IF(daily_refund.is_refund_done = 1, 'Active_false','Inactive_false')as collection_is_active"))
            ->orderBy('daily_refund.collection_date', 'asc')
            ->paginate(400);
        return $getData;
    }

    //Get the collection headwise
    public function getAllRefundHeadWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;
        $selectedHead= $request->selectedHead;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
              $getData = DB::table("daily_refund")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_refund.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_refund.user_id')
              ->whereRaw('date(collection_date) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_refund.lms_center_id', $centerId)
              ->where('lms_department.lms_department_id', $selectedHead)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_refund.refund_id','daily_refund.head_id','daily_refund.refund_amount as advocate_share','daily_refund.notary_public_refund_amount as notary_public_share',
             'daily_refund.AWC_refund_amount as AWC_share', 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_refund.collection_date, "%d-%m-%y") as collection_created_at'),'daily_refund.receipt_no',
             DB::raw("IF(daily_refund.is_refund_done = 1, 'Active_false','Inactive_false')as collection_is_active"))
            ->orderBy('daily_refund.collection_date', 'asc')

            ->paginate(400);
        return $getData;
    }


    //Get the collection headwise datwwise
    public function getAllRefundDateWiseHeadWise(Request $request)
    {
        $selectedStartDate= $request->selectedStartDate;
        $selectedEndDate= $request->selectedEndDate;

        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("daily_collection")
             ->join('lms_department', 'lms_department.lms_department_id', '=', 'daily_collection.head_id')
             ->join('lms_user', 'lms_user.lms_user_id', '=', 'daily_collection.advocate_id')
              ->whereRaw('date(collection_created_at) between ? AND  ?', [$selectedStartDate, $selectedEndDate])
              ->where('daily_collection.lms_center_id', $centerId)
             ->select('lms_user.lms_user_id','lms_user.lms_user_full_name','daily_collection.collection_id','daily_collection.head_id',
              DB::raw('sum(daily_collection.advocate_share) as advocate_share,
             sum(daily_collection.notary_public_share) as notary_public_share,
             sum(daily_collection.AWC_share) as AWC_share '), 'lms_department.lms_department_name',DB::raw('DATE_FORMAT(daily_collection.collection_created_at, "%d-%m-%y") as collection_created_at'),'daily_collection.receipt_no',
             DB::raw("IF(daily_collection.collection_is_active = 1, 'Active_false','Inactive_false')as collection_is_active"))
            ->orderBy('daily_collection.collection_created_at', 'asc')
              ->groupBy('daily_collection.head_id')
            ->paginate(400);
        return $getData;
    }

}
