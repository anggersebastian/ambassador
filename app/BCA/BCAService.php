<?php

namespace App\BCA;

use GPBMetadata\Google\Protobuf\Timestamp;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Namshi\JOSE\Signer\OpenSSL\HMAC;
use Seld\PharUtils\Timestamps;
use Carbon\Carbon;

use function GuzzleHttp\json_decode;

class BCAService
{
    protected $bca_url, $corp_id, $api_key, $api_secret, $client_id, $client_secret, $account_number;

    public function __construct($flag = ''){
        // Sandbox
        if(!empty($flag)){
            $this->bca_url          = env('BCA_ENDPOINT_'.$flag);
            $this->corp_id          = env('BCA_CORP_ID_'.$flag);
            $this->api_key          = env('BCA_API_KEY_'.$flag);
            $this->api_secret       = env('BCA_API_SECRET_'.$flag);
            $this->client_id        = env('BCA_CLIENT_ID_'.$flag);
            $this->client_secret    = env('BCA_CLIENT_SECRET_'.$flag);
            $this->account_number   = env('BCA_ACCOUNT_NUMBER_'.$flag);
        }
    }

    public function requestToken(){
        $result = [
            'status'    => false,
            'data'      => ''
        ];
        $basicAuth  = base64_encode($this->client_id.':'.$this->client_secret);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->bca_url."api/oauth/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".$basicAuth,
            "Content-Type: application/x-www-form-urlencoded",
            "Cache-Control: no-cache",
            "Postman-Token: 9372d56b-9d5f-fa98-9a72-c9fadff29d10"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        if(array_key_exists('ErrorCode', json_decode($response, true))){
            $result['data'] = json_decode($response, true)['ErrorMessage']['Indonesian'];
        }

        if(empty($result['data'])){
            return [
                'status'    => true,
                'data'      => $response
            ];
        }

        return $result;
    }

    public function generateSignature($token, $stringData){
        
        $stringToSign   = $stringData['http_method'].':'.$stringData['relative_url'].':'.$token.':'.$stringData['hashed_req'].':'.$stringData['timestamp'];
        $signature      = hash_hmac('sha256', $stringToSign, $this->api_secret);
        return $signature;
    }

    private function processMutation($token, $stringData, $signature, $dateStart, $dateEnd){
        $result =   [
            'status'    => false,
            'data'      => ''
        ];
        $curl   = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->bca_url."banking/v3/corporates/".$this->corp_id."/accounts/".$this->account_number."/statements?EndDate=".$dateEnd."&StartDate=".$dateStart,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
            "X-BCA-Key: ".$this->api_key,
            "X-BCA-Timestamp: ".$stringData['timestamp'],
            "X-BCA-Signature: ".$signature,
            "Cache-Control: no-cache",
            "Postman-Token: 8555e604-e861-2bf9-59be-28bb901216bb"
        ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        if(array_key_exists('ErrorCode', json_decode($response, true))){
            $result['data'] = json_decode($response, true)['ErrorMessage']['Indonesian'];
        }
        if(empty($result['data'])){
            return [
                'status'    => true,
                'data'      => $response
            ];
        }
        return $result;
    }

    private function processBalanceInfoAccount($token, $stringData, $signature, $accounts) {
        $result =   [
            'status'    => false,
            'data'      => ''
        ];

        $curl = curl_init();
        $f = tmpfile();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->bca_url."banking/v3/corporates/".$this->corp_id."/accounts/".$accounts,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,

        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
            "X-BCA-Key: ".$this->api_key,
            "X-BCA-Timestamp: ".$stringData['timestamp'],
            "X-BCA-Signature: ".$signature,
            "Cache-Control: no-cache",
            "Postman-Token: 8555e604-e861-2bf9-59be-28bb901216bb"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if(array_key_exists('ErrorCode', json_decode($response, true))){
            $result['data'] = json_decode($response, true)['ErrorMessage']['Indonesian'];
        }
        if(empty($result['data'])){
            return [
                'status'    => true,
                'data'      => $response
            ];
        }
        return $result;
    }

    public function mutationAccountv2($dateStart, $dateEnd){
        $result = [
            'status'    => false,
            'data'      => ''
        ];
        
        $response_token = $this->requestToken();

        if (!$response_token['status']) {
            return $response_token;
        }
        $token          = '';
        $mutation       = '';
        $token  = json_decode($response_token['data'], true)['access_token'];

        // Generate Signature
        $stringData     = [
            'http_method'   => 'GET',
            'relative_url'  => '/banking/v3/corporates/'.$this->corp_id.'/accounts/'.$this->account_number.'/statements?EndDate='.$dateEnd.'&StartDate='.$dateStart,
            'request_body'  => '',
            'timestamp'     => date('Y-m-d\TH:i:s.000+07:00'),
        ];
        $stringData['hashed_req'] = strtolower(hash('sha256',$stringData['request_body']));

        if(!empty($token)){
            $signature  = $this->generateSignature($token, $stringData);
        } else {
            $result['data']  =  'Token tidak berhasil diterima';
            return $result;
        }

        // Access Mutation
        $mutation   = $this->processMutation($token, $stringData, $signature, $dateStart, $dateEnd);

        if($mutation['status']){
            return [
                'status'    => true,
                'data'      => $mutation['data']
            ];
        } else {
            $result['data'] = $mutation['data'];
            return $result;
        }
    }

    public function balanceInfo(){
        $result = [
            'status'    => false,
            'data'      => ''
        ];

        $accounts   =   [$this->account_number]; // why must be on array (because you can input multiple account actually)
        $accounts   =   implode('%2C', $accounts);

        // dari sini
        $response_token = $this->requestToken();

        if (!$response_token['status']) {
            return $response_token;
        }
        $token          = '';
        $mutation       = '';
        $token  = json_decode($response_token['data'], true)['access_token'];

        // Generate Signature
        $stringData     = [
            'http_method'   => 'GET',
            'relative_url'  => '/banking/v3/corporates/'.$this->corp_id.'/accounts/'.$accounts,
            'request_body'  => '',
            'timestamp'     => date('Y-m-d\TH:i:s.000+07:00'),
        ];
        $stringData['hashed_req'] = strtolower(hash('sha256',$stringData['request_body']));

        if(!empty($token)){
            $signature  = $this->generateSignature($token, $stringData);
        } else {
            $result['data']  =  'Token tidak berhasil diterima';
            return $result;
        } // bisa di create function

        // Access Information
        $balance   = $this->processBalanceInfoAccount($token, $stringData, $signature, $accounts);

        if($mutation['status']){
            return [
                'status'    => true,
                'data'      => $balance['data']
            ];
        } else {
            $result['data'] = $balance['data'];
            return $result;
        }
    }
}
