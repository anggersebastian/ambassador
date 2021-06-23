<?php

namespace App\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'order';


    protected $appends = ['selected','current_status', 'crypt_invoice'];
    
    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function costumer()
    {
        return $this->hasOne(Costumer::class);
    }

    public function getCurrentStatusAttribute()
    {
        if($this->done_at) return 'Completed';
        if($this->cancel_at) return 'Refund';
        if($this->shipping_at) return 'Shipping';
        if($this->process_at) return 'Processing';
        if($this->checkout_at) return 'Pending';

        return 'Pending';
    }

    public function getSelectedAttribute(){
       return false;
    }

    public function getCryptInvoiceAttribute()
    {
        return Crypt::encrypt($this->invoice_number);
    }

    public function followup()
    {
        return $this->hasMany(FollowUp::class);
    }

    public function logPayment()
    {
        return $this->hasOne(OrderLogPayment::class);
    }

    public function handle()
    {
        return $this->belongsTo(\App\AdminUsers\AdminUser::class, 'admin_id', 'id');
    }

    public function myshortcart()
    {
        return $this->hasMany(Myshortcart::class);
    }

}
