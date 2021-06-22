<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Payment\PaymentRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MidtransController extends Controller{

    private $repo;

    public function __construct(PaymentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function snap(Request $request)
    {
       $payment = $this->repo->midtransSnapToken($request->get('invoice_id'), $request->get('mode'));
       return response()->json($payment);
    }

    public function saveInfo(Request $request)
    {
        $payment = $this->repo->saveInfoMidtrans($request->get('invoice'), $request->get('result'));
        return response()->json([
            'status'=> true,
            'data' => $payment
        ]);
    }

    public function notification()
    {
        $status = $this->repo->midtransNotification();
        return response()->json($status);
    }

    public function importirNotif(Request $request)
    {
        Log::error("DROPY::Midtrans from importir: " . json_encode($request->all()));
        if($request->get('order_id')){
            
            $m = $this->repo->makePaid($request->get('order_id'), $request->get('payment_type'));
            Log::error("DROPY::Update order from importir: " . json_encode($m));
            return response()->json($m);
        }

        return response()->json([
            'status' => false,
            'data' => 'Invalid invoice'
        ]);
    }

}