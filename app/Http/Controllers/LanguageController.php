<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //
    public function changeLanguage(Request $request)
    {
        $lang=$request->lang;
        if(isset(auth()->guard('admin')->user()->id)){
            Admin::where('id',auth()->guard('admin')->user()->id)->update(['lang'=>$lang]);
        }
        else if(isset(auth()->user()->id)){
            User::where('id',auth()->user()->id)->update(['lang'=>$lang]);
        }
        session()->put('locale',$lang);

        $currentUrl = url()->previous();

        // Parse the URL and query string
        $parsedUrl = parse_url($currentUrl);
        parse_str($parsedUrl['query'] ?? '', $queryParams);
    
        // Remove the 'facility' parameter
        unset($queryParams['facility']);
    
        // Build the new query string
        $newQueryString = http_build_query($queryParams);
    
        // Construct the new URL
        $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        if (isset($parsedUrl['path'])) {
            $newUrl .= $parsedUrl['path'];
        }
        if (!empty($newQueryString)) {
            $newUrl .= '?' . $newQueryString;
        }
        return redirect()->to($newUrl);
    }
}
