<?php

namespace App\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandingProduct extends Model
{

    protected $table = 'landing_product';

    public $timestamps = true;
    protected $guarded = [];

    use SoftDeletes;
}
