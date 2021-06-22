<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product\Category;
class CategoryController extends Controller{


    public function index()
    {

        $category = Category::with('parent')->get();
        $jumlah_category = Category::count();
        return view('backend.category.index', compact('category', 'jumlah_category'));
    }

    public function create()
    {
        $category = Category::whereNull('parent_id')->get();
        return view('backend.category.create', compact('category'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->get('name');
        $category->slug = str_slug($request->get('name'));
        if($request->get('parent') != '' ) {
            $category->parent_id =$request->get('parent');
        }

        $category->save();
        return redirect('/backend/category');
    }

    public function edit($id)
    {
        $edit = Category::find($id);
        $category = Category::whereNull('parent_id')->get();
        return view('backend.category.edit', compact('category', 'edit'));
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->slug = str_slug($request->get('name'));
        if($request->get('parent') != '') {
            $category->parent_id = $request->get('parent');
        }
        $category->save();
        return redirect('/backend/category');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('/backend/category');
    }
   
    
}