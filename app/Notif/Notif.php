<?php

namespace App\Notif;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{

    protected $table = 'order_notification';

    public function order()
    {
        return $this->belongsTo(\App\Order\Order::class);
    }
}
