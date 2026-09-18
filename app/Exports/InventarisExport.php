<?php

namespace App\Exports;

use App\Models\SparePart;
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

class InventarisExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
{
    private $rowNumber = 0;

    public function collection(): Collection
    {
        return SparePart::with(['category', 'location'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Input',
            'Merk',
            'Tipe',
            'No. Seri',
            'No. Inventaris',
            'Kategori',
            'Lokasi',
            'Kondisi',
            'Status',
            'Keterangan',
        ];
    }

    public function map($item): array
    {
        $groupCount = \App\Models\SparePart::where('brand', $item->brand)->where('type', $item->type)->where('is_available', true)->count();
        if ($groupCount == 0) {
            $statusText = 'Habis';
        } elseif ($groupCount <= 3) {
            $statusText = 'Menipis';
        } else {
            $statusText = 'Aman';
        }

        return [
            ++$this->rowNumber,
            $item->created_at->format('d/m/Y'),
            $item->brand,
            $item->type,
            $item->serial_number,
            $item->inventory_number,
            $item->category->name ?? '-',
            $item->location->name ?? '-',
            $item->condition,
            $statusText,
            $item->description,
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