<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Menu;
use App\Queue;
use App\Barber;
use App\Service;
use App\Http\Requests\QueueCreateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
use Input;
use Redirect;

class QueueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$shopDtls = Shop::where('validflg','=',1)->get();
        
        if (count($shopDtls) < 1) {
            $shopsName = array();
        } else {
            foreach ($shopDtls as $k => $v) {
                $shopsName[$v->id] = $v->name;
            }
        }*/
        $shops = Shop::all();

        $services = Service::where('validflg','=',1)->get();

        $path = explode("/", $request->path());
        if ($path[0] == 'admin') {
            $byshop = array();
            $shopsName = array();
        }
        

        return view('queue',compact('shops', 'services', 'byshop', 'shopsName'));
    }

    public function callNext(Request $request){
        $queuedate = date("Y-m-d");
        
        if($request->q_id != ""){
            Queue::where('id' , $request->q_id)->update(['service_status' => 0]);
        }
        
        $tokenDetails = Queue::fnCallToken($request, $queuedate);
        if(count($tokenDetails) > 0){
            foreach ($tokenDetails as $k => $v) {
                $id = $v->id;
                $service_id = $v->service_id;
                $tokenno = $v->token_number;
            }
            
            $tokenDetails = [
                'id' => $id,
                'service_id' => $service_id,
                'token_number' => $tokenno
            ];
            
            return response()->json($tokenDetails);
        }/*else{
            $resultStatus = "Token Already Registered";
            return response()->json($tokenDetails);
        }*/
        
    }

    public function callAgain(Request $request){
        $queuedate = date("Y-m-d");
        $tokenDetails = Queue::fnCallTokenAgain($request, $queuedate);
        if(count($tokenDetails) > 0){
            foreach ($tokenDetails as $k => $v) {
                $id = $v->id;
                $service_id = $v->service_id;
                $tokenno = $v->token_number;
            }
        }
        
        $tokenDetails = [
            'id' => $id,
            'service_id' => $service_id,
            'token_number' => $tokenno
        ];
        return response()->json($tokenDetails);
    }

}
