<?php

namespace App\Http\Controllers;

use App\Models\MedicalFecility;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalFecilityController extends Controller
{
    //
    public function index(Request $request)
    {

        $medications = MedicalFecility::where('lang',app()->getLocale())->get();
        $doctors=User::all();
        $patients=Patient::all();
        return view('medical_fecility', compact('medications','doctors','patients'));
    }
    public function store(Request $request)
    {
        $doctors='';
        $patients='';
        if($request->doctor!=null){
            $doctors=implode(',',$request->doctor);
        }
        if($request->patient!=null){
            $patients=implode(',',$request->patient);
        }
        $facility=MedicalFecility::updateOrCreate(['id' => $request->fec_id], ['facility_name' => $request->facility_name, 'facility_drs' => $doctors,'facility_patients'=>$patients,'lang'=>$request->lang]);
        if ($request->fec_id != '') {
            return redirect()->back()->with('success', __('facility.Medical Fecility Updated Successfully'));
        }
        $med_id=sprintf('%04d', $facility->id);
        MedicalFecility::where('id',$facility->id)->update(['facility_id'=>$med_id]);
        return redirect()->back()->with('success', __('facility.Medical Fecility Added Successfully'));
    }
    public function delete(Request $request)
    {
        MedicalFecility::where('id',$request->id)->delete();

        return redirect()->back()->with('success',__('facility.Medical Fecility Deleted Successfully'));
    }
}
