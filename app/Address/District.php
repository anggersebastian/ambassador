<?php

namespace App\Address;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class District extends Model
{
    use SoftDeletes;

    protected $table = 'subdistricts';

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
