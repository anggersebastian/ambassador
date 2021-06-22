<?php

namespace App\BCA;

use Carbon\Carbon;

class BcaLogRepository
{
    public function insert($inputs = []){
        $data       = new BcaLog();

        $data->date         = $inputs['date'];
        $data->description  = $inputs['description'];
        $data->in_out       = $inputs['in_out'];
        $data->amount       = $inputs['amount'];
        $data->get_by       = $inputs['get_by'];
        $data->save();

        return $data;
    }

    public function findByDescValue($desc = '', $amount = 0){
        return BcaLog::with([])
            ->where('description', $desc)
            ->where('amount', $amount)
            ->where('created_at', '>=', Carbon::now()->subDays(3)->toDateTimeString())
            ->first();
    }

    public function get($filters = [], $paginate = 30)
    {
        $bca    = BcaLog::with([]);

        if (!empty($filters['description'])) {
            $bca    = $bca->where('description', 'like', '%' . $filters['description'] . '%');
        }

        if (!empty($filters['amount'])) {
            $bca    = $bca->where('amount', 'like', '%' . $filters['amount'] . '%');
        }

        if (!empty($filters['date'])) {
            $bca    = $bca->where('date', $filters['date']);
        }

        if (!empty($filters['in_out'])) {
            $bca    = $bca->where('in_out', $filters['in_out']);
        }
        if (!empty($filters['date_start']) AND !empty($filters['date_end'])) {
            $bca    = $bca->whereBetween('created_at', [
                Carbon::parse($filters['date_start'])->toDateTimeString(),
                Carbon::parse($filters['date_end'])->toDateTimeString()
            ]);
        }

        if ($paginate == 0) {
            return $bca->orderBy('id', 'desc')->get();
        }

        return $bca->orderBy('id', 'desc')->paginate($paginate);
    }

}
