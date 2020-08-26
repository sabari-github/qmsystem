<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queue;
use Session;
use App;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {        
        // $queues = Queue::orderBy('id', 'asc')->paginate(5);
        $queueDetails = Queue::fnGetQueueDetails($request, null, null, 'Admin');
        $queues = array();
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
                if ($v->service_status == 0) {
                    $status = '完了';
                }else if ($v->service_status == 1) {
                    $status = '待';
                }else{
                    $status = 'キャンセル';
                }
                $queues[$k]['service_status'] = $status;
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

        return view('admin',compact('queues'));
    }
}
