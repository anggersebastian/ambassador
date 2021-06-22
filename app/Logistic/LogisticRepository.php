<?php

namespace App\Logistic;

use App\AwsSdk\S3Service;
use App\Imports\LogisticOrders;
use App\Jurnal\JurnalService;
use App\Order\Order;
use App\User\PhoneNumberService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DB;

class LogisticRepository{
    public function __construct()
    {
    }

    public function findLogisticBatch($id = null){
        $data   = LogisticBatch::with(['logistic_orders']);


        return $data->find($id);
    }

    public function deleteLogisticBatchAndOrders($id = null){
        $data   = LogisticBatch::with(['logistic_orders']);


        $data   = $data->find($id);
        if($data){
            foreach ($data->logistic_orders as $order){
                $order->delete();
            }
            $data->delete();
        }

        return true;
    }

    public function deleteOrder($id = null){
        $order  = $this->findLogisticOrder($id);
        if(!$order){
            return false;
        }
        $order->delete();

        return true;
    }

    public function getLogisticBatches($filters = []){
        $data   = LogisticBatch::with(['logistic_orders']);

        if(!empty($filters['title'])){
            $data->where('title','like','%'. $filters['title'] .'%');
        }

        if(!empty($filters['request_date'])){
            $data->where('request_date','like','%'. $filters['request_date'] .'%');
        }

        return $data->orderBy('id','desc')->paginate('25');
    }

    public function getBatchLimit()
    {
        return LogisticBatch::limit(20)->orderBy('id', 'DESC')->get();
    }

    public function saveBatch($id = null, $inputs = []){
        $batch  = $this->findLogisticBatch($id);
        if(!$batch){
            $batch  = new LogisticBatch();
        }

        $batch->title           = $inputs['title'];
        $batch->request_date    = $inputs['request_date'];
        $batch->status          = $inputs['status'];
        $batch->created_by      = \Sentinel::check()->first_name;
        $batch->save();

        return $batch;
    }

    public function findLogisticOrder($id = null){
        return LogisticOrder::with(['logistic_batch','logistic_statuses'])->find($id);
    }

    public function findLogisticOrderByOrderId($id = null){
        return LogisticOrder::with(['logistic_batch'])->where('order_id', $id)->first();
    }

    public function findLogisticOrderByPhoneZip($phone = '', $zip = '', $name = ''){
        return LogisticOrder::with([])->where('phone', $phone)
            //->where('zip', $zip)
            ->where('name', $name)
            ->first();
    }

    public function getLogisticOrderGroupByCS($filters = []){
        $data   = LogisticOrder::with([]);

        if(!empty($filters['name'])){
            $data->where('handled_by','like','%' . $filters['name'] . '%');
        }

        if(!empty($filters['date_start']) AND !empty($filters['date_end'])){
            $start  = date('Y-m-d 00:00:00', strtotime($filters['date_start']));
            $end    = date('Y-m-d 23:59:59', strtotime($filters['date_end']));

            $data->whereBetween('updated_at', [$start, $end]);
        }

        return $data->groupBy('handled_by')
            ->orderBy('id','desc')
            ->paginate(25);
    }

    public function getLogisticOrderByBatchId($id = null, $payment = null){
        $data   = LogisticOrder::with([])->where('logistic_batch_id', $id);
        if(!is_null($payment)){
            $data = $data->where('payment_method', $payment);
        }
        return  $data->get();
    }

    public function countLogisticOrders($filters = []){
        $data   = LogisticOrder::with([])->select(['id','handled_by','logistic_status','quantity','bump_price']);

        if(!empty($filters['handled_by'])){
            $data->where('handled_by','like','%'. $filters['handled_by'] .'%');
        }

        if(!empty($filters['date_start']) AND !empty($filters['date_end'])){
            $start  = date('Y-m-d 00:00:00', strtotime($filters['date_start']));
            $end    = date('Y-m-d 23:59:59', strtotime($filters['date_end']));

            $data->whereBetween('updated_at', [$start, $end]);
        }

        return $data->orderBy('id','desc')->get();
    }

    public function getLogisticOrders($filters = [], $isPaginate = true){
        $data   = LogisticOrder::with(['logistic_batch','logistic_statuses']);

        if(!empty($filters['logistic_batch_id'])){
            $data->where('logistic_batch_id', $filters['logistic_batch_id']);
        }

        if(!empty($filters['order_id'])){
            $data->where('order_id','like','%'. $filters['order_id'] .'%');
        }

        if(!empty($filters['product_name'])){
            $data->where('product_name','like','%'. $filters['product_name'] .'%');
        }

        if(!empty($filters['name'])){
            $data->where('name','like','%'. $filters['name'] .'%');
        }

        if(!empty($filters['date_start']) AND !empty($filters['date_end'])){

            $data->whereBetween('updated_at', [$filters['date_start'], $filters['date_end']]);
        }

        if(!empty($filters['have_status']) AND $filters['have_status'] != 'all'){
            if($filters['have_status'] == 'yes'){
                $data->where('logistic_status', '<>','');
            }
            if($filters['have_status'] == 'no'){
                $data->where('logistic_status', '');
            }
        }

        if(!empty($filters['logistic_status'])){
            $myArray = explode(',', $filters['logistic_status']);
            $data->where(function($query)use($myArray){
                foreach ($myArray as $value){
                    $query->orWhere('logistic_status','like','%'. $value .'%');
                }
            });
        }

        //logistic_status_not
        if(!empty($filters['logistic_status_not'])){
            $myArray = explode(',', $filters['logistic_status_not']);
            foreach ($myArray as $value){
                $data->where('logistic_status','not like','%'. $value .'%');
            }
        }

        if(!empty($filters['handled_by'])){
            $data->where('handled_by','like','%'. $filters['handled_by'] .'%');
        }

        if(!empty($filters['phone'])){
            $phone      = new PhoneNumberService();
            $realPhone  = $phone->standardPhone($filters['phone']);

            $data->where('phone','like','%'. $realPhone .'%');
        }

        if(!empty($filters['receipt'])){
            $data->where('receipt_number','like','%'. $filters['receipt'] .'%');
        }


        if(!empty($filters['has_receipt']) AND $filters['has_receipt'] != 'all'){
            $hasReceipt = $filters['has_receipt'];
            if($hasReceipt == 'yes'){
                $data->where('receipt_number','<>','');
            }

            if($hasReceipt == 'no'){
                $data->where('receipt_number','');
            }
        }

        $data->orderBy('id','desc');

        if($isPaginate){

            return $data->paginate('50');
        }

        return $data->get();
    }

    public function extractCsvLogisticOrderOnline($inputs = []){
        $logisticBatchId    = $inputs['logistic_batch_id'];
        $uploadFile         = $inputs['csv'];

        $responses          = [];
        try{
            $responses      = \Excel::setDelimiter(",")->load($uploadFile)->get();
        }catch (\Exception $exception){
            return false;
        }

        if(empty($responses)){
            return false;
        }


        $phoneService   = new PhoneNumberService();
        $results        = [];
        foreach ($responses->toArray() as $key => $response){
            /*if(isset($response['order_id']) OR isset($response['product']) OR isset($response['name'])
                OR isset($response['email']) OR isset($response['phone']) OR isset($response['address'])
                OR isset($response['province']) OR isset($response['city']) OR isset($response['subdistrict'])
                OR isset($response['zip']) OR isset($response['status']) OR isset($response['payment_status'])
                OR isset($response['payment_method']) OR isset($response['product_price']) OR isset($response['cogs']) OR isset($response['discount'])
                OR isset($response['quantity']) OR isset($response['bump']) OR isset($response['bump_price']) OR isset($response['notes'])
                OR isset($response['courier']) OR isset($response['shipping_cost']) OR isset($response['cod_cost']) OR isset($response['receipt_number'])
                OR isset($response['gross_revenue']) OR isset($response['net_revenue']) OR isset($response['created_at']) OR isset($response['processing_at'])
                OR isset($response['completed_at']) OR isset($response['handled_by']) OR isset($response['coupon']) OR isset($response['utm_campaign'])
                OR isset($response['utm_medium']) OR isset($response['utm_source']) OR isset($response['utm_content']) OR isset($response['utm_term'])
                OR empty($response['tags']) OR empty($response['variation'])){
                dd(is_null($response['email']));
                return false;
            }*/

            $results[$key]                      = $response;

            $results[$key]['order_id']          = (int)$response['order_id'];

            $results[$key]['zip']               = (int)$response['zip'];
            $results[$key]['product_price']     = (int)$response['product_price'];
            $results[$key]['cogs']              = (int)$response['cogs'];
            $results[$key]['discount']          = (int)$response['discount'];
            $results[$key]['bump_price']        = (int)$response['bump_price'];
            $results[$key]['shipping_cost']     = (int)$response['shipping_cost'];
            $results[$key]['cod_cost']          = (int)$response['cod_cost'];
            $results[$key]['gross_revenue']     = (int)$response['gross_revenue'];
            $results[$key]['net_revenue']       = (int)$response['net_revenue'];

            $results[$key]['phone']             = $phoneService->standardPhone($response['phone']);
            $date                               = str_replace(' - ', ' ', $response['created_at']);
            $results[$key]['created_at']        = Carbon::parse($date)->toDateTimeString();
        }

        return $results;
    }

    public function extractCsvLogisticNinja($inputs = []){
        $uploadFile         = $inputs['csv'];

        $responses          = [];
        try{
            $responses      = \Excel::load($uploadFile)->get();
        }catch (\Exception $exception){
            return false;
        }

        if(empty($responses)){
            return false;
        }

        $phoneService   = new PhoneNumberService();
        $result         = [];
        foreach ($responses->toArray() as $key => $response){
            /*if(!isset($response['kontak']) OR !isset($response['nama']) OR !isset($response['kontak'])
                OR !isset($response['alamat_pengirim']) OR !!isset($response['id_pelacakan']) OR !isset($response['status_granular'])
                OR !isset($response['nama_pengirim']) OR !isset($response['kontak_pengirimim']) OR !isset($response['kode_pos_pengirim'])
                OR !isset($response['cod']) OR !isset($response['alamat_penerima']) OR !isset($response['alamat_penerima_2'])
                OR !isset($response['kode_pos'])){

                return false;
            }*/
            $result[$key]                       = $response;
            $result[$key]['kontak']             = $phoneService->standardPhone($response['kontak']);
            $result[$key]['kontak_pengirimim']  = $phoneService->standardPhone($response['kontak_pengirimim']);
        }

        return $result;
    }

    public function extractCsvReconciliationLogisticNinja($inputs){

        $explodes   = preg_split('/\s+/', $inputs['csv']);
        $data       = [];
        $key        = 0;
        $masterKey  = 0;
        foreach ($explodes as $k => $value){
            $key++;
            if($key == 1){
                $data[$masterKey]['date'] = $value;
            }

            if($key == 2){
                $data[$masterKey]['resi'] = $value;
            }

            if($key == 3){
                $data[$masterKey]['fee'] = $value;
                $masterKey++;
                $key    = 0;
            }
        }

        $resiAll    = [];
        foreach ($data as $key => $value){
            $resiAll[]  = $value['resi'];
        }

        return $resiAll;
    }


    public function extractBulkCsv($inputs){
        $explodes   = explode(PHP_EOL,  $inputs['csv']);
        $data       = [];
        foreach ($explodes as $k => $value){
            $data[]   = str_replace("\r", '', $value);
        }

        $logisticOrders     = LogisticOrder::with(['logistic_batch'])->whereIn('receipt_number', $data)
            ->orderBy('logistic_batch_id','desc')->get();

        return $logisticOrders;
    }

    public function updateCompleteByReconciliation($resiAll){
        $orders     = LogisticOrder::with([])->whereIn('receipt_number', $resiAll)->get();
        foreach ($orders as $order){
            if($order->logistic_status != 'Completed'){
                $order->logistic_status = 'Completed';
                $order->save();
            }
        }

        return $orders;
    }


    // here we go
    public function updateReceiptLogisticOrder($id, $receipt = ''){

        $order  = $this->findLogisticOrder($id);
        if(!$order){
            return false;
        }

        $order->receipt_number  = $receipt;
        $order->save();

        return true;
    }
    public function saveLogisticOrderForm($batchId = null, $inputs = [], $id = null){
        $inputs     = (array)$inputs;

        if(is_null($batchId)){
            $batchId    = $inputs['logistic_batch_id'];
        }

        /*$batch  = $this->findLogisticBatch($batchId);
        if(!$batch){
            return false;
        }*/

        $tokenGenerate  = date("Y_m_d_H_i_s");
        $order          = $this->findLogisticOrder($id);
        if(!$order){
            $order          = new LogisticOrder();
        }

        $order->batch_token         = $order->batch_token ? $order->batch_token : $tokenGenerate;
        $order->logistic_batch_id   = $batchId;
        $order->order_id            = $inputs['order_id'];
        $order->product_name        = !empty($inputs['product']) ? $inputs['product'] : $inputs['product_name'];
        $order->notes               = !empty($inputs['notes']) ? $inputs['notes'] : '';
        $order->quantity            = (empty($inputs['quantity']) OR $inputs['quantity'] == 0) ? 1 : $inputs['quantity'];
        $order->name                = $inputs['name'];
        $order->email               = !is_null($inputs['email']) ? $inputs['email'] : '';
        $order->phone               = $inputs['phone'];
        $order->full_address        = !empty($inputs['address']) ? $inputs['address'] : $inputs['full_address'];
        $order->province            = $inputs['province'];
        $order->city                = $inputs['city'];
        $order->subdistrict         = $inputs['subdistrict'];
        $order->zip                 = $inputs['zip'];

        $order->payment_status      = $inputs['payment_status'];
        $order->payment_method      = $inputs['payment_method'];
        $order->bump                = $inputs['bump'];
        $order->bump_price          = $inputs['bump_price'];
        $order->discount            = $inputs['discount'];
        $order->product_price       = $inputs['product_price'];
        $order->cogs                = $inputs['cogs'];

        $order->courier             = $inputs['courier'];
        $order->shipping_cost       = $inputs['shipping_cost'];
        $order->cod_cost            = $inputs['cod_cost'];
        $order->gross_revenue       = $inputs['gross_revenue'];
        $order->net_revenue         = $inputs['net_revenue'];
        $order->logistic_status     = !empty($inputs['logistic_status']) ? $inputs['logistic_status'] : '';

        $order->order_created_at    = !empty($inputs['created_at']) ? $inputs['created_at'] : '';
        $order->order_processed_at  = (!empty($inputs['processing_at']) AND !is_null($inputs['processing_at'])) ? $inputs['processing_at'] : '';
        $order->handled_by          = !is_null($inputs['handled_by']) ? $inputs['handled_by'] : '';

        $order->coupon              = '';
        $order->utm_campaign        = !is_null($inputs['utm_campaign']) ? $inputs['utm_campaign'] : '';
        $order->utm_medium          = !is_null($inputs['utm_medium']) ? $inputs['utm_medium'] : '';
        $order->utm_source          = !is_null($inputs['utm_source']) ? $inputs['utm_source'] : '';
        $order->utm_content         = !is_null($inputs['utm_content']) ? $inputs['utm_content'] : '';
        $order->utm_term            = !empty($inputs['utm_term']) ? $inputs['utm_term'] : '';
        $order->tags                = !is_null($inputs['tags']) ? $inputs['tags'] : '';

        $order->comments            = !empty($inputs['comments']) ? $inputs['comments'] : '';
        $order->variation           = !is_null($inputs['variation']) ? $inputs['variation'] : '';

        $qty                        = $order->quantity;
        if($order->bump_price > 0){
            $qty                = $order->quantity + 1;
        }

        // IMPORTANT
        $order->comments            = $order->product_name . ' ' . $order->variation . ' x ' . $qty . ' | ' . $order->notes;

        $order->receipt_number      = !empty($inputs['receipt_number']) ? $inputs['receipt_number'] : '';
        $order->pickup_address      = !empty($inputs['pickup_address']) ? $inputs['pickup_address'] : '';
        //dd($order);
        $order->save();

        return $order;
    }

    public function saveLogisticOrder($batchId = null, $inputsData = []){
        $batch  = $this->findLogisticBatch($batchId);
        if(!$batch){
            return false;
        }

        DB::beginTransaction();
        $orders         = json_decode($inputsData['orders']);
        foreach ($orders as $inputs){
            $this->saveLogisticOrderForm($batchId, $inputs);
        }
        DB::commit();
        return true;
    }
    
    public function updateBulkOrderWithNinja($ninjaOrders = []){
        $ninjaOrders    = json_decode($ninjaOrders['orders']);
        $orderNotFound  = [];
        $phoneService   = new PhoneNumberService();

        DB::beginTransaction();
        $logisticID = null;
        foreach ($ninjaOrders as $order){
            $orderId    = str_replace(env('LOGISTIC_NINJA_PREFIX'),'', $order->id_pelacakan);
            $orderId    = substr($orderId, 0, -1);

            $zip        = $order->kode_pos;
            $name       = $order->nama;
            $phone      = $phoneService->standardPhone($order->kontak);

            $orderResult    = $this->findLogisticOrderByPhoneZip($phone, $zip, $name);
            if(!$orderResult){
                $orderNotFound[]    = [
                    'tracking_no'   => $order->id_pelacakan,
                    'phone'         => $phone,
                    'zip'           => $zip
                ];

                continue;
            }

            $orderResult->receipt_number    = $order->id_pelacakan;
            $orderResult->pickup_address    = $order->alamat_pengirim;
            $orderResult->cod_cost          = $order->cod;
            $orderResult->save();
            if($logisticID == null){
                $logisticID = $orderResult->logistic_batch_id;
            }
        }

        DB::commit();

        return [
            'status'    => true,
            'not_found' => $orderNotFound
        ];
    }

    public function updateOrderByWebHookNinja($shipper_ref_no, $tracking_id, $status, $comments, $ninjaId, $timestamp){
        $order  = LogisticOrder::with([])
            ->where('order_id', $shipper_ref_no)
            ->orWhere('receipt_number', $tracking_id)
            ->first();

        if(!$order){
            Log::error("Ninja Webhook Not Found: " . $shipper_ref_no . ' ' . $tracking_id);
        }

        if(!$order){
            return false;
        }
        $orderStatus                        = new LogisticOrderStatus();
        $orderStatus->logistic_order_id     = $order ? $order->order_id : null;
        $orderStatus->tracking_id           = $tracking_id;
        $orderStatus->ninja_id              = $ninjaId;
        $orderStatus->status                = $status;
        $orderStatus->comments              = !is_null($comments) ? $comments : '';
        $orderStatus->previous_status       = '';
        $orderStatus->save();

        // update incorrect receipt
        $order->receipt_number              = $tracking_id;

        // success message
        $success    = [
            'Completed',
            'Successful',
            'Successful Delivery'
        ];


        $order->logistic_status             = $status;

        if(in_array($orderStatus->status, $success)){
            $order->payment_status          = 'paid';
        }

        $order->save();

        if($orderStatus->status == 'Completed'){
            $changeStatus   =   $this->updateJurnalSalesStatus($order);
            // $jurnal_value   =   $this->updateJurnalPaid($order->id, $order->logistic_batch_id, $order->payment_method, $changeStatus);
            $jurnal_value   =   $this->updateJurnalPaid($order, $changeStatus);
        }

        return $orderStatus;
    }

    public function extractCode($code = ''){
        preg_match_all('!\d+!', $code, $number);
        $code       = preg_replace('/[0-9]+/', '', $code);
        $strLength  = strlen($code);

        if(!$code){
            return false;
        }

        if(!empty($number[0][0]) AND $number[0][0] != $strLength){
            return false;
        }
        $csName     = $code;

        $order      = $this->findHandledBy($csName);

        if(!$order){
            return false;
        }

        \Session::put('handled_by', $order->handled_by);

        return true;
    }

    public function findHandledBy($csName = ''){

        $order      = LogisticOrder::with([])
            ->where('handled_by', $csName)
            ->orderBy('id','desc')
            ->first();

        return $order;
    }

    public function makeOrderLogistic($order, $batch){
        $order = Order::with(['detail.product', 'detail.variations', 'costumer', 'costumer.district', 
        'followup'])->find($order);
        $totalQuantity = 0;
        $variation = '';
        $product = '';
        $model = '';
        foreach($order->detail as $value){
            $totalQuantity = $totalQuantity + $value->quantity;
            if($value->variations){
                $model = $value->variations->value;
            }
            if($product != $value->product->name){
                $product = $value->product->name;
                $variation .= $value->product->name.' '.$model.' x '.$value->quantity.' | ';
            }else{
                $variation .= $model.' x '.$value->quantity.' | ';
            }
        }
        $phoneService   = new PhoneNumberService();
        $logistic = new LogisticOrder();
        $logistic->batch_token = date("Y_m_d_H_i_s");
        $logistic->logistic_batch_id = $batch;
        $logistic->order_id = $order->invoice_number;
        $logistic->product_name = $order->detail[0]->product->name;
        $logistic->notes = $order->note ? $order->note : '';
        $logistic->quantity = $totalQuantity;
        $logistic->name = $order->costumer->name;
        $logistic->email = $order->costumer->email ? $order->costumer->email  : '';
        $logistic->phone = $phoneService->standardPhone($order->costumer->phone);
        $logistic->full_address = $order->costumer->address;
        $logistic->province = $order->costumer->province;
        $logistic->city = $order->costumer->city;
        $logistic->subdistrict = $order->costumer->province;
        $logistic->zip = '';
        $logistic->payment_status = $order->paid_at ? 'Paid' : 'Unpaid';
        $logistic->payment_method = $order->paid_with;
        $logistic->bump = 0;
        $logistic->bump_price = 0;
        $logistic->discount = 0;
        $logistic->product_price = $order->product_price;
        $logistic->cogs = $order->detail[0]->product->price;
        $logistic->courier = 'NINJA - STANDARD';
        $logistic->logistic_status = '';
        $logistic->shipping_cost = $order->shipping_fee;
        $logistic->cod_cost = $order->cod_fee;
        $logistic->gross_revenue = $order->total_price;
        $logistic->net_revenue = 0;
        $logistic->handled_by = 'Amalia';
        $logistic->variation = $variation;
        $logistic->pickup_address = 'Pergudangan 3 Multi Gudang Blok B no 1 Jl. Manis Raya Bitung, Tangerang';
        $logistic->receipt_number = $order->tracking_number ? $order->tracking_number : '';
        $logistic->comments = $variation;
        $logistic->tags = 'AKAN KIRIM';
        $logistic->save();
        return $logistic;
    }

    public function getListJurnalProducts($orders){
        $jurnal         = new JurnalService();
        $nameProducts   = [];
        foreach($orders as $order){
            if(!in_array($order->product_name, $nameProducts)){
                $nameProducts[] = $order->product_name;
            }
        }
        $listProduct    = $jurnal->checkProductByName($nameProducts);
        if($listProduct['status']){
            $listProduct            = $listProduct['data'];
            $listProduct            = $this->generateSku($listProduct);
        }
        return $listProduct;
    }

    public function generateSku($raw){
        $data   = [];
        foreach($raw as $product){
            $sku_arr        = explode(' ',$product);
            $sku_str        = '';
            foreach($sku_arr as $char){
                $sku_str    = $sku_str.''.substr($char, 0, 1);
            }
            $sku_str        = $sku_str.'001';
            if(array_key_exists($sku_str, $data)){
                $sku_str    = $sku_str.''.substr(md5(microtime()),rand(0,26),1);
            }
            $data[$sku_str] = $product;
        }
        return $data;
    }

    public function createJurnalProducts($request){
        $jurnal = new JurnalService();
        $status = [];
        for($i = 0; $i < 3; $i++){
            $accounts   =   $jurnal->getAllAccounts();
            if($accounts['status']){
                break;
            }
        }
        if($accounts['status']){
            $accounts       = $accounts['data']->accounts;
            foreach($accounts as $account){
                if(in_array($account->category_id, ['1','3','4'])){
                   if($account->category_id == 4 And ($account->category == 'Inventory' or $account->category == 'Persediaan')){
                       $getLastNumbers  =  $account->number;
                   }
                } else {
                    break;
                }
            }
        } else {
            return $accounts;
        }
        foreach($request as $productInput){
            // Check Account Exist or not
            if(!in_array($productInput['name'], $accounts)){
                $getLastNumbers++;
                $statusAccount  = $jurnal->createAccountInventory($productInput['name'], $getLastNumbers);
            }
            $status[] = $jurnal->createProduct($productInput);
        }
        return $status;
    }

    public function createJurnalSalesInvoice($id){
        $result     =   [
            'status'    =>  true,
            'message'   =>  ''
        ];
        $jurnal     =   new JurnalService();
        $cod        =   $this->getLogisticOrderByBatchId($id, 'cod');
        $transfer   =   $this->getLogisticOrderByBatchId($id, 'bank_transfer');
        $ship_trf   =   0;
        $ship_cod   =   0;
        $cod_process=   $result;
        $trf_process=   $result;

        if(count($transfer) > 0){
            foreach($transfer as $trf){
                $ship_trf   +=  $trf['shipping_cost'];
            }
            $data_transfer  =   [
                'id_batch'  =>  $id,
                'type'      =>  'transfer',
                'orders'    =>  $transfer,
                'ship_cost' =>  $ship_trf,
            ];
            $custom_id  =   $data_transfer['id_batch'].'_'.$data_transfer['type'];
            $checking   =   $jurnal->getSalesInvoice($custom_id);
            if(!$checking['status'] && (strpos($checking['data'], 'Data not found') !== false or strpos($checking['data'], 'Data tidak ditemukan') !== false)){
                $trf_process    = $jurnal->addSalesInvoice($data_transfer);
            } else if ($checking['status']) {
                $deleting       = $jurnal->deleteSalesInvoice($custom_id);
                if($deleting['status']){
                    $trf_process    = $jurnal->addSalesInvoice($data_transfer);
                }
            }
        }
        if(count($cod) > 0 ){
            foreach($cod as $c){
                $ship_cod   +=  $c['gross_revenue'] - $c['net_revenue'];
            }
            $data_cod       =   [
                'id_batch'  =>  $id,
                'type'      =>  'cod',
                'orders'    =>  $cod,
                'ship_cost' =>  $ship_cod,
            ];
            $custom_id  =   $data_cod['id_batch'].'_'.$data_cod['type'];
            $checking   =   $jurnal->getSalesInvoice($custom_id);
            if(!$checking['status'] && (strpos($checking['data'], 'Data not found') !== false or strpos($checking['data'], 'Data tidak ditemukan') !== false)){
                $cod_process = $jurnal->addSalesInvoice($data_cod);
            } else if ($checking['status']) {
                $deleting       = $jurnal->deleteSalesInvoice($custom_id);
                if($deleting['status']){
                    $cod_process    = $jurnal->addSalesInvoice($data_cod);
                }
            }
        }
        if($cod_process['status'] == false or $trf_process['status'] == false){
            $result['status']   =   false;
            if($trf_process['status'] == false and $cod_process['status'] == false){
                $result['message']    =   'Transfer Error : '.$trf_process['data'].' Cod Error '.$cod_process;
            } else if($trf_process['status'] == false){
                $result['message']    =   'Transfer Error : '.$trf_process['data'];
            } else if($cod_process['status'] == false){
                $result['message']    =   'Cod Error : '.$cod_process['data'];
            }
            return  $result;
        }
        return $result;
    }

    public function updateJurnalPaid($order, $changeStatus = false){
        $result     = [
            'status'    => false,
            'data'      => ''
        ];
        $order_id       = $order->id;
        $payment_method = $order->payment_method;
        $batch_id       = $order->logistic_batch_id;
        $receive    = null;
        $jurnal     = new JurnalService();
        if($payment_method == 'bank_transfer'){
            $custom_id  = $batch_id.'_transfer';
        } else if($payment_method == 'cod'){
            $custom_id  = $batch_id.'_'.$payment_method;
        }
        $data       =   $jurnal->getSalesInvoice($custom_id);
        if($data['status'] and !is_null($order_id)){
            if($changeStatus){
                $receive    =   $jurnal->createSalesInvoicePayment($data);
                if(!$receive){
                    $result['data'] = $receive['data'];
                    return $receive;
                }
            }
            $update = $jurnal->updateSalesInvoiceDesc($order_id, $data, $custom_id, $receive);
            if($update['status']){
                $order->jurnal_updated_at   =   Carbon::now()->toDateTimeString();
                $order->save();
                return [
                    'status'    => true,
                    'data'      => 'Data order '.$order_id.' berhasil diupdate'
                ];
            } else {
                $result['data'] =   $update['data'];
                return $result;
            }
        } else {
            return [
                'status'    => false,
                'data'      => $data['data']
            ];
        }

        return $result;
    }

    public function updateJurnalSalesStatus($order = []){
        $jurnal     = new JurnalService();
        $paidOrder  = null;
        if(!empty($order)){
            $paidOrder  =   LogisticOrder::with([])
            ->where('logistic_batch_id', $order->logistic_batch_id)
            ->where('payment_method', $order->payment_method)
            ->where('payment_status', 'unpaid')
            ->get();
            if(count($paidOrder) == 0){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function getLogisticOrderNotPushJurnal(){
        $orders = LogisticOrder::with([])
        ->whereNotNull('logistic_batch_id')
        ->where('payment_status', 'paid')
        ->whereNull('jurnal_updated_at')->limit(5)->get();

        return $orders;
    }
}
