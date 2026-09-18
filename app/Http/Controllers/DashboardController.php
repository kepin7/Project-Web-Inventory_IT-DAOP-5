<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Notification;
use App\Models\SparePart;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalSpareParts = SparePart::count();
        $normalCount = SparePart::where('condition', 'Normal')->where('is_available', true)->count();
        $repairCount = SparePart::where('condition', 'Perbaikan')->where('is_available', true)->count();
        $brokenCount = SparePart::where('condition', 'Rusak')->where('is_available', true)->count();

        // Group parts to check availability and repair status
        $groups = SparePart::select(
            'brand', 
            'type', 
            'category_id',
            \DB::raw("SUM(CASE WHEN is_available = 1 THEN 1 ELSE 0 END) as available_count"),
            \DB::raw("SUM(CASE WHEN `condition` = 'Perbaikan' THEN 1 ELSE 0 END) as repair_count")
        )
        ->groupBy('brand', 'type', 'category_id')
        ->get();

        $menipisCount = $groups->where('available_count', '<=', 3)->where('available_count', '>', 0)->count();
        $habisCount = SparePart::where('is_available', false)->count();

        // Tindakan Diperlukan - items with low/zero stock or in repair
        $actionRequiredItems = collect();
        $notificationItems = collect();

        foreach ($groups as $group) {
            $status = null;
            if ($group->available_count == 0) {
                $status = 'Habis';
            } elseif ($group->available_count <= 3) {
                $status = 'Menipis';
            }

            $firstPart = SparePart::where('brand', $group->brand)->where('type', $group->type)->first();
            $itemName = trim(($group->brand ?? '') . ' ' . ($group->type ?? ''));
            if (empty($itemName)) {
                $itemName = $firstPart->inventory_number ?? 'Barang';
            }

            if ($status) {
                $notificationItems->push((object)[
                    'name' => $itemName,
                    'count' => (int) $group->available_count,
                    'status' => $status
                ]);

                $actionRequiredItems->push([
                    'name' => $itemName,
                    'qty' => (int) $group->available_count,
                    'status' => $status,
                    'category' => $firstPart?->category?->name ?? '-',
                ]);
            }

            if ($group->repair_count > 0) {
                $actionRequiredItems->push([
                    'name' => $itemName . ' (Perbaikan)',
                    'qty' => (int) $group->repair_count,
                    'status' => 'Perbaikan',
                    'category' => $firstPart?->category?->name ?? '-',
                ]);
            }
        }

        // Sort items so Habis is at the top, then Menipis, then Perbaikan
        $actionRequiredItems = $actionRequiredItems->sortBy(function($item) {
            if ($item['status'] === 'Habis') return 1;
            if ($item['status'] === 'Menipis') return 2;
            if ($item['status'] === 'Perbaikan') return 3;
            return 4;
        })->values();

        // Aktivitas Terkini - filter by period
        $activityPeriod = $request->query('activity_period');
        $activitiesQuery = Activity::with('category')->latest();

        if ($activityPeriod === 'hari_ini') {
            $activitiesQuery->whereDate('created_at', now()->today());
        } elseif ($activityPeriod === 'minggu_ini') {
            $activitiesQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($activityPeriod === 'bulan_ini') {
            $activitiesQuery->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year);
        }

        // Retrieve activities (limit to 100 so it doesn't overload, but it's much larger than 10)
        $activities = $activitiesQuery->take(100)->get();
        $allCategories = Category::all();

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

        // Generate stock notifications if not exists in the last 24 hours
        $this->generateStockNotifications($notificationItems);

        // Count unread notifications
        $unreadNotificationCount = Notification::unread()->count();

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
            'activities' => $activities,
            'allCategories' => $allCategories,
            'selectedActivityPeriod' => $activityPeriod ?? '',
            'actionRequiredItems' => $actionRequiredItems,
            'unreadNotificationCount' => $unreadNotificationCount,
        ]);
    }

    private function generateStockNotifications($notificationItems)
    {
        foreach ($notificationItems as $item) {
            $itemName = $item->name;
            $title = $item->status === 'Habis' ? 'Stok Habis' : 'Stok Menipis';

            // Check if notification already exists in the last 24 hours
            $exists = Notification::where('title', $title)
                ->where('message', 'like', "%{$itemName}%")
                ->where('created_at', '>=', now()->subDay())
                ->exists();

            if (!$exists) {
                Notification::create([
                    'title' => $title,
                    'message' => "{$itemName} memiliki stok tersedia {$item->count} unit.",
                    'type' => 'stock',
                    'link' => '/inventory',
                ]);
            }
        }
    }
}