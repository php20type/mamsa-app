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
use App\Models\PatientMedication;
use App\Models\PatientMedicalCondition;
use App\Models\PatientMonitoringFrequency;
use App\Models\PatientMedicationsTreatment;
use App\Models\PatientQuantitativeIndicators;
use App\Models\PatientLifestyleAndWellbeing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;
use App\Models\Hobby;
use App\Models\PatientFemilyMember;
use App\Models\PatientHobby;

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
        $patient = Patient::updateOrCreate(['id' => $request->patient_id], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'lang' => $request->lang, 'DOB' => $request->DOB, 'weight' => $request->weight,'gender'=>$request->gender]);
        if ($request->facility_ids != null) {
           foreach($request->facility_ids as $facility){
               $facilitydata=MedicalFecility::where('id',$facility)->first();
               if($facilitydata->facility_patients!=null){
                $patient_ids_array=explode(',',$facilitydata->facility_patients);
                if(!in_array($patient->id,$patient_ids_array)){
                    array_push($patient_ids_array,$patient->id);
                    MedicalFecility::where('id',$facility)->update(['facility_patients'=>implode(',',$patient_ids_array)]);
                }
               }else{
                   MedicalFecility::where('id',$facility)->update(['facility_patients'=>$patient->id]);
               }
           }
           $unassignedfacility=MedicalFecility::whereNotIn('id',$request->facility_ids)->whereRaw("FIND_IN_SET($patient->id,facility_patients)")->get();
           foreach($unassignedfacility as $unfacility){
                  $facility_ids_array=explode(',',$unfacility->facility_patients);
                   if (($key = array_search($patient->id, $facility_ids_array)) !== false) {
                       unset($facility_ids_array[$key]);
                   }
                   MedicalFecility::where('id',$unfacility->id)->update(['facility_patients'=>implode(',',$facility_ids_array)]);
           }
        }
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
        $userid = auth()->user()->id;
        $query = MedicalFecility::query();

        foreach (explode(',', $doctor_ids) as $id) {
            $query->orWhereRaw("FIND_IN_SET(?, facility_drs)", [$id]);
        }

        $medical_facilities = $query->pluck('id')->toArray();
        if ($medical_facilities) {
            $facility_ids = implode(',', $medical_facilities);
        }
        if ($request->patient_id != '') {
            $patient = Patient::updateOrCreate(['id' => $request->patient_id], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'DOB' => $request->DOB, 'weight' => $request->weight, 'lang' => $request->lang,'gender'=>$request->gender]);
        } else {
            $patient = Patient::updateOrCreate(['phone_number' => $request->phone_number], ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'phone_number' => $request->phone_number, 'facility_ids' => $facility_ids, 'doctor_ids' => $doctor_ids, 'preferred_time_from' => $request->preferred_time_from, 'preferred_time_to' => $request->preferred_time_to, 'frequency' => implode(',', $frequency_array), 'lang' => $request->lang, 'DOB' => $request->DOB, 'weight' => $request->weight,'gender'=>$request->gender]);
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
        $patient->weight = $request->input('weight');
        $patient->gender = $request->input('gender');

        // Save the updated patient
        $patient->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    public function getPatientData(Request $request)
    {
        $patient = Patient::where(DB::raw('RIGHT(phone_number, 10)'), substr($request->phone_number, -10))->first();
        if ($patient) {
            $monitordata = PatientMonitor::where('id', $patient->monitor_id)->first();
            $medication = Medication::where('id', $monitordata->medication)->first();
            $symptoms = Symptom::where('id', $monitordata->monitor_condition)->first();
            $doctor = User::where('id', $monitordata->doctor_id)->first();
            $messages = Message::where('receiver_id', $patient->id)->where('is_read', 0)->get();
            $messagetext = '';
            Message::where('receiver_id', $patient->id)->update(['is_read' => 1]);
            foreach ($messages as $message) {
                $messagetext .= $message->message;
            }
            $frequencyPattern = explode(',', $patient->frequency);
            $medical_condition = PatientMedicalCondition::where('patient_id', $patient->id)->first();
            $quantitative_indicators = PatientQuantitativeIndicators::where('patient_id', $patient->id)->first();
            $lifestyles = PatientLifestyleAndWellbeing::where('patient_id', $patient->id)->first();
            // Get today's day of the week (1 for Monday through 7 for Sunday)
            $today = Carbon::now()->dayOfWeekIso; // Monday = 1, Sunday = 7
            // Find the next enabled day
            $nextEnabledDay = '';
            for ($i = 1; $i < 7; $i++) {
                $dayIndex = ($today + $i - 1) % 7; // Adjust index to match array (0-6)
                if ($frequencyPattern[$dayIndex] == '1' && $nextEnabledDay == '') {
                    $nextEnabledDay = Carbon::now()->addDays($i)->format('l');
                }
            }
            $patientdata['FirstName'] = $patient->first_name;
            $patientdata['LastName'] = $patient->last_name;
            $patientdata['weight'] = $patient->weight;
            $patientdata['gender'] = $patient->gender;
            $patientdata['PatientID'] = $patient->patient_id;
            $patientdata['MonitoredCondition1'] = $symptoms->title;
            $patientdata['Meds1_Name'] = $medication->med_name;
            $patientdata['med_form_look'] = $medication->med_form_look;
            $patientdata['med_pack_look'] = $medication->med_pack_look;
            $patientdata['dose'] = $monitordata->dose;
            $patientdata['nextDay'] = $nextEnabledDay;
            $patientdata['message'] = $messagetext;
            $patientdata['medical_condition'] = $medical_condition;
            $patientdata['quantitative_indicators'] = $quantitative_indicators;
            $patientdata['lifestyles'] = $lifestyles;
            if (isset($doctor->firstname)) {
                $patientdata['medication_admin'] = $doctor->firstname;
            } else {
                $patientdata['medication_admin'] = '';
            }
            $history=MonitoringHistory::create(['patient_id'=>$patient->id,'rep_date' => now()]);
            $patientdata['history_id']=$history->id;
            return response()->json($patientdata);
        }
        return false;
    }
    public function storeMonitorHistory(Request $request)
    {
        $patient = Patient::where('patient_id', $request->patient_id)->first();
        $monitorhistory=MonitoringHistory::where('id',$request->history_id)->first();
        $montorcondition = PatientMonitor::where('id', $patient->monitor_id)->first();
        $lang = 'en';
        if ($request->lang) {
            $lang = $request->lang;
        }
        // Prepare the data array for update or create
        $data = [
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
        if ($request->filled('monitor_bloodpressure_measured')) {
            $data['monitor_bloodpressure_measured'] = $request->monitor_bloodpressure_measured;
        }
        if ($request->filled('monitor_bloodpressure_measure_now')) {
            $data['monitor_bloodpressure_measure_now'] = $request->monitor_bloodpressure_measure_now;
        }
        if ($request->filled('monitor_bloodpressure_systolic')) {
            $data['monitor_bloodpressure_systolic'] = $request->monitor_bloodpressure_systolic;
        }
        if ($request->filled('monitor_bloodpressure_diastolic')) {
            $data['monitor_bloodpressure_diastolic'] = $request->monitor_bloodpressure_diastolic;
        }
        if ($request->filled('monitor_bloodpressure_feeling')) {
            $data['monitor_bloodpressure_feeling'] = $request->monitor_bloodpressure_feeling;
        }
        if ($request->filled('notes')) {
            $data['notes'] = $request->notes;
            Message::create(['sender_id' => $monitorhistory->patient_id, 'receiver_id' => $monitorhistory->doctor_id, 'message' => $request->notes, 'message_sender' => 'patient']);
        }
        if($request->filled('monitor_chronicpain')){
            $data['monitor_chronicpain']=$request->monitor_chronicpain;
        }
        if($request->filled('monitor_chronicpain_location')){
            if($monitorhistory->monitor_chronicpain_location!=null){
                $chronicpain_location=explode(',',$monitorhistory->monitor_chronicpain_location);
                array_push($chronicpain_location,$request->monitor_chronicpain_location);
                $data['monitor_chronicpain_location']=implode(',',$chronicpain_location);
            }else{
                $data['monitor_chronicpain_location']=$request->monitor_chronicpain_location;
            }
        }
        if($request->filled('monitor_chronicpain_scale')){
            if($monitorhistory->monitor_chronicpain_scale!=null){
                $chronicpain_scale=explode(',',$monitorhistory->monitor_chronicpain_scale);
                array_push($chronicpain_scale,$request->monitor_chronicpain_scale);
                $data['monitor_chronicpain_scale']=implode(',',$chronicpain_scale);
            }else{
                $data['monitor_chronicpain_scale']=$request->monitor_chronicpain_scale;
            }
        }
        if($request->filled('monitor_sleep_well')){
            $data['monitor_sleep_well']=$request->monitor_sleep_well;
        }
        if($request->filled('monitor_sleep_reason')){
            $data['monitor_sleep_reason']=$request->monitor_sleep_reason;
        }
        if($request->filled('monitor_hydration_glasses')){
            $data['monitor_hydration_glasses']=$request->monitor_hydration_glasses;
        }
        if($request->filled('monitor_hydration_level')){
            $data['monitor_hydration_level']=$request->monitor_hydration_level;
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
        // Find the patient with all related data
        $patient = Patient::with([
            'PatientMedicalCondition',
            'PatientMedicationsTreatment',
            'PatientQuantitativeIndicators',
            'PatientLifestyleAndWellbeing'
        ])->find($request->id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found');
        }
        $hobbies = Hobby::all();
        $selectedHobbies = PatientHobby::where('patient_id', $patient->id)
            ->where('status', 1)
            ->pluck('hobby_id')
            ->toArray();
        $monitoringFrequency = PatientMonitoringFrequency::where('patient_id', $patient->id)->first();
        $patientmembers = PatientFemilyMember::where('patient_id', $patient->id)->get();
        $patientMedications = $patient->medications;
        $selectedDoctorIds = explode(',', $patient->doctor_ids);
        $doctors = User::all();

        // Pass the patient and related data to the view
        return view('doctor/editPatient', compact('patient', 'hobbies', 'selectedHobbies', 'patientMedications', 'monitoringFrequency', 'patientmembers', 'doctors', 'selectedDoctorIds'));
    }
    public function getPatientList(Request $request)
    {
        $userid = auth()->user()->id;
        $search = $request->search;
        if ($search != '') {
            $patients = Patient::whereRaw("FIND_IN_SET($userid,doctor_ids)")->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')->orWhere('last_name', 'LIKE', '%' . $search . '%');
            })->where('lang', app()->getLocale())
                ->orderBy('first_name', 'asc')
                ->get();
        } else {
            $patients = Patient::whereRaw("FIND_IN_SET($userid,doctor_ids)")->where('lang', app()->getLocale())
                ->orderBy('first_name', 'asc')
                ->get();
        }


        // Group patients by the first letter of their first name
        $groupedPatients = $patients->groupBy(function ($item) {
            return strtoupper(substr($item->first_name, 0, 1));
        });
        $html = '';
        foreach ($groupedPatients as $letter => $patients) {
            $html .= '<div class="d-flex"><span class="name-letter">' . $letter . '</span><ul class="first">';
            foreach ($patients as $patient) {
                $html .= '<li><a href="#">' . $patient->first_name . ', ' . $patient->last_name . '</a></li>';
            }
            $html .= '</ul></div>';
        }
        return $html;
    }

    public function updateMedicalCondition(Request $request)
    {
        $patientId = $request->input('patientId');
        $model = $request->input('model');
        $column = $request->input('column');
        $value = $request->input('value');

        $modelClass = 'App\\Models\\' . $model;
        $modelInstance = $modelClass::where('patient_id', $patientId)->first();

        if ($modelInstance) {
            // Update the existing record
            $modelInstance->$column = $value;
        } else {
            // Create a new record with the provided patient_id
            $modelInstance = new $modelClass;
            $modelInstance->patient_id = $patientId;
            $modelInstance->$column = $value;
        }

        // Save the record (either new or updated)
        $modelInstance->save();

        return response()->json(['success' => true]);
    }

    public function updateHobbyStatus(Request $request)
    {
        $hobbyId = $request->input('hobby_id');
        $isChecked = $request->input('is_checked');
        $patientId = $request->input('patient_id');
        // Check if the hobby already exists for the patient
        $patientHobby = PatientHobby::where('patient_id', $patientId)
            ->where('hobby_id', $hobbyId)
            ->first();

        if ($patientHobby) {
            if ($isChecked == 1) {
                // If checked and already exists, update the status to 1 (active)
                $patientHobby->update(['status' => 1]);
            } else {
                // If unchecked, update the status to 0 (inactive)
                $patientHobby->update(['status' => 0]);
            }
        } else if ($isChecked) {
            // If not exists and checked, create a new record
            PatientHobby::create([
                'patient_id' => $patientId,
                'hobby_id' => $hobbyId,
                'status' => 1
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function storeMedication(Request $request)
    {
        $request->validate([
            'medication' => 'required|string',
            'purpose_of_medication' => 'nullable|string',
            'use_schedule' => 'nullable|array', // Ensure it's validated as an array
            'food_use' => 'nullable|integer',
            'dose_use' => 'nullable|string',
            'doses_per_package' => 'nullable|string',
            'last_prescription_start' => 'nullable|date',
        ]);

        $useSchedule = $request->input('use_schedule', []);
        $useScheduleJson = json_encode($useSchedule); // Convert array to JSON string
        $medication = new PatientMedication([
            'patient_id' => $request->input('patient_id'),
            'medication' => $request->input('medication'),
            'purpose_of_medication' => $request->input('purpose_of_medication'),
            'use_schedule' => $useScheduleJson, // Save as JSON string
            'food_use' => $request->input('food_use'),
            'dose_use' => $request->input('dose_use'),
            'doses_per_package' => $request->input('doses_per_package'),
            'last_prescription_start' => $request->input('last_prescription_start'),
        ]);

        $medication->save();

        return response()->json([
            'message' => 'Medication Saved Successfully!',
            'id' => $medication->id
        ]);
    }

    public function updateMedication(Request $request)
    {
        $data = $request->all();
        $medication = PatientMedication::find($data['id']);
        // Update the existing medication
        $medication->update($data);

        return response()->json([
            'message' => 'Medication Updated Successfully!',
            'id' => $medication->id
        ]);
    }

    public function destroyMedication(Request $request)
    {
        $medicationId = $request->input('id');
        // Ensure the ID is present
        if (!$medicationId) {
            return response()->json(['success' => false, 'message' => 'ID not provided'], 400);
        }

        // Find and delete the medication
        $medication = PatientMedication::find($medicationId);

        if ($medication) {
            $medication->delete();
            return response()->json(['success' => true, 'message' => 'Medication deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Medication not found'], 404);
        }
    }

    public function saveMonitoringFrequency(Request $request)
    {
        $frequency = json_encode($request->input('frequency'));

        $monitoringFrequency = PatientMonitoringFrequency::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'patient_id' => $request->input('patient_id'),
                'frequency' => $frequency,
                'preferred_call_time' => $request->input('preferred_call_time')
            ]
        );

        return response()->json(['message' => 'Monitoring frequency saved successfully!', 'id' => $monitoringFrequency->id]);
    }
    public function deleteMember(Request $request)
    {
        PatientFemilyMember::where('id', $request->member_id)->delete();
        return response()->json(['status' => true]);
    }
    public function addMember(Request $request)
    {
        $membersname = $request->name;
        $member_ids = [];
        foreach ($membersname as $key => $member) {
            $member = PatientFemilyMember::updateOrCreate(['id' => $request->member_id[$key]], ['patient_id' => $request->patient_id, 'name' => $request->name[$key], 'phone' => $request->phone[$key], 'relation' => $request->relation[$key], 'email' => $request->email[$key]]);
            array_push($member_ids, $member->id);
        }
        return response()->json(['status' => true, 'member_ids' => $member_ids]);
    }
}
