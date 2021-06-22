<?php
namespace App\Payment;
use App\Order\Myshortcart;
use App\Order\Order;
use App\Order\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PaymentRepository extends MidtransService{


    
    public function midtransSnapToken($invoice, $type)
    {
        $order = Order::where('invoice_number', $invoice)->first();
        if($order){
            $shortcart = new Myshortcart();
            $shortcart->order_id = $order->id;
            $shortcart->transidmerchant = 'DROPY-'.date('YmdHis');
            $shortcart->status = 'requested';
            $shortcart->starttime = date("Y-m-d H:i:s");
            $shortcart->totalamount = $order->total_price;
            $shortcart->trxtype = 'midtrans';
            $shortcart->save();

            $totalPrice = $order->total_price;
            $token = $this->getSnapToken($shortcart->transidmerchant, $totalPrice, $type);

            return [
                'status' => true,
                'data' => $token
            ];
        }

        return[
            'status' => false,
            'data' => 'Invalid order'
        ];
    }

    public function saveInfoMidtrans($invoice, $params)
    {
        $order = Order::where('invoice_number', $invoice)->first();
        if($order){
            $order->logPayment()->create(['dump' => json_encode($params)]);
            $order->save();
            return [
                'status' => true,
                'data' => $order
            ];
        }

        return [
            'status' => false,
            'data' => 'Invalid Invoice'
        ];
    }

    public function midtransNotification()
    {
        $repo = new MidtransService();
        $notif = $repo->notification();
        if($notif['status']){

            if($notif['data']['transaction'] == 'settlement' || $notif['data']['transaction'] == 'capture'){
                // exe make paid
                $paid =  $this->makePaid($notif['data']['order_id'], $notif['data']['type']);
                return $paid;
            }

        }

        return [
            'status' => false,
            'data' => 'Invalid notif'
        ];
    }

    public function makePaid($invoice, $type)
    {
        $shortcart = \App\Order\Myshortcart::where('transidmerchant', $invoice)->first();
        if($shortcart){

            $order = \App\Order\Order::with('costumer')->find($shortcart->order_id);
            if($order){
                $paid = date('Y-m-d H:i:s');
                $order->paid_at = $paid;
                $order->paid_by = $type;
                $order->save();
                $crypt = Crypt::encrypt($order->invoice_number);
                if($order->costumer && $order->costumer->email){
                    $arg = [
                        'to' =>$order->costumer->email, 
                        'customer' => $order->costumer ? $order->costumer->name : '',
                        'invoice' => $order->invoice_number,
                        'link' => 'https://dropy.id/thanks?order='.$order->invoice_number,
                        'link_invoice' => url('/api/order/generate-pdf/'.$crypt)
                    ];
                    \App\EmailService\EmailService::sendNotifHasPaidToCustormer($arg);
                }
                // update order detail
                OrderDetail::where('order_id', $order->id)->update(['paid_at' => $paid]);
                return [
                    'status' => true,
                    'data' => $order
                ];
            }
            return [
                'status' => true,
                'data' => 'Invalid Order'
            ];

        }
        return [
            'status' => true,
            'data' => 'Invalid Shortcart'
        ];
    }

}