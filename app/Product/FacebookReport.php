<?php
namespace App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacebookReport extends Model{

    use SoftDeletes;
    protected $table = 'facebook_report';
    // protected $fillable = ['product_id','ad_spent', 'view_content', 'add_to_cart', 'initiate_checkout', 'lead'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}