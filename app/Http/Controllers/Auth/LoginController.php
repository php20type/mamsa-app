<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/doctor';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['showAdminLogin','logout','adminLogin','adminLogout']);
        $this->middleware('guest:admin')->except(['logout','adminLogin','adminLogout']);

    }
    public function showAdminLogin()
    {
        return view('auth/admin/login');
    }
    public function adminLogin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if(Auth::guard('admin')->attempt($request->only(['email','password']),$request->get('remember'))){
            return redirect()->intended('/admin');
        }
        return redirect()->back()->withInput($request->only(['email','password']))->withErrors(['email'=>'These credentials do not match our records.']);
    }
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->back();
    }
}
