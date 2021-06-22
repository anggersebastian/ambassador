<?php
namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLogPayment extends Model{

    use SoftDeletes;

    protected $table = 'order_log_payment';

    protected $fillable = ['dump'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}