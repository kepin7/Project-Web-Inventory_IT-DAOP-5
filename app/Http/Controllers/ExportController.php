<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Exports\KategoriExport;
use App\Exports\PergerakanStokExport;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(string $type, string $format)
    {
        $validTypes = ['inventaris', 'pergerakan-stok', 'kategori'];
        $validFormats = ['pdf', 'xlsx', 'csv'];

        if (!in_array($type, $validTypes) || !in_array($format, $validFormats)) {
            abort(404);
        }

        $dateLabel = Carbon::now()->format('Ymd_His');
        $fileName = strtoupper(str_replace('-', '_', $type)) . "_{$dateLabel}";

        if ($type === 'inventaris') {
            $export = new InventarisExport();
            $viewName = 'exports.inventaris_pdf';
            $title = 'Laporan Inventaris Spare Part';
        } elseif ($type === 'pergerakan-stok') {
            $export = new PergerakanStokExport();
            $viewName = 'exports.pergerakan_stok_pdf';
            $title = 'Laporan Pergerakan Stok';
        } else {
            $export = new KategoriExport();
            $viewName = 'exports.kategori_pdf';
            $title = 'Laporan Data Kategori';
        }

        if ($format === 'pdf') {
            $data = $export->data();
            $view = View::make($viewName, [
                'data' => $data,
                'title' => $title,
                'generatedAt' => Carbon::now()->format('d/m/Y H:i:s'),
            ]);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($view->render())
                ->setPaper('a4', 'landscape');

            return $pdf->download($fileName . '.pdf');
        }

        if ($format === 'xlsx') {
            return Excel::download($export, $fileName . '.xlsx');
        }

        return Excel::download($export, $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}