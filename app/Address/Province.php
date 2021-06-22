<?php

namespace App\Address;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $table = 'provinces';

    public function city()
    {
        return $this->hasMany(City::class);
    }
}
