<?php

namespace App\Exports;

use App\Models\SparePart;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarisExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection(): Collection
    {
        return SparePart::with(['category', 'location'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Merk',
            'Tipe',
            'No. Seri',
            'No. Inventaris',
            'Kategori',
            'Lokasi',
            'Kondisi',
            'Status',
            'Keterangan',
            'Tanggal Input',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->brand,
            $item->type,
            $item->serial_number,
            $item->inventory_number,
            $item->category->name ?? '-',
            $item->location->name ?? '-',
            $item->condition,
            $item->is_available ? 'Tersedia' : 'Habis',
            $item->description,
            $item->created_at->format('d/m/Y'),
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