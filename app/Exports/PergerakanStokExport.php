<?php

namespace App\Exports;

use App\Models\StockMovement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PergerakanStokExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    private $rowNumber = 0;

    public function collection(): Collection
    {
        return StockMovement::with('sparePart')->latest('date')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'ID Transaksi',
            'Tipe',
            'Merek',
            'Tipe Barang',
            'Serial Number',
            'Lokasi / Tujuan',
            'PIC / Peminjam',
            'Kondisi Barang',
            'Catatan',
        ];
    }

    public function map($item): array
    {
        $sparePart = $item->sparePart;

        return [
            ++$this->rowNumber,
            $item->date->format('d/m/Y H:i'),
            $item->transaction_id,
            $item->type === 'in' ? 'Masuk' : 'Keluar',
            $sparePart->brand ?? '-',
            $sparePart->type ?? '-',
            $sparePart->serial_number ?? '-',
            $sparePart->location->name ?? '-',
            $item->pic_name ?? '-',
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

    public function bindValue(Cell $cell, mixed $value): bool
    {
        if (is_numeric($value) && strlen((string)$value) > 10) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}