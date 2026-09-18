<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('spareParts')->get();
        return Inertia::render('Management/Category/Index', [
            'categories' => $categories
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
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create($validated);

        Activity::create([
            'user_name' => auth()->user()->name ?? 'Sistem',
            'action' => 'created',
            'description' => "Menambahkan kategori {$validated['name']}",
            'item_name' => $validated['name'],
        ]);

        Notification::create([
            'title' => 'Kategori Ditambahkan',
            'message' => "Kategori {$validated['name']} berhasil dibuat.",
            'type' => 'system',
            'link' => '/management/category',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($validated);

        Activity::create([
            'user_name' => auth()->user()->name ?? 'Sistem',
            'action' => 'updated',
            'description' => "Memperbarui kategori {$validated['name']}",
            'item_name' => $validated['name'],
        ]);

        Notification::create([
            'title' => 'Kategori Diperbarui',
            'message' => "Kategori {$validated['name']} berhasil diperbarui.",
            'type' => 'system',
            'link' => '/management/category',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->spareParts()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki barang terdaftar.');
        }

        $categoryName = $category->name;
        $category->delete();

        Activity::create([
            'user_name' => auth()->user()->name ?? 'Sistem',
            'action' => 'deleted',
            'description' => "Menghapus kategori {$categoryName}",
            'item_name' => $categoryName,
        ]);

        Notification::create([
            'title' => 'Kategori Dihapus',
            'message' => "Kategori {$categoryName} berhasil dihapus.",
            'type' => 'system',
            'link' => '/management/category',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}