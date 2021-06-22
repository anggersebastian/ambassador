<?php
namespace App\TaskSchedule;

use Illuminate\Support\Facades\Log;
use App\Logistic\LogisticRepository;

class TaskSchedule {
    public function taskJurnalSalesInvoice(){
        $logistic       = new LogisticRepository();
        $orders         = $logistic->getLogisticOrderNotPushJurnal();
        $changeStatus   = true;
        $result         = [];
        foreach($orders as $order){
            $result[]   = $logistic->updateJurnalPaid($order, $changeStatus);
        }
        return response()->json([true]);
    }
}