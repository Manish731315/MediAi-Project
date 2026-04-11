<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    // --- Public Routes ---

    /**
     * Display a listing of medicines for users.
     */
    public function index()
    {
        $medicines = Medicine::latest()->paginate(12);
        return view('shop.index', compact('medicines'));
    }

    /**
     * Display the specified medicine for users.
     */
    public function show(Medicine $medicine)
    {
        return view('shop.show', compact('medicine'));
    }

    // --- Admin Routes ---

    /**
     * Display a listing of the resource for Admin.
     */
    public function adminIndex()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id', 
            'image' => 'nullable|image|max:2048',
        ]);

        $data['prescription_required'] = $request->has('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        // This will now work because 'category' column is gone from DB
        Medicine::create($data); 

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        // --- THIS IS THE MISSING PART ---
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prescription_required' => 'nullable|boolean',
        ]);
        
        $validated['prescription_required'] = $request->has('prescription_required');
        

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $validated['image'] = $request->file('image')->store('medicine_images', 'public');
        }

        $medicine->update($validated); // This line will now work
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}