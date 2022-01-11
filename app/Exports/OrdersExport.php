<?php

namespace App\Exports;

use App\Models\Enum\OrderStatus;
use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Orders::select('phone', 'name', 'status')->get();
    }
}
