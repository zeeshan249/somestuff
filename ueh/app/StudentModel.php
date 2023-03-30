<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class StudentModel extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected  $primaryKey = "student_id";
    protected  $table = "ueh_student";
    public  $timestamps = false;

    public static function approveRejectCertificate(
        $certificateId,
        $certificateStatus,
        $franchiseId,
        $studentId
    ) {
        if ($certificateStatus == "2") {

            //trans

            $exception = DB::transaction(function () use (
                $certificateId,
                $certificateStatus,
                $franchiseId,
                $studentId
            ) {



                //
                $get_query =  DB::table('ueh_franchise')
                    ->join('ueh_state', 'ueh_state.state_id', '=', 'ueh_franchise.state_id')
                    ->select(['ueh_state.state_code'])
                    ->where('ueh_franchise.franchise_id', $franchiseId)
                    ->get();

                $certificate_code_prefix = "UEH/" . $get_query[0]->state_code . "/" . date('y') . "/C";

                $certificate_ueh_number = IdGenerator::generate([
                    'table' => 'ueh_certificate', 'length' => 16, 'prefix' => $certificate_code_prefix,
                    'reset_on_prefix_change' => true, 'field' => 'certificate_ueh_number'
                ]);


                DB::table('ueh_certificate')
                    ->where('certificate_id', $certificateId)
                    ->update([
                        'certificate_status' => $certificateStatus,
                        'certificate_ueh_number' => $certificate_ueh_number,
                        'certificate_approved_rejected_on' => now()

                    ]);

                DB::table('ueh_student')
                    ->where('student_id', $studentId)
                    ->update([
                        'student_status' => 3


                    ]);
            });

            if (is_null($exception)) {

                $save_data['Result'] = "1";
            } else {

                $save_data['Result'] = "2";
            }
            //End


        } else {





            //
            //trans

            $exception = DB::transaction(function () use (
                $certificateId,
                $certificateStatus,
                $franchiseId,
                $studentId
            ) {


                DB::table('ueh_certificate')
                    ->where('certificate_id', $certificateId)
                    ->update([
                        'certificate_status' => $certificateStatus,
                        'certificate_approved_rejected_on' => now()

                    ]);


                DB::table('ueh_student')
                    ->where('student_id', $studentId)
                    ->update([
                        'student_status' => 4


                    ]);
            });

            if (is_null($exception)) {

                $save_data['Result'] = "3";
            } else {

                $save_data['Result'] = "4";
            }
            //End


            //

        }
        return $save_data;
    }
}
