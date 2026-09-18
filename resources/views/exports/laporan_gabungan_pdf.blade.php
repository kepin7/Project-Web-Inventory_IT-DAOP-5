<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1f2937; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #312e81; padding-bottom: 15px; }
        .header h1 { color: #312e81; margin: 0 0 5px 0; font-size: 18px; }
        .header .sub { color: #6b7280; font-size: 11px; }
        .header .org { font-size: 13px; font-weight: bold; color: #1f2937; }
        .meta { font-size: 10px; color: #6b7280; margin-bottom: 12px; text-align: right; }
        .section-title { background: #eef2ff; color: #312e81; padding: 8px 12px; font-weight: bold; font-size: 12px; border-left: 4px solid #312e81; margin-top: 20px; }
        .section-title:first-of-type { margin-top: 0; }
        .section-sub { font-size: 10px; color: #6b7280; margin: 4px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #312e81; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; }
        td { padding: 6px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
        .page-break { page-break-before: always; }
        .footer { margin-top: 25px; text-align: center; color: #9ca3af; font-size: 9px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="org">PT KERETA API INDONESIA (PERSERO)</div>
        <div class="sub">DAOP 5 PURWOKERTO</div>
        <h1>{{ $title }}</h1>
        <div class="sub">Periode: {{ $generatedAt }}</div>
    </div>

    <div class="meta">Dibuat oleh: {{ auth()->check() ? auth()->user()->name . ' (' . ucwords(str_replace('_', ' ', auth()->user()->role)) . ')' : 'Guest' }}</div>

    {{-- ============ INVENTARIS ============ --}}
    <div class="section-title">A. Laporan Inventaris Spare Part</div>
    <p class="section-sub">Total: {{ count($inventaris) }} barang</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Input</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>No. Seri</th>
                <th>No. Inventaris</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventaris as $index => $item)
            @php
                $groupCount = \App\Models\SparePart::where('brand', $item->brand)->where('type', $item->type)->where('is_available', true)->count();
                if ($groupCount == 0) {
                    $statusText = 'Habis';
                } elseif ($groupCount <= 3) {
                    $statusText = 'Menipis';
                } else {
                    $statusText = 'Aman';
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->brand }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->serial_number }}</td>
                <td>{{ $item->inventory_number }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->location->name ?? '-' }}</td>
                <td>{{ $item->condition }}</td>
                <td>{{ $statusText }}</td>
                <td>{{ $item->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ============ PERGERAKAN STOK ============ --}}
    <div class="section-title page-break">B. Laporan Pergerakan Stok</div>
    <p class="section-sub">Total: {{ count($pergerakanStok) }} transaksi</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Tipe</th>
                <th>Merek</th>
                <th>Tipe Barang</th>
                <th>Serial Number</th>
                <th>Lokasi / Tujuan</th>
                <th>PIC / Peminjam</th>
                <th>Kondisi Barang</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pergerakanStok as $index => $item)
            @php
                $sparePart = $item->sparePart;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->date->format('d/m/Y H:i') }}</td>
                <td>{{ $item->transaction_id }}</td>
                <td>{{ $item->type === 'in' ? 'Masuk' : 'Keluar' }}</td>
                <td>{{ optional($sparePart)->brand ?? '-' }}</td>
                <td>{{ optional($sparePart)->type ?? '-' }}</td>
                <td>{{ optional($sparePart)->serial_number ?? '-' }}</td>
                <td>{{ optional($sparePart)->location->name ?? '-' }}</td>
                <td>{{ $item->pic_name ?? '-' }}</td>
                <td>{{ $item->condition ?? '-' }}</td>
                <td>{{ $item->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ============ KATEGORI ============ --}}
    <div class="section-title page-break">C. Laporan Data Kategori</div>
    <p class="section-sub">Total: {{ count($kategori) }} kategori</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Barang</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description ?? '-' }}</td>
                <td>{{ $item->spare_parts_count }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Dokumen ini dibuat secara otomatis oleh Sistem Inventory Spare Part IT DAOP 5 PWT</div>
</body>
</html>