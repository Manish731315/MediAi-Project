<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a list of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Show 10 orders per page

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the details of a specific order.
     */
    public function show(Order $order)
    {
        // Security check: Ensure the order belongs to the logged-in user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load the items and the medicine details associated with them
        $order->load('items.medicine');

        return view('orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.medicine', 'user']);

        // This creates the PDF from a view and allows it to download
        $pdf = Pdf::loadView('orders.invoice_pdf', compact('order'));
        
        return $pdf->download('invoice-order-' . $order->id . '.pdf');
    }
}