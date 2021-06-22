<?php
namespace App\BCA;

class IbParser
{
    protected $conf, $bank;

    function __construct()
    {
        $arrContextOptions      = array(
            "ssl"=>array(
                "verify_peer"       => false,
                "verify_peer_name"  => false,
            ),
        );

        $this->conf['ip']       = json_decode( file_get_contents( 'https://api.ipify.org/?format=json' ,false, stream_context_create($arrContextOptions)) )->ip;
        $this->conf['time']     = time() + ( 3600 * 14 );
        $this->conf['path']     = storage_path('framework/cache');
        $this->bank = new BCAParser($this->conf);
    }


    function getBalance($username, $password )
    {
        $this->bank->login( $username, $password );
        $balance = $this->bank->getBalance();
        $this->bank->logout();
        return $balance;

    }

    function getTransactions($username, $password )
    {
        $this->bank->login( $username, $password );
        $transactions = $this->bank->getTransactions();
        $this->bank->logout();
        return $transactions;

    }

    function getMutation($dateStart, $dateEnd, $flag){
        $bca    =   new BCAService($flag);
        $data   =   $bca->mutationAccountv2($dateStart, $dateEnd);
        if($data['status']){
            return $data['data'];
        }
        return false;
    }

}
