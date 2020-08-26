<?php

namespace App;
use App\Shop;
use App\Menu;

use Illuminate\Database\Eloquent\Model;
\Carbon\Carbon::setToStringFormat('d-m-Y');

class Service extends Model
{
    protected $table = "m_services";
    protected $fillable = ['name', 'estimatedtime', 'tokenstartfrom', 'shop_id', 'image', 'remarks', 'validflg'];

    public function shop() {
        return $this->belongsTo('App\Shop');
    }

    public function menu() {
        return $this->belongsTo('App\Menu');
    }

    /*public function getRouteKeyName()
	{
	    return 'menu_id';
	}*/

}
