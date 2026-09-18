<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Notification;
use App\Models\SparePart;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $dateStart = $request->query('date_start');
        $dateEnd = $request->query('date_end');

        $search = $request->query('search');
        $typeFilter = $request->query('type');

        $movementsQuery = StockMovement::with(['sparePart', 'location'])
            ->select('transaction_id', 'type', 'pic_name', 'reference', 'notes', 'condition', 'location_id', 'destination',
                \DB::raw('MAX(id) as id'),
                \DB::raw('MAX(date) as date'),
                \DB::raw('MAX(spare_part_id) as spare_part_id'),
                \DB::raw('COUNT(id) as quantity')
            )
            ->groupBy('transaction_id', 'type', 'pic_name', 'reference', 'notes', 'condition', 'location_id', 'destination')
            ->orderBy('date', 'desc');

        if ($dateStart) {
            $movementsQuery->whereDate('date', '>=', $dateStart);
        }
        if ($dateEnd) {
            $movementsQuery->whereDate('date', '<=', $dateEnd);
        }
        if ($search) {
            $movementsQuery->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhereHas('sparePart', function ($q2) use ($search) {
                      $q2->where('brand', 'like', "%{$search}%")
                         ->orWhere('type', 'like', "%{$search}%");
                  });
            });
        }
        if ($typeFilter) {
            $movementsQuery->where('type', $typeFilter);
        }

        $movements = $movementsQuery->paginate(15)->withQueryString();

        // Custom counting logic for transactions (not individual items) based on period
        $summaryQueryIn = StockMovement::select('transaction_id')->where('type', 'in')->groupBy('transaction_id');
        $summaryQueryOut = StockMovement::select('transaction_id')->where('type', 'out')->groupBy('transaction_id');

        if ($dateStart) {
            $summaryQueryIn->whereDate('date', '>=', $dateStart);
            $summaryQueryOut->whereDate('date', '>=', $dateStart);
        }
        if ($dateEnd) {
            $summaryQueryIn->whereDate('date', '<=', $dateEnd);
            $summaryQueryOut->whereDate('date', '<=', $dateEnd);
        }

        $inTransactions = $summaryQueryIn->get()->count();
        $outTransactions = $summaryQueryOut->get()->count();

        $summary = [
            'in' => $inTransactions,
            'out' => $outTransactions,
        ];

        $spareParts = SparePart::with('category:id,name')->select('id', 'brand', 'type', 'serial_number', 'inventory_number', 'condition', 'category_id')->get();
        $locations = \App\Models\Location::where('status', 'aktif')->get();

        return Inertia::render('StockMovement/Index', [
            'movements' => $movements,
            'summary' => $summary,
            'spare_parts' => $spareParts,
            'locations' => $locations,
            'filters' => $request->only(['date_start', 'date_end', 'search', 'type']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'pic_name' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'condition' => 'required_if:type,in|nullable|string|max:255',
            'spare_part_ids' => 'required|array|min:1',
            'spare_part_ids.*' => 'exists:spare_parts,id',
            'location_id' => 'required_if:type,in|nullable|exists:locations,id',
            'destination' => 'required_if:type,out|nullable|string|max:255',
        ]);

        $transactionId = 'TRX-'.date('YmdHis').'-'.strtoupper(\Str::random(4));

        foreach ($validated['spare_part_ids'] as $sparePartId) {
            StockMovement::create([
                'transaction_id' => $transactionId,
                'spare_part_id' => $sparePartId,
                'type' => $validated['type'],
                'date' => $validated['date'],
                'pic_name' => $validated['pic_name'],
                'notes' => $validated['notes'] ?? null,
                'condition' => $validated['condition'] ?? null,
                'location_id' => $validated['type'] === 'in' ? $validated['location_id'] : null,
                'destination' => $validated['type'] === 'out' ? $validated['destination'] : null,
                'reference' => 'N/A',
            ]);

            // Update ketersediaan barang dan kondisi berdasarkan tipe transaksi
            $updateData = [
                'is_available' => $validated['type'] === 'in',
            ];
            
            if ($validated['type'] === 'in' && !empty($validated['condition'])) {
                $updateData['condition'] = $validated['condition'];
            }
            
            SparePart::where('id', $sparePartId)->update($updateData);

            $sparePart = SparePart::find($sparePartId);
            $itemName = trim(($sparePart->brand ?? '') . ' ' . ($sparePart->type ?? ''));
            if (empty($itemName)) {
                $itemName = $sparePart->inventory_number ?? 'Barang';
            }

            $typeLabel = $validated['type'] === 'in' ? 'masuk' : 'keluar';

            Activity::create([
                'user_name' => auth()->user()->name ?? 'Sistem',
                'action' => $validated['type'] === 'in' ? 'stock_in' : 'stock_out',
                'description' => "Stok {$typeLabel}: {$itemName} ({$transactionId})",
                'category_id' => $sparePart->category_id,
                'item_name' => $itemName,
            ]);
        }

        $typeLabel = $validated['type'] === 'in' ? 'Masuk' : 'Keluar';

        Notification::create([
            'title' => "Stok {$typeLabel}",
            'message' => "Transaksi {$transactionId} dicatat: stok {$typeLabel} untuk " . count($validated['spare_part_ids']) . " barang.",
            'type' => 'activity',
            'link' => '/stock-movement',
        ]);

        return redirect()->back()->with('success', 'Transaksi pergerakan stok berhasil dicatat.');
    }

    public function show($transaction_id)
    {
        $movements = StockMovement::with('sparePart')
            ->where('transaction_id', $transaction_id)
            ->get();

        return response()->json($movements);
    }
}