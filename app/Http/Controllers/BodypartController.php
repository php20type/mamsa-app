<?php

namespace App\Http\Controllers;

use App\Models\BodyPart;
use Illuminate\Http\Request;

class BodypartController extends Controller
{
    //
    public function index(Request $request)
    {

        $bodyparts = BodyPart::where('lang',app()->getLocale())->get();
        return view('bodyparts', compact('bodyparts'));
    }
    public function store(Request $request)
    {
        BodyPart::updateOrCreate(['id' => $request->bodypart_id], ['title' => $request->title, 'value' => $request->value, 'synonyms' => $request->synonyms,'lang'=>$request->lang]);
        if ($request->bodypart_id != '') {
            return redirect()->back()->with('success', __('bodypart.BodyPart Data Updated Successfully'));
        }
        return redirect()->back()->with('success', __('bodypart.BodyPart Data Added Successfully'));
    }
    public function list(Request $request)
    {
        $bodyparts = BodyPart::where('lang',$request->lang)->get();

        // Format synonyms field as array
        $bodyparts->transform(function ($bodypart) {
            $bodypart->synonyms = explode(',', $bodypart->synonyms);
            return $bodypart;
        });
        return response()->json($bodyparts);
    }
    public function delete(Request $request)
    {
        BodyPart::where('id',$request->id)->delete();

        return redirect()->back()->with('success',__('bodypart.BodyPart Data Deleted Successfully'));
    }
}
