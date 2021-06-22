<?php

namespace App\Logistic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogisticBatch extends Model
{

    protected $table = 'logistic_batch';

    public $timestamps = true;
    protected $guarded = [];

    use SoftDeletes;


    public function logistic_orders(){
        return $this->hasMany('App\Logistic\LogisticOrder')->orderBy('id','desc');
    }
}
