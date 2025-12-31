<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    /**
     * Show the form for uploading a prescription for a specific order.
     */
    public function showUploadForm(Order $order)
    {
        // Policy: Ensure the user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure we're not uploading for an order that doesn't need it
        if ($order->status !== 'pending_prescription') {
            return redirect()->route('dashboard')->with('error', 'This order does not require a prescription.');
        }

        return view('checkout.upload-prescription', compact('order'));
    }

    /**
     * Store the uploaded prescription.
     */
    public function storeUpload(Request $request, Order $order)
    {
        // Policy: Ensure the user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'prescription_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        // Store the file
        $path = $request->file('prescription_file')->store('prescriptions', 'public');

        // Create the prescription record
        Prescription::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'file_path' => $path,
            'status' => 'pending', // Admin will review this
        ]);

        // Update the order status
        $order->update(['status' => 'pending_approval']); // Now awaits admin approval

        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Prescription uploaded successfully. Your order is now pending review.');
    }
}