<?php

namespace App;
use App\Shop;
use App\Barber;
use App\Service;
use App\Menu;
use DB;

use Illuminate\Database\Eloquent\Model;
\Carbon\Carbon::setToStringFormat('d-m-Y');

class Queue extends Model
{
	protected $table = "queues";
    protected $fillable = ['queuedate', 'token_number', 'servicetime', 'customer', 'email', 'service_id', 'shop_id', 'service_status'];

    public function shop() {
        return $this->belongsTo('App\Shop');
    }

    public function barber() {
        return $this->belongsTo('App\Barber');
    }

	public function service() {
        return $this->belongsTo('App\Service');
    }

    public function menu() {
        return $this->belongsTo('App\Menu');
    }

    public static function fnGetQueueDetails($request, $shopId, $date, $auth) {
    	// $queuedate = ($queuedate) ? $queuedate : date("Y-m-d");

    	$query = DB::table('queues')
                      ->SELECT('m_services.name AS servicename',
                      			'queues.id AS qid',
                      			'queues.token_number',
                      			'queues.queuedate',
	                            'queues.servicetime',
	                            'queues.email',
	                            'queues.service_id',
	                            'queues.service_status',
	                            'queues.shop_id',
	                            'm_shops.name AS shopname',
                      			'm_shops.starttime'
                      			)
                      ->LEFTJOIN('m_services', 'queues.service_id' ,'=','m_services.id')
                      ->LEFTJOIN('m_shops', 'queues.shop_id' ,'=','m_shops.id')
                      // ->where('queues.service_status', '=', 1)
                      ->where('m_shops.validflg', '=', 1)
                      ->where('m_services.validflg', '=', 1)
                      // ->where('queues.queuedate', '=', date("Y-m-d"))
                      ->orderBy('queues.shop_id','ASC')
                      ->orderBy('queues.service_id','ASC')
                      ->orderBy('queues.token_number','ASC')
                      ->orderBy('queues.queuedate','ASC');
                      // ->get();
						if($shopId){
							$query = $query->where('queues.shop_id', '=', $shopId);
						}
						if($date != ""){
							$query = $query->where('queues.queuedate', '=', date("Y-m-d"));
						}
						if(!$auth){
							$query = $query->where('queues.service_status', '=', 1);
						}
						$query = $query->get();
                      // print_r($query);exit();
                      // ->tosql();
                      //dd($query);
		return $query;
    }
	public static function fnTokenExistCheck($request, $queuedate, $email) {
		$result = DB::table('queues')
		      ->select('id')
		      ->where('service_status', 1)
		      ->where('queuedate', $queuedate)
		      ->where('email', $email)
		      ->where('service_id', $request->service_id)
		      ->where('shop_id', $request->shop_id)
		      ->get();
		return $result;
	}

	public static function fnCallToken($request, $queuedate) {
		$service_id = $request->service_id;
        $shop_id = $request->shop_id;
		$sql = "SELECT id,token_number,service_id FROM queues WHERE service_status = 1 and shop_id = $shop_id and service_id = $service_id and queuedate = '$queuedate' LIMIT 1";
		$result = DB::select(DB::raw($sql));
		return $result;
	}

	public static function fnCallTokenAgain($request, $queuedate) {
		$q_id = $request->q_id;
		$sql = "SELECT id,token_number,service_id FROM queues WHERE service_status = 1 and id = $q_id and queuedate = '$queuedate'";
		$result = DB::select(DB::raw($sql));
		return $result;
	}

	public static function fnGetQueueServiceCnt($request, $queuedate) {
    	
		$query = DB::table('queues')
				->where('service_status','=',1)
				->where('service_id','=',$request->service_id)
				->where('shop_id','=',$request->shop_id)
				->where('queuedate','=',$queuedate)
				->count();
				
		return $query;
	}

	public static function fnTokenCancel($request) {
		$update = DB::table('queues')
			->where('id',$request->qid)
			->update(
				['service_status' => 2,
				'updated_at' => date('Y-m-d H:i:s')
			]);
			
		return $update;
	}

	/**/

	/*public static function aaloc($request, $queuedate) {
    	$sql = "LOCK TABLE queues WRITE";
		$result = DB::select(DB::raw($sql));
		return $result;
	}

	public static function getloc($request, $queuedate) {
    	$sql = "SHOW OPEN TABLES WHERE In_use > 0";
		$result = DB::select(DB::raw($sql));
		return $result;
	}*/

    

	public static function fnGetEstimatedServiceTime($request) {
		$result = DB::table('services')
					->select('estimatedtime')
					->where('validflg', 1)
					->where('menu_id', $request->service)
					->where('shop_id', $request->shop)
					->get();
		return $result;
	} 

  public static function fnGetServiceDetails($request) {
    $result = DB::table('m_services')
          ->select('estimatedtime', 'tokenstartfrom')
          ->where('validflg', 1)
          ->where('id', $request->service_id)
          ->where('shop_id', $request->shop_id)
          ->get();
    return $result;
  }  

}
