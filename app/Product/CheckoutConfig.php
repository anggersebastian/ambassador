<?php
namespace App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckoutConfig extends Model
{
    use SoftDeletes;

    protected $table = 'checkout_config';

    protected $fillable = ['product_id','dump'];

    protected $appends = ['config'];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function getConfigAttribute()
    {
        return $this->dump ? json_decode($this->dump) : null;
    }
}
