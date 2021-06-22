<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
    // use SoftDeletes;

    protected $table = 'order_follow_up';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
