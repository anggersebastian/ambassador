<?php
namespace App\Product;

use App\Order\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model{

    use SoftDeletes;

    protected $table = 'product';

    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    public function models()
    {
        return $this->hasMany(ProductModel::class, 'product_id', 'id');
    }

    public function range()
    {
        return $this->hasMany(ProductRange::class, 'product_id', 'id');
    }

    public function setting()
    {
        return $this->hasOne(CheckoutConfig::class);
    }

    public function cs()
    {
        return $this->hasMany(ProductCs::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function facebookReport()
    {
        return $this->hasMany(FacebookReport::class);
    }

    public function users(){
        return $this->hasMany('App\AdminUsers\AdminUser', 'product_id');
    }
}
