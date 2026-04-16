<?php
namespace App\Http\Controllers\Admin; 

//namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class MedicineController extends Controller
{
    // --- Public Routes ---

    public function index()
    {
        // Eager load category to prevent N+1 query issues in the shop grid
        $medicines = Medicine::with('category')->latest()->paginate(12);
        return view('shop.index', compact('medicines'));
    }

    public function show(Medicine $medicine)
    {
        // 1. Eager load the category relationship to avoid that JSON object error
        $medicine->load('category');

        // 2. Fetch related products here (MVC Pattern: Logic belongs in Controller, not Blade)
        $related = Medicine::where('category_id', $medicine->category_id)
                            ->where('id', '!=', $medicine->id)
                            ->limit(4)
                            ->get();

        return view('shop.show', compact('medicine', 'related'));
    }

    // --- Admin Routes ---

    public function adminIndex()
    {
        $medicines = Medicine::with('category')->latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Category::all(); // Need this to populate the dropdown
        return view('admin.medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id', // Correct
            'image' => 'nullable|image|max:2048',
        ]);

        $data['prescription_required'] = $request->has('prescription_required');

        if ($request->hasFile('image')) {
            // Consistent folder: 'medicines'
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($data); 

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully!');
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::all();
        return view('admin.medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // FIXED: Changed 'category' to 'category_id' to match your DB schema
            'category_id' => 'required|exists:categories,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $validated['prescription_required'] = $request->has('prescription_required');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            // Consistently store in 'medicines' folder
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($validated); 
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}