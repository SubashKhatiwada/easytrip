<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user',['except'=>['logout']]);
    }




    public function logout(Request $request){
        // Auth::guard('user')->logout();
        Auth::guard('user')->logout();
        // $request->session()->invalidate();

        return redirect('/');
    }
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }



   public function login(Request $request){

       $this->validate($request,[
           'email'=>'required|email',
           'password'=>'required|min:6'
       ]);


       if (Auth::guard('user')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){
           return redirect()->intended(route('home'));
       }
       else{
           return redirect()->back()->withInput($request->only('email','remember'));
       }
   }
}
