<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product\Category;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::get();
        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }
}
