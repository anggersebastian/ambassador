<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order\OrderRepository;

class PaymentController extends Controller
{
    private $payment;
    public function __construct(OrderRepository $order)
    {
        $this->payment = $order;
    }

    public function index()
    {
        return view('backend.order.index-payment');
    }

    public function indexJson()
    {
        $payment = $this->payment->getAllPayment();

        return response()->json([
            'status' => true,
            'data' => $payment
        ]);
    }
}
