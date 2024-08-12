<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Symptom;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    //
    public function index(Request $request)
    {

        $medications = Medication::where('lang',app()->getLocale())->get();
        // $contraindications=Medication::select('med_contraindications')->groupBy('med_contraindications')->pluck('med_contraindications')->toArray();
        $sideeffect=Symptom::select('title','lang')->whereNotNull('title')->get();
        return view('medication', compact('medications','sideeffect'));
    }
    public function store(Request $request)
    {
        $med_sideeffects='';
        if($request->med_sideeffects!=null){
            $med_sideeffects= implode(',',$request->med_sideeffects);
        }
        $medicin=Medication::updateOrCreate(['id' => $request->medication_id], ['med_name'=>$request->med_name,'med_form' => $request->med_form,'med_form_look'=>$request->med_form_look, 'med_pack_look' => $request->med_pack_look,'med_sideeffects'=>$med_sideeffects,'lang'=>$request->lang]);
        if ($request->medication_id != '') {
            return redirect()->back()->with('success', __('medication.Medication Updated Successfully'));
        }
        $med_id=sprintf('%04d', $medicin->id);
        Medication::where('id',$medicin->id)->update(['med_id'=>$med_id]);
        return redirect()->back()->with('success', __('medication.Medication Added Successfully'));
    }
    public function delete(Request $request)
    {
        Medication::where('id',$request->id)->delete();

        return redirect()->back()->with('success',__('medication.Medication Deleted Successfully'));
    }
}
