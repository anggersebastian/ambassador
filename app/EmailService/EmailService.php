<?php
namespace App\EmailService;

use App\Order\Order;

class EmailService {

    public function startSending($params){
        $user = env("MAIL_API_KEY", "new");
        $pass = env("MAIL_PASSWORD", "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");

        $params['api_user'] = $user;
        $params['api_key']  = $pass;

        $url        = 'https://api.sendgrid.com/';
        $request    =  $url.'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded",
            "authorization: Bearer " . $params['api_key'],
            "cache-control: no-cache"
        ));
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, http_build_query($params));
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        // print everything out
        return $response;
    }

    public static function sendNotifNewOrderToAdmin($arg)
    {
        try {
            $view       = view('email.notif-new-order-to-admin', compact('arg'))->render();
            $params = array(
                'to'        => $arg['to'],
                'subject'   => 'New Order',
                'html'      => $view,
                'from'      => 'developer@dropy.id'
            );
            return (new self)->startSending($params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function sendNotifNewOrderToCustomer($arg)
    {
        try {
            $view       = view('email.notif-new-order-to-customer', compact('arg'))->render();
            $params = array(
                'to'        => $arg['to'],
                'subject'   => 'New Order',
                'html'      => $view,
                'from'      => 'no-reply@dropy.id'
            );
            return (new self)->startSending($params);
        } catch (\Exception $e) {
            return $e->getMessage(); 
        }
    }

    public static function sendNotifHasPaidToCustormer($arg)
    {
        try {
            $view       = view('email.notif-order-has-paid', compact('arg'))->render();
            $params = array(
                'to'        => $arg['to'],
                'subject'   => 'New Order',
                'html'      => $view,
                'from'      => 'no-reply@dropy.id'
            );
            return (new self)->startSending($params);
        } catch (\Exception $e) {
            return $e->getMessage(); 
        }
    }

}