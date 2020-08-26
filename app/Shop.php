<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
\Carbon\Carbon::setToStringFormat('d-m-Y');

class Shop extends Model
{
	protected $table = "m_shops";
    protected $fillable = ['name', 'starttime', 'endtime', 'image', 'remarks', 'validflg'];
    /*public function shop() { echo "test";exit();
        return $this->hasMany('App\Barber');
    }*/

}
