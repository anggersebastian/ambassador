<?php
namespace App\Payment;

class MidtransService{

    protected $midtransProd, $serverKey, $segment;
    
    public function __construct() {
        $this->midtransProd     = env('MIDTRANS_PROD', false);
        $this->serverKey        = env('MIDTRANS_SERVER_KEY', 'VT-server-GKFsWJnLE6kdJ93cDsyxjoaz');
        // $this->segment          = new AnalyticService();
    }

    public function getSnapToken($invoiceNo = '', $amount = 0, $type){
        \Midtrans\Config::$isProduction    = $this->midtransProd;
        \Midtrans\Config::$serverKey       = $this->serverKey;

        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $transferFee = 4400;
        if($type == 'gopay'){
            $transferFee = ((int)$amount * 3) / 100;
        }
        $grossAmount = $amount + $transferFee; // Convenience fee (Biaya transaksi)
        $complete_request = [
            "transaction_details" => [
                "order_id"      => $invoiceNo,
                "gross_amount"  => (int)$grossAmount
            ],
            "item_details"  => [
                [
                    "id"    => "Bill-" . $invoiceNo,
                    "price" => (int)$amount,
                    "quantity"  => 1,
                    "name"      => "Bill Invoice Pembayaran " . $invoiceNo,
                    "category"  => "Invoice",
                    "merchant_name" => "Dropy.id"
                ],
                [
                    "id"    => "TRX-" . $invoiceNo,
                    "price" => (int)$transferFee,
                    "quantity"  => 1,
                    "name"      => "Biaya per Transaksi Pembayaran",
                    "category"  => "Invoice",
                    "merchant_name" => "Midtrans.com"
                ]
            ]
        ];
        $snap_token = \Midtrans\Snap::getSnapToken($complete_request);
        // $this->segment->track(\Auth::user(), 'Initial Purchase', [
        //     "invoice"   => "Bill-" . $invoiceNo,
        //     "price"     => ($amount + 4400)
        // ]);
        return $snap_token;
    }

    public function notification()
    {
        try {
            \Midtrans\Config::$isProduction    = $this->midtransProd;
            \Midtrans\Config::$serverKey       = $this->serverKey;
            $notif = new \Midtrans\Notification();
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            return [
                'status' => true,
                'data' => [
                    'transaction' => $transaction,
                    'order_id' => $order_id,
                    'type' => $type
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage
            ];
        }
    }

}