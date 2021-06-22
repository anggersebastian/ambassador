<?php

namespace App\BCA;

use DB;

class BCALogService extends BcaLogRepository{
    protected $parser, $user, $pass, $org, $order, $price_minimum_membership;
    public function __construct() {
        $this->user   = env('BCA_USER');
        $this->pass   = env('BCA_KEY');

        $this->parser = new IbParser();
    }

    public function checkTransaction($getBy = "cron"){
        $trans = $this->parser->getTransactions($this->user, $this->pass);

        if(!$trans){
            return false;
        }

        $results = [];
        foreach($trans as $tran){
            $var    = $tran[0] . "/" . date("Y");
            $date   = str_replace('/', '-', $var);

            $isValidDate    = (strtotime($date)) ? true : false;
            $date           = ($isValidDate) ? date("Y-m-d", strtotime($date)) : date("Y-m-d");
            $results[]   = [
                "date"          => $date,
                "description"   => $tran[1],
                "in_out"        => ($tran[2] == "DB") ? "out" : "in",
                "amount"        => (float)$tran[3],
                "get_by"        => $getBy
            ];
        }

        if(!empty($results)){
            $this->createNew($results);
        }

        return $results;
    }

    public function createNew(array $results = []){
        DB::beginTransaction();

        foreach ($results as $result){
            $hasLog = $this->findByDescValue($result['description'], $result['amount']);
            if(!$hasLog){
                $this->insert($result);

                $text   = 'Transaksi ' . strtoupper($result['in_out']) . ', ' . $result['description'] . ', Total: Rp' . number_format($result['amount'], 0);
                $this->callSlack($text);
            }
        }

        DB::commit();
        return true;
    }

    public function callSlack($text = ''){
        $curl = curl_init();

        $textParam  = [
            'text'  => $text
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://hooks.slack.com/services/T4F86MT5Y/BDA04A5U6/" . env('SLACK_KEY_SALES'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($textParam),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}
