<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRange extends Model
{
    use SoftDeletes;

    protected $table = 'price_range';
}
