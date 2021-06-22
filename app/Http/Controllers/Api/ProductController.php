<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product\Product;

class ProductController extends Controller
{
    public function view(Request $request, $slug)
    {
        $product = Product::with('category', 'tag', 'gallery', 'models', 'range', 'setting')->where('slug', $slug)->first();
        if(!$product) return response()->json([
            'status' => false,
            'data' => 'Product not found'
        ]);

        $result = [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'slug' => $product->slug,
            'description' => $product->description,
            'price_type' => $product->price_type,
            'price' => $product->price,
            'weight' => $product->weight,
            'main_image' => $product->main_image,
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'setting' => $product->setting,
            'category' => $product->category->map(function($value){
                return [
                    'name' => $value->name,
                    'slug' => $value->slug
                ];
            }),
            'tag' => $product->tag->map(function($value){
                return [
                    'name' => $value->name,
                    'slug' => $value->slug
                ];
            }),
            'gallery' => $product->gallery->map(function($value){
                return [
                    'url' => $value->url
                ];
            }),
            'attribute' => $product->models->map(function($value){
                return [
                    'id' => $value->id,
                    'key' => $value->key,
                    'value' => $value->value,
                    'price' => $value->price,
                    'qty' => 1
                ];
            }),
            'range' => $product->range->map(function($value){
                return [
                    'start' => $value->start,
                    'end' => $value->end,
                    'price' => $value->price,
                ];
            })

        ];

        return response()->json([
            'status' => true,
            'data' => $result
        ]);
    }
}
