<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use App;
use App\Shop;
use App\Service;
use App\Queue;
use DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $shopDtls = Shop::where('validflg','=',1)->get();
        
        if (count($shopDtls) < 1) {
            $shopsName = array();
        } else {
            foreach ($shopDtls as $k => $v) {
                $shopsName[$v->id] = $v->name;
            }
        }
        $shops = Shop::where('validflg','=',1)->get();
        $singleShop = $shops->find(1);

        $services = Service::where('validflg','=',1)->get();
        $queues = Queue::where('service_status','=',1)->get();

        if ($request->path() == 'home') {
            $byshop = array();
        }

        return view('home',compact('byshop', 'shopsName', 'singleShop', 'services', 'queues', 'shops'));
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
        $queuedate = date("Y-m-d");
        $queueDetails = Queue::fnGetQueueDetails($request, $byshop->id, $queuedate, null);

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

                $queues[$k]['qid'] = $v->qid;
                $queues[$k]['shop_id'] = $v->shop_id;
                $queues[$k]['queuedate'] =  date("Y年 m月 d日", strtotime($v->queuedate));
                $queues[$k]['shopname'] = $v->shopname;
                $queues[$k]['service_status'] = ($v->service_status == 0) ? '完了' : '待';
                $queues[$k]['servicename'] = $v->servicename;
                $queues[$k]['email'] = $v->email;
                
                $queues[$k]['token_number'] = $v->token_number;
                
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
        DB::beginTransaction();
        try {
            DB::table('queues')->where('queuedate', '=', $queuedate)->lockForUpdate()->get();
            // DB::table('queues')->where('queuedate', '=', $queuedate)->sharedLock()->get();
            // DB::raw('LOCK TABLE queues WRITE');
            // $qq = DB::raw('SHOW OPEN TABLES WHERE In_use > 0');
            // print_r($qq);
            // exit();
            $serviceCnt = Queue::fnGetQueueServiceCnt($request, $queuedate);
            
            $token_number = $tokenstartfrom + $serviceCnt + 1;

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
            if ($id) {
                DB::commit();
            }
            // print_r($qq);exit();
            DB::raw('UNLOCK TABLES');
            
        }catch(\Exception $e){
            DB::rollBack();
            $tokenno = "Insertion Failed。";
            // throw new Exception($e->getMessage());
            throw $e;
        }
        
        $tokenno = $id;
        return $tokenno;
    }

    public function tokenCancel(Request $request){
        
        $result = Queue::fnTokenCancel($request);
        return redirect::to('byShop/'.$request->shop_id.'/service')->with('message', trans('messages.token_cancel_msg'));

        
    }

}
