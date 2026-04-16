<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class MedicineController extends Controller
{
    /**
     * Display a listing of the medicines.
     */
    public function index()
    {
        $medicines = Medicine::with('category')->latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new medicine.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.medicines.create', compact('categories'));
    }

    /**
     * Store a newly created medicine in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['prescription_required'] = $request->has('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully!');
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit(Medicine $medicine)
    {
        // Change 1: Fetch categories so the dropdown works in the edit form
        $categories = Category::all();
        
        // Change 2: Pass both the medicine and categories to the view
        return view('admin.medicines.edit', compact('medicine', 'categories'));
    }

    /**
     * Update the specified medicine in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        
        // Handle Toggle/Checkbox for prescription
        $data['prescription_required'] = $request->has('prescription_required');

        // Handle Image Update
        if ($request->hasFile('image')) {
            // Delete old image if it exists to save storage space
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            // Store new image
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully!');
    }

    /**
     * Remove the specified medicine from storage.
     */
    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }

    public function exportPdf()
    {
        $medicines = Medicine::with('category')->get();

        $pdf = Pdf::loadView('admin.medicines.pdf', compact('medicines'));

        return $pdf->download('medicines.pdf');
    }
}