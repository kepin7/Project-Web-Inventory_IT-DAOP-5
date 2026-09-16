<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalSpareParts = SparePart::count();
        $normalCount = SparePart::where('condition', 'Normal')->where('is_available', true)->count();
        $repairCount = SparePart::where('condition', 'Perbaikan')->where('is_available', true)->count();
        $brokenCount = SparePart::where('condition', 'Rusak')->where('is_available', true)->count();

        // Calculate Menipis based on brand and type (quantity <= 3, hanya barang tersedia)
        $brandTypeCounts = SparePart::where('is_available', true)
            ->select('brand', 'type', \DB::raw('count(*) as count'))
            ->groupBy('brand', 'type')
            ->get();

        $menipisCount = $brandTypeCounts->where('count', '<=', 3)->where('count', '>', 0)->count();
        $habisCount = SparePart::where('is_available', false)->count();

        $rawCategories = SparePart::join('categories', 'spare_parts.category_id', '=', 'categories.id')
            ->select('categories.name', \DB::raw('count(spare_parts.id) as count'))
            ->groupBy('categories.name')
            ->get();

        // Largest Remainder Method: agar total persentase selalu tepat 100%
        $exactPercentages = $rawCategories->map(function ($item) use ($totalSpareParts) {
            $exact = $totalSpareParts > 0 ? ($item->count / $totalSpareParts) * 100 : 0;

            return [
                'name' => $item->name,
                'count' => $item->count,
                'floor' => (int) floor($exact),
                'remainder' => $exact - floor($exact),
            ];
        });

        $totalFloor = $exactPercentages->sum('floor');
        $remainder = 100 - $totalFloor;

        $categoriesData = $exactPercentages
            ->sortByDesc('remainder')
            ->values()
            ->map(function ($item, $i) use (&$remainder) {
                $percentage = $item['floor'] + ($remainder-- > 0 ? 1 : 0);

                return [
                    'name' => $item['name'],
                    'count' => $item['count'],
                    'percentage' => $percentage,
                ];
            })
            ->sortByDesc('count')
            ->values();

        // Calculate dynamic growth (items added this month vs total)
        $currentMonthCount = SparePart::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $growthPercentage = $totalSpareParts > 0 ? round(($currentMonthCount / $totalSpareParts) * 100, 1) : 0;

        // Chart Data Calculation
        $period = $request->query('period', 'minggu_ini');

        $dateStart = now()->startOfWeek();
        $dateEnd = now()->endOfWeek();
        $format = 'D';

        if ($period === 'minggu_lalu') {
            $dateStart = now()->subWeek()->startOfWeek();
            $dateEnd = now()->subWeek()->endOfWeek();
        } elseif ($period === 'bulan_ini') {
            $dateStart = now()->startOfMonth();
            $dateEnd = now()->endOfMonth();
            $format = 'd';
        }

        $labels = [];
        $currentDate = $dateStart->copy();
        while ($currentDate <= $dateEnd) {
            if ($format === 'D') {
                $dayNames = ['Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];
                $labels[] = $dayNames[$currentDate->format('D')];
            } else {
                $labels[] = $currentDate->format('d/m');
            }
            $currentDate->addDay();
        }

        $movements = StockMovement::whereBetween('date', [$dateStart->format('Y-m-d'), $dateEnd->format('Y-m-d')])
            ->select('date', 'type', \DB::raw('count(id) as quantity'))
            ->groupBy('date', 'type')
            ->get();

        $dataIn = array_fill(0, count($labels), 0);
        $dataOut = array_fill(0, count($labels), 0);

        foreach ($movements as $movement) {
            $movementDate = Carbon::parse($movement->date);
            $index = $dateStart->diffInDays($movementDate);

            if ($index >= 0 && $index < count($labels)) {
                if ($movement->type === 'in') {
                    $dataIn[$index] += $movement->quantity;
                } else {
                    $dataOut[$index] += $movement->quantity;
                }
            }
        }

        $chartData = [
            'labels' => $labels,
            'dataIn' => $dataIn,
            'dataOut' => $dataOut,
            'period' => $period,
            'max' => max(10, max($dataIn) + 10, max($dataOut) + 10), // dynamically set max y-axis
        ];

        return Inertia::render('Dashboard/Index', [
            'totalSpareParts' => $totalSpareParts,
            'normalCount' => $normalCount,
            'repairCount' => $repairCount,
            'brokenCount' => $brokenCount,
            'menipisCount' => $menipisCount,
            'habisCount' => $habisCount,
            'categoriesData' => $categoriesData,
            'growthPercentage' => $growthPercentage,
            'chartData' => $chartData,
        ]);
    }
}
