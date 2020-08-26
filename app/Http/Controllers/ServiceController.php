<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Requests\ServiceCreateRequest;
use App\Shop;
use App\Service;
use Input;
use Redirect;
use Session;
use Cookie;
use App;

class ServiceController extends Controller
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

    public function index(Request $request){

        $services = Service::orderBy('validflg', 'desc')->paginate(10);

    	return view('service/index',compact('services'));
    }

    public function create(Request $request){

    	$shopDtls = Shop::where('validflg','=',1)->get();
    	
    	if (count($shopDtls) < 1) {
    		$shopsName = array();
    	} else {
    		foreach ($shopDtls as $k => $v) {
	    		$shopsName[$v->id] = $v->name;
	    	}
    	}

    	return view('service/create',compact('shopsName'));
    }

    public function store(ServiceCreateRequest $request){

        $servicesExistCnt = $this->servicesExistCheck($request);
        if (count($servicesExistCnt) > 0) {
            return redirect(route('admin.service'))->with('error', trans('messages.service_created_fail'));
        }else{
            if ($request->hasFile('image')) {
                $filename = $request->image->getClientOriginalName();
                $destinationPath = base_path() . '/resources/assets/uploads/';
                $request->image->move($destinationPath, $filename);
            }

            $data = [
                'name' => Input::get('name'),
                'shop_id' => Input::get('shop_id'),
                'estimatedtime' => Input::get('estimatedtime'),
                'tokenstartfrom' => Input::get('tokenstartfrom'),
                'image' => $filename,
                'remarks' => Input::get('remarks')
            ];

            Service::create($data);
            return redirect(route('admin.service'))->with('message', trans('messages.service_created_successfully'));
        }

        

    }

    public function edit(Service $service){

    	$shopDtls = Shop::where('validflg','=',1)->get();
    	
    	if (count($shopDtls) < 1) {
    		$shopsName = array();
    	} else {
    		foreach ($shopDtls as $k => $v) {
	    		$shopsName[$v->id] = $v->name;
	    	}
    	}

        return view('service.edit',compact('service','shopsName'));
    }

    public function update(ServiceCreateRequest $request, Service $service){
        
        $servicesExistCnt = $this->servicesExistCheck($request);

        $old_id = Input::get('old_id');

        if ((count($servicesExistCnt) > 0) && ($servicesExistCnt[0]->id != $old_id)) {
            
            return redirect(route('admin.service'))->with('error', trans('messages.service_updated_fail'));
        }else{
            $filename = $this->fileUploadProcess($request);

            $service->update(['name' => $request->name,'estimatedtime' => $request->estimatedtime,'tokenstartfrom' => $request->tokenstartfrom,'shop_id' => $request->shop_id,'image' => $filename,'remarks' => $request->remarks]);
            
            return redirect(route('admin.service'))->with('message', trans('messages.service_updated_successfully'));
        }
    }

    public function mkValidInvalid(Request $request)
    { 
        Service::where('id' , $request->id)->update(['validflg' => $request->validflg]); 
        return redirect(route('admin.service'))->with('message', trans('messages.service_updated_successfully'));
    }

    public function servicesExistCheck(Request $request)
    {
        $existServices = Service::where('shop_id', '=', $request->shop_id)->where('name', '=', $request->name)->where('validflg', '=', 1)->get();

        return $existServices;

    }

    public function fileUploadProcess(Request $request)
    {
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $destinationPath = base_path() . '/resources/assets/uploads/';
            
            $oldfilename = Input::get('old_image_name');
            if ($oldfilename != $filename) {
                unlink(base_path() . '/resources/assets/uploads/'.$oldfilename);
            }
            $result = $request->image->move($destinationPath, $filename);
        }else{
            $filename = Input::get('old_image_name');
        }

        return $filename;
    }
}
