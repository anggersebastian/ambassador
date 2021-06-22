<?php

namespace App\SmsGateway;

class ZenzivaService{
    protected $cs;
    public function __construct() {
        $this->cs   = "083806439028";
    }

    public function send($message, $phone, $type = ''){
        $phone      = str_replace('+','',$phone);
        $username   = env('ZENZIVA_USER', false);
        $password   = env('ZENZIVA_PASS', false);
        $message    = str_replace(" ","%20", $message);


        $sms_command    = 'https://reguler.zenziva.net/apps/smsapi.php?userkey='. $username .'&passkey='. $password .'&nohp='. $phone .'&pesan=' . $message;

        $send   = null;
        try{
            $send = file_get_contents($sms_command);
        }catch (\Exception $e){
            return [
                'status'    => false,
                'code'      => $send,
                'message'   => 'SMS gagal dikirim'
            ];
        }
        try{
            $xml        = simplexml_load_string($send);
        }catch (\Exception $exception){
            return [
                'status'    => false,
                'code'      => $send,
                'message'   => "Something error."
            ];
        }

        return [
            'status'    => true,
            'code'      => $send,
            'message'   => "Sms berhasil dikirim."
        ];
    }

    public function customerOrderSMS($user){
        $sms = "Hi pelanggan LaundryTaxi ". $user->name .", Pesanan laundry kamu akan segera dijemput oleh merchant kami pada jam & hari kerja, harap pastikan nomor kamu aktif terus yaa!!";
        return $this->send($sms, $user->phone);
    }

    public function validationPhone($user){
        $sms = "Hi pelanggan LaundryTaxi ". $user->name .", verifikasi kode kamu adalah, " . $user->activate_code . ". Kode berlaku hingga " . $user->activate_code_expired;
        return $this->send($sms, $user->phone);
    }

    public function merchantOrderSMS($merchant, $user){
        $sms = "Hi merhcant LaundryTaxi, Ada pesanan laundry untuk kamu dari " . $user->name . ", ". $user->phone .", dan akan diantar kurir segera. by LaundryTaxi.id";
        // return $this->send($sms, $merchant->phone);
        return $this->send($sms, '+6281806423887'); // alan
    }

    public function updateOrderPickup($user, $order){
        $sms    = "Hi pelanggan LaundryTaxi " . $user->name . ", laundry kamu dg no ". $order->invoice_no ." telah dipickup, total berat " . $order->actual_weight . "kg dan biaya (estimasi) Rp" .
        number_format($order->grand_total,0) . " akan segera diproses.";
        return $this->send($sms, $user->phone);
    }

    public function rejectOrder($user, $order){
        $sms    = "Hii pelanggan LaundryTaxi " . $user->name .", mohon maaf, pesanan kamu dg no ". $order->invoice_no ." tdk dpt kami teruskan krn ". $order->success_comment .". Kami akn terus memperbaiki layanan.";
        return $this->send($sms, $user->phone);
    }

    public function courierPickedUp($user, $order){
        $sms    = "Hi pelanggan LaundryTaxi " . $user->name . ", laundry no ". $order->invoice_no ." telah dipickup oleh kurir dengan berat " . $order->actual_weight . "kg akan segera diproses. CS: " . $this->cs;
        return $this->send($sms, $user->phone);
    }

    public function onProcess($user, $order, $deliveryDate = ''){
        $sms    = "Hi pelanggan LaundryTaxi " . $user->name . ", laundry no ". $order->invoice_no ." telah/sedang diproses dengan jumlah pcs ". $order->actual_count .", dan akan diantarkan pada tanggal ". $deliveryDate .", total ". number_format($order->grand_total,0) ." . CS: " . $this->cs;
        return $this->send($sms, $user->phone);
    }

    public function delivered($user, $order){
        $sms    = "Hi pelanggan LaundryTaxi " . $user->name . ", laundry no ". $order->invoice_no ." telah dikirim, jika ada masalah dengan laundry kamu, bisa hubungi CS no: " . $this->cs . ", Terimakasih silahkan order kembali!!";
        return $this->send($sms, $user->phone);
    }

    public function customSms($user, $message){
        return $this->send($message, $user->phone);
    }
}