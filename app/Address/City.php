<?php

namespace App\Address;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'cities';

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->hasMany(District::class);
    }
}
