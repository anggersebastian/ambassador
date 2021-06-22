<?php
namespace App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model{

    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = ['name', 'slug'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

}