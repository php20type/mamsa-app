<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Patient;
use App\Models\PatientMonitor;
use App\Models\Symptom;
use Illuminate\Http\Request;

class PatientMonitorController extends Controller
{
    //
    public function index(){
        $doctor_id=auth()->user()->id;
        $symptoms=Symptom::all();
        $medications=Medication::all();
        $patients=Patient::whereRaw("FIND_IN_SET($doctor_id,doctor_ids)")->get();
        $monitor_conditions=PatientMonitor::where('doctor_id',$doctor_id)->where('lang',app()->getLocale())->get();
        return view('doctor/monitor',compact('symptoms','medications','patients','monitor_conditions'));
    }
    public function store(Request $request){
        PatientMonitor::updateOrCreate(['id' => $request->monitor_id], ['doctor_id'=>auth()->user()->id,'patient_id'=>$request->patient_id,'monitor_condition' => $request->monitor_condition, 'medication' =>$request->medication,'dose'=>$request->dose,'lang'=>$request->lang]);
        if ($request->monitor_id != '') {
            return redirect()->back()->with('success', __('monitor.Monitor Condition Updated Successfully'));
        }
        return redirect()->back()->with('success', __('monitor.Monitor Condition Added Successfully'));
    }
    public function delete(Request $request)
    {
        PatientMonitor::where('id', $request->id)->delete();

        return redirect()->back()->with('success', __('monitor.Monitor Condition Deleted Successfully'));
    }
}
