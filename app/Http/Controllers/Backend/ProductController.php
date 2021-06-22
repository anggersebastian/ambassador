<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product\ProductRepository;
use App\Product\Product;
use App\Product\FacebookReport;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller{

    private $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return view('backend.product.index');
    }

    public function productDetails()
    {
        return view('backend.product.product_details');
    }

    public function jsonFbReport($id){
      
        $data = $this->product->detail($id);
       return response()->json([
            'status' => true,
            'data' => $data
        ]);
  
    }

    public function indexJson(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $product = $this->product->getAll($start, $end);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'meta_slug' => 'required|unique:product,slug',
            'description' => 'required',
            'price_type' => 'required',
            'cogs' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'cover' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'category' => 'required',
            'tag' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->messages()
            ]);
        } 

        $product = $this->product->insert($request);
        return response()->json($product);
       
    }

    public function view($id)
    {
        $product = $this->product->view($id);
        return response()->json($product);
    }

    public function edit($id)
    {
        return view('backend.product.edit');
    }

    public function update(Request $request, $id)
    {
        $product = $this->product->updated($request,$id);
        return response()->json($product);
    }

    public function destroy(Request $request, $id)
    {
        $product = $this->product->delete($id);
        return response()->json([
            'status' => true,
            'data' => "Product Has been deleted"
        ]);
    }

   
    
}