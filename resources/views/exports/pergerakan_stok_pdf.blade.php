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
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #312e81; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; }
        td { padding: 6px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
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

    <div class="meta">Dibuat oleh: Jaelani Nurazizah (Super Admin)</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Barang</th>
                <th>No. Seri</th>
                <th>PIC</th>
                <th>Kondisi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
            @php
                $sparePart = $item->sparePart;
                $itemName = '-';
                if ($sparePart) {
                    $itemName = trim(($sparePart->brand ?? '') . ' ' . ($sparePart->type ?? ''));
                    if (empty($itemName)) { $itemName = $sparePart->inventory_number ?? '-'; }
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->transaction_id }}</td>
                <td>{{ $item->date->format('d/m/Y H:i') }}</td>
                <td>{{ $item->type === 'in' ? 'Masuk' : 'Keluar' }}</td>
                <td>{{ $itemName }}</td>
                <td>{{ optional($sparePart)->serial_number ?? '-' }}</td>
                <td>{{ $item->pic_name }}</td>
                <td>{{ $item->condition ?? '-' }}</td>
                <td>{{ $item->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Dokumen ini dibuat secara otomatis oleh Sistem Inventory Spare Part IT DAOP 5 PWT</div>
</body>
</html>