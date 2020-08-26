<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Input;
use Redirect;
use Session;
use Cookie;
use App;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $username = Input::get('email');
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $userdata = array(
                        'name' => Input::get('email'),
                        'password' => Input::get('password'),
            );
        } else {
            $userdata = array(
                        'email' => Input::get('email'),
                        'password' => Input::get('password'),
            );
        }

        $rules = array (
                
                'email' => 'required',
                'password' => 'required' 
        );

        $messages = [
            'email.required' => trans('messages.wrng_username'),
            'password.required' => trans('messages.wrng_password'),
        ];
        $validator = Validator::make ( Input::all (), $rules, $messages);
        if ($validator->fails ()) {
            return redirect::back ()->withErrors ( $validator)->withInput ();
        } else {
            $remember = Input::get('remember');
            if($remember) {
                $value = self::setCookie($request);
            }else{
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('remember'));
            }

            if (Auth::guard('admin')->validate($userdata)) {
                if (Auth::guard('admin')->attempt($userdata)) {
                    if (Auth::guard('admin')->user()->is_email_verified == 'no') {
                        Session::flash('error', trans('messages.is_mail_verification'));
                        return redirect::back ()->withErrors ( $validator )->withInput ();
                        exit();
                    }
                    Session::put('name',Auth::guard('admin')->user()->name);
                    date_default_timezone_set("Asia/Calcutta");
                    Auth::guard('admin')->user()->last_login_at = date('Y-m-d H:i:s');
                    Auth::guard('admin')->user()->loginCount++;
                    Auth::guard('admin')->user()->save();
                    return redirect()->intended(route('admin.dashboard'));
                }
            } else {
                Session::flash('error', trans('messages.wrng_login'));
                return Redirect::back ()->withErrors ( $validator )->withInput ();
            }
        }

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function setCookie(Request $request){
        $email = Input::get('email');
        $remember = Input::get('remember');
        $minutes = 60;
        Cookie::queue('email', $email, $minutes);
        Cookie::queue('remember', $remember, $minutes);
        return;
    }
}
