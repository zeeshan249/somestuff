<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class SpecializationController extends Controller
{
    public  $Namex = "specialization";

    // get all specialization
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("specialization")->select(['specialization_id', 'specialization', DB::raw("IF(specialization_status = 'Active', 'Active','Inactive')as specialization_status")])

            ->where('specialization', 'like', '%' . $searchText . '%')->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' =>  $getQuery], 200);
    }
    //save specialization
    public function Save(Request $request)
    {


        $Name = trim($request->Name);
        $created_by = $request->created_by;
        $db = DB::table('specialization')->where('specialization',$Name)->count();
        if ($db > 0) {
            return response()->json(['message' => 'Specialization name already present please enter a new Specialization name'], 200);
        }
        else {
            $saveQuery = DB::table('specialization')->insertGetId(
                [
                    'specialization' => $Name,
                    'created_by' => $created_by,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => $Name . ' saved successfully'], 200);
            }
        }
    }

    //Update specialization
    public function Update(Request $request)
    {


        $Name = $request->Name;
        $Id = $request->Id;
        $isActive = $request->isActive;
        $updated_by = $request->updated_by;
        $db = DB::table('specialization')->where('specialization', $Name)->where('specialization_id', '!=',$Id)->count();
        if ($db > 0) {
            return response()->json(['message' => 'Specialization name already present please enter a new Specialization name'], 200);
        }
        else {
            $updateQuery = DB::table('specialization')
                ->where('specialization_id', $Id)
                ->update([
                    'specialization' => $Name,
                    'specialization_status' => $isActive,
                    'updated_at' => now(),
                    'updated_by' => $updated_by,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['message' => $Name . ' updated successfully'], 200);
            }
        }
    }

    //Delete specialization
    public function Delete(Request $request)
    {

        $Id = $request->Id;
        $deleteQuery = DB::table('specialization')->where('specialization_id', $Id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
    }

    public function GetWithoutPagination(Request $request)
    {



        $status = $request->status;
        $getQuery = DB::table("specialization")->select(['specialization_id', 'specialization', DB::raw("IF(specialization_status = 'Active', 'Active','Inactive')as specialization_status")]);



            if (isset($status)) {
                $getQuery->where('specialization_status', '=', $status);
            } else {
                $getQuery->where('specialization_status', '=', 'Active');

            }


        $getQuery = $getQuery->get();
        return response()->json(['success'=>'true','resultData' => $getQuery], 200);
    }
}
