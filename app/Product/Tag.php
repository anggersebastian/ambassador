<?php
namespace App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model{

    use SoftDeletes;
    protected $table = 'tag';

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }
}