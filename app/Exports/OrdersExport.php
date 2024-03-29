<?php

namespace App\Exports;

use App\Models\Enum\OrderStatus;
use App\Models\Orders;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class OrdersExport implements FromCollection, WithMapping, WithColumnFormatting
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Orders::select('id', 'client_id', 'status')->with('client')->get();
    }

    public function map($row): array
    {
        return [
            $row->status,
            $row->client->name,
            $row->client->phone,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
