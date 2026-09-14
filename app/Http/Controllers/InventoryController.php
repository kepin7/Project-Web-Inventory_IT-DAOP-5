<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SparePart;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SparePart::with(['category', 'location']);

        // Filter by Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('inventory_number', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('location', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by Location
        if ($request->has('location') && $request->location != '') {
            $query->where('location_id', $request->location);
        }

        // Filter by Condition
        if ($request->has('condition') && $request->condition != '') {
            $query->where('condition', $request->condition);
        }

        // Filter by Date Start
        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('spare_parts.created_at', '>=', $request->date_start);
        }

        // Filter by Date End
        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('spare_parts.created_at', '<=', $request->date_end);
        }

        // Sorting
        $sortBy = $request->has('sort_by') && $request->sort_by != '' ? $request->sort_by : 'created_at';
        $sortDir = $request->has('sort_dir') && $request->sort_dir != '' ? $request->sort_dir : 'desc';

        if ($sortBy == 'category') {
            $query->join('categories', 'spare_parts.category_id', '=', 'categories.id')
                  ->orderBy('categories.name', $sortDir)
                  ->select('spare_parts.*');
        } elseif ($sortBy == 'location') {
            $query->join('locations', 'spare_parts.location_id', '=', 'locations.id')
                  ->orderBy('locations.name', $sortDir)
                  ->select('spare_parts.*');
        } elseif ($sortBy == 'brand') {
            $query->orderBy('brand', $sortDir)->orderBy('type', $sortDir);
        } else {
            // Include created_at, serial_number, condition, etc.
            // Check if it's a valid column to avoid SQL injection
            $validColumns = ['id', 'created_at', 'brand', 'serial_number', 'condition', 'inventory_number'];
            if (in_array($sortBy, $validColumns)) {
                $query->orderBy($sortBy, $sortDir);
            } else {
                $query->orderBy('created_at', 'desc');
            }
        }

        $spareParts = $query->paginate(15)->withQueryString();
        $categories = \App\Models\Category::all();
        $locations = \App\Models\Location::all();

        // Menghitung quantity berdasarkan brand dan type
        // Kita hitung dari seluruh tabel tanpa filter agar quantity barang yang sama tetap konsisten (meskipun terpotong paginate)
        $brandTypeCounts = SparePart::select('brand', 'type', \DB::raw('count(*) as count'))
            ->groupBy('brand', 'type')
            ->get()
            ->keyBy(function($item) {
                return $item->brand . '|' . $item->type;
            });

        $spareParts->getCollection()->transform(function ($item) use ($brandTypeCounts) {
            $key = $item->brand . '|' . $item->type;
            $item->quantity = $brandTypeCounts->has($key) ? $brandTypeCounts[$key]->count : 1;
            return $item;
        });

        return Inertia::render('Inventory/Index', [
            'spareParts' => $spareParts,
            'categories' => $categories,
            'locations' => $locations,
            'filters' => $request->only(['search', 'category', 'location', 'condition', 'date_start', 'date_end', 'sort_by', 'sort_dir'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'brand' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'inventory_number' => 'nullable|string|max:255',
            'condition' => 'required|in:Normal,Perbaikan,Rusak',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120', // maks 5MB
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('spare_parts', 'public');
        }

        SparePart::create($validated);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'brand' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'inventory_number' => 'nullable|string|max:255',
            'condition' => 'required|in:Normal,Perbaikan,Rusak',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($sparePart->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($sparePart->image);
            }
            $validated['image'] = $request->file('image')->store('spare_parts', 'public');
        }

        $sparePart->update($validated);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(SparePart $sparePart)
    {
        if ($sparePart->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($sparePart->image);
        }
        $sparePart->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }
}
