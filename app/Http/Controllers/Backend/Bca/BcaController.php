<?php

namespace App\Http\Controllers\Backend\Bca;

use App\BCA\BcaLogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BcaController extends Controller
{
    protected $bca;

    public function __construct(BcaLogRepository $bca)
    {
        $this->bca  = $bca;
    }

    public function index(Request $request)
    {
        $filters    = $request->all();
        $logs       = $this->bca->get($filters);

        return view('backend.bca.index', compact('logs'));
    }
}
