<?php
namespace App\Notif;
use App\Notif\Notif;
use App\AdminUsers\AdminUser;

class NotifRepository {

    public function getNotifOrder()
    {
        $userId = \Sentinel::check()->id;
        $notif = Notif::with(['order.detail.product', 'order.costumer'])
                ->where('admin_id', $userId)
                ->whereNull('is_read')->get();
        
        $notif = $notif->map(function($q){
            return [
                'order' => $q->order_id,
                'admin_id' => $q->admin_id,
                'costumer' => $q->order->costumer->name,
                'product' => $q->order->detail[0]->product->name,
                'created_at' => (string) $q->created_at
            ];
        });
        return [
            'status' => true,
            'data' => $notif
        ];
    }

    public static function insertBulk($order)
    {
        $user = adminUser::select('id')->get();
        $user = $user->map(function($value)use($order){
            return [
                'admin_id' => $value->id,
                'order_id' => $order,
                'created_at' => date('Y-m-d H:i:s')
            ];
        });
        return $user;
    }

    public function readAll()
    {
        $userId = \Sentinel::check()->id;
        $notif = Notif::where('admin_id',$userId )->update(['is_read' => date('Y-m-d H:i:s')]);
        return $notif;
    }

}