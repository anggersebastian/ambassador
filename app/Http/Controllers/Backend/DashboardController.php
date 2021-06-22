<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    protected $dashboard;

    public function __construct(){
    }

    public function index(){
        return view('backend.dashboard');
    }

    public function indexJson(Request $request)
    {
        $repo = new \App\Order\OrderRepository();
        $totalUnpaidRevenue = $repo->generateUnpaidRevenue($request->get('start'), $request->get('end'));
        $totalGrossRevenue = $repo->generateGrossRevenue($request->get('start'), $request->get('end'));
        $totalGrossProfit = $repo->generateGrossProfit($request->get('start'), $request->get('end'));
        $totalNetProfit = $repo->generateNetProfit($request->get('start'), $request->get('end'));
        $totalNetRevenue = $repo->generateNetRevenue($request->get('start'), $request->get('end'));
       
        $totalCogs = $repo->generateCogs($request->get('start'), $request->get('end'));
        $totalSold = $repo->generateQuantitySold($request->get('start'), $request->get('end'));
        $paid = $repo->generateOrderPaid(true, $request->get('start'), $request->get('end'));
        $unpaid = $repo->generateOrderPaid(false, $request->get('start'), $request->get('end'));
        $totalOrder = $repo->generateTotalOrder($request->get('start'), $request->get('end'));

        return response()->json([
            'status' => true,
            'data' =>[
                'paid' => $paid,
                'unpaid'=> $unpaid,
                'total_order' => $totalOrder,
                'paid_ratio' => $totalOrder > 0 ? ($paid * 100)/ $totalOrder : 0,
                'total_sold' => (int) $totalSold,
                'total_cogs' => (float) $totalCogs,
                'unpaid_revenue' => (float) $totalUnpaidRevenue,
                'gross_revenue' => (float) $totalGrossRevenue,
                'gross_profit' => (float) $totalGrossProfit,
                'net_revenue' => (float) $totalNetRevenue,
                'net_profit' => (float) $totalNetProfit
            ]
        ]);
    }

    public function totalSeminar(){
    	//return $this->dashboard->countTotalSeminar();
    }

    public function participant(){
    	//return $this->dashboard->countParticipant();
    }

    public function totalShipping(){
    	//return $this->dashboard->countTotalShipping();
    }

    public function totalPageFinance(){
    	//return $this->dashboard->countTotalPageFinance();
    }

    public function unprocessedSupplier(){
        //return $this->dashboard->countUnprocessedSupplierShipping();
    }

    public function chat(){
    	//return $this->dashboard->getChat();
    }
}