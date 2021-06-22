<?php
namespace App\RajaOngkir;

class RajaOngkir{

    public static function getOngkir($weight, $destination)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=".env("RAJA_ONGKIR_ORIGIN", '')."&originType=city&destination=".$destination."&destinationType=subdistrict&weight=".$weight."&courier=ninja",
            CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key:".env('RAJA_ONGKIR_KEY', '')
                ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'status' => false,
                'data' => $err
            ];
        }

        $data = json_decode($response);
        if($data->rajaongkir->status->code == 200){
            return [
                'status' => true,
                'data' => $data->rajaongkir->results[0]->costs[0]->cost[0]
                // 'data' => $data
            ];
        }else{
            return [
                'status' => false,
                'data' => $data
            ];
        }
    }

}