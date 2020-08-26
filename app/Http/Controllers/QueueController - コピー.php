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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $path = explode("/", $request->path());
        if ($path[0] == 'queue') {
            $byshop = array();
            $shopsName = array();
        }

        $shops = Shop::all();
        $queueDetails = Queue::fnGetQueueDetails($request, null, null);

        $queues = array();
        if (count($queueDetails) > 0) {
            // print_r($queueDetails);
            
            $shopId = '';
            $prvshopid = '';
            $prvserviceid = '';
            $prvqueuedate = '';
            
            foreach ($queueDetails as $k => $v) {
                if (($v->shop_id != $prvshopid || $v->service_id != $prvserviceid || $v->queuedate != $prvqueuedate)) {
                // if (!($v->service_id == $prvserviceid)) {
                    $startTime = '';
                    

                }
                $prvshopid = $v->shop_id;
                $prvserviceid = $v->service_id;
                $prvqueuedate = $v->queuedate;
                $queues[$k]['servicename'] = $v->servicename;
                $queues[$k]['email'] = $v->email;
                // echo $v->servicetime;echo "<br/>";
                $token_number = explode("_", $v->token_number);
                $queues[$k]['token_number'] = $token_number[1];
                // echo $v->starttime;echo "<br/>";
                /**/
                // $sId = $v->shop_id;
                // if ($shopId == "") {
                    if ($startTime == "") {
                        $endTime = $this->sum_the_time($v->starttime, $v->servicetime);
                        $startTime = $v->starttime;
                    }else{
                        $startTime = $endTime;
                        $endTime = $this->sum_the_time($endTime, $v->servicetime);
                    }
                    // $sId = $v->shop_id;
                // }

                /*if ($shopId != $sId) {

                    $startTime = $v->starttime;
                    $endTime = $this->sum_the_time($v->starttime, $v->servicetime);
                }*/
                
                
                /*echo $startTime.' 時 ～ '.$endTime.' 時'.'----'.$token_number[1].'---'.$v->servicetime;echo "<br/>";*/
                $queues[$k]['queue_time'] = $startTime.' 時 ～ '.$endTime.' 時';
                // $v->starttime = "";
                // $serviceId = $v->service_id;
                // $shopId = $v->shop_id;
            }
        }
        // $services = Menu::where('validflg','=',1)->get();
        // Queue::where('queuedate','=','2020-08-24')->lockForUpdate()->get();
        // DB::raw('LOCK TABLE queues WRITE');

        // DB::table('users')->where('votes', '>', 100)->lockForUpdate()->get();
   // exit();
        return view('queue',compact('queues', 'byshop', 'shopsName'));
    }

    public function byShop(Request $request, Shop $byshop){
        $shopDtls = Shop::where('validflg','=',1)->get();
        
        if (count($shopDtls) < 1) {
            $shopsName = array();
        } else {
            foreach ($shopDtls as $k => $v) {
                $shopsName[$v->id] = $v->name;
            }
        }
        $shops = Shop::all();

        $services = Service::where('validflg','=',1)->get();

        $shopbyown = $shops->find($byshop->id);

        $servicesbyshop = Service::where('shop_id', '=', $byshop->id)->where('validflg', '=', 1)->get();
        
        $queues = array();
        $queueDetails = Queue::fnGetQueueDetails($request, $byshop->id, null);

        if (count($queueDetails) > 0) {
            
            $shopId = '';
            $prvshopid = '';
            $prvserviceid = '';
            $prvqueuedate = '';
            
            foreach ($queueDetails as $k => $v) {
                if (($v->shop_id != $prvshopid || $v->service_id != $prvserviceid || $v->queuedate != $prvqueuedate)) {
                    $startTime = '';
                }
                $prvshopid = $v->shop_id;
                $prvserviceid = $v->service_id;
                $prvqueuedate = $v->queuedate;

                $queues[$k]['queuedate'] =  date("Y年 m月 d日", strtotime($v->queuedate));
                $queues[$k]['shopname'] = $v->shopname;
                $queues[$k]['service_status'] = ($v->service_status == 0) ? '完了' : '待';
                $queues[$k]['servicename'] = $v->servicename;
                $queues[$k]['email'] = $v->email;
                $token_number = explode("_", $v->token_number);
                $queues[$k]['token_number'] = $token_number[1];
                
                if ($startTime == "") {
                    $endTime = $this->sum_the_time($v->starttime, $v->servicetime);
                    $startTime = $v->starttime;
                }else{
                    $startTime = $endTime;
                    $endTime = $this->sum_the_time($endTime, $v->servicetime);
                }
                    
                $queues[$k]['queue_time'] = $startTime.' 時 ～ '.$endTime.' 時';
            }
        }

        return view('servicebyshop',compact('byshop', 'shopbyown','servicesbyshop', 'shopsName', 'services', 'queues'));
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
            $token_number = explode("_",$tokenno);
            $tokenDetails = [
                'id' => $id,
                'service_id' => $service_id,
                'token_number' => $token_number[1]
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
        $token_number = explode("_",$tokenno);
        $tokenDetails = [
            'id' => $id,
            'service_id' => $service_id,
            'token_number' => $token_number[1]
        ];
        return response()->json($tokenDetails);
    }

    public function tokenReg(Request $request){
        
        $queuedate = date("Y-m-d");
        $email = Auth::user()->email;
        $oldId = Queue::fnTokenExistCheck($request, $queuedate, $email);

        if(count($oldId) > 0){
            $result = "";
            $resultStatus = "Token Already Registered";
        }else{
            $result = $this->queueReg($request);
            $resultStatus = "Generated Token Number : $result";
        }
        
        return response()->json($resultStatus);
    }

    public function queueReg(Request $request)
    {   
        $servicesTime = Queue::fnGetServiceDetails($request);
        $queuedate = date("Y-m-d");
        if (count($servicesTime) > 0) {
            
            foreach ($servicesTime as $k => $v) {
                $estimatedtime = $v->estimatedtime;
                $tokenstartfrom = $v->tokenstartfrom;
            }            
        }

        $lastInsertId = DB::getPdo()->lastInsertId();
        $lastInsertId = isset($lastInsertId) ? $lastInsertId : 0;
        $newNumber = $tokenstartfrom + $lastInsertId;
        $token_number = $queuedate.'_'.$newNumber;

        $data = [
            'queuedate' => $queuedate,
            'token_number' => $token_number,
            'servicetime' => $estimatedtime,
            'customer' => Auth::user()->name,
            'email' => Auth::user()->email,
            'service_id' => $request->service_id,
            'shop_id' => $request->shop_id,
            'service_status' => 1
        ];
        $id = Queue::create($data)->token_number;
        $tokenno = explode("_",$id);
        return $tokenno[1];
    }

    // public function queueReg(Request $request)
    // {   
    //     $serviceCnt = Queue::fnGetServiceCnt($request);
    //     $servicesTime = Queue::fnGetEstimatedServiceTime($request);
    //     if ($serviceCnt < 11) {
    //         switch ($request->service) {
    //             case 1:
    //                 $tokenNumberFrom = 100;
    //                 break;
    //             case 2:
    //                 $tokenNumberFrom = 200;
    //                 break;
    //             case 3:
    //                 $tokenNumberFrom = 300;
    //                 break;
    //             case 4:
    //                 $tokenNumberFrom = 400;
    //                 break;
    //             default:
    //                 $tokenNumberFrom = 500;
    //         }
    //         $queueid = $tokenNumberFrom + $serviceCnt + 1;
    //     }else{
            
    //         return "failed";
    //     }
        
    //     $data = [
    //         'queuedate' => Input::get('queuedate'),
    //         'queueid' => $queueid,
    //         'servicetime' => $servicesTime[0]->estimatedtime,
    //         'customer' => Input::get('name'),
    //         'email' => Input::get('mailid'),
    //         'service_id' => Input::get('service'),
    //         'shop_id' => Input::get('shop'),
    //         'barber_id' => Input::get('barber'),
    //         'service_status' => 1
    //     ];
    //     Queue::create($data);
    //     return "success";
        
    //     /*$services = Menu::where('validflg','=',1)->get();
    //     DB::raw('LOCK TABLES important_table WRITE');
    //     return view('queue', compact('services'));*/
    // }

    // public function getShopsDetails(Request $request){
        
    //     $shops_info = Queue::fnGetShops($request);
    //     return response()->json($shops_info);
    //     /*return response()->json([
    //         'services' => $services
    //     ]);*/
    // }

    // public function getBarbersDetails(Request $request){
    //     $barbers_info = Queue::fnGetBarbers($request);
    //     return response()->json($barbers_info);
    // }

    // public function store(Request $request){

    //     $rules = [
    //         'queuedate' => 'required',
    //         'service' => 'required',
    //         'shop' => 'required',
    //         'barber' => 'required',
    //         'name' => 'required',
    //         'mailid' => 'required',
    //     ];

    //     $validator = Validator::make(Input::all() , $rules);
    //     if ($validator->fails ()) {
    //         return redirect::back ()->withErrors ($validator)->withInput ();
    //     } else {
    //         $result = $this->queueReg($request);
    //         if ($result == "failed") {
    //             $resultStatus = 'error';
    //             $msg = '本日これ以上はサービスできません。Brサイトをご利用になっていただきありがとうございます。';
    //         }else{
    //             $resultStatus = 'message';
    //             $msg = 'お客様の予約が登録されました。';
    //         }
    //         return redirect(route('queue'))->with($resultStatus, $msg);
    //     }
        
    // }

}
