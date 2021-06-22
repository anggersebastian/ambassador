<?php
namespace App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCs extends Model
{
    use SoftDeletes;

    protected $table = 'product_cs';

    protected $fillable = ['product_id','user_id', 'email'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
