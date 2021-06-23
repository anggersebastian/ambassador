<?php
namespace App\Product;

use App\Order\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProductRepository{

    public function getAll($start, $end)
    {
        $product = Product::with(['orderDetail' => function($q)use($start, $end){
                $q->select(DB::raw('id,product_id, ROUND(SUM(quantity), 0) as qty, ROUND(SUM(price), 0) as total_price'));
                $q->whereNotNull('paid_at');
                if($start !='' && $end !=''){
                    $q->where('created_at', '>=', formatingDefaultDate($start, true))->where('created_at', '<=', formatingDefaultDate($end, false));
                }else{
                    $last = Carbon::now()->subDays(30);
                    $q->where('created_at', '>=', $last);
                }
                $q->groupBy('product_id');
        }, 'facebookReport' => function($q){
            $q->select(DB::raw('id, product_id, ROUND(SUM(ad_spent), 0) as fb_spent'));
            $q->groupBy('product_id');
        }])
        ->orderBy('id', 'desc')->get();

        $res = $product->map(function($q){
            return [
                'id' => $q->id,
                'name' => $q->name,
                'code'=> $q->code,
                'slug' => $q->slug,
                'description' => $q->description,
                'price_type' => $q->price_type,
                'price' => (int)$q->price,
                'weight' => $q->weight,
                'cogs' => $q->cogs,
                'main_image' => $q->main_image,
                'meta_title' => $q->meta_title,
                'meta_description' => $q->meta_description,
                'total_order' => $q->orderDetail()->sum('quantity'),
                'total_paid' => count($q->orderDetail) ? $q->orderDetail[0]->qty : 0,
                'gross_revenue' => count($q->orderDetail) ? (float) $q->orderDetail[0]->total_price : 0,
                'net_revenue' => count($q->orderDetail) ? (float) $q->orderDetail[0]->total_price - ($q->cogs * $q->orderDetail[0]->qty) : 0,
                'fb_spent' => count($q->facebookReport) ? (float) $q->facebookReport[0]->fb_spent : 0
            ];
        });
        return [
            'status' => true,
            'data' => $res
        ];
    }

    public function insert($request)
    {
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->importir_product_id = $request->get('importir_product_id');
            $product->name = $request->get('name');
            $product->slug = $request->get('meta_slug');
            $product->description = $request->get('description');
            $product->price_type = $request->get('price_type');
            $product->cogs = $request->get('cogs');
            $product->price = $request->get('price');
            $product->weight = $request->get('weight');
            $product->main_image = $request->get('cover');
            
            $product->meta_title = $request->get('meta_title');
            $product->meta_description = $request->get('meta_description');
            $product->visit_count = 0;
            $product->save();

            $product->code = env('PRODUCT_CODE', '').$product->id;
            $product->save();

            // insert category and tag
            $product->category()->attach($request->get('category'));
            $product->tag()->attach($request->get('tag'));

            //insert product gallery
            if(count($request->get('product_image')) > 0){
                $gallery = [];
                foreach($request->get('product_image') as $value){
                    array_push($gallery, [
                        'url' => $value,
                        'product_id' => $product->id
                    ]);
                }
                $product->gallery()->insert($gallery);
            }
            
            // insert product Model
            if(count($request->get('attribute')) > 0){
                $model = [];
                foreach($request->get('attribute') as $value){
                    array_push($model, [
                        'product_id' => $product->id,
                        'key' => $value['key'],
                        'value' => $value['value'],
                        'price' => $value['price']
                    ]);
                }
                $product->models()->insert($model);
            }

            // insert price range
            if($request->get('price_type') == 'range' && count($request->get('price_range')) > 0){
                $range = [];
                foreach($request->get('price_range') as $item){
                    array_push($range, [
                        'product_id' => $product->id,
                        'start' => $item['start'],
                        'end' => $item['end'],
                        'price' => $item['price']
                    ]);
                }
                $product->range()->insert($range);
            }

            // insert checkout setting
            $product->setting()->create(['dump' => json_encode($request->get('setting'))]);
            
            // insert admin
            if($request->get('cs')){
                $product->cs()->createMany($request->get('cs'));
            }

            DB::commit();
            return [
                'status' => true,
                'data' => $product
            ];
        } catch (\Exception $th) {
            throw $th;
            return[
                'status' => false,
                'data' => $th->getMessage()
            ];
        }
    }

    public function updated($request, $id)
    {
        try {
            $product = Product::with('setting')->find($id);
            if(!$product)return[
                'status' => false,
                'data' => 'Product not found'
            ];
            DB::beginTransaction();
            //code...
            $product->importir_product_id = $request->get('importir_product_id');
            $product->name = $request->get('name');
            $product->slug = $request->get('meta_slug');
            $product->description = $request->get('description');
            $product->price_type = $request->get('price_type');
            $product->cogs = $request->get('cogs');
            $product->price = $request->get('price');
            $product->weight = $request->get('weight');
            $product->main_image = $request->get('cover');
            
            $product->meta_title = $request->get('meta_title');
            $product->meta_description = $request->get('meta_description');
            $product->save();

            // remove category and tag
            $product->category()->detach();
            $product->tag()->detach();
            // insert category and tag
            $product->category()->attach($request->get('category'));
            $product->tag()->attach($request->get('tag'));

            //insert product gallery
            if(count($request->get('product_image')) > 0){
                $product->gallery()->delete();
                $gallery = [];
                foreach($request->get('product_image') as $value){
                    array_push($gallery, [
                        'url' => $value,
                        'product_id' => $product->id
                    ]);
                }
                $product->gallery()->insert($gallery);
            }

             // insert product Model
             if(count($request->get('attribute')) > 0){
                $model = [];
                $product->models()->delete();
                foreach($request->get('attribute') as $value){
                    array_push($model, [
                        'product_id' => $product->id,
                        'key' => $value['key'],
                        'value' => $value['value'],
                        'price' => $value['price']
                    ]);
                }
                $product->models()->insert($model);
            }

            // insert price range
            if($request->get('price_type') == 'range' && count($request->get('price_range')) > 0){
                $range = [];
                $product->range()->delete();
                foreach($request->get('price_range') as $item){
                    array_push($range, [
                        'product_id' => $product->id,
                        'start' => $item['start'],
                        'end' => $item['end'],
                        'price' => $item['price']
                    ]);
                }
                $product->range()->insert($range);
            }

             // insert checkout setting
            if(!$product->setting){
                $product->setting()->create(['dump' => json_encode($request->get('setting'))]);
            }else{
                $product->setting()->update(['dump' => json_encode($request->get('setting'))]);
             }
            
             // insert admin
             $product->cs()->delete();
             if($request->get('cs')){
                 $product->cs()->createMany($request->get('cs'));
             }

            DB::commit();
            return [
                'status' => true,
                'data' => $product
            ];

        } catch (\Exception $th) {
            return[
                'status' => false,
                'data' => $th->getMessage()
            ];
        }
    }

    public function view($id)
    {
        $product = Product::with('category', 'tag', 'gallery', 'models', 'range', 'cs', 'setting')->find($id);
        if($product){
            return [
                'status' => true,
                'data' => $product
            ];
        }

        return [
            'status' => false,
            'data' => null
        ];
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
        }
        return true;
    }

    public function detail($id)
    {
        // $product = Product::with('facebookReport')->find($id);
        // $fb = FacebookReport::where('product_id', $id)->get();
        // $fb = $fb->pluck('created_at')->toArray();

        // // $fb = OrderDetail::where('product_id', $id)->whereIn()
        $fb = DB::table('facebook_report')
        ->select(DB::raw('*, DATE(created_at) as day'))
        ->whereNull('deleted_at')
        ->where('product_id', $id)
        ->orderBy('report_date', 'DESC')
        ->get();

        $paid = $this->getFbPaid(true, $id);
        

        $result = $fb->map(function($q)use($paid){
            $m = array_count_values($paid);
            $q->paid = isset($m[$q->day]) ? $m[$q->day] : 0;
            return $q;
        });

        $unpaid = $this->getFbPaid(false, $id);

        $result = $fb->map(function($q)use($unpaid){
            $m = array_count_values($unpaid);
            $q->unpaid = isset($m[$q->day]) ? $m[$q->day] : 0;
            $q->total_order = $q->paid + $q->unpaid;
            return $q;
        });

        return[
            'facebook_report' => $result,
            'total_order' => $this->totalOrder($id),
            'total_unpaid' => $this->totalPaid(false, $id),
            'total_paid' => $this->totalPaid(true, $id),
            'total_sold' => $this->totalSoldByProductId($id),
            'gross_profit' => $this->getGrossProfit($id),
            'net_profit' => $this->netProfit($id),
            'total_cogs' => $this->totalCogs($id),
        ];
    }

    private function getFbPaid($type, $id)
    {
        $od = DB::table('order_detail')
        ->select(DB::raw('*, DATE(created_at) as day'))
        ->whereNull('deleted_at');
        if($type){
            $od = $od->whereNotNull('paid_at');
        }else{
            $od = $od->whereNull('paid_at');

        }
        $od = $od->where('product_id', $id)
        ->get()->pluck('day')->toArray();
        return $od;
    }

    private function totalSoldByProductId($id)
    {
        $product = OrderDetail::where('product_id', $id)->whereNotNull('paid_at')->sum('quantity');
        return $product;
    }

    private function totalPaid($type, $id)
    {
        $product = OrderDetail::where('product_id', $id);
        if($type){
           $product = $product->whereNotNull('paid_at')->count();
        }else{
           $product = $product->whereNull('paid_at')->count();
        }
        return $product;
    }

    private function totalOrder($id)
    {
        $product = OrderDetail::where('product_id', $id)->count();
        return $product;
    }

    private function totalCogs($id)
    {
        $product = DB::table('product as p')
            ->select(DB::raw('ROUND(SUM(d.quantity), 0)  * p.cogs as total'))
        ->join('order_detail as d', 'p.id', '=', 'd.product_id')
        ->where('p.id', $id)
        ->whereNotNull('d.paid_at')
        ->get();

        return $product;
    }

    public function getGrossProfit($id)
    {
        $product = OrderDetail::where('product_id', $id)->whereNotNull('paid_at')->sum('price');
        return $product;
    }

    public function netProfit($id)
    {

        $product = DB::table('product as p')
            ->select(DB::raw('ROUND(SUM(d.price), 2)  - (ROUND(SUM(d.quantity), 0) * p.cogs) as total'))
        ->join('order_detail as d', 'p.id', '=', 'd.product_id')
        ->where('p.id', $id)
        ->whereNotNull('d.paid_at')
        ->first();
        return $product;
    }

}