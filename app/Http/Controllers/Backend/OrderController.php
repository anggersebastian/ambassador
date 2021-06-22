<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderRepository;

class OrderController extends Controller
{
    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        return view('backend.order.index');
    }

    public function indexJson(Request $request)
    {
        $order = $this->order->indexJsonAdmin($request);
        if($request->get('export')) return $this->exportExcel($order);

        $paid = $this->order->generateOrderPaid(true, $request->get('start'), $request->get('end'));
        $unpaid = $this->order->generateOrderPaid(false, $request->get('start'), $request->get('end'));
        $totalOrder = $this->order->generateTotalOrder($request->get('start'), $request->get('end'));
        return response()->json([
            'status' => true,
            'data' =>[
                'order' => $order,
                'paid' => $paid,
                'unpaid' => $unpaid,
                'paid_ratio' => $totalOrder > 0 ? ($paid * 100)/ $totalOrder : 0,
                'total_order' => $totalOrder
            ]
        ]);
    }

    public function setStatus(Request $request, $id)
    {
        $order = $this->order->changeStatus($request, $id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $update = $this->order->updateOrder($request, $id);
        return response()->json([
            'status' => true,
            'data' => $update
        ]);
    }

    public function bulkSetStatus(Request $request)
    {
        $order = $this->order->bulkChangeStatus($request);
        return response()->json([
            'status' => true,
            'data' => $order
        ]);
    }

    public function setFollowUp(Request $request, $order)
    {
        $name = $request->get('name');
        $followUp = $this->order->setFollowUp($name, $order);
        return response()->json([
            'status' => true,
            'data' => $followUp
        ]);
    }

    public function destroy($id)
    {
        $order = $this->order->deleted($id);
        return response()->json($order);
    }

    private function exportExcel($order)
    {
        $result = $order->map(function($q, $index){
            return [

                'no' => $index + 1,
                'invoice' => $q->invoice_number,
                'name' => $q->costumer->name,
                'phone' => $q->costumer->phone,
                'email' => $q->costumer->email,
                'address' => $q->costumer->address.' '.$q->costumer->district_name.' '.$q->costumer->province,
                'Product Name' => $q->detail[0]->product->name,
                'Quantity' => $q->detail[0]->quantity,
                'Handle By' => $q->handle ? $q->handle->first_name : '',
                'Status' => $q->current_status,
                'Payment' => $q->paid_at ? "PAID" : "UNPAID",
                'Method' => $q->paid_with,
                'Weight' => $q->total_weight,
                'Product Price' => number_format($q->product_price),
                'Shipping Fee' => number_format($q->shipping_fee),
                'COD Fee/Transfer Fee' => $q->paid_with == 'cod' ? number_format($q->cod_fee) : number_format(4400),
                'Uik Code' => $q->unique_fee,
                'Total Price' => number_format($q->total_price),
                'Tracking Number' => $q->tracking_number,
                'Date' => $q->created_at,
            ];
        });
        // return response()->json($result);
        $filename = 'Order-'.date('Y-m-d');
        return \Maatwebsite\Excel\Facades\Excel::create($filename, function($excel)use($result) {
            $excel->sheet('Sheetname', function($sheet)use($result) {
                $sheet->fromArray($result);
            });
        
        })->export('xls');
    }
}
