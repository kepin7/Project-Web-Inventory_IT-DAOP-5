<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanGabunganExport implements Export, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Inventaris' => new InventarisExport(),
            'Pergerakan Stok' => new PergerakanStokExport(),
            'Kategori' => new KategoriExport(),
        ];
    }
}
