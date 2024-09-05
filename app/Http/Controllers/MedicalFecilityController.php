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
        $patientArray=$request->patient;
        if($request->doctor!=null){
            $doctors=implode(',',$request->doctor);
            foreach($request->doctor as $doctor){
                $patientlist=Patient::whereRaw("FIND_IN_SET($doctor,doctor_ids)")->get();
                foreach($patientlist as $patients){
                    if(!in_array($patients->id,$patientArray)){
                        array_push($patientArray,$patients->id);
                    }
                }
            }
        }
        if($patientArray!=null){
            $patients=implode(',',$patientArray);
        }
       
        $facility=MedicalFecility::updateOrCreate(['id' => $request->fec_id], ['facility_name' => $request->facility_name, 'facility_drs' => $doctors,'facility_patients'=>$patients,'lang'=>$request->lang]);
       
        if($patientArray!=null){
            $patients=implode(',',$patientArray);
            foreach($patientArray as $patient){
                $patientdata=Patient::where('id',$patient)->first();
                if($patientdata->facility_ids!=null){
                    $facility_ids_array=explode(',',$patientdata->facility_ids);
                    if(!in_array($facility->id,$facility_ids_array)){
                        array_push($facility_ids_array,$facility->id);
                        Patient::where('id',$patient)->update(['facility_ids'=>implode(',',$facility_ids_array)]);
                    }

                }else{
                    Patient::where('id',$patient)->update(['facility_ids'=>$facility->id]);
                }
            }
            $unassignedpatient=Patient::whereNotIn('id',$patientArray)->whereRaw("FIND_IN_SET($facility->id,facility_ids)")->get();
            foreach($unassignedpatient as $unpatient){
                   $facility_ids_array=explode(',',$unpatient->facility_ids);
                    if (($key = array_search($facility->id, $facility_ids_array)) !== false) {
                        unset($facility_ids_array[$key]);
                    }
                    Patient::where('id',$unpatient->id)->update(['facility_ids'=>implode(',',$facility_ids_array)]);
            }
        }
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
