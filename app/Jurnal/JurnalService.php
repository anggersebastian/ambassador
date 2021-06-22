<?php

namespace App\Jurnal;

use GuzzleHttp\Client;
use Carbon\Carbon;

use function GuzzleHttp\json_decode;

class JurnalService {

    protected $jurnalUrl;
    protected $header;
    protected $client;

    public function __construct()
    {
        $this->jurnalUrl = env('JURNAL_ENDPOINT').'core/api/v1';
        $this->client = new Client();
        $this->header = [
            'content-type' => 'application/json',
            'apikey' => env('JURNAL_API_KEY_EDRUS_STRATEGY_DIGITAL')
        ];
    }

    public function addSalesInvoice($data){
        if($data['type'] == 'transfer'){
            $tags   = 'TRANSFER';
            $person = 'Dropy-SalesInvoice-Transfer';
        } else if($data['type'] == 'cod'){
            $tags   = 'COD';
            $person = 'Dropy-SalesInvoice-COD';
        }
        
        $params     = [
            "sales_invoice"=> [
                "transaction_date"  => Carbon::now()->toDateString(),
                "transaction_lines_attributes" => [],
                "custom_id"         => $data['id_batch'].'_'.$data['type'],
                "tags" => [
                    $tags
                ],
                "term_name"         => "Net 30",
                "person_name"       => $person,
                "is_shipped"        => true,
                "ship_via"          => 'Ninja',
                "shipping_date"     => Carbon::now()->toDateString(),
                "shipping_price"    => $data['ship_cost'],
            ]
        ];
        foreach($data['orders'] as $rawData){
            $params['sales_invoice']['transaction_lines_attributes'][] = [
                'custom_id'     => strval($rawData['id']),            
                'quantity'      => 1,
                'rate'          => $rawData['net_revenue'],
                'product_name'  => $rawData['product_name'],
                'description'   => 'Method :'.$rawData['payment_method'].' Payment Status :'.$rawData['payment_status'],
            ];
        }
        try {
            $res    = $this->client->request('POST', $this->jurnalUrl.'/sales_invoices', [
                'headers'   => $this->header,
                'body'      => json_encode($params),
            ]);
            $res    = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($res),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function getSalesInvoice($id){
        // for checking
        try{
            $res    = $this->client->request('GET', $this->jurnalUrl.'/sales_invoices/'.$id, 
            [
                'headers'   => $this->header, 
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function updateSalesInvoiceDesc($order_id = null, $data = [], $custom_id = null){
        // for update
        $payment_method = explode('_', $custom_id)[1];
        $json           = json_encode($data['data'], true);
        $array          = json_decode($json, true);
        $sales_invoice  = $array["sales_invoice"];
        $key            = array_search($order_id, array_column($sales_invoice["transaction_lines_attributes"], 'custom_id'));
        $sales_invoice['transaction_lines_attributes'][$key]['description'] = 'Method :'. $payment_method .' Payment Status :PAID';

        $params     = [
            "sales_invoice"=> [
                "transaction_date"  =>  $sales_invoice['transaction_date'],
                "due_date"          =>  $sales_invoice['due_date'],
                "transaction_status"=>  $sales_invoice['transaction_status'],
                "transaction_lines_attributes"  => [],
                "tags" => [
                    $sales_invoice['tags'][0]['name']
                ]
            ]
        ];
        foreach($sales_invoice['transaction_lines_attributes'] as $transaction){
            $params['sales_invoice']['transaction_lines_attributes'][] = [
                'custom_id'     => $transaction['custom_id'],            
                'quantity'      => $transaction['quantity'],
                'rate'          => $transaction['rate'],
                'product_name'  => $transaction['product']['name'],
                'description'   => $transaction['description'],
            ];
        }
        try{
            $res    = $this->client->request('PATCH', $this->jurnalUrl.'/sales_invoices/'.$custom_id, 
            [
                'headers'   => $this->header,
                'body'      => json_encode($params)
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function deleteSalesInvoice($custom_id){
        try{
            $res    = $this->client->request('DELETE', $this->jurnalUrl.'/sales_invoices/'.$custom_id, 
            [
                'headers'   => $this->header,
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => ""
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function createSalesInvoicePayment($data){
        
        $transaction_id =   $data['data']->sales_invoice->id;
        $remaining      =   $data['data']->sales_invoice->remaining;
        $custom_id      =   $data['data']->sales_invoice->custom_id;
        
        $params     = [
            "receive_payment"=> [
                "transaction_date"      =>  Carbon::now()->toDateString(),
                "records_attributes"    =>  [
                    [
                        'transaction_id'=>  $transaction_id,
                        'amount'        =>  (int)$remaining
                    ]
                ],
                "custom_id"             =>  $custom_id,
                "payment_method_name"   =>  "Cash",
                "deposit_to_name"       =>  "Cash",
            ]
        ];
        
        try {
            $res    = $this->client->request('POST', $this->jurnalUrl.'/receive_payments', [
                'headers'   => $this->header,
                'body'      => json_encode($params),
            ]);
            $res    = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($res),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function createProduct($product){
        // create product
        $name   = $product['name'];
        $sku    = $product['sku'];

        $params     = [
            "product"=> [
                "name"                  => $name,
                "product_code"          => $sku,
                "is_bought"             => true,
                "buy_price_per_unit"    => "0",
                "buy_account_number"    => "5-50000",
                "is_sold"               => true,
                "sell_account_number"   => "4-40000",
                "sell_price_per_unit"   => "0",
                "track_inventory"       => "true",
                "inventory_asset_account_name" => $name,
            ]
        ];
        try {
            $res    = $this->client->request('POST', $this->jurnalUrl.'/products', [
                'headers'   => $this->header,
                'body'      => json_encode($params)
        ]);
            $res    = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($res)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function createAccountInventory($accountName, $number){
        $params     = [
            "account"=> [
                "name"          => $accountName,
                // "category_name" => 'Inventory', // for sandbox only
                "category_name" => 'Persediaan', // for production edrus strategy digital
                "number"        => $number,
            ]
        ];
        try {
            $res    = $this->client->request('POST', $this->jurnalUrl.'/accounts', [
                'headers'   => $this->header,
                'body'      => json_encode($params)
            ]);
            $res    = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($res)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    private function checkProductID($productName){
        try{
            $res    = $this->client->request('GET', $this->jurnalUrl.'/products/'.$productName, 
            [
                'headers'   => $this->header, 
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function getAllAccounts(){
        try{
            $res    = $this->client->request('GET', $this->jurnalUrl.'/accounts/', 
            [
                'headers'   => $this->header, 
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function getAllProducts($page = null){
        try{
            $res    = $this->client->request('GET', $this->jurnalUrl.'/products/?page='.$page,
            // ?page='.$page.'?page_size=50 
            [
                'headers'   => $this->header, 
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    public function checkProductByName($nameProducts = []){
        $result = [
            'status'    =>  false,
            'data'      => ''
        ];
        $jurnalProducts     = [];
        $notExistedProduct  = [];
        $processing         = $this->getAllProducts();
        $total_pages        = null;
        if($processing['status']){
            $total_pages    = $processing['data']->total_pages;
            for($i = 0; $i < $total_pages; $i++){
                $products   = $this->getAllProducts($i);
                $data       = $products['data']->products;
                foreach($data as $d){
                    $jurnalProducts[] = $d->name;
                }
            }
        }
        else {
            $result['data'] = $processing['data'];
            return $result;
        }
        if(!empty($nameProducts)){
            foreach($nameProducts as $product){
                if(!in_array($product , $jurnalProducts)){
                    $notExistedProduct[] = $product;
                }
            }
            $result = [
                'status'    => true,
                'data'      => $notExistedProduct,
            ];
            return $result;
        }
        return $result;
    }

    public function processCustomIdProduct($products){
        $dump_process = [];
        if($products['status']){
            $arrProduct     = $products['data']->products;
            try{
                foreach($arrProduct as $product){
                    if(is_null($product->custom_id) and !is_null($product->product_code)){
                        $update = $this->updateProduct($product->id, $product->product_code); // processing update
                        if(!$update['status']){
                            $dump_process[] = $product->id;
                        }
                    }
                }
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'data' => $e->getMessage()
                ];
            }
            return [
                'status'        => true,
                'failed_data'   => $dump_process
            ];
        } else {
            return [
                'status'    => false,
                'data'      => $products['data']
            ];
        }
    } // not used yet

    private function updateProduct($id, $skuCode){
        // If custom ID not exist, and you want to get the faster performance to process create Sales Invoice
        $params     = [
            "product"=> [
                'custom_id' =>  $skuCode
            ]
        ];
        try{
            $res    = $this->client->request('PATCH', $this->jurnalUrl.'/products/'.$id, 
            [
                'headers'   => $this->header,
                'body'      => json_encode($params)
            ]);
            $result = $res->getBody()->getContents();
            return [
                'status'    => true,
                'data'      => json_decode($result)
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => $e->getMessage()
            ];
        }
    } // Not used yet
}
