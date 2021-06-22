<?php

namespace App\Logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticOrder extends Model
{

    protected $table = 'logistic_order';
    protected $appends = ['quantity_real'];

    public $timestamps = true;
    protected $guarded = [];

    use SoftDeletes;


    public function logistic_batch(){
        return $this->belongsTo('App\Logistic\LogisticBatch');
    }

    public function logistic_statuses(){
        return $this->hasMany('App\Logistic\LogisticOrderStatus','logistic_order_id','order_id')->orderBy('id','desc');
    }

    public function getQuantityRealAttribute(){

        $qty                        = $this->quantity;
        if($this->bump_price > 0){
            $qty                    = $this->quantity + 1;
        }

        return $qty;
    }
}
