<?php


namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;


date_default_timezone_set('Asia/Kolkata');


class CollectionModel extends Model
{
    protected $primaryKey = "lms_department_id";
    protected $table = "lms_department";
    public $timestamps = false;

     // Check Department in DB and then Save
    public static function saveDailyCollection($centerId,
            $advocate_share,$notary_public_share ,$AWC_share ,$advocate_id,$head_id,$loggedUserId,
            $short_code,$isSaveEditClicked,$collection_id,$Quantity,$departmentName,$withAdvocateReceipt,$court_id)
             {

                                 if ($isSaveEditClicked == 1) {
                 $receiptCodePrefix =  $short_code . date('ym');

                        $receiptCode = IdGenerator::generate([
                            'table' => 'daily_collection', 'length' => 10, 'prefix' => $receiptCodePrefix,
                            'reset_on_prefix_change' => true, 'field' => 'receipt_no',
                        ]);

                        $receiptCodePrefix_barcode =  date('y');
                        $notary_bar_code = IdGenerator::generate([
                            'table' => 'daily_collection', 'length' => 10, 'prefix' => 'NP' . $receiptCodePrefix_barcode,
                            'reset_on_prefix_change' => true, 'field' => 'notary_bar_code',
                        ]);

                        $advocate_bar_code = IdGenerator::generate([
                            'table' => 'daily_collection', 'length' => 10, 'prefix' => 'LA' . $receiptCodePrefix_barcode,
                            'reset_on_prefix_change' => true, 'field' => 'advocate_bar_code',
                        ]);
                            $notary_public_share= $Quantity * $notary_public_share;
                            $advocate_share =  $Quantity * $advocate_share;
                            $AWC_share = $Quantity * $AWC_share;

                $saveQuery = DB::table('daily_collection')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'head_id' => $head_id,
                        'receipt_no'=>$receiptCode,
                        'advocate_share' => $advocate_share,
                        'advocate_id' => $advocate_id,
                        'notary_public_share'=>$notary_public_share,
                        'AWC_share' =>  $AWC_share,
                        'collection_created_by'=>$loggedUserId,
                        'Quantity'=> $Quantity,
                        'advocate_bar_code' => $advocate_bar_code,
                        'notary_bar_code' => $notary_bar_code,
                        'court_id'=> $court_id,

                    ]
                );
                // for Advocate entry
                if($AWC_share > 0)
                {


                 $saveQuery_advocate = DB::table('daily_refund')->insertGetId(
                    [
                        'lms_center_id' => $centerId, 'collection_id' => $saveQuery,
                        'head_id' => $head_id, 'user_id' => $advocate_id,
                        'user_type' =>'LA', 'receipt_no'=>$receiptCode,
                        'collection_amount' => $advocate_share, 'refund_amount' =>'0',
                        'is_refund_done' => '0', 'collection_date'=>now(),
                        'collection_created_by'=>$loggedUserId, 'refund_is_active'=>'1',
                        'notary_public_collection_amount' =>$notary_public_share,
                        'notary_public_refund_amount'=>'0',
                        'AWC_collection_amount'=> $AWC_share,
                        'AWC_refund_amount'=>$AWC_share,
                        'advocate_bar_code'=>$advocate_bar_code,
                        'notary_bar_code'=>$notary_bar_code,
                        'Quantity'=> $Quantity,


                    ]
                );




            }




            // for Notary Public entry
                if($notary_public_share > 0)
                {
            // // Print Start
            $profile = CapabilityProfile::load("simple");
                        $connector = new WindowsPrintConnector("smb://127.0.0.1/EPSONTMT82IIReceipt");
            $printer = new Printer($connector, $profile);
            /* Print some bold text */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("Advocate Welfare Society\n");
                $printer -> text("Bankura\n");
                $printer -> text("Date: " . now() . "\n");

                $printer -> feed();
                $printer -> text("--------------------------------------\n");
                $printer -> text("Receipt Number : " . $receiptCode . "\n");
                $printer -> text("Head : " . $departmentName . "\n");
                $printer -> text("--------------------------------------\n");
                $printer -> text("Notary Token\n");
                $printer -> text("NP Token Number : " . $notary_bar_code . "\n");
                $printer -> text("Token Count : " . $Quantity . "\n");
                $printer -> text("NP : Rs." . $notary_public_share. ".00\n");
                $printer -> setEmphasis(false);
                $printer -> feed(3);
                $printer -> barcode($notary_bar_code);
               $printer -> text("--------------------------------------\n");
                $printer -> cut();
                /* Close printer */
                $printer -> close();
                //Print End
             }

            // // for WFC entry
                if($advocate_share > 0)
                {


//               $profile = CapabilityProfile::load("simple");
//                           $connector = new WindowsPrintConnector("smb://127.0.0.1/EPSONTMT82IIReceipt");

// //$connector = new WindowsPrintConnector("smb://DELL-PRIYO/EPSONTMT82IIReceipt");
// $printer = new Printer($connector, $profile);


// /* Print some bold text */
//     $printer -> setJustification(Printer::JUSTIFY_CENTER);
// 	$printer -> setEmphasis(true);
//     $printer -> text("Advocate Welfare Society\n");
//     $printer -> text("Bankura\n");
//     $printer -> text("Date: " . now() . "\n");


// 	$printer -> feed();
//    $printer -> text("--------------------------------------\n");
//     $printer -> text("Receipt Number : " . $receiptCode . "\n");
//     $printer -> text("Head : " . $departmentName . "\n");
//     $printer -> text("--------------------------------------\n");
//     $printer -> text("Advocate Token\n");
//     $printer -> text("LA Token Number : " . $advocate_bar_code . "\n");
//     $printer -> text("Token Count : " . $Quantity . "\n");
//     $printer -> text("LA : Rs." . $advocate_share. ".00\n");
//     $printer -> setEmphasis(false);
//     $printer -> feed(3);
//     $printer -> barcode($advocate_bar_code);

//     $printer -> text("--------------------------------------\n");
//     $printer -> cut();
// 	/* Close printer */
// 	$printer -> close();
            }


            // // for WFC entry
            if($advocate_share == 0 && $notary_public_share == 0)
            {

              $profile = CapabilityProfile::load("simple");
                          $connector = new WindowsPrintConnector("smb://127.0.0.1/EPSONTMT82IIReceipt");

//$connector = new WindowsPrintConnector("smb://DELL-PRIYO/EPSONTMT82IIReceipt");
$printer = new Printer($connector, $profile);


/* Print some bold text */
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setEmphasis(true);
    $printer -> text("Advocate Welfare Society\n");
    $printer -> text("Bankura\n");
    $printer -> text("Date: " . now() . "\n");


	$printer -> feed();
   $printer -> text("--------------------------------------\n");
    $printer -> text("Receipt Number : " . $receiptCode . "\n");
    $printer -> text("Head : " . $departmentName . "\n");
    $printer -> text("--------------------------------------\n");
    $printer -> text("Welfare Token\n");

    $printer -> text("Token Count : " . $Quantity . "\n");
    $printer -> text("LA : Rs." . $AWC_share. ".00\n");
    $printer -> setEmphasis(false);
    $printer -> feed(3);


    $printer -> text("--------------------------------------\n");
    $printer -> cut();
	/* Close printer */
	$printer -> close();
        }


                if ($saveQuery_advocate > 0) {
                    // Daily Collection Saved
                    $result_data['responseData'] = "2";



                } else {
                    // Failed to save Daily Collection
                    $result_data['responseData'] = "3";

                }
            }
            else {
            $updateQuery = DB::table('daily_collection')
                ->where('collection_id', $collection_id)
                ->where('lms_center_id', $centerId)
                ->update([
                    'head_id' => $head_id,
                    'advocate_id' => $advocate_id,
                    'collection_updated_at' => now(),
                    'collection_updated_by'=>$loggedUserId

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            } else {
                $result_data['responseData'] = "5";

            }
        }



        return $result_data;

    }

    // Enable Disable Department
    public static function updateDepartment($centerId,
    $departmentName,$departmentId,$isDepartmentActive,$loggedUserId) {
        $updateQuery = DB::table('lms_department')
            ->where('lms_department_id', $departmentId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_department_name' => $departmentName,
                'lms_department_is_active' => $isDepartmentActive,
                'lms_department_updated_at' => now(),
                'lms_department_updated_by'=>$loggedUserId

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }


}
