<?php
namespace App\Order;

use App\Address\District;
use App\AdminUsers\AdminUser;
use App\Product\Product;
use Illuminate\Support\Facades\DB;
use App\AwsSdk\S3Service;
use App\Product\ProductModel;
use Carbon\Carbon;

class OrderRepository {

    public function indexJsonAdmin($request)
    {
        $order  = Order::with(['detail.product', 'detail.variations', 
        'handle' =>  function($q){
            $q->select('id','email', 'first_name');
        }, 
        'myshortcart' => function($q){
            $q->select('id', 'order_id','transidmerchant');
        },
        'costumer', 'costumer.district', 
                'followup' => function($q){
                    $q->select('order_id', 'name');
                }]);
        if(\Sentinel::inRole('cs')){
            $user = \Sentinel::check();
            $order = $order->where('admin_id', $user->id);
        }
        if($request->get('status')){
            if($request->get('status') == 'pending'){
                $order = $order->whereNull('process_at');
            }elseif($request->get('status') == 'process'){
                $order = $order->whereNotNull('process_at');
            }elseif($request->get('status') == 'shipping'){
                $order = $order->whereNotNull('shipping_at');
            }elseif($request->get('status') == 'cancel'){
                $order = $order->whereNotNull('cancel_at');
            }elseif($request->get('status') == 'done'){
                $order = $order->whereNotNull('done_at');
            }
        }

        if($request->get('payment')){
            if($request->get('payment') == 'paid'){
                $order = $order->whereNotNull('paid_at');
            }elseif($request->get('payment') == 'unpaid'){
                $order = $order->whereNull('paid_at');
            }
        }

        if($request->get('payment-method')){
            if($request->get('payment-method') == 'cod'){
                $order = $order->where('paid_with', 'cod');
            }elseif($request->get('payment-method') == 'transfer'){
                $order = $order->where('paid_with', 'transfer');
            }
        }

        if($request->get('tracking')){
            $order = $order->where('tracking_number', 'like', '%'. $request->get('tracking') . '%');
        }
        if($request->get('handle')){
            $order = $order->where('admin_id', $request->get('handle'));
        }

        if($request->get('start') !='' && $request->get('end') !=''){
            $order = $order->where('created_at', '>=', formatingDefaultDate($request->get('start'), true))->where('created_at', '<=', formatingDefaultDate($request->get('end'), false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('created_at', '>=', $last);
        }

        if($request->get('search')){
            $order = $order->where('invoice_number', 'like', '%'. $request->get('search'). '%');
            $order = $order->orWhereHas('costumer', function($q) use($request){
                $q->where('name', 'like', '%'. $request->get('search') . '%');
            });
            $order = $order->orWhereHas('myshortcart', function($q)use($request){
                $q->where('transidmerchant', 'like', '%'. $request->get('search').'%');
            });
        }

        
        $order = $order->orderBy('id', 'DESC');

        $page = $request->get('page') ? $request->get('page') : 0;
        $limit =60;
        $page = $page * $limit;
        if($request->get('export')){
            $order = $order->limit(1000)->get();
        }else{
            $order = $order->offset($page)
                    ->limit($limit)
                    ->get();
        }
        return $order;
    }

    public function generateTotalOrder($start = '', $end = '')
    {
        if($start !='' && $end !=''){
            $order = Order::where('created_at', '>=', formatingDefaultDate($start, true))->where('created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = Order::where('created_at', '>=', $last);
        }

        $order = $order->count();
        return $order;
    }

    public function generateOrderPaid($type, $start = '', $end = '')
    {
        if($type == 'paid'){
            $order = Order::whereNotNull('paid_at');
        }else{
            $order = Order::whereNull('paid_at');
        }

        if($start !='' && $end !=''){
            $order = $order->where('created_at', '>=', formatingDefaultDate($start, true))->where('created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('created_at', '>=', $last);
        }
        $order = $order->count();
        return $order;

    }

    public function generateQuantitySold($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id');

        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum('quantity');
        return $order;
    }

    public function generateCogs($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
        ->join('product', 'product.id', '=', 'order_detail.product_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum('cogs');
        return $order;
    }

    public function generateUnpaidRevenue($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNull('order.paid_at')->whereNull('order.deleted_at')->sum('total_price');
        return $order;
    }

    public function generateGrossRevenue($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum('total_price');
        return $order;
    }

    public function generateNetRevenue($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
        ->join('product', 'product.id', '=', 'order_detail.product_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum('order.product_price');
        return $order;
    }

    public function generateGrossProfit($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
        ->join('product', 'product.id', '=', 'order_detail.product_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum(DB::raw('product.price * order_detail.quantity'));
        return $order;
    }
    
    public function generateNetProfit($start = '', $end = '')
    {
        $order = DB::table('order')
        ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
        ->join('product', 'product.id', '=', 'order_detail.product_id');
        if($start !='' && $end !=''){
            $order = $order->where('order.created_at', '>=', formatingDefaultDate($start, true))->where('order.created_at', '<=', formatingDefaultDate($end, false));
        }else{
            $last = Carbon::now()->subDays(30);
            $order = $order->where('order.created_at', '>=', $last);
        }
        $order = $order->whereNotNull('order.paid_at')->whereNull('order.deleted_at')->sum(DB::raw('order_detail.price - (product.cogs * order_detail.quantity)'));
        return $order;
    }

    public function insertOrder($request)
    {
        //Create order detail
        $product = Product::with('cs')->find($request->get('product'));
        if(!$product) return [
            'status' => false,
            'data' => 'Product not found'
        ];

        $attribute = $request->get('attribute') ? $request->get('attribute') : [];
        $token = time().str_random(10);
        $detailPayload = [];
        $productPrice = 0;
        $totalWeight = 0;
        $uniqueFee = rand(100, 500);
        if(count($attribute)){
            foreach($attribute as $value){
                $model = ProductModel::find($value['id']);
                if($model){
                    array_push($detailPayload, [
                        'product_model_id' => $value['id'],
                        'product_id' => $request->get('product'),
                        'quantity' => $value['qty'],
                        'weight' => $product->weight * $value['qty'],
                        'price' => $model->price * $value['qty'],
                        'created_at' => date('Y-m-d H:m:i'),
                        'updated_at' => date('Y-m-d H:m:i'),
                        'token' => $token
                    ]);
                    $productPrice = $productPrice + $model->price * $value['qty'];
                    $totalWeight = $totalWeight + $product->weight * $value['qty'];
                }
            }
        } else{
            array_push($detailPayload, [
                // 'product_model_id' => null,
                'product_id' => $request->get('product'),
                'quantity' => $request->get('qty'),
                'weight' => $product->weight * $request->get('qty'),
                'price' => $product->price * $request->get('qty'),
                'created_at' => date('Y-m-d H:m:i'),
                'updated_at' => date('Y-m-d H:m:i'),
                'token' => $token
            ]);
            $productPrice = $product->price * $request->get('qty');
            $totalWeight = $totalWeight + $product->weight * $request->get('qty');
        }
        try {
            DB::beginTransaction();
            $orderDetail = OrderDetail::insert($detailPayload);
            if($request->get('city')){
                $ongkir = \App\RajaOngkir\RajaOngkir::getOngkir($totalWeight, $request->get('city')['id']);
                $ongkirAmount = $ongkir['status'] ? $ongkir['data']->value : 0;
                $codFee = ($ongkirAmount + $productPrice) * 5 / 100;
                $total = $ongkirAmount + $productPrice + $codFee;
            }else{
                $ongkirAmount = 0;
                $codFee = 0;
                $total = $ongkirAmount + $productPrice + $codFee;
            }
            // make Invoice
            $order = new Order();
            $order->admin_id = $this->generateCs($product);
            $order->product_price = $productPrice;
            $order->shipping_type = 'ninja';
            $order->shipping_fee = $ongkirAmount;
            $order->cod_fee = $codFee;
            $order->total_price = $request->get('payment')  == 'cod' ? $total : ($total - $codFee) + $uniqueFee;
            $order->total_weight = $totalWeight;
            $order->paid_with = $request->get('payment') ? $request->get('payment') : 'transfer';
            $order->unique_fee = $uniqueFee;
            $order->order_from = $request->get('order_from');
            $order->save();
            $order->invoice_number = env('PREFIX_INVOICE', 'DRP').$order->id;
            $order->save();
    
            // update order detail
            OrderDetail::where('token', $token)->update(['order_id' => $order->id]);
    
            // insert to costumer
            $costumer = $this->insertCustomer($order, $request);
            $getOrderDetail = OrderDetail::where('order_id', $order->id)->get();
           
            // create notif
            $notif = \App\Notif\NotifRepository::insertBulk($order->id);

            if(!env('APP_DEBUG')){
                // send notif email to admin or cs
                $admin = AdminUser::select('id','email')->find($order->admin_id);
                if($admin){
                    $arg = [
                        'to' => $admin->email,
                        'adminName' => $admin->first_name,
                        'customer' => $request->get('name'),
                        'invoice' => $order->invoice_number,
                        'link' => url('/backend/order'),
                        'detail' => $getOrderDetail,
                        'product_price' => $order->product_price,
                        'shipping_fee' => $order->shipping_fee,
                        'cod_fee' => $order->cod_fee,
                        'unique_fee' => $order->unique_fee,
                        'total_price' => $order->total_price,
                        'paid_with' => $order->paid_with,
                        'link_customer' => 'https://dropy.id/thanks?order='.$order->invoice_number
                    ];

                    \App\EmailService\EmailService::sendNotifNewOrderToAdmin($arg);
                }
                // send email to customer
                if($request->get('email')){
                    $arg = [
                        'to' => $request->get('email'),
                        'customer' => $request->get('name'),
                        'invoice' => $order->invoice_number,
                        'link' =>'https://dropy.id/thanks?order='.$order->invoice_number,
                        'detail' => $getOrderDetail,
                        'product_price' => $order->product_price,
                        'shipping_fee' => $order->shipping_fee,
                        'cod_fee' => $order->cod_fee,
                        'unique_fee' => $order->unique_fee,
                        'total_price' => $order->total_price,
                        'paid_with' => $order->paid_with,
                    ];
                    \App\EmailService\EmailService::sendNotifNewOrderToCustomer($arg);
                }
            }
            DB::commit();
            return [
                'status' => true,
                'data' => [
                    'order' => $order,
                    'order_detail' => $getOrderDetail,
                    'customer' => $costumer,
                    'product' => $product->name
                ]
            ];
        } catch (\Exception $e) {
            throw $e;
            exit;
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function updateOrder($request, $id)
    {
        try {
            $district = \App\Address\District::with('city.province')->find($request->get('district'));
            $constumer = [
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'address' => $request->get('address'),
                'subdistrict_id' => $district->id,
                'province' => $district->city->province->name,
                'city' => $district->city->name,
                'district_name' => $district->name,
            ];
    
            DB::beginTransaction();
            $productPrice = 0;
            $totalWeight = 0;
            foreach($request->get('detail') as $value){
                $detail = \App\Order\OrderDetail::find($value['id']);
                $product = \App\Product\Product::find($detail->product_id);
                $detail->quantity = $value['quantity'];
                $detail->price = $value['quantity'] * $product->price;
                $detail->weight = $value['quantity'] * $product->weight;
                $productPrice = $productPrice + ($value['quantity'] * $product->price);
                $totalWeight = $totalWeight + ($value['quantity'] * $product->weight);
                $detail->save();
            }

            $order = Order::with('costumer')->find($id);
            $order->tracking_number = $request->get('tracking_number');
            $order->note = $request->get('note');
            $order->paid_with = $request->get('payment');

           
            $ongkir = \App\RajaOngkir\RajaOngkir::getOngkir($totalWeight, $district->city_id);
            $ongkirAmount = $ongkir['status'] ? $ongkir['data']->value : 0;
            $codFee = ($ongkirAmount + $productPrice) * 5 / 100;
            $total = $ongkirAmount + $productPrice + $codFee;
            $order->product_price = $productPrice;
            $order->shipping_fee = $ongkirAmount;
            $order->cod_fee = $codFee;
            $order->total_price = $request->get('payment')  == 'cod' ? $total : ($total - $codFee);
            $order->total_weight = $totalWeight;
            $order->save();

            $order->costumer()->update($constumer);
            DB::commit();
            return[
                'status' => true,
                'data' => $order
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function insertCustomer($order, $request)
    {
        $district = District::with('city.province')->find($request->get('city')['id']);
        $costumer = new Costumer();
        $costumer->order_id = $order->id;
        $costumer->subdistrict_id = $district ? $district->id : null;
        $costumer->province = $district ? $district->city->province->name : null;
        $costumer->city = $district ? $district->city->name : null;
        $costumer->district_name = $district ? $district->name : null;
        $costumer->name = $request->get('name');
        $costumer->email = $request->get('email') ? $request->get('email') : null;
        $costumer->phone = $request->get('phone');
        $costumer->address = $request->get('address');
        $costumer->save();
        return $costumer;
    }

    public function findByInvoice($invoice)
    {
        $order = Order::where('invoice_number', $invoice)->with('detail.product', 'logPayment', 'costumer')->first();
        if(!$order) return [
            'status' => false,
            'data' => 'Order not found'
        ];
        $payment = null;
        if($order->logPayment){
            if($order->logPayment->dump){
                $payment = json_decode($order->logPayment->dump);
            }
        }

        return [
            'status' => true,
            'data' => [
                'id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'product_price' => $order->product_price,
                'shipping_type' => $order->shipping_type,
                'shipping_fee' => $order->shipping_fee,
                'cod_fee' => $order->cod_fee,
                'unique_fee' => $order->unique_fee,
                'total_price' => $order->total_price,
                'total_weight' => $order->total_weight,
                'payment_type' => $order->paid_with,
                'paid_at' => $order->paid_at,
                'detail' => $order->detail->map(function($value){
                    return [
                        'id' => $value->id,
                        'product' => [
                            'name' => $value->product->name,
                            'slug' => $value->product->slug,
                            'price' => $value->product->price
                        ]
                    ];
                }),
                'payment' => $payment,
                'customer' => $order->costumer,
                'created_at' => $order->created_at
            ]
        ];
    }

    public function confirmPayment($request)
    {
        $order = Order::where('invoice_number', $request->get('order'))->first();
        if(!$order) return [
            'status' => false,
            'data' => 'Order not found'
        ];

        $confirm = new ConfirmPayment();
        $confirm->order_id = $order->id;
        $confirm->customer_account = $request->get('customer_account');
        $confirm->transfer_to = $request->get('transfer_to');
        $confirm->transaction_at = $request->get('transaction_date');
        $confirm->amount = $request->get('amount');

        if($request->hasFile('struck')){
            $s3    = new S3Service();
            $imagePacking   = $request->file('struck');
            try{
                $uploadFile  = $s3->putObject($imagePacking, $imagePacking->getClientOriginalName(), $imagePacking->getMimeType(),'dropy-confirm-order');
                $confirm->files = env('CDN_URL').'dropy-confirm-order/'.$uploadFile['name'];
            }catch (\Exception $exception){
                return [
                    'status' => false,
                    'data' => $exception->getMessage()
                ];
            }
        }

        $confirm->save();
        return [
            'status' => true,
            'data' => $confirm
        ];
    }

    public function changeStatus($request, $id)
    {
        $order = Order::with('costumer')->find($id);
        $status = $request->get('status');
        switch ($status) {
            case 'pending':
                $order->process_at = null;
                break;
            case 'process':
                $order->process_at = date('Y-m-d H:i:s');
                break;
            case 'shipping':
                $order->shipping_at = date('Y-m-d H:i:s');
                $order->tracking_number = $request->tracking;
                $logistict = new \App\Logistic\LogisticRepository();
                if($request->get('batch')){
                    $logistict->makeOrderLogistic($id, $request->get('batch'));
                }
                break;
            case 'paid':
                $files = null;
                if($request->hasFile('file')){
                    $s3    = new S3Service();
                    $imagePacking   = $request->file('file');
                    try{
                        $uploadFile  = $s3->putObject($imagePacking, $imagePacking->getClientOriginalName(), $imagePacking->getMimeType(),'payment-confirm');
                        $files = env('CDN_URL').'payment-confirm/'.$uploadFile['name'];
                    }catch (\Exception $exception){
                        $uploadFile  = $exception->getMessage();
                    }
                }
                $amount = $request->get('amount') ? $request->get('amount') : 0;
                $customer = $request->get('customer') ? $request->get('customer') : null;
                if(!$order->paid_at){
                    $user = \Sentinel::check();
                    $confirm = new ConfirmPayment();
                    $confirm->order_id = $order->id;
                    $confirm->admin_id = $user->id;
                    $confirm->customer_account = $customer;
                    $confirm->amount = $amount;
                    $confirm->files = $files;
                    $confirm->save();
                }
                if(!$order->paid_at){
                    if( $order->costumer &&  $order->costumer->email){
                        $arg = [
                            'to' => $order->costumer->email,
                            'customer' => $order->costumer ? $order->costumer->name : '',
                            'invoice' => $order->invoice_number,
                            'link' => url('https://dropy.id/thanks?order='.$order->invoice_number)
                        ];
                       $c =  \App\EmailService\EmailService::sendNotifHasPaidToCustormer($arg);
                    }
                }
                $order->paid_at = $order->paid_at ? null : date('Y-m-d H:i:s');
                break;
            case 'done':
                $order->done_at = date('Y-m-d H:i:s');
                break;
            case 'cancel':
                $order->cancel_at = date('Y-m-d H:i:s');
                break;
            default:
                $order->process_at = null;
                break;
        }
        if($request->get('tracking') !=''){
            $order->tracking_number = $request->get('tracking');
        }
        $order->save();
        // update order detail
        OrderDetail::where('order_id', $order->id)->update(['paid_at' => $order->paid_at]);
        return [
            'status' => true,
            'data' => $order
        ];
    }

    public function bulkChangeStatus($request)
    {
        $body = $request->get('key');
        $order = $request->get('order');

        $order = Order::whereIn('id', $order)->update($body);

        return $order;
    }

    public function setFollowUp($name, $orderId)
    {
        $order = new FollowUp();
        $order->order_id = $orderId;
        $order->name = $name;
        $order->save();
        return [
            'status' => true,
            'data' => $order
        ];
    }

    public function deleted($id)
    {
        $order = Order::find($id);
        if($order) {
            $order->delete();
        }

        return [
            'status' => true,
            'data' => 'Order has been deleted'
        ]; 
    }

    public function generateCs($product)
    {
        try {
            if(count($product->cs) >0){
                $cs = $product->cs->pluck('user_id')->toArray();
                $findOrder = Order::with('detail')->whereHas('detail', function($q)use($product){
                    $q->where('product_id', $product->id);
                })
                ->orderBy('id', 'desc')
                ->first();
                if(!$findOrder)  return $cs[0];
                if(count($cs) == 1) return $cs[0];
                $search = array_search($findOrder->admin_id, $cs, true);
                $length = count($cs) - 1;
                if($search < $length){
                    return $cs[$search + 1];
                }else{
                    return $cs[0];
                }
                return 11;
            }else{
                $lastOrder = Order::select('admin_id')->whereNotNull('admin_id')->orderBy('id', 'DESC')->first();
                $role = \Sentinel::findRoleById(2); // cs
                if(!$role) return 1;
                $cs = $role->users()->with('roles')->get();
                $cs = $cs->pluck('id');
                $cs = $cs->all();
                if(!$lastOrder) return $cs[0];
                if(count($cs) == 1) return $cs[0];
                $search = array_search($lastOrder->admin_id, $cs);
                $length = count($cs) - 1;
                
                if($search < $length){
                    return $cs[$search + 1];
                }elseif($search == $length){
                    return $cs[0];
                }else{
                    return 11;
                }
            }
        } catch (\Exception $th) {
            return 11;
        }
    }

    // payment
    public function getAllPayment()
    {
        $payment = ConfirmPayment::with(['order' => function($q){
            $q->select('id', 'invoice_number');
        }, 'admin'=>function($q){
            $q->select('id', 'email');
        }])
        ->whereHas('order', function($q){
            $q->where('paid_with', 'transfer');
        })
        ->orderBy('id', 'DESC')->get();
        return $payment;
    }
}