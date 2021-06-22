<?php

namespace App\Http\Controllers\Backend\Logistic;

use App\Logistic\LogisticRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Jurnal\JurnalService;
use Maatwebsite\Excel\Facades\Excel;
use App\TaskSchedule\TaskSchedule;

class LogisticController extends Controller
{
    protected $logistic;

    public function __construct(LogisticRepository $logistic)
    {
        $this->logistic  = $logistic;
    }

    public function indexBatch(Request $request)
    {
        $filters    = $request->all();
        $batches    = $this->logistic->getLogisticBatches($filters);

        return view('backend.logistic.index-batch', compact('batches'));
    }

    public function detailBatch($id = null, Request $request){
        $filters    = $request->all();
        $batch      = $this->logistic->findLogisticBatch($id, $filters);
        $filters['logistic_batch_id'] = $id;
        // test-debug (harusnya pas upload CSV)
        $orders     = $this->logistic->getLogisticOrders($filters, false);
        
        // CHECKED
        return view('backend.logistic.detail-batch', compact('batch','filters','orders','id'));
    }


    public function deleteBatch($id = null, Request $request){
        $filters    = $request->all();
        $batch      = $this->logistic->deleteLogisticBatchAndOrders($id, $filters);

        alertNotify(true, "Success deleted", $request);

        return redirect(url('backend/logistic'));
    }

    public function formBatch($id = null, Request $request){
        $batch      = $this->logistic->findLogisticBatch($id);

        return view('backend.logistic.form-batch', compact('batch'));
    }

    public function saveBatch($id = null, Request $request){
        $inputs     = $request->only([
            'title','request_date','status'
        ]);
        $batch      = $this->logistic->saveBatch($id, $inputs);

        alertNotify(true, "Saved", $request);

        return redirect(url('backend/logistic/detail-batch/' . $batch->id));
    }


    public function indexOrders(Request $request)
    {
        $filters    = $request->all();
        $orders     = $this->logistic->getLogisticOrders($filters);

        return view('backend.logistic.index-orders', compact('orders','filters'));
    }

    public function reconciliationFormNinjaCsv(Request $request){
        return view('backend.logistic.form-reconciliation-ninja-csv');
    }

    public function formBulkByReceipt(Request $request){
        return view('backend.logistic.form-bulk-receipt');
    }

    public function displayBulkReceipt(Request $request){
        $inputs     = $request->only(['csv']);
        $orders     = $this->logistic->extractBulkCsv($inputs);

        return view('backend.logistic.result-bulk-receipt', compact('orders'));
    }

    public function orderForm($id = null, Request $request){
        $order      = $this->logistic->findLogisticOrder($id);

        return view('backend.logistic.form-order', compact('order'));
    }

    public function orderDetail($id = null, Request $request){
        $order      = $this->logistic->findLogisticOrder($id);
        if(!$order){
            alertNotify(false, "Order not found", $request);

            return redirect()->back();
        }

        return view('backend.logistic.detail-order', compact('order'));
    }

    public function orderSave($id = null, Request $request){
        $batchId    = $request->get('logistic_batch_id');
        $save       = $this->logistic->saveLogisticOrderForm($batchId, $request->all(), $id);

        if(!$save){
            alertNotify(false, "Order Error", $request);
        }else{
            alertNotify(true, "Order updated", $request);
        }

        return redirect()->back();
    }

    public function deleteOrder($id = null, Request $request){
        $order  = $this->logistic->deleteOrder($id);

        alertNotify(true, "Order Deleted", $request);

        return redirect()->back();
    }

    public function formOrderCsv(Request $request){
        $batches    = $this->logistic->getLogisticBatches($request->all());

        return view('backend.logistic.form-order-csv', compact('batches'));
    }

    public function displayFormCsv(Request $request){
        $inputs     = $request->only(['csv','logistic_batch_id']);
        $orders     = $this->logistic->extractCsvLogisticOrderOnline($inputs);
        $batch      = $this->logistic->findLogisticBatch($inputs['logistic_batch_id']);
        if(!$batch){
            alertNotify(false,'Batch Not Found', $request);
            return redirect()->back();
        }

        return view('backend.logistic.form-result-order-temp', compact('orders', 'batch'));
    }

    public function formOrder($id = null, Request $request){
        $order      = $this->logistic->findLogisticOrder($id);

        return view('backend.logistic.form-order', compact('order'));
    }

    public function saveOrder($batchId = null, Request $request){
        /*$inputs     = $request->only([
            'logistic_batch_id','order_id','product_name','quantity','name','email','phone','full_address','province','city','subdistrict','zip',
            'payment_status','payment_method','bump','bump_price','discount','product_price','cogs',
            'courier','shipping_cost','cod_cost',
            'order_created_at','order_processed_at',
            'coupon','utm_campaign','utm_medium','utm_source','utm_content','utm_term','tags',
            'comments','variation',
            'receipt_number','pickup_address'
        ]);*/

        $inputs     = $request->only(['orders']);

        $batch      = $this->logistic->findLogisticBatch($batchId);
        if(!$batch){
            alertNotify(false, "Batch not found", $request);
            return redirect()->back();
        }
        $order      = $this->logistic->saveLogisticOrder($batchId, $inputs);

        return redirect(url('backend/logistic/detail-batch/' . $batchId));
    }

    public function updateReceiptOrder(Request $request){
        $id             = $request->get('id');
        $receiptNumber  = $request->get('receipt_number');

        $order          = $this->logistic->updateReceiptLogisticOrder($id, $receiptNumber);
        alertNotify(true, "Update success", $request);

        return redirect()->back();
    }

    public function formNinjaCsv(Request $request){
        return view('backend.logistic.form-ninja-csv');
    }

    public function jurnalListBatch($id){
        return view('backend.logistic.jurnal-list-batch', compact('id'));
    }

    public function displayFormCsvNinja(Request $request){
        $inputs     = $request->only(['csv']);
        if(is_null($inputs['csv'])){
            alertNotify(false, 'Harap isi kolom dengan file .csv' , $request);
            return redirect()->back()->withInput();
        }
        
        $orders     = $this->logistic->extractCsvLogisticNinja($inputs);

        $batch = [];

        return view('backend.logistic.form-result-ninja-temp', compact('orders', 'batch'));
    }

    public function displayReconciliationFormCsvNinja(Request $request){
        $inputs     = $request->only(['csv']);
        $orders     = $this->logistic->extractCsvReconciliationLogisticNinja($inputs);

        return view('backend.logistic.form-reconciliation-result-ninja-temp', compact('orders', 'batch'));
    }

    public function saveReconciliationFormCsvNinja(Request $request){
        $resi       = json_decode($request->get('resi'));
        $orders     = $this->logistic->updateCompleteByReconciliation($resi);
        alertNotify(true, "Order success " . $orders->count(), $request);

        return redirect(url('backend/logistic'));
    }

    public function saveOrderNinja(Request $request){
        $inputs     = $request->only(['orders']);
        $result     = $this->logistic->updateBulkOrderWithNinja($inputs);
        alertNotify(true, "Update success, not found : " . count($result['not_found']) . ' List Not found ' . json_encode($result['not_found']), $request);

        return redirect('backend/logistic/orders');
    }

    public function webhookNinja(Request $request){
        $shipper_ref_no = $request->get('shipper_ref_no');
        $tracking_id    = $request->get('tracking_id');
        $status         = $request->get('status');
        $ninjaId        = $request->get('id');
        $comments       = $request->get('comments');
        $timestamp      = $request->get('timestamp');

        Log::error('Ninja In: ' . json_encode($request->all()));

        $order          = $this->logistic->updateOrderByWebHookNinja($shipper_ref_no, $tracking_id, $status, $comments, $ninjaId, $timestamp);

        return response()->json([
            'status'    => true,
            'order'     => $order
        ]);
    }

    public function orderExportCsv($batchId = null){

        $filters['logistic_batch_id']   = $batchId;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=batch-". $batchId ."_" . date('Y_m_d-H_i') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $orders     = $this->logistic->getLogisticOrders($filters, false);
        $columns    = array('order_id', 'name', 'phone', 'address', 'province', 'city', 'subdistrict', 'zip', 'cod','comments');

        $callback = function() use ($orders, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($orders as $order) {
                $cod        = 0;
                if($order->payment_method == 'cod'){
                    $cod    = $order->gross_revenue;
                }
                fputcsv($file, array($order->order_id, $order->name, $order->phone, $order->full_address,$order->province, $order->city,
                    $order->subdistrict, $order->zip, $cod, $order->comments));
            }
            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }

    public function orderExportCsvOrderOnline($batchId = null, Request $request){

        $filters['logistic_batch_id']   = $batchId;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=batch-". $batchId ."_" . date('Y_m_d-H_i') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $orders     = $this->logistic->getLogisticOrders($filters, false);
        $columns    = array('order_id', 'receipt_number', 'payment_status');

        $callback = function() use ($orders, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($orders as $order) {
                $cod        = 0;
                if($order->payment_method == 'cod'){
                    $cod    = $order->gross_revenue;
                }
                fputcsv($file, array($order->order_id, $order->receipt_number, $order->payment_status));
            }
            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }

    public function indexCs(Request $request){
        $filters    = $request->only(['name','date_start','date_end']);
        $cs         = $this->logistic->getLogisticOrderGroupByCS($filters);
        $countCs    = $this->logistic->countLogisticOrders($filters);

        return view('backend.logistic.index-cs', compact('cs','countCs','filters'));
    }

    public function batchJson()
    {
        $batch = $this->logistic->getBatchLimit();
        return response()->json([
            'status' => true,
            'data' => $batch
        ]);
    }

    public function jurnalCheckProduct($id){
        $orders       = $this->logistic->getLogisticOrderByBatchId($id);
        $products     = $this->logistic->getListJurnalProducts($orders);
        return $products;
    }

    public function jurnalCreateProduct(Request $request){
        $statusProduct = [];
        if(!is_null($request->jurnal)){
            $jurnal = $this->logistic->createJurnalSalesInvoice($request->jurnal);
            if(!$jurnal['status']){
                alertNotify(false, $jurnal['message'], $request);
                return redirect()->back()->withInput();
            } else if($jurnal['status']){
                alertNotify(true, 'Sales Invoice Created Successfully on Jurnal', $request);
                return redirect()->back()->withInput();
            }
        }
        if(!is_null($request->product)){
            $statusProduct = $this->logistic->createJurnalProducts($request->product);
        }
        return view('backend.logistic.part.status-jurnal-create', compact('statusProduct'));
    }
    
    public function exportToExcel(Request $request)
    {
        $id = $request->get('batch-id');
        if(!$id){
            $logistic = \App\Logistic\LogisticOrder::with(['logistic_batch','logistic_statuses'])->orderBy('id', 'desc')->get();
        }else{
            $logistic = \App\Logistic\LogisticOrder::where('logistic_batch_id', $id)->with(['logistic_batch','logistic_statuses'])->orderBy('id', 'desc')->get();
        }
        if(!$logistic) return abort(404);
        $logistic = $logistic->map(function($item){
            return [
                'order_id' => $item->order_id,
                'batch_id' => $item->logistic_batch_id,
                'resi' => $item->receipt_number,
                'product' => $item->product_name,
                'notes' => $item->notes,
                'comments' => $item->comments,
                'gross_revenue' => $item->gross_revenue,
                'name' => $item->name,
                'phone' => $item->phone,
                'address' => $item->full_address,
                'province' => $item->province,
                'city' => $item->city,
                'subdistrict' => $item->subdistrict,
                'zip' => $item->zip,
                'payment_status' => $item->payment_status,
                'quantity' => $item->quantity,
                'bump' => $item->bump,
                'bump_price' => $item->bump_price,
                'created_at' => $item->created_at,
                'handled_by' => $item->handled_by,
                'variation' => $item->variation,
            ];
        });
        $filename = 'Batch-'.$id.'-order';
        return Excel::create($filename, function($excel)use($logistic) {
            $excel->sheet('Sheetname', function($sheet)use($logistic) {
                $sheet->fromArray($logistic);
            });
        
        })->export('xls');
    }
    // public function jurnalCustomId(){
    //     $jurnal     = new JurnalService();
    //     $task       = new TaskSchedule();

    //     dd($task->taskJurnalSalesInvoice());
    // }
}
