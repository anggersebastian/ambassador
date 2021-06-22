<?php

namespace App\Logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticOrderStatus extends Model
{

    protected $table = 'logistic_order_status';

    public $timestamps = true;
    protected $guarded = [];

    use SoftDeletes;


    public function logistic_order(){
        return $this->belongsTo('App\Logistic\LogisticOrder','id','order_id');
    }
}
