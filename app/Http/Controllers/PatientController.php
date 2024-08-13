<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalFecility;
use App\Models\Medication;
use App\Models\Message;
use App\Models\MonitoringHistory;
use App\Models\Patient;
use App\Models\PatientMonitor;
use App\Models\Symptom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    //
    public function index(Request $request)
    {
        $patients = new Patient();
        $search = $request->search;
        $facility_id = $request->facility;
        $doctor_id = $request->doctor;
        if ($search != '') {
            $patients = $patients->where(function ($query) use ($search) {
                return $query->where('first_name', 'LIKE', '%' . $search . '%')->orWhere('first_name', 'LIKE', '%' . $search . '%');
            });
        }
        if ($facility_id != '') {
            $patients = $patients->whereRaw("FIND_IN_SET($facility_id,facility_ids)");
        }
        if ($doctor_id != '') {
            $patients = $patients->whereRaw("FIND_IN_SET($doctor_id,doctor_ids)");
        }
        $patients = $patients->where('lang', app()->getLocale())->get();
        $doctors = User::all();
        $facilities = MedicalFecility::all();
        return view('patients', compact('patients', 'doctors', 'facilities', 'search', 'facility_id', 'doctor_id'));
    }
    public function store(Request $request)
    {
        $patientId = $request->patient_id;
        $request->validate([
            'first_name' => 'required',
            'phone_number' => [
                'required',
                // Unique phone number, ignore the current record during update
                Rule::unique('patients')->ignore($patientId),
            ],
        ]);
        $frequency = $request->frequency;
        $frequency_array = array();
        for ($i = 0; $i < 7; $i++) {
            if (!isset($frequency[$i])) {
                array_push($frequency_array, 0);
            } else {
                array_push($frequency_array, 1);
            }
        }
        $doctor_ids = '';
        $facility_ids = '';
        if ($request->doctor_ids != null) {
            $doctor_ids = implode(',', $request->doctor_ids);
        }
        if ($request->facility_ids != null) {
            $facility_ids = implode(',', $request->facility_ids);
        }
        $patient = Patient::updateOrCreate(['id' => $request->patient_id], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'lang' => $request->lang, 'DOB' => $request->DOB, 'weight' => $request->weight]);

        if ($request->patient_id != '') {
            return redirect()->back()->with('success', __('patient.Patient Updated Successfully'));
        }
        $patient_id = sprintf('%04d', $patient->id);
        Patient::where('id', $patient->id)->update(['patient_id' => $patient_id]);
        return redirect()->back()->with('success', __('patient.Patient Added Successfully'));
    }
    public function delete(Request $request)
    {
        Patient::where('id', $request->id)->delete();

        return redirect()->back()->with('success', __('patient.Patient Deleted Successfully'));
    }
    public function updateFrequency(Request $request)
    {
        $patientId = $request->input('patient_id');
        $dayIndex = $request->input('day_index');
        $checked = $request->input('checked');

        // Find the patient record
        $patient = Patient::find($patientId);

        // Check if the frequency field is null and initialize it
        if (is_null($patient->frequency)) {
            $frequencyArray = array_fill(0, 7, 0); // Initialize an array with 7 zeros
        } else {
            // Split the existing frequency field into an array
            $frequencyArray = explode(',', $patient->frequency);
        }

        // Update the specific day's frequency
        $frequencyArray[$dayIndex] = $checked;

        // Convert the array back to a comma-separated string
        $patient->frequency = implode(',', $frequencyArray);

        // Save the updated patient record
        $patient->save();

        return response()->json(['success' => true]);
    }
    public function patientFile(Request $request)
    {
        $patients = new Patient();
        $search = $request->search;
        $facility_id = $request->facility;
        $doctor_id = auth()->user()->id;
        if ($search != '') {
            $patients = $patients->where(function ($query) use ($search) {
                return $query->where('first_name', 'LIKE', '%' . $search . '%')->orWhere('first_name', 'LIKE', '%' . $search . '%');
            });
        }
        if ($facility_id != '') {
            $patients = $patients->whereRaw("FIND_IN_SET($facility_id,facility_ids)");
        }

        $patients = $patients->whereRaw("FIND_IN_SET($doctor_id,doctor_ids)");
        $patients = $patients->where('lang', app()->getLocale())->get();
        $doctors = User::all();
        $facilities = MedicalFecility::all();
        return view('doctor/patients', compact('patients', 'doctors', 'facilities', 'search', 'facility_id', 'doctor_id'));
    }
    public function storePatientFile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'phone_number' => 'required',
            // additional fields...
        ]);
        $frequency = $request->frequency;
        $frequency_array = array();
        for ($i = 0; $i < 7; $i++) {
            if (!isset($frequency[$i])) {
                array_push($frequency_array, 0);
            } else {
                array_push($frequency_array, 1);
            }
        }
        $facility_ids = '';
        $patientdata = Patient::where('phone_number', $request->phone_number)->first();
        if (isset($patientdata->doctor_ids) && $patientdata->doctor_ids != '') {
            $doctor_ids = $patientdata->doctor_ids . ',' . auth()->user()->id;
        } else {
            $doctor_ids = auth()->user()->id;
        }
        if ($request->facility_ids != null) {
            $facility_ids = implode(',', $request->facility_ids);
        }
        if ($request->patient_id != '') {
            $patient = Patient::updateOrCreate(['id' => $request->patient_id], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'DOB' => $request->DOB, 'weight' => $request->weight, 'lang' => $request->lang]);
        } else {
            $patient = Patient::updateOrCreate(['phone_number' => $request->phone_number], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'lang' => $request->lang, 'DOB' => $request->DOB, 'weight' => $request->weight]);
        }
        if ($request->patient_id != '') {
            return redirect()->back()->with('success', __('patient.Patient Updated Successfully'));
        }
        $patient_id = sprintf('%04d', $patient->id);
        Patient::where('id', $patient->id)->update(['patient_id' => $patient_id]);
        return redirect()->back()->with('success', __('patient.Patient Added Successfully'));
    }
    public function updateData(Request $request)
    {

        // Validate the request
        // $validatedData = $request->validate([
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'other_number' => 'nullable|string|regex:/^\+?[1-9]\d{1,14}$/|max:20', // Phone number validation
        //     'address' => 'nullable|string|max:255',
        //     'DOB' => 'nullable|date',
        // ]);

        // Find the patient or user model
        $patient = Patient::find($request->patient_id); // Adjust to how you identify the patient

        // Check if the request has a file
        if ($request->hasFile('image')) {
            // Store the file and get its path
            $imagePath = $request->file('image')->store('public/patient_images');
            $imageName = basename($imagePath);
            
            // Update the patient's image
            $patient->image = $imageName;
        }

        // Update other fields
        $patient->first_name = $request->input('first_name');
        $patient->last_name = $request->input('last_name');
        $patient->other_number = $request->input('other_number');
        $patient->address = $request->input('address');
        $patient->DOB = $request->input('DOB');

        // Save the updated patient
        $patient->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    public function getPatientData(Request $request)
    {
        $patient = Patient::where(DB::raw('RIGHT(phone_number, 10)'), substr($request->phone_number, -10))->first();
        $monitordata = PatientMonitor::where('id', $patient->monitor_id)->first();
        $medication=Medication::where('id',$monitordata->medication)->first();
        $symptoms=Symptom::where('id',$monitordata->monitor_condition)->first();
        $doctor=User::where('id',$monitordata->doctor_id)->first();
        $messages = Message::where('receiver_id', $patient->id)->where('is_read', 0)->get();
        $messagetext = '';
        Message::where('receiver_id', $patient->id)->update(['is_read' => 1]);
        foreach ($messages as $message) {
            $messagetext .= $message->message;
        }
        $frequencyPattern = explode(',', $patient->frequency);

        // Get today's day of the week (1 for Monday through 7 for Sunday)
        $today = Carbon::now()->dayOfWeekIso; // Monday = 1, Sunday = 7
        // Find the next enabled day
        $nextEnabledDay='';
        for ($i = 1; $i < 7; $i++) {
            $dayIndex = ($today + $i - 1) % 7; // Adjust index to match array (0-6)
            if ($frequencyPattern[$dayIndex] == '1' && $nextEnabledDay=='') {
                $nextEnabledDay = Carbon::now()->addDays($i)->format('l');
            }
        }
        $patientdata['FirstName'] = $patient->first_name;
        $patientdata['LastName'] = $patient->last_name;
        $patientdata['PatientID'] = $patient->patient_id;
        $patientdata['MonitoredCondition1'] = $symptoms->title;
        $patientdata['Meds1_Name'] = $medication->med_name;
        $patientdata['med_form_look'] = $medication->med_form_look;
        $patientdata['med_pack_look'] = $medication->med_pack_look;
        $patientdata['dose'] = $monitordata->dose;
        $patientdata['nextDay']=$nextEnabledDay;
        $patientdata['message'] = $messagetext;
        if(isset($doctor->firstname)){
            $patientdata['medication_admin']=$doctor->firstname;
        }else{
            $patientdata['medication_admin']='';
        }
        return response()->json($patientdata);
    }
    public function storeMonitorHistory(Request $request)
    {
        $patient = Patient::where('patient_id', $request->patient_id)->first();
        $montorcondition = PatientMonitor::where('id', $patient->monitor_id)->first();

        $lang = 'en';
        if ($request->lang) {
            $lang = $request->lang;
        }
        // Prepare the data array for update or create
        $data = [
            'doctor_id' => $montorcondition->doctor_id,
            'patient_id' => $montorcondition->patient_id,
            'monitor_id' => $montorcondition->id,
            'lang' => $lang,
            'rep_date' => now(), // Using Laravel's now() helper for current date and time
        ];

        // Conditionally add the parameters if they are present and not null
        if ($request->filled('rep_overall')) {
            $data['rep_overall'] = $request->rep_overall;
        }
        if ($request->filled('rep_overall_neg')) {
            $data['rep_overall_neg'] = $request->rep_overall_neg;
        }
        if ($request->filled('rep_overall_bodypart')) {
            $data['rep_overall_bodypart'] = $request->rep_overall_bodypart;
        }
        if ($request->filled('rep_monitor_condition')) {
            $data['rep_monitor_condition'] = $request->rep_monitor_condition;
        }
        if ($request->filled('rep_monitor_condition_neg')) {
            $data['rep_monitor_condition_neg'] = $request->rep_monitor_condition_neg;
        }
        if ($request->filled('rep_medication')) {
            $data['rep_medication'] = $request->rep_medication;
        }
        if ($request->filled('rep_medication_neg')) {
            $data['rep_medication_neg'] = $request->rep_medication_neg;
        }
        if ($request->filled('rep_medication_sideeffect')) {
            $data['rep_medication_sideeffect'] = $request->rep_medication_sideeffect;
        }
        if ($request->filled('rep_medication_bodypart')) {
            $data['rep_medication_bodypart'] = $request->rep_medication_bodypart;
        }
        if ($request->filled('notes')) {
            $data['notes'] = $request->notes;
            Message::create(['sender_id'=>$montorcondition->patient_id,'receiver_id'=>$montorcondition->doctor_id,'message'=>$request->notes,'message_sender'=>'patient']);
        }

        // Update or create the MonitoringHistory record with the prepared data
        $MonitoringHistory = MonitoringHistory::updateOrCreate(
            ['id' => $request->history_id],
            $data
        );
        return response()->json($MonitoringHistory);
    }
    public function patientDetail(Request $request)
    {
        return view('doctor/patient_detail');
    }
    public function editPatient(Request $request)
    {
        
        $patient = Patient::find($request->id);
        return view('doctor/editPatient',compact('patient'));
    }
}
