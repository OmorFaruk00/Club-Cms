<?php

namespace App\Libraries;

use App\Models\Student;
use App\Models\Employee;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class bapi
{
    public static function ssl()
    {
        return stream_context_create(
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]
        );
    }
  

    public static function get_banks_all()
    {

        if (Cache::has('rms_get_banks')) {
            return $result = Cache::get('rms_get_banks');
        }

        $data_result = json_decode(file_get_contents('' . env('BAPI_URL') . '/get_banks', false, self::ssl()));

        if (!empty($data_result)) {
            Cache::put('rms_get_banks', $data_result, 700); //1440 minute = 1 day
            return $data_result;
        }
        return NULL;
    }

    public static function get_purpose_pay()
    {
        if (Cache::has('rms_get_purpose_pay')) {
            return $result = Cache::get('rms_get_purpose_pay');
        }

        $data_result = json_decode(file_get_contents('' . env('BAPI_URL') . '/get-purpose-pay', false, self::ssl()));

        if (!empty($data_result)) {
            Cache::put('rms_get_purpose_pay', $data_result, 700); //1440 minute = 1 day
            return $data_result;
        }
        return NULL;
      
    }

    public static function get_departments()
    {

        if (Cache::has('rms_departments')) {
            return $result = Cache::get('rms_departments');
        }

        $data_result = json_decode(file_get_contents('' . env('BAPI_URL') . '/get_deptartments', false, self::ssl()));

        if (!empty($data_result)) {
            Cache::put('rms_departments', $data_result, 700); //1440 minute = 1 day
            return $data_result;
        }
        return NULL;       
    }

    public static function get_batch_id_name($department_id)
    {   
        if (Cache::has('rms_get_batch_id_name_' . $department_id)) {

            $result = Cache::get('rms_get_batch_id_name_' . $department_id);
            return response()->json($result, 201);
        }

        $data_result = json_decode(@file_get_contents('' . env('BAPI_URL') . '/get_batch_id_name/' . $department_id . '', false, self::ssl()));

        if (!empty($data_result)) {

            Cache::put('rms_get_batch_id_name_' . $department_id, $data_result, 1440); //1440 minute = 1 day

            return response()->json($data_result, 201);
        }
        return response()->json(NULL, 404);
    }

    public static function get_students_by_batch_id($batch_id)
    {      

        $url = env('BAPI_URL') . '/get_students_by_batch_id/' . $batch_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content['data'];
        }
        return null;

    }
    public static function student_info_with_complete_semester_result($student_id)
    {
        $url = env('BAPI_URL') . '/student/' . $student_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();


        if ($response->status == 200) {
            return $response->content;
        }else{
            return $response;
        }

        return false;

    }

    public static function student_provisional_transcript_marksheet_info_by_student_id($student_id)
    {
        $url = env('BAPI_URL') . '/provisional-transcript-marksheet-info/' . $student_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();


        if ($response->status == 200) {
            return $response->content;
        }else
        {
            return $response;
        }

        return false;
    }

    public static function purposeInfo($purpose_id)
    {
        $url = env('BAPI_URL') . '/get-purpose-pay/' . $purpose_id;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public static function get_student_by_id($std_id, $by_array = false)
    {
        $result = json_decode(@file_get_contents('' . env('BAPI_URL') . '/get_student_by_id/' . $std_id . '', false, self::ssl()), $by_array);
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }
    public static function student_account_info_summary($student_id)
    {
        $url = '' . env('BAPI_URL') . '/student_account_info_summary/' . $student_id;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }
    public static function student_account_info_summary_by_reg($reg)
    {
        $url = '' . env('BAPI_URL') . '/student_account_info_summary_by_reg/' . $reg;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }
    public static function get_student_by_like_reg_code($reg)
    {
        $url = '' . env('BAPI_URL') . '/get_student_by_like_reg_code/' . $reg;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public static function student_account_info($student_id)
    {
        $url = '' . env('BAPI_URL') . '/student_account_info/' . $student_id;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }
    public static function student_account_info_by_reg($reg)
    {
        $url = '' . env('BAPI_URL') . '/student_account_info_by_reg/' . $reg;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public static function download_regular_admit_card($student_id)
    {
        $result = json_decode(@file_get_contents('' . env('BAPI_URL') . '/download_regular_admit_card/' . $student_id . '', false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }
        return NULL;
    }
    public static function  update_students_actual_fee($input)
    {
        $url = env('BAPI_URL') . '/update-students-actual-fee-and-number-of-semester';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }
    public static function  update_ct_students_actual_fee($input)
    {
        $url = env('BAPI_URL') . '/update-ct-students-actual-fee-and-semester-n-paymenet-from-semseter';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }
    public static function  apply_extra_fee_on_students($input)
    {
        $url = env('BAPI_URL') . '/apply-extra-fee-on-students';
        $response = Curl::to($url)->withData($input)->returnResponseObject()->asJson(true)->put();
        return response()->json($response->content, $response->status);
    }

    public static function covid_accounts_report($batchId)
    {
        $result = json_decode(@file_get_contents('' . env('BAPI_URL') . '/get-batch-wise-account-info/' . $batchId, false, self::ssl()));

        $returnArray = [];

        if (!empty($result)) {

            // dd($result);

            foreach ($result as $array) {

                if (strlen($array->phone_no) > 10 &&
                    (
                        strlen($array->f_cellno) > 10 ||
                        strlen($array->m_cellno) > 10 ||
                        strlen($array->e_cellno) > 10 ||
                        strlen($array->g_cellno) > 10
                    )) {

                    $array->phone_no = '+88' . $array->phone_no;

                    if (strlen($array->f_cellno) > 10) {
                        $array->fme = '+88' . $array->f_cellno;
                    } elseif (strlen($array->m_cellno) > 10) {
                        $array->fme = '+88' . $array->m_cellno;
                    } elseif (strlen($array->g_cellno) > 10) {
                        $array->fme = '+88' . $array->g_cellno;
                    } elseif (strlen($array->e_cellno) > 10) {
                        $array->fme = '+88' . $array->e_cellno;
                    } else {
                        $array->fme = 'NF';
                    }

                } else {
                    $stdFromStdSite = Student::where('id', $array->id)->first();
                    if ($stdFromStdSite) {
                        // dd($stdFromStdSite );   
                        $array->phone_no = '+88' . $stdFromStdSite->PHONE_NO;

                        if ($stdFromStdSite->F_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->F_CELLNO;
                        } elseif ($stdFromStdSite->M_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->M_CELLNO;
                        } elseif ($stdFromStdSite->G_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->G_CELLNO;
                        } elseif ($stdFromStdSite->E_CELLNO) {
                            $array->fme = '+88' . $stdFromStdSite->E_CELLNO;
                        } else {
                            $array->fme = 'NF';
                        }
                    }
                }


                $returnArray[] = $array;
            }


            return response()->json($returnArray, 200);
        }
        return response()->json(NULL, 404);
    }
    public static function covid_discount_as_scholarship($request, int $stdId, float $amount)
    {
        $office_email = Employee::findOrFail($request->auth->id)->office_email;

        $url = '' . env('BAPI_URL') . '/covid-discount-as-scholarhip?std_id=' . $stdId . '&amount=' . $amount . '&office_email=' . $office_email;
        $response = Curl::to($url)->returnResponseObject()->asJson(true)->get();

        return response()->json($response->content, $response->status);
    }
   
    public static function get_student_by_regcode_partial($txid, $regcodepart){
        
       
        $result = json_decode(@file_get_contents('' . env('BAPI_URL') . '/get-student-by-regcode-part/'  . $txid . '/' . $regcodepart . '', false, self::ssl()));
        if (!empty($result)) {
            return $result;
        }
        return NULL;     
    }
    public static function student_fetch_all_course_by_student_id_and_semester($student_id, $semester)
    {   
        $url = env('BAPI_URL') . '/semester-course-list/' . $student_id . '/' . $semester;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }
        return false;
    }

    public static function get_current_improvement_exam_schedule()
    {

        if (Cache::has('rms_get_current_improvement_exam_schedule')) {

            $result = Cache::get('rms_get_current_improvement_exam_schedule');

            return $result;

        }

        $result = json_decode(file_get_contents('' . env('BAPI_URL') . '/get_current_improvement_exam_schedule', false, self::ssl()));

        if (!empty($result)) {
            Cache::put('rms_get_current_improvement_exam_schedule', $result, 700); //1440 minute = 1 day
            return $result;
        }
        return NULL;
    }

    public static function student_search_reg_code($reg)
    {
   
        $url = env('BAPI_URL') . '/admission/student-filter/' . $reg;
        $curl = Curl::to($url)->returnResponseObject();
        $curl->asJson(true);
        $response = $curl->get();

        if ($response->status == 200) {
            return $response->content;
        }

        return false;
    }
  
   

    
}
