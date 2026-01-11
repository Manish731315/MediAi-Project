<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Medicine::query();

        // 1. Filter by Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 2. Filter by Category Slug
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $medicines = $query->latest()->paginate(12);

        return view('shop.index', compact('medicines', 'categories'));
    }

    public function show(Medicine $medicine)
    {
        return view('shop.show', compact('medicine'));
    }
}