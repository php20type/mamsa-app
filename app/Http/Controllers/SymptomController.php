<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    //
    public function index(Request $request)
    {

        $symptoms = Symptom::where('lang',app()->getLocale())->get();
        return view('symptom', compact('symptoms'));
    }
    public function store(Request $request)
    {
        Symptom::updateOrCreate(['id' => $request->symptom_id], ['title' => $request->title, 'value' => $request->value,'bodypart'=>$request->bodypart, 'synonyms' => $request->symptoms,'category'=>$request->category,'emergency'=>$request->emergency,'lang'=>$request->lang]);
        if ($request->symptom_id != '') {
            return redirect()->back()->with('success', __('symptom.Symptoms Updated Successfully'));
        }
        return redirect()->back()->with('success', __('symptom.Symptoms Added Successfully'));
    }
    public function list(Request $request)
    {
        $lang='en';
        if(isset($request->lang) && $request->lang!=''){
            $lang=$request->lang;
        }
        $symptoms = Symptom::where('lang',$lang)->get();

        // Format synonyms field as array
        $symptoms->transform(function ($symptom) {
            $symptom->synonyms = explode(',', $symptom->synonyms);
            return $symptom;
        });
        return response()->json($symptoms);
    }
    public function getDetails(Request $request)
    {
        $symptom=Symptom::where('value',$request->value)->first();
        return response()->json($symptom);
    }
    public function delete(Request $request)
    {
        Symptom::where('id',$request->id)->delete();

        return redirect()->back()->with('success',__('symptom.Symptoms Deleted Successfully'));
    }
}
