<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Requests\ShopCreateRequest;
use App\Shop;
use Input;
use Redirect;
use Session;
use Cookie;
use App;

class ShopController extends Controller
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

        $shops = Shop::orderBy('validflg', 'desc')->paginate(10);

        // $shops = $shops->paginate(5);

    	return view('shop/index',compact('shops'));
    }

    public function create(Request $request){

    	return view('shop/create');
    }

    public function store(ShopCreateRequest $request){
        if ($request->hasFile('image')) {
            $filename = $request->image->getClientOriginalName();
            $destinationPath = base_path() . '/resources/assets/uploads/';
            $request->image->move($destinationPath, $filename);
        }

        $data = [
            'name' => Input::get('name'),
            'starttime' => Input::get('starttime'),
            'endtime' => Input::get('endtime'),
            'image' => $filename,
            'remarks' => Input::get('remarks')
        ];

        Shop::create($data);
        return redirect(route('admin.shop'))->with('message', trans('messages.shop_created_successfully'));

    }

    public function edit(Shop $shop){

        return view('shop.edit',compact('shop'));
    }

    /*public function edit($id){
        $shop = Shop::find($id);
        return view('shop/edit',compact('shop'));
    }*/

    public function update(ShopCreateRequest $request, Shop $shop){

        $filename = $this->fileUploadProcess($request);

        $shop->update(['name' => $request->name,'starttime' => $request->starttime,'endtime' => $request->endtime,'image' => $filename,'remarks' => $request->remarks]);
        return redirect(route('admin.shop'))->with('message', trans('messages.shop_updated_successfully'));
    }

    public function mkValidInvalid(Request $request)
    {
        
        Shop::where('id' , $request->id)->update(['validflg' => $request->validflg]); 
        return redirect(route('admin.shop'))->with('message', trans('messages.shop_updated_successfully'));
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
