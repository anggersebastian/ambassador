<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notif\NotifRepository;

class NotifController extends Controller
{
    private $notif;

    public function __construct(NotifRepository $notif)
    {
        $this->notif = $notif;
    }

    public function index()
    {
        $notif = $this->notif->getNotifOrder();
        return response()->json($notif);
    }

    public function markAsReadAll()
    {
        $notif = $this->notif->readAll();
        return response()->json([
            'status' => true,
            'data' => []
        ]);
    }
}
