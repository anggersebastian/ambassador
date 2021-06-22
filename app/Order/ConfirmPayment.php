<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfirmPayment extends Model
{
    use SoftDeletes;

    protected $table = 'payment_confirmation';

    public function admin()
    {
        return $this->belongsTo(\App\AdminUsers\AdminUser::class, 'admin_id');
    }

    public function order()
    {
        return $this->belongsTo(\App\Order\Order::class);
    }

}
