<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientMonitor;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Auth;
use DB;

class OutboundController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $userid = auth()->user()->id;
        $paientslist = Patient::select('patients.*')->with(['patientHistory' => function ($query) {
            $query->select('patient_id', DB::raw('GROUP_CONCAT(rep_overall) as over_rep_combined'),DB::raw('SUM(rep_overall) as total_value'),DB::raw('count(rep_overall) as total_days'),DB::raw('GROUP_CONCAT(DATE_FORMAT(rep_date, "%Y-%m-%d")) as rep_dates'))
                  ->groupBy('patient_id');
        }])->whereRaw("FIND_IN_SET($userid,doctor_ids)")->where('lang', app()->getLocale())
            ->orderBy('first_name', 'asc')
            ->get();
        $patients = Patient::whereRaw("FIND_IN_SET($userid,doctor_ids)")->where('lang', app()->getLocale())
            ->orderBy('first_name', 'asc')
            ->get();

        // Group patients by the first letter of their first name
        $groupedPatients = $patients->groupBy(function ($item) {
            return strtoupper(substr($item->first_name, 0, 1));
        });
        $doctorId = Auth::id(); // Assuming the logged-in user is a doctor

        $topSymptoms = Symptom::select('symptoms.title', DB::raw('count(distinct patient_monitors.patient_id) as patient_count'))
            ->join('patient_monitors', function ($join) use ($doctorId) {
                $join->on(DB::raw("FIND_IN_SET(symptoms.id, patient_monitors.monitor_condition)"), '>', DB::raw('0'))
                    ->where('patient_monitors.doctor_id', $doctorId);
            })
            ->groupBy('symptoms.title')
            ->orderByDesc('patient_count')
            ->limit(5)
            ->get();
        $patients = Patient::whereRaw("FIND_IN_SET($userid,doctor_ids)")->get();
        return view('welcome', compact('paientslist', 'groupedPatients', 'patients','topSymptoms'));
    }
    public function call(Request $request)
    {
        $monitor_condition = PatientMonitor::where('id', $request->patient_id)->first();
        Patient::where('id', $monitor_condition->patient_id)->update(['monitor_id' => $request->patient_id]);
        $patient = Patient::where('id', $monitor_condition->patient_id)->first();
        $phone_number = $patient->phone_number;
        $data['bot'] = 'st-6f87a15a-fd93-5476-bee4-390dded02853';
        $data['target'] = $phone_number;
        $data['caller'] = '+421800223184';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://smartassist.kore.ai/api/1.1/public/bot/st-6f87a15a-fd93-5476-bee4-390dded02853/smartassist/dialout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Auth: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6ImNzLWM4MTUxOGRkLWU0MGEtNTJkYS1hYzNmLTBmOGQ0YTZjODlhMCJ9.qPOadjHTFpjoc2AV-CAdCU-2KFmjyo143AJrc7_LgtU',
                'accountId: 6605460a50c7c155ebe5324d',
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);
        dd($response);
        if (isset($response['callId'])) {
            return redirect()->back()->with('success', 'Outbound Call Execute Successfully !');
        }
    }
    public function getHistory(Request $request)
    {

        $callID = '96551ae8-ce6b-123d-fc8f-0e07acdd3d1b';
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://smartassist.kore.ai/api/1.1/public/bot/st-6dca4177-14d6-543a-82a3-f0ea628ccbae/recordings?sessionId=66b1d6206aa0ba0afa841004');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Auth: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6ImNzLWM4MTUxOGRkLWU0MGEtNTJkYS1hYzNmLTBmOGQ0YTZjODlhMCJ9.qPOadjHTFpjoc2AV-CAdCU-2KFmjyo143AJrc7_LgtU';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        dd($result);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://smartassist.kore.ai/agentassist/api/v1/public/st-6dca4177-14d6-543a-82a3-f0ea628ccbae/conversations');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Auth: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6ImNzLWM4MTUxOGRkLWU0MGEtNTJkYS1hYzNmLTBmOGQ0YTZjODlhMCJ9.qPOadjHTFpjoc2AV-CAdCU-2KFmjyo143AJrc7_LgtU';
        $headers[] = 'Accountid: 6605460a50c7c155ebe5324d';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        dd($result);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://smartassist.kore.ai/agentassist/api/public/analytics/account/6605460a50c7c155ebe5324d/v2/interactionDetails?offset=0&limit=100');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"startDate\": \"2024-08-05\",\n    \"endDate\": \"2024-08-06\",\n    \"selectedFields\": [\n        \"skills\",\n        \"userleveltags\",\n        \"sessionleveltags\",\n        \"customerinfo\"\n    ],\n    \"timeZoneOffset\": -330\n}");

        $headers = array();
        $headers[] = 'Auth: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6ImNzLWM4MTUxOGRkLWU0MGEtNTJkYS1hYzNmLTBmOGQ0YTZjODlhMCJ9.qPOadjHTFpjoc2AV-CAdCU-2KFmjyo143AJrc7_LgtU';
        $headers[] = 'Accountid: 6605460a50c7c155ebe5324d';
        $headers[] = 'Accept: application/json, text/plain, /';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        dd($result);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://smartassist.kore.ai/api/1.1/public/bot/st-6dca4177-14d6-543a-82a3-f0ea628ccbae/conversationDetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Auth: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6ImNzLWM4MTUxOGRkLWU0MGEtNTJkYS1hYzNmLTBmOGQ0YTZjODlhMCJ9.qPOadjHTFpjoc2AV-CAdCU-2KFmjyo143AJrc7_LgtU',
                'accountId: 6605460a50c7c155ebe5324d',
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);
    }
}
