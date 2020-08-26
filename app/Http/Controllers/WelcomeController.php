<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Shop;
use App\Service;
use App\Queue;
use App;

class WelcomeController extends Controller
{
    public function welcome(Request $request) {

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

        $shops = Shop::where('validflg','=',1)->get();
        
        $services = Service::where('validflg','=',1)->get();

        if ($request->path() == '/') {
            $byshop = array();
        }

        return view('welcome',compact('byshop', 'shopsName', 'singleShop', 'services', 'shops'));
    }

    /*public function byShop(Request $request, Shop $byshop){
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

        $shopbyown = $shops->find($byshop->id);

        $servicesbyshop = Service::where('shop_id', '=', $byshop->id)->where('validflg', '=', 1)->get();
        $queues = Queue::where('service_status','=',1)->get();

        return view('servicebyshop',compact('byshop', 'shopbyown', 'servicesbyshop', 'shopsName', 'singleShop', 'services', 'queues'));
    }

    public function byService(Request $request, Service $byservice, Shop $byshop){
        $shopDtls = Shop::where('validflg','=',1)->get();
        
        if (count($shopDtls) < 1) {
            $shopsName = array();
        } else {
            foreach ($shopDtls as $k => $v) {
                $shopsName[$v->id] = $v->name;
            }
        }
        $shops = Shop::all();
        $menus = Menu::where('validflg','=',1)->get();
        $singleShop = $shops->find(1);

        $services = Service::where('validflg','=',1)->get();
        $barbers = Barber::where('validflg','=',1)->get();
        $shopbyown = $shops->find($byshop->id);

        $barberbyshop = Barber::where('shop_id', '=', $byshop->id)->where('validflg', '=', 1)->get();
        $servicesbyservice = Service::where('menu_id', 'like', $byservice->menu_id)->where('validflg', '=', 1)->get();
        $queues = Queue::where('service_status','=',1)->get();

        $path = explode("/", $request->path());
        if ($path[0] == 'byService') {
            $byshop = array();
        }

        return view('servicebyservice',compact('byservice', 'byshop', 'shopbyown', 'barberbyshop', 'servicesbyservice', 'shopsName', 'singleShop', 'services', 'barbers', 'queues', 'menus'));
    }*/
}
