<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderRepository;
use Illuminate\Support\Facades\Crypt;
use PDF;
class OrderController extends Controller
{
    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function makeOrder(Request $request)
    {
        $makeOrder = $this->order->insertOrder($request);
        if($request->get('rediret-url')) return redirect($request->get('rediret-url'));
        return response()->json($makeOrder);
    }

    public function view($invoice)
    {
        $order = $this->order->findByInvoice($invoice);
        return response()->json($order);
    }

    public function confirmPayment(Request $request)
    {
        $confirm = $this->order->confirmPayment($request);
        return response()->json($confirm);
    }

    public function generatePdf(Request $request, $invoice)
    {
       try {
            $c = Crypt::decrypt($invoice);
            $order = $this->order->findByInvoice($c);
            if(!$order['status']){
                exit;
            }
            $order = $order['data'];
            $order['total'] = $order['payment_type'] == 'transfer' ? $order['total_price'] + 4400 : $order['total_price'];
            // return response($order);
            $pdf = PDF::loadView('document.invoice-pdf', ['order' => $order]);
            return $pdf->download('dropy-invoice-'.$order['invoice_number'].'.pdf');
       } catch (\Exception $th) {
           throw $th;
       }
    }
}
 