<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tag = Tag::get();
        return response()->json([
            'status' => true,
            'data' => $tag
        ]);
    }
}
