<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::withCount('spareParts')->get();
        return Inertia::render('Management/Locations/Index', [
            'locations' => $locations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,non-aktif',
            'capacity' => 'nullable|integer|min:0',
        ]);

        Location::create($validated);

        return redirect()->back()->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,non-aktif',
            'capacity' => 'nullable|integer|min:0',
        ]);

        $location->update($validated);

        return redirect()->back()->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        if ($location->spareParts()->count() > 0) {
            return redirect()->back()->with('error', 'Lokasi tidak dapat dihapus karena masih memiliki barang terdaftar.');
        }

        $location->delete();

        return redirect()->back()->with('success', 'Lokasi berhasil dihapus.');
    }
}
