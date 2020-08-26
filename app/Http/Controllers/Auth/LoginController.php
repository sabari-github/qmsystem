<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use Cookie;
use App;
use App\Shop;
use App\Service;
use App\Queue;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'userLogout');
    }

    public function showLoginForm(Request $request)
    {
        $shopDtls = Shop::where('validflg','=',1)->get();
        
        if (count($shopDtls) < 1) {
            $shopsName = array();
        } else {
            foreach ($shopDtls as $k => $v) {
                $shopsName[$v->id] = $v->name;
            }
        }
        $shops = Shop::all();
        $singleShop = $shops->find(1);

        $services = Service::where('validflg','=',1)->get();
        $queues = Queue::where('service_status','=',1)->get();

        if ($request->path() == 'login') {
            $byshop = array();
            $byservice = array();
        }

        return view('auth.login',compact('byservice', 'byshop', 'shopsName', 'singleShop', 'services', 'queues'));
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
            
            if(Input::get('remember')) {
                self::setCookie($request);
            }else{
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('remember'));
            }

            if (Auth::validate($userdata)) {
                if (Auth::attempt($userdata)) {
                    if (Auth::user()->is_email_verified == 'no') {
                        Session::flash('error', trans('messages.is_mail_verification'));
                        return redirect::back ()->withErrors ( $validator )->withInput ();
                        exit();
                    }
                    Session::put('name',Auth::user()->name);
                    date_default_timezone_set("Asia/Calcutta");
                    Auth::user()->last_login_at = date('Y-m-d H:i:s');
                    Auth::user()->loginCount++;
                    Auth::user()->save();
                    return redirect::to('home');
                }
            } else {
                Session::flash('error', trans('messages.wrng_login'));
                return Redirect::back ()->withErrors ( $validator )->withInput ();
            }
        }
    }

    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();
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
