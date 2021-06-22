<?php
namespace App\Http\Controllers\Backend;

use App\AdminUsers\AdminUser;
use App\Http\Controllers\Controller;

class AdminController extends Controller{

    public function getAllCs()
    {
        $cs = AdminUser::with('newRole')->whereHas('newRole', function($q){
            $q->where('name', 'CS');
        })->get();
        return response()->json([
            'status' => true,
            'data' => $cs
        ]);
    }

}