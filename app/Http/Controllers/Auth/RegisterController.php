<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Input;
use Redirect;
use Session;
use App;
use Mail;
use App\Shop;
use App\Service;
use App\Queue;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
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

        if ($request->path() == 'register') {
            $byshop = array();
            $byservice = array();
        }
        
        return view('auth.register',compact('byservice', 'byshop', 'shopsName', 'singleShop', 'services', 'queues'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {        
        $rules = array (
                
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed' 
        );
        $messages = [

            'name.required' => trans('messages.wrng_name'),
            'email.required' => trans('messages.wrng_email'),
            'email.email' => trans('messages.wrng_valid_email'),
            'email.unique' => trans('messages.wrng_exist_email'),
            'password.required' => trans('messages.wrng_password'),
            'password.min' => trans('messages.wrng_password_length'),
            'password.confirmed' => trans('messages.wrng_password_confirm'),
        ];
        $validator = Validator::make ( Input::all (), $rules, $messages);
        if ($validator->fails ()) {
            return redirect::back ()->withErrors ($validator)->withInput ();
        } else {
            
            $verification_key = md5(rand());
            
            $data = array(
            'name'  => Input::get('name'),
            'email'  => Input::get('email'),
            'password' => Input::get('password'),
            'verification_key' => $verification_key
            );
            $id = self::create($data);
            if($id > 0) {
                $mailData = array(
                'name'  => Input::get('name'),
                'email'  => Input::get('email'),
                'verification_key' => $verification_key,
                'id' => $id
                );
                $mailResult = self::mailToAccountActivation($mailData);
                $result = trans('messages.wrng_register_suucess');
            }else{
                $result = trans('messages.wrng_register_fail');
            }
            Session::flash('error', $result);
            return redirect::back ()->withErrors ($validator)->withInput ();
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_key' => $data['verification_key'],
        ]);
        return $user->id;
    }

    protected function mailToAccountActivation(array $mailData)
    {
        $mailData['subject'] = trans('messages.register_mail_subject');
        $mailData['content_1'] = trans('messages.register_mail_content_1');
        $mailData['content_2'] = trans('messages.register_mail_content_2');
        $mailData['link'] = url('/')."/verify_email/".$mailData['id']."/".$mailData['verification_key'];
   
        Mail::send('mail', $mailData, function($message) use($mailData) {
         $message->to($mailData['email'], '')->subject
            ($mailData['subject']);
         $message->from('vengad7@gmail.com','Br Shop');
        });

        return;
    }

    protected function verify_email($id, $key)
    {
        if($id && $key) {
            $query = User::where('id', '=', $id)->where('verification_key', '=', $key)->get();
            
            // if ($query[0]->name != "") {
            if ($query) {
                User::where('id', '=', $id)
                ->update([
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'is_email_verified' => 'yes', 
                    'verification_key' => ''
                ]);
                $message = trans('messages.register_mail_verification_ok');
            }else{
                $message = trans('messages.register_mail_verification_ng');
            }
        }
        Session::flash('error', $message);
        return redirect::to('login');
    }
}
