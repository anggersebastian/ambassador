<?php

namespace App\Http\Controllers;

use App\Logistic\LogisticRepository;
use Illuminate\Http\Request;

class CsController extends Controller
{
    private $logistic;

    public function __construct(LogisticRepository $logistic)
    {
        $this->logistic = $logistic;
    }

    public function cs(Request $request){

        $handledBy  = \Session::get('handled_by');
        $verify     = $this->logistic->findHandledBy($handledBy);
        if(!$verify){
            alertNotify(false, "You need to login using code", $request);
            return redirect(url('cs-login'));
        }

        $filters            = $request->only(['name','date_start','date_end']);
        $filters['name']    = $handledBy;

        $cs         = $this->logistic->getLogisticOrderGroupByCS($filters);
        $countCs    = $this->logistic->countLogisticOrders($filters);

        return view('cs.report', compact('filters', 'cs','countCs'));
    }

    public function orders(Request $request)
    {
        $handledBy  = \Session::get('handled_by');
        $verify     = $this->logistic->findHandledBy($handledBy);
        if(!$verify){
            alertNotify(false, "You need to login using code", $request);
            return redirect(url('cs-login'));
        }


        $filters    = $request->all();
        $filters['handled_by']  = $verify->handled_by;
        $orders     = $this->logistic->getLogisticOrders($filters);

        return view('cs.orders', compact('orders', 'filters'));
    }

    public function detail($id = null, Request $request)
    {
        $handledBy  = \Session::get('handled_by');
        $verify     = $this->logistic->findHandledBy($handledBy);
        if(!$verify){
            alertNotify(false, "You need to login using code", $request);
            return redirect(url('cs-login'));
        }

        $order      = $this->logistic->findLogisticOrder($id);

        return view('cs.detail', compact('order'));
    }

    public function login(Request $request)
    {
        $key = $request->get('key');

        return view('cs.login');
    }

    public function auth(Request $request){
        $code   = $request->get('code');

        $result     = $this->logistic->extractCode($code);

        if(!$result){
            alertNotify(false, "Error code", $request);
            return redirect()->back();
        }else{
            return redirect(url('cs'));
        }
    }

    public function logout(Request $request){
        \Session::put('handled_by', null);

        return redirect()->back();
    }
}
