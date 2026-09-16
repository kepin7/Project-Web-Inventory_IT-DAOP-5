<?php

namespace App\Exports;

use App\Models\StockMovement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PergerakanStokExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection(): Collection
    {
        return StockMovement::with('sparePart')->latest('date')->get();
    }

    public function headings(): array
    {
        return [
            'No. Transaksi',
            'Tanggal',
            'Tipe',
            'Barang',
            'No. Seri',
            'PIC',
            'Referensi',
            'Kondisi',
            'Catatan',
        ];
    }

    public function map($item): array
    {
        $sparePart = $item->sparePart;
        $itemName = '-';
        if ($sparePart) {
            $itemName = trim(($sparePart->brand ?? '') . ' ' . ($sparePart->type ?? ''));
            if (empty($itemName)) {
                $itemName = $sparePart->inventory_number ?? '-';
            }
        }

        return [
            $item->transaction_id,
            $item->date->format('d/m/Y H:i'),
            $item->type === 'in' ? 'Masuk' : 'Keluar',
            $itemName,
            $sparePart->serial_number ?? '-',
            $item->pic_name,
            $item->reference,
            $item->condition ?? '-',
            $item->notes ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function data()
    {
        return $this->collection();
    }
}