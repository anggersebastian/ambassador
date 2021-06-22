<?php
namespace App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use SoftDeletes;

    protected $table = 'product_image';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
