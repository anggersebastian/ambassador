<?php

namespace App\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Costumer extends Model
{
    use SoftDeletes;

    protected $table = 'customer';

    public function district()
    {
        return $this->belongsTo(\App\Address\District::class, 'subdistrict_id');
    }
}
