<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use App;
use Mail;

class AdminRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showRegistrationForm()
    {
        return view('auth.admin-register');
    }

    public function register(Request $request)
    {
        $rules = array (
                
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
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
            // Create admin user
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
            return redirect()->back()->withInput($request->only('name', 'email'));
            // return redirect::back ()->withErrors ($validator)->withInput ();
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function create(array $data)
    {
        // Create admin user
        try {
            $admin = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'verification_key' => $data['verification_key'],
            ]);

            // Log the admin in
            /*Auth::guard('admin')->loginUsingId($admin->id);
            return redirect()->route('admin.dashboard');*/
            return $admin->id;
        } catch (\Exception $e) {
            return;
        }

        
        
    }

    protected function mailToAccountActivation(array $mailData)
    {
        $mailData['subject'] = trans('messages.register_mail_subject');
        $mailData['content_1'] = trans('messages.register_mail_content_1');
        $mailData['content_2'] = trans('messages.register_mail_content_2');
        $mailData['link'] = url('/')."/admin/verify_email/".$mailData['id']."/".$mailData['verification_key'];
   
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
            $query = Admin::where('id', '=', $id)->where('verification_key', '=', $key)->get();
            
            if ($query) {
                Admin::where('id', '=', $id)
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
        return redirect()->intended(route('admin.login'));
    }
}
