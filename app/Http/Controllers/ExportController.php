<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Exports\LaporanGabunganExport;
use App\Models\Category;
use App\Models\SparePart;
use App\Models\StockMovement;
use App\Models\Activity;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(string $format)
    {
        $validFormats = ['pdf', 'xlsx', 'csv'];

        if (!in_array($format, $validFormats)) {
            abort(404);
        }

        $dateLabel = Carbon::now()->format('Ymd_His');
        $fileName = "LAPORAN_GABUNGAN_{$dateLabel}";

        Activity::create([
            'user_name' => auth()->user()->name ?? 'Sistem',
            'action' => 'created',
            'description' => "Mengekspor laporan gabungan format " . strtoupper($format),
            'item_name' => "Laporan Gabungan",
        ]);

        if ($format === 'pdf') {
            $view = View::make('exports.laporan_gabungan_pdf', [
                'inventaris' => SparePart::with(['category', 'location'])->get(),
                'pergerakanStok' => StockMovement::with('sparePart')->latest('date')->get(),
                'kategori' => Category::withCount('spareParts')->get(),
                'title' => 'Laporan Gabungan Inventory Spare Part',
                'generatedAt' => Carbon::now()->format('d/m/Y H:i:s'),
            ]);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($view->render())
                ->setPaper('a4', 'landscape');

            return $pdf->download($fileName . '.pdf');
        }

        if ($format === 'xlsx') {
            return Excel::download(new LaporanGabunganExport(), $fileName . '.xlsx');
        }

        return Excel::download(new InventarisExport(), $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}