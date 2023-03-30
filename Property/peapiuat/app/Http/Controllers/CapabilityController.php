<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class CapabilityController extends Controller
{
    public  $Namex = "Capability";

    // get all Capability
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("capability")->select(['capability_id', 'capability_name', DB::raw("IF(capability_status = 'Active', 'Active','Inactive')as capability_status")])

            ->where('capability_name', 'like', '%' . $searchText . '%')->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' =>  $getQuery], 200);
    }
    //save Capability
    public function Save(Request $request)
    {


        $Name = trim($request->Name);
        $created_by = $request->created_by;
        $capability= DB::table('capability')->where('capability_name',$Name)->count();
        if ( $capability>0) {
            return response()->json(['message' => 'Capability name already present please enter a new Capability Name '], 200);
        }
        else {
            $saveQuery = DB::table('capability')->insertGetId(
                [
                    'capability_name' => $Name,
                    'created_by' => $created_by,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => $Name . ' saved successfully'], 200);
            }
        }
    }

    //Update Capability
    public function Update(Request $request)
    {


        $Name = $request->Name;
        $Id = $request->Id;
        $isActive = $request->isActive;
        $updated_by = $request->updated_by;
        $db = DB::table('capability')->where('capability_name', $Name)->where('capability_id', '!=', $Id )->count();
        if ($db > 0) {
            return response()->json(['message' => 'capability name already present please enter a new capability Name'], 200);
        }
        else {
            $updateQuery = DB::table('capability')
                ->where('capability_id', $Id)
                ->update([
                    'capability_name' => $Name,
                    'capability_status' => $isActive,
                    'updated_at' => now(),
                    'updated_by' => $updated_by,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['message' => $Name . ' updated successfully'], 200);
            }
        }
    }

    //Delete Capability
    public function Delete(Request $request)
    {

        $Id = $request->Id;
        $deleteQuery = DB::table('capability')->where('capability_id', $Id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
    }
    public function GetWithoutPagination(Request $request)
    {



        $status = $request->status;
        $getQuery = DB::table("capability")->select(['capability_id', 'capability_name', DB::raw("IF(capability_status = 'Active', 'Active','Inactive')as capability_status")]);



        if (isset($status)) {
            $getQuery->where('capability_status', '=', $status);
        } else {
            $getQuery->where('capability_status', '=', 'Active');

        }


        $getQuery = $getQuery->get();
        return response()->json(['success'=>'true','resultData' => $getQuery], 200);
    }
    //web end
}
