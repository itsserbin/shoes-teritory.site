<?php

namespace App\Exports;

use App\Models\Clients;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ClientsExport implements FromCollection, WithMapping, WithColumnFormatting
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Clients::select('name', 'phone', 'status', 'comment', 'created_at')->orderBy('created_at', 'desc')->get();
    }

    public function map($row): array
    {
        return [
            $row->status,
            $row->name,
            $row->phone,
            $row->comment,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
