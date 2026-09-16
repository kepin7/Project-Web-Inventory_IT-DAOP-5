<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KategoriExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection(): Collection
    {
        return Category::withCount('spareParts')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Deskripsi',
            'Jumlah Barang',
            'Dibuat Pada',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->description ?? '-',
            $item->spare_parts_count,
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